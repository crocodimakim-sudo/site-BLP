<?php
// 2026-04-24: Blog schema — inject on blog.php listing page
// Requires: $articles array (from DB), $page_canonical
// Outputs: Blog type with blogPost ItemList for up to 10 most recent articles

if (empty($articles) && empty($hero)) {
    return;
}

$all_posts = [];
if (!empty($hero)) {
    $all_posts[] = $hero;
}
if (!empty($articles)) {
    foreach ($articles as $a) {
        $all_posts[] = $a;
    }
}

// 2026-04-24: cap at 10 to keep payload reasonable
$all_posts = array_slice($all_posts, 0, 10);

$blog_posts = [];
foreach ($all_posts as $a) {
    $post_url = 'https://building-port.ru/blog/' . ($a['slug'] ?? '');
    $image_url = !empty($a['image'])
        ? (strpos($a['image'], 'http') === 0 ? $a['image'] : 'https://building-port.ru' . $a['image'])
        : 'https://building-port.ru/images-convert/og-default.jpg';

    $entry = [
        '@type'         => 'BlogPosting',
        '@id'           => $post_url . '#blogposting',
        'headline'      => $a['title'] ?? '',
        'url'           => $post_url,
        'image'         => $image_url,
        'datePublished' => isset($a['published_at']) ? date('c', strtotime($a['published_at'])) : '',
        'author'        => ['@id' => 'https://building-port.ru/#organization'],
        'publisher'     => ['@id' => 'https://building-port.ru/#organization'],
        'inLanguage'    => 'ru-RU',
        'isPartOf'      => ['@id' => 'https://building-port.ru/blog#blog'],
    ];

    if (!empty($a['subtitle'])) {
        $entry['description'] = $a['subtitle'];
    }

    $blog_posts[] = $entry;
}

$schema = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'           => 'Blog',
            '@id'             => 'https://building-port.ru/blog#blog',
            'url'             => 'https://building-port.ru/blog',
            'name'            => 'Блог BLP Board — статьи о фиброцементе и вентилируемых фасадах',
            'description'     => 'Экспертные материалы о монтаже фиброцементных панелей, сравнении материалов, типовых ошибках вентилируемых фасадов и реализованных проектах BLP Board.',
            'inLanguage'      => 'ru-RU',
            'publisher'       => ['@id' => 'https://building-port.ru/#organization'],
            'isPartOf'        => ['@id' => 'https://building-port.ru/#website'],
            'blogPost'        => $blog_posts,
        ],
    ],
];

echo '<script type="application/ld+json">' . PHP_EOL;
echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo PHP_EOL . '</script>' . PHP_EOL;
