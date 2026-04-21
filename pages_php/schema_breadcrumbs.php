<?php
// 2026-04-20: BreadcrumbList schema — dynamic per-page breadcrumbs
// Usage: set $breadcrumbs array before including this file
// Example in catalog.php:
//   $breadcrumbs = [
//     ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
//     ['name' => 'Каталог', 'url' => 'https://building-port.ru/blp/catalog'],
//   ];

if (!isset($breadcrumbs) || empty($breadcrumbs)) {
    return;
}

$items = [];
foreach ($breadcrumbs as $pos => $crumb) {
    $items[] = [
        '@type'    => 'ListItem',
        'position' => $pos + 1,
        'name'     => $crumb['name'],
        'item'     => $crumb['url'],
    ];
}

$schema = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => $items,
];

echo '<script type="application/ld+json">' . PHP_EOL;
echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo PHP_EOL . '</script>' . PHP_EOL;
