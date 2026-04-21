<?php
// 2026-04-20: Stage 2 — one-time generate WebP from existing images-convert/*.{jpg,png}
// Runs alongside convert_images.php; can be removed after first run.
define('BASE_DIR', __DIR__ . '/..');
define('SRC_DIR', BASE_DIR . '/images-convert');

if (!function_exists('imagewebp')) {
    echo "[ERROR] GD WebP not available\n";
    exit(1);
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(SRC_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
);

$ok = 0; $skip = 0; $fail = 0;
foreach ($files as $file) {
    if (!$file->isFile()) continue;
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) continue;

    $src = $file->getPathname();
    $dst = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $src);

    if (file_exists($dst) && filemtime($src) <= filemtime($dst)) {
        $skip++;
        continue;
    }

    $img = match ($ext) {
        'png'           => imagecreatefrompng($src),
        'jpg', 'jpeg'   => imagecreatefromjpeg($src),
        default         => null,
    };
    if (!$img) { echo "[FAIL] $src\n"; $fail++; continue; }

    if ($ext === 'png') {
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
    }

    if (imagewebp($img, $dst, 82)) {
        $ok++;
        echo "[OK] " . substr($dst, strlen(SRC_DIR) + 1) . "\n";
    } else {
        $fail++;
        echo "[FAIL] $dst\n";
    }
    imagedestroy($img);
}

echo "\n[DONE] ok=$ok skip=$skip fail=$fail\n";
