<?php
// 2026-05-11: BlogPosting schema — вынесено из blog-post.php в отдельный параметризованный файл
// Вход: $article — массив из БД (id, slug, title, subtitle, content, image, category,
//                               published_at, updated_at, read_time)
//       $_canonical_for_schema — строка с canonical URL страницы
// Если данные пусты или не задан title — ничего не выводит

if (empty($article) || !is_array($article) || empty($article['title'])) return;
if (empty($_canonical_for_schema)) return;

$_image_url = !empty($article['image'])
    ? (strpos($article['image'], 'http') === 0 ? $article['image'] : 'https://building-port.ru' . $article['image'])
    : 'https://building-port.ru/images/og-default.jpg';

$_datePublished = !empty($article['published_at']) ? date('c', strtotime($article['published_at'])) : '';
$_dateModified  = !empty($article['updated_at'])   ? date('c', strtotime($article['updated_at']))   : $_datePublished;

$_schema = [
    '@context'       => 'https://schema.org',
    '@type'          => 'BlogPosting',
    '@id'            => $_canonical_for_schema . '#blogposting',
    'headline'       => $article['title'],
    'url'            => $_canonical_for_schema,
    'description'    => $article['subtitle'] ?? '',
    'image'          => [
        '@type'  => 'ImageObject',
        'url'    => $_image_url,
        'width'  => 1200,
        'height' => 630,
    ],
    'datePublished'  => $_datePublished,
    'dateModified'   => $_dateModified,
    'author'         => [
        '@type' => 'Organization',
        '@id'   => 'https://building-port.ru/#organization',
        'name'  => 'BLP Board',
    ],
    'publisher'      => ['@id' => 'https://building-port.ru/#organization'],
    'inLanguage'     => 'ru-RU',
    'isPartOf'       => ['@id' => 'https://building-port.ru/blog#blog'],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id'   => $_canonical_for_schema . '#webpage',
    ],
];

if (!empty($article['read_time'])) {
    $_schema['timeRequired'] = 'PT' . (int)$article['read_time'] . 'M';
}
?>
<script type="application/ld+json">
<?php echo json_encode($_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
