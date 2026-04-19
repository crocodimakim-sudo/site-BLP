<?php
header('Content-Type: application/json; charset=utf-8');

function scanProjectFolders() {
    $convertBase = __DIR__ . '/../images-convert/pages/projects/';
    $base = is_dir($convertBase) ? $convertBase : __DIR__ . '/../images/pages/projects/';
    $useConvert = is_dir($convertBase);
    $projects = [];

    $folders = array_filter(glob($base . '*'), 'is_dir');
    sort($folders);

    // Fallback метаданные (для обратной совместимости если нет meta.json и description.txt)
    $folderMeta = [
        'sapronova'     => ['name' => 'Поликлиника', 'location' => 'г.о. Видное, Московская область', 'tag' => 'Медицина', 'category' => '', 'order' => 1],
        'school'        => ['name' => 'Школа', 'location' => 'г. Истра, Московская область', 'tag' => 'Образование', 'category' => '', 'order' => 2],
        'sud'           => ['name' => 'Здание суда', 'location' => 'г.о. Мытищи, Московская область', 'tag' => 'Государственное', 'category' => '', 'order' => 3],
        'international' => ['name' => 'Объекты с ФЦП', 'location' => 'Китай', 'tag' => 'Международные', 'category' => '', 'order' => 4],
    ];

    usort($folders, function($a, $b) use ($base, $folderMeta) {
        $ka = basename($a);
        $kb = basename($b);

        // Порядок из meta.json если доступен
        $orderA = 999;
        $orderB = 999;

        $metaA = $a . '/meta.json';
        if (file_exists($metaA)) {
            $ma = json_decode(file_get_contents($metaA), true) ?? [];
            $orderA = $ma['order'] ?? 999;
        } elseif (isset($folderMeta[$ka])) {
            $orderA = $folderMeta[$ka]['order'];
        }

        $metaB = $b . '/meta.json';
        if (file_exists($metaB)) {
            $mb = json_decode(file_get_contents($metaB), true) ?? [];
            $orderB = $mb['order'] ?? 999;
        } elseif (isset($folderMeta[$kb])) {
            $orderB = $folderMeta[$kb]['order'];
        }

        return $orderA - $orderB;
    });

    foreach ($folders as $idx => $folderPath) {
        $folderName = basename($folderPath);

        // O2: Читаем метаданные из meta.json (приоритет), затем description.txt, затем fallback
        $metaFile = $folderPath . '/meta.json';
        $descFile  = $folderPath . '/description.txt';

        if (file_exists($metaFile)) {
            $meta     = json_decode(file_get_contents($metaFile), true) ?? [];
            $name     = $meta['name']     ?? $folderName;
            $location = $meta['location'] ?? '';
            $tag      = $meta['tag']      ?? '';
            $category = $meta['category'] ?? '';
        } elseif (file_exists($descFile)) {
            // Fallback на description.txt для обратной совместимости
            $meta = [];
            foreach (file($descFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                [$key, $val] = array_pad(explode('=', $line, 2), 2, '');
                $meta[trim($key)] = trim($val);
            }
            $name     = $meta['name']     ?? $folderName;
            $location = $meta['location'] ?? '';
            $tag      = $meta['tag']      ?? '';
            $category = $meta['category'] ?? '';
        } elseif (isset($folderMeta[$folderName])) {
            $name     = $folderMeta[$folderName]['name'];
            $location = $folderMeta[$folderName]['location'];
            $tag      = $folderMeta[$folderName]['tag'];
            $category = $folderMeta[$folderName]['category'];
        } else {
            $name     = $folderName;
            $location = '';
            $tag      = '';
            $category = '';
        }

        $imageFiles = array_merge(
            glob($folderPath . '/*.jpg')  ?: [],
            glob($folderPath . '/*.JPG')  ?: [],
            glob($folderPath . '/*.jpeg') ?: [],
            glob($folderPath . '/*.png')  ?: [],
            glob($folderPath . '/*.PNG')  ?: [],
            glob($folderPath . '/*.webp') ?: []
        );
        sort($imageFiles);

        $images = array_map(function($file) use ($useConvert) {
            $rel    = str_replace('\\', '/', $file);
            $needle = $useConvert ? '/images-convert/pages/projects/' : '/images/pages/projects/';
            $webBase = $useConvert ? '/blp/images-convert/pages/projects/' : '/blp/images/pages/projects/';
            $pos    = strpos($rel, $needle);
            if ($pos !== false) {
                return $webBase . substr($rel, $pos + strlen($needle));
            }
            return '/blp/' . basename($file);
        }, $imageFiles);

        // O1: Пустые папки включаются (images: [])
        // Убрана строка: if (empty($images)) continue;

        // O3: category включается в JSON ответ
        $projects[] = [
            'id'       => $idx + 1,
            'name'     => $name,
            'location' => $location,
            'tag'      => $tag,
            'category' => $category,
            'images'   => array_values($images),
        ];
    }

    return $projects;
}

echo json_encode(scanProjectFolders(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
