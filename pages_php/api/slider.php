<?php
// 2026-04-22: JSON API — возвращает слайды из images-convert/pages/catalog/slider/
header('Content-Type: application/json; charset=utf-8');
// 2026-04-23: убран wildcard CORS — API используется только этим же сайтом

$sliderDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'images-convert' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR;
$webBase = '/blp/images-convert/pages/catalog/slider/';

$slides = [];

if (is_dir($sliderDir)) {
    $entries = @scandir($sliderDir);
    if ($entries) {
        $basenames = [];
        foreach ($entries as $entry) {
            if (preg_match('/\.(jpg|jpeg|png)$/i', $entry) && $entry[0] !== '.') {
                $basenames[] = $entry;
            }
        }
        natsort($basenames);

        $id = 1;
        foreach ($basenames as $basename) {
            $nameNoExt = pathinfo($basename, PATHINFO_FILENAME);
            $title = str_replace(['walypan_slide_', '_'], ['Слайд ', ' '], $nameNoExt);
            $image = $webBase . $basename;
            // WebP thumbnail если существует
            $webpFile = $sliderDir . $nameNoExt . '.webp';
            $thumbnail = file_exists($webpFile)
                ? $webBase . $nameNoExt . '.webp'
                : $image;

            $slides[] = [
                'id'        => $id++,
                'title'     => $title,
                'image'     => $image,
                'thumbnail' => $thumbnail,
            ];
        }
    }
}

echo json_encode(['slides' => $slides], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
