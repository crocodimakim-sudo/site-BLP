<?php
/**
 * compress_heavy.php
 * 2026-04-24: Агрессивное сжатие тяжёлых изображений в images-convert/
 * Ресайзит до max 1920px, пересохраняет JPG Q82 / PNG Q8 / WebP Q75
 * Запуск: php scripts/compress_heavy.php [--force]
 */

if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only'); }
if (!extension_loaded('gd')) { die("[ERROR] GD extension not loaded\n"); }

define('DST_DIR', __DIR__ . '/../images-convert');
define('MAX_W', 1920);
define('MAX_H', 1920);
define('JPG_Q', 82);
define('WEBP_Q', 75);
define('MIN_SIZE', 200 * 1024); // пересжимать файлы > 200 КБ

$force = in_array('--force', $argv ?? []);
$totalBefore = 0;
$totalAfter  = 0;
$processed   = 0;

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(DST_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($files as $file) {
    if (!$file->isFile()) continue;
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) continue;

    $path = $file->getPathname();
    $size = filesize($path);

    if (!$force && $size < MIN_SIZE) continue;

    $sizeBefore = $size;
    $totalBefore += $sizeBefore;

    // Загрузить изображение
    $img = match ($ext) {
        'jpg', 'jpeg' => @imagecreatefromjpeg($path),
        'png'         => @imagecreatefrompng($path),
        default       => null,
    };
    if (!$img) { echo "[SKIP] Cannot load: " . basename($path) . "\n"; continue; }

    $w = imagesx($img);
    $h = imagesy($img);

    // Вычислить новые размеры (сохранить пропорции)
    $newW = $w;
    $newH = $h;
    if ($w > MAX_W || $h > MAX_H) {
        $ratio = min(MAX_W / $w, MAX_H / $h);
        $newW  = (int)round($w * $ratio);
        $newH  = (int)round($h * $ratio);
    }

    // Создать ресайзнутое изображение
    $resized = imagecreatetruecolor($newW, $newH);
    if ($ext === 'png') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefilledrectangle($resized, 0, 0, $newW, $newH, $transparent);
    }
    imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
    imagedestroy($img);

    // Перезаписать оригинальный файл сжатым
    match ($ext) {
        'jpg', 'jpeg' => imagejpeg($resized, $path, JPG_Q),
        'png'         => imagepng($resized, $path, 8),
        default       => null,
    };

    // Создать / обновить WebP
    $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);
    if (function_exists('imagewebp')) {
        imagewebp($resized, $webpPath, WEBP_Q);
    }

    imagedestroy($resized);

    $sizeAfter = filesize($path);
    $totalAfter += $sizeAfter;
    $processed++;

    $rel     = str_replace(DST_DIR . '/', '', $path);
    $saving  = round(($sizeBefore - $sizeAfter) / 1024);
    $pct     = $sizeBefore > 0 ? round((1 - $sizeAfter / $sizeBefore) * 100) : 0;
    $dims    = ($w !== $newW) ? " [{$w}x{$h} → {$newW}x{$newH}]" : " [{$w}x{$h}]";
    echo sprintf("[OK] %-60s %5dKB → %4dKB (%d%%)\n",
        substr($rel, -60), round($sizeBefore / 1024), round($sizeAfter / 1024), $pct) . $dims . "\n";
}

echo "\n=== ИТОГО: обработано $processed файлов ===\n";
echo "До:    " . round($totalBefore / 1024 / 1024, 1) . " МБ\n";
echo "После: " . round($totalAfter / 1024 / 1024, 1) . " МБ\n";
if ($totalBefore > 0) {
    echo "Экономия: " . round(($totalBefore - $totalAfter) / 1024 / 1024, 1) . " МБ ("
        . round((1 - $totalAfter / $totalBefore) * 100) . "%)\n";
}
