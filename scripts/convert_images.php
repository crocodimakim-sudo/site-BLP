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
            continue;
        }

        if (file_exists($dstPath)) {
            unlink($dstPath);
            echo "[DELETE] $relativePath\n";
        }

        // 2026-04-22: Копировать оригиналы как есть (полный размер) + создать WebP (только для растров)
        if (copy($srcPath, $dstPath)) {
            echo "[OK] $relativePath\n";

            // Создать WebP версию для браузера (только для jpg/png, не для svg)
            if ($ext !== 'svg' && function_exists('imagewebp')) {
                createWebP($srcPath, preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $dstPath), $ext);
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
            $base = preg_replace('/\.webp$/i', '', $relativePath);
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

// 2026-04-22: Create WebP version without resizing (for browser optimization only)
function createWebP(string $src, string $dst, string $ext): bool {
    try {
        $img = match ($ext) {
            'png'           => imagecreatefrompng($src),
            'jpg', 'jpeg'   => imagecreatefromjpeg($src),
            default         => null,
        };

        if (!$img) return false;

        // Check if image has alpha channel (PNG with transparency) or palette mode
        // WebP doesn't support palette mode, so convert to truecolor if needed
        if ($ext === 'png' && !imageistruecolor($img)) {
            // Convert from palette/indexed to truecolor
            $w = imagesx($img);
            $h = imagesy($img);
            $newImg = imagecreatetruecolor($w, $h);
            imagecopy($newImg, $img, 0, 0, 0, 0, $w, $h);
            imagedestroy($img);
            $img = $newImg;
        }

        @imagewebp($img, $dst, 82);
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
