<?php
// 2026-05-11: ItemList schema — параметризованный JSON-LD для списков товаров/страниц
// Вход: $itemlist_items — массив ['name'=>..., 'url'=>..., 'image'=>..., 'price'=>..., 'priceCurrency'=>'RUB']
// Если массив пуст или не задан — ничего не выводит

if (empty($itemlist_items) || !is_array($itemlist_items)) return;

$elements = [];
foreach ($itemlist_items as $pos => $it) {
    $element = [
        '@type'    => 'ListItem',
        'position' => $pos + 1,
        'item'     => [
            '@type' => 'Product',
            'name'  => $it['name'] ?? '',
            'url'   => $it['url']  ?? '',
        ],
    ];
    if (!empty($it['image'])) {
        $element['item']['image'] = $it['image'];
    }
    if (isset($it['price'])) {
        $element['item']['offers'] = [
            '@type'         => 'Offer',
            'price'         => $it['price'],
            'priceCurrency' => $it['priceCurrency'] ?? 'RUB',
            'availability'  => 'https://schema.org/InStock',
        ];
    }
    $elements[] = $element;
}

$_schema = [
    '@context'        => 'https://schema.org',
    '@type'           => 'ItemList',
    'itemListElement' => $elements,
];
?>
<script type="application/ld+json">
<?php echo json_encode($_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
