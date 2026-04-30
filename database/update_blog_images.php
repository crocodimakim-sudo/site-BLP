<?php
// 2026-04-27: проставить реальные изображения всем статьям блога
if (php_sapi_name() !== 'cli') { exit("CLI only\n"); }

$dbFile = __DIR__ . '/blog.db';
$pdo = new PDO('sqlite:' . $dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$images = [
    // ---- Монтаж / инструкции ----
    'montazh-zima'                           => '/images-convert/pages/projects/school/project_school_1.jpg',
    'oshibki-fasada'                         => '/images-convert/blocks/objects/object_commercial.png',
    'krepezh-guide'                          => '/images-convert/pages/catalog/series-nature.png',
    'shpargalka-montazhnika-blp'             => '/images-convert/blocks/products/series-texture.png',
    'poshagovyj-montazh-fibrocementa'        => '/images-convert/blocks/products/series-polished.png',
    'montazhnye-sistemy-fibrocementa-analiz' => '/images-convert/blocks/products/series-walypan.png',

    // ---- Сравнения (уже в БД через fibrociment-vs-kirpich) ----
    'fibrociment-vs-kirpich'                 => '/images-convert/blocks/products/series-nature.png',

    // ---- Проекты / новости ----
    'blp-2026'                               => '/images-convert/pages/index/index_hero.jpg',
    'proekt-zhk-parkovy'                     => '/images-convert/pages/projects/sapronova/project_sapronova_10.jpg',

    // ---- Новые: сравнения (id 10-14) ----
    'fibrocement-vs-keramogranit'            => '/images-convert/blocks/objects/object_education.jpg',
    'fibrocement-vs-hpl'                     => '/images-convert/blocks/products/series-polished.png',
    'fibrocement-vs-metallokassety'          => '/images-convert/blocks/products/series-texture.png',
    'fibrocement-vs-shtukaturka'             => '/images-convert/blocks/objects/object_admin.png',
    'fibrocement-vs-hrizotilcement'          => '/images-convert/blocks/products/series-nature.png',

    // ---- Новые: FAQ (id 15-19) ----
    'chto-takoe-fibrocementnye-paneli'       => '/images-convert/pages/index/index_hero.jpg',
    'uhod-za-fibrocementnym-fasadom'         => '/images-convert/blocks/objects/object_commercial.png',
    'podsistema-dlya-ventfasada'             => '/images-convert/blocks/products/series-walypan.png',
    'fibrocement-v-interere'                 => '/images-convert/pages/projects/school/project_school_1.jpg',
    'garantiya-fibrocementnye-paneli'        => '/images-convert/pages/diler/diler_hero.jpg',
];

$stmt = $pdo->prepare("UPDATE articles SET image = :img WHERE slug = :slug");

foreach ($images as $slug => $img) {
    $stmt->execute([':img' => $img, ':slug' => $slug]);
    echo ($stmt->rowCount() ? "[OK] " : "[NOT FOUND] ") . $slug . "\n";
}

echo "[DONE]\n";
