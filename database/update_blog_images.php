<?php
// 2026-04-27: проставить реальные изображения всем статьям блога
if (php_sapi_name() !== 'cli') { exit("CLI only\n"); }

$dbFile = __DIR__ . '/blog.db';
$pdo = new PDO('sqlite:' . $dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$images = [
    // ---- Монтаж / инструкции ----
    'montazh-zima'                           => '/blp/images-convert/pages/projects/school/project_school_1.jpg',
    'oshibki-fasada'                         => '/blp/images-convert/blocks/objects/object_commercial.png',
    'krepezh-guide'                          => '/blp/images-convert/pages/catalog/series-nature.png',
    'shpargalka-montazhnika-blp'             => '/blp/images-convert/blocks/products/series-texture.png',
    'poshagovyj-montazh-fibrocementa'        => '/blp/images-convert/blocks/products/series-polished.png',
    'montazhnye-sistemy-fibrocementa-analiz' => '/blp/images-convert/blocks/products/series-walypan.png',

    // ---- Сравнения (уже в БД через fibrociment-vs-kirpich) ----
    'fibrociment-vs-kirpich'                 => '/blp/images-convert/blocks/products/series-nature.png',

    // ---- Проекты / новости ----
    'blp-2026'                               => '/blp/images-convert/pages/index/index_hero.jpg',
    'proekt-zhk-parkovy'                     => '/blp/images-convert/pages/projects/sapronova/project_sapronova_10.jpg',

    // ---- Новые: сравнения (id 10-14) ----
    'fibrocement-vs-keramogranit'            => '/blp/images-convert/blocks/objects/object_education.jpg',
    'fibrocement-vs-hpl'                     => '/blp/images-convert/blocks/products/series-polished.png',
    'fibrocement-vs-metallokassety'          => '/blp/images-convert/blocks/products/series-texture.png',
    'fibrocement-vs-shtukaturka'             => '/blp/images-convert/blocks/objects/object_admin.png',
    'fibrocement-vs-hrizotilcement'          => '/blp/images-convert/blocks/products/series-nature.png',

    // ---- Новые: FAQ (id 15-19) ----
    'chto-takoe-fibrocementnye-paneli'       => '/blp/images-convert/pages/index/index_hero.jpg',
    'uhod-za-fibrocementnym-fasadom'         => '/blp/images-convert/blocks/objects/object_commercial.png',
    'podsistema-dlya-ventfasada'             => '/blp/images-convert/blocks/products/series-walypan.png',
    'fibrocement-v-interere'                 => '/blp/images-convert/pages/projects/school/project_school_1.jpg',
    'garantiya-fibrocementnye-paneli'        => '/blp/images-convert/pages/diler/diler_hero.jpg',
];

$stmt = $pdo->prepare("UPDATE articles SET image = :img WHERE slug = :slug");

foreach ($images as $slug => $img) {
    $stmt->execute([':img' => $img, ':slug' => $slug]);
    echo ($stmt->rowCount() ? "[OK] " : "[NOT FOUND] ") . $slug . "\n";
}

echo "[DONE]\n";
