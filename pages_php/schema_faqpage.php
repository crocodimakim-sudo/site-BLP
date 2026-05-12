<?php
// 2026-05-11: FAQPage schema — параметризованный JSON-LD для страниц с вопросами и ответами
// Вход: $faq_items — массив [['q'=>'вопрос', 'a'=>'ответ'], ...]
// Используется в faq.php. Если массив пуст или не задан — ничего не выводит

if (empty($faq_items) || !is_array($faq_items)) return;

$entities = [];
foreach ($faq_items as $item) {
    if (empty($item['q']) || empty($item['a'])) continue;
    $entities[] = [
        '@type' => 'Question',
        'name'  => $item['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => $item['a'],
        ],
    ];
}

if (empty($entities)) return;

$_schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $entities,
];
?>
<script type="application/ld+json">
<?php echo json_encode($_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
