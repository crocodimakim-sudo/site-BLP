<?php
/**
 * convert_images.php
 * Сканирует images/, создаёт оптимизированные версии (50% размера) в images-convert/
 * Запуск: php scripts/convert_images.php
 */

define('BASE_DIR', __DIR__ . '/..');
define('SRC_DIR', BASE_DIR . '/images');
define('DST_DIR', BASE_DIR . '/images-convert');

function convertImages(): void {
    if (!extension_loaded('gd')) {
        echo "[ERROR] GD extension not loaded\n";
        return;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(SRC_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($files as $file) {
        if (!$file->isFile()) continue;

        $ext = strtolower($file->getExtension());
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) continue;

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

        if (createOptimized($srcPath, $dstPath, $ext)) {
            echo "[OK] $relativePath\n";
        } else {
            echo "[FAIL] $relativePath\n";
        }
    }

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

    echo "[DONE] Конвертация завершена\n";
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

    imagedestroy($srcImg);
    imagedestroy($dstImg);

    return (bool)$result;
}

convertImages();
