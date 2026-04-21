<?php
// 2026-04-20: WebPage schema — dynamic, inject per page via template.php
// Requires: $page_title, $page_desc, $page_canonical (set in each page file)

$wp_title     = isset($page_title)     ? $page_title     : 'BLP Board';
$wp_desc      = isset($page_desc)      ? $page_desc      : '';
$wp_canonical = isset($page_canonical) ? $page_canonical : 'https://building-port.ru/blp/';
$wp_image     = isset($page_og_image)  ? $page_og_image  : 'https://building-port.ru/blp/images-convert/shared/header/logo-3.svg';

$schema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    '@id'         => $wp_canonical . '#webpage',
    'url'         => $wp_canonical,
    'name'        => $wp_title,
    'description' => $wp_desc,
    'isPartOf'    => ['@id' => 'https://building-port.ru/blp/#website'],
    'about'       => ['@id' => 'https://building-port.ru/blp/#organization'],
    'inLanguage'  => 'ru-RU',
    'primaryImageOfPage' => [
        '@type' => 'ImageObject',
        'url'   => $wp_image,
    ],
];

echo '<script type="application/ld+json">' . PHP_EOL;
echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo PHP_EOL . '</script>' . PHP_EOL;
