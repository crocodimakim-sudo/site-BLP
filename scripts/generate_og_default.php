<?php
// 2026-04-20: Generate og-default.jpg (1200x630) for social sharing fallback
// Brand colors: #00352F (dark green), #f0f8f7 (light accent), white text
$W = 1200; $H = 630;
$img = imagecreatetruecolor($W, $H);

$bgDark  = imagecolorallocate($img, 0x00, 0x35, 0x2F);
$accent  = imagecolorallocate($img, 0x4a, 0x8a, 0x80);
$white   = imagecolorallocate($img, 0xff, 0xff, 0xff);
$light   = imagecolorallocate($img, 0xf0, 0xf8, 0xf7);
$gray    = imagecolorallocate($img, 0xc8, 0xd8, 0xd5);

imagefilledrectangle($img, 0, 0, $W, $H, $bgDark);

// Diagonal accent bar (top-right corner decoration)
$points = [$W - 280, 0,  $W, 0,  $W, 180,  $W - 120, 180];
imagefilledpolygon($img, $points, $accent);

// Bottom accent bar
imagefilledrectangle($img, 0, $H - 12, $W, $H, $accent);

// Logo mark: simple "BLP" block on left
$boxX = 90; $boxY = 130;
imagefilledrectangle($img, $boxX, $boxY, $boxX + 140, $boxY + 140, $accent);
imagefilledrectangle($img, $boxX + 20, $boxY + 20, $boxX + 120, $boxY + 120, $bgDark);

// Built-in font has no Cyrillic — use Latin "BLP" mark + brand name
$fontLarge = 5;
imagestring($img, $fontLarge, $boxX + 48, $boxY + 58, 'BLP', $white);

// Main title (English fallback, built-in font)
$titleX = 260; $titleY = 170;
imagestring($img, 5, $titleX, $titleY,       'BLP BOARD', $white);
imagestring($img, 4, $titleX, $titleY + 45,  'Fibre Cement Panels', $light);
imagestring($img, 3, $titleX, $titleY + 85,  'for Ventilated Facades', $gray);

// Try TTF if available for Cyrillic
$ttfCandidates = [
    'C:/Windows/Fonts/arialbd.ttf',
    'C:/Windows/Fonts/arial.ttf',
    'C:/Windows/Fonts/segoeuib.ttf',
];
$ttf = null;
foreach ($ttfCandidates as $f) {
    if (file_exists($f)) { $ttf = $f; break; }
}

if ($ttf && function_exists('imagettftext')) {
    // Overwrite title area with cleaner Cyrillic typography
    imagefilledrectangle($img, $titleX - 10, $titleY - 40, $W - 40, $titleY + 140, $bgDark);
    imagettftext($img, 48, 0, $titleX, $titleY + 20,  $white, $ttf, 'BLP Board');
    imagettftext($img, 26, 0, $titleX, $titleY + 70,  $light, $ttf, 'Фиброцементные панели');
    imagettftext($img, 22, 0, $titleX, $titleY + 110, $gray,  $ttf, 'для вентилируемых фасадов');

    // Tagline at bottom
    imagettftext($img, 18, 0, 90, $H - 80, $light, $ttf, 'НГ • 0% асбеста • ГОСТ • Крупный формат');
    imagettftext($img, 14, 0, 90, $H - 45, $gray,  $ttf, 'building-port.ru/blp');
}

$out = __DIR__ . '/../images/og-default.jpg';
imagejpeg($img, $out, 88);
echo "[OK] $out (" . filesize($out) . " bytes, {$W}x{$H})\n";

imagedestroy($img);
