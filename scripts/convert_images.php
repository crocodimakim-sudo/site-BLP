<?php
/**
 * convert_images.php
 * Сканирует images/, создаёт оптимизированные версии (50% размера) в images-convert/
 * Запуск: php scripts/convert_images.php
 */

define('BASE_DIR', __DIR__ . '/..');
define('SRC_DIR', BASE_DIR . '/images');
define('DST_DIR', BASE_DIR . '/images-convert');
define('THUMB_DIR', DST_DIR . '/thumbnails');

function convertImages(): void {
    if (!extension_loaded('gd')) {
        echo "[ERROR] GD extension not loaded\n";
        return;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(SRC_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    $count = 0;
    foreach ($files as $file) {
        if (!$file->isFile()) continue;

        $ext = strtolower($file->getExtension());
        /* 2026-04-22: добавлен webp в список разрешенных расширений */
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'svg', 'webp'])) continue;
        $count++;

        $srcPath = $file->getPathname();
        $relativePath = substr($srcPath, strlen(SRC_DIR) + 1);
        $dstPath = DST_DIR . '/' . $relativePath;

        $dstDir = dirname($dstPath);
        if (!is_dir($dstDir)) {
            mkdir($dstDir, 0755, true);
        }

        // Если источник новее конвертации — пересоздать
        if (file_exists($dstPath) && filemtime($srcPath) <= filemtime($dstPath)) {
            // 2026-04-28: даже если основной файл актуален — проверить наличие -sm.webp
            if ($ext !== 'svg' && function_exists('imagewebp')) {
                $smDst = preg_replace('/\.(jpg|jpeg|png)$/i', '-sm.webp', $dstPath);
                if (!file_exists($smDst)) {
                    createSmallWebP($srcPath, $smDst, $ext);
                    echo "[SM] $relativePath\n";
                }
            }
            continue;
        }

        if (file_exists($dstPath)) {
            unlink($dstPath);
            echo "[DELETE] $relativePath\n";
        }

        // 2026-04-24: сжимать растры до 1920px вместо копирования оригинала
        $ok = false;
        if ($ext === 'svg') {
            $ok = copy($srcPath, $dstPath);
        } else {
            $ok = createOptimized($srcPath, $dstPath, $ext);
        }

        if ($ok) {
            echo "[OK] $relativePath\n";
            if ($ext !== 'svg' && function_exists('imagewebp')) {
                createWebP($srcPath, preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $dstPath), $ext);
                // 2026-04-28: -sm.webp (max 800px) для responsive srcset в мини-слайдере
                createSmallWebP($srcPath, preg_replace('/\.(jpg|jpeg|png)$/i', '-sm.webp', $dstPath), $ext);
                createThumbnail($srcPath, $ext);
            }
        } else {
            echo "[FAIL] $relativePath\n";
        }
    }
    echo "[STATS] Processed: $count files\n";

    // Копировать meta.json из images/ в images-convert/ (зеркально)
    $metaFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(SRC_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($metaFiles as $file) {
        if (!$file->isFile() || $file->getFilename() !== 'meta.json') continue;
        $srcPath     = $file->getPathname();
        $relativePath = substr($srcPath, strlen(SRC_DIR) + 1);
        $dstPath     = DST_DIR . '/' . $relativePath;
        $dstDir      = dirname($dstPath);
        if (!is_dir($dstDir)) {
            mkdir($dstDir, 0755, true);
        }
        if (!file_exists($dstPath) || filemtime($srcPath) > filemtime($dstPath)) {
            copy($srcPath, $dstPath);
            echo "[META] $relativePath\n";
        }
    }

    // Удалить orphaned файлы из images-convert/, которых больше нет в images/
    $dstFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(DST_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($dstFiles as $file) {
        if (!$file->isFile()) continue;
        $dstPath = $file->getPathname();
        $relativePath = substr($dstPath, strlen(DST_DIR) + 1);
        $srcPath = SRC_DIR . '/' . $relativePath;

        // Для .webp проверяем оригинал с расширением .jpg/.jpeg/.png
        $ext = strtolower($file->getExtension());
        if ($ext === 'webp') {
            // 2026-04-28: strip -sm suffix чтобы не удалять sm-варианты как orphaned
            $base = preg_replace('/(-sm)?\.webp$/i', '', $relativePath);
            $srcPath = SRC_DIR . '/' . $base . '.jpg';
            if (!file_exists($srcPath)) {
                $srcPath = SRC_DIR . '/' . $base . '.jpeg';
            }
            if (!file_exists($srcPath)) {
                $srcPath = SRC_DIR . '/' . $base . '.png';
            }
        }

        if (!file_exists($srcPath)) {
            unlink($dstPath);
            echo "[DELETE ORPHANED] $relativePath\n";
        }
    }

    cleanOrphanedThumbnails();

    echo "[DONE] Конвертация завершена\n";
}

// 2026-04-22: Create 100x100px WebP thumbnail, delete orphaned thumbnails when original is missing
function createThumbnail(string $srcPath, string $ext): void {
    $relativePath = substr($srcPath, strlen(SRC_DIR) + 1);
    $thumbName = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', str_replace(DIRECTORY_SEPARATOR, '_', $relativePath));
    $thumbPath = THUMB_DIR . '/' . $thumbName;

    if (!is_dir(THUMB_DIR)) {
        mkdir(THUMB_DIR, 0755, true);
    }

    // Skip if thumbnail is up to date
    if (file_exists($thumbPath) && filemtime($srcPath) <= filemtime($thumbPath)) {
        return;
    }

    $img = match ($ext) {
        'png'         => imagecreatefrompng($srcPath),
        'jpg', 'jpeg' => imagecreatefromjpeg($srcPath),
        default       => null,
    };

    if (!$img) return;

    $srcW = imagesx($img);
    $srcH = imagesy($img);

    $thumb = imagecreatetruecolor(100, 100);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, 100, 100, $srcW, $srcH);
    imagedestroy($img);

    @imagewebp($thumb, $thumbPath, 82);
    imagedestroy($thumb);

    echo "[THUMB] $thumbName\n";
}

// 2026-04-22: Delete orphaned thumbnails whose originals no longer exist in images/
function cleanOrphanedThumbnails(): void {
    $thumbDir = DST_DIR . '/thumbnails';
    if (!is_dir($thumbDir)) return;

    foreach (new DirectoryIterator($thumbDir) as $file) {
        if (!$file->isFile() || $file->getExtension() !== 'webp') continue;

        // Reverse the flat name back to relative path
        $base = preg_replace('/\.webp$/i', '', $file->getFilename());
        $relativeWithSep = str_replace('_', DIRECTORY_SEPARATOR, $base);

        $found = false;
        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            if (file_exists(SRC_DIR . '/' . $relativeWithSep . '.' . $ext)) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            unlink($file->getPathname());
            echo "[DELETE THUMB ORPHANED] " . $file->getFilename() . "\n";
        }
    }
}

// 2026-04-24: Create WebP version with resize to max 1920px (was: no resize)
function createWebP(string $src, string $dst, string $ext): bool {
    define('WEBP_MAX', 1920);
    try {
        $img = match ($ext) {
            'png'         => imagecreatefrompng($src),
            'jpg', 'jpeg' => imagecreatefromjpeg($src),
            default       => null,
        };
        if (!$img) return false;

        $w = imagesx($img);
        $h = imagesy($img);

        // Resize proportionally to max 1920px
        if ($w > WEBP_MAX || $h > WEBP_MAX) {
            $ratio = min(WEBP_MAX / $w, WEBP_MAX / $h);
            $newW  = (int)round($w * $ratio);
            $newH  = (int)round($h * $ratio);
            $resized = imagecreatetruecolor($newW, $newH);
            if ($ext === 'png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $t = imagecolorallocatealpha($resized, 0, 0, 0, 127);
                imagefilledrectangle($resized, 0, 0, $newW, $newH, $t);
            }
            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
            imagedestroy($img);
            $img = $resized;
        } elseif ($ext === 'png' && !imageistruecolor($img)) {
            $newImg = imagecreatetruecolor($w, $h);
            imagecopy($newImg, $img, 0, 0, 0, 0, $w, $h);
            imagedestroy($img);
            $img = $newImg;
        }

        @imagewebp($img, $dst, 75);
        imagedestroy($img);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// 2026-04-28: Create small WebP (max 800px) for responsive srcset in mini-slider
function createSmallWebP(string $src, string $dst, string $ext): bool {
    $smMax = 800;
    try {
        $img = match ($ext) {
            'png'         => imagecreatefrompng($src),
            'jpg', 'jpeg' => imagecreatefromjpeg($src),
            default       => null,
        };
        if (!$img) return false;

        $w = imagesx($img);
        $h = imagesy($img);

        if ($w > $smMax || $h > $smMax) {
            $ratio   = min($smMax / $w, $smMax / $h);
            $newW    = (int)round($w * $ratio);
            $newH    = (int)round($h * $ratio);
            $resized = imagecreatetruecolor($newW, $newH);
            if ($ext === 'png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }
            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
            imagedestroy($img);
            $img = $resized;
        } elseif ($ext === 'png' && !imageistruecolor($img)) {
            // palette PNG → truecolor (WebP не поддерживает palette)
            $newImg = imagecreatetruecolor($w, $h);
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            imagecopy($newImg, $img, 0, 0, 0, 0, $w, $h);
            imagedestroy($img);
            $img = $newImg;
        }

        @imagewebp($img, $dst, 80);
        imagedestroy($img);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function createOptimized(string $src, string $dst, string $ext): bool {
    [$w, $h] = getimagesize($src);
    $newW = (int)($w * 0.5);
    $newH = (int)($h * 0.5);

    $srcImg = match ($ext) {
        'png'           => imagecreatefrompng($src),
        'jpg', 'jpeg'   => imagecreatefromjpeg($src),
        default         => null,
    };

    if (!$srcImg) return false;

    $dstImg = imagecreatetruecolor($newW, $newH);

    // Сохранить прозрачность для PNG
    if ($ext === 'png') {
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
        $transparent = imagecolorallocatealpha($dstImg, 0, 0, 0, 127);
        imagefilledrectangle($dstImg, 0, 0, $newW, $newH, $transparent);
    }

    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newW, $newH, $w, $h);

    $result = match ($ext) {
        'png'           => imagepng($dstImg, $dst, 8),
        'jpg', 'jpeg'   => imagejpeg($dstImg, $dst, 80),
        default         => false,
    };

    // 2026-04-20: Stage 2 — создаём .webp рядом (quality 82) для <picture> fallback
    if ($result && function_exists('imagewebp')) {
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $dst);
        if ($webpPath && $webpPath !== $dst) {
            imagewebp($dstImg, $webpPath, 82);
        }
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);

    return (bool)$result;
}

convertImages();
