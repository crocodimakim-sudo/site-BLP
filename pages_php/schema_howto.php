<?php
// 2026-05-11: HowTo schema — параметризованный JSON-LD для инструкций/руководств
// Вход: $howto_data — массив:
//   'name'        => string
//   'description' => string
//   'totalTime'   => string (ISO 8601, напр. 'PT3D')
//   'tool'        => [['name'=>...], ...]
//   'supply'      => [['name'=>...], ...]
//   'step'        => [['name'=>..., 'text'=>..., 'image'=>...], ...]
// Используется в install.php и kreplenie.php. Если данные пусты — ничего не выводит

if (empty($howto_data) || !is_array($howto_data) || empty($howto_data['name'])) return;

$_schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'HowTo',
    'name'     => $howto_data['name'],
];

if (!empty($howto_data['description'])) {
    $_schema['description'] = $howto_data['description'];
}

if (!empty($howto_data['totalTime'])) {
    $_schema['totalTime'] = $howto_data['totalTime'];
}

if (!empty($howto_data['tool']) && is_array($howto_data['tool'])) {
    $_schema['tool'] = array_map(function($t) {
        return ['@type' => 'HowToTool', 'name' => $t['name'] ?? ''];
    }, $howto_data['tool']);
}

if (!empty($howto_data['supply']) && is_array($howto_data['supply'])) {
    $_schema['supply'] = array_map(function($s) {
        return ['@type' => 'HowToSupply', 'name' => $s['name'] ?? ''];
    }, $howto_data['supply']);
}

if (!empty($howto_data['step']) && is_array($howto_data['step'])) {
    $steps = [];
    foreach ($howto_data['step'] as $i => $s) {
        if (empty($s['text'])) continue;
        $step = [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $s['name'] ?? '',
            'text'     => $s['text'],
        ];
        if (!empty($s['image'])) {
            $step['image'] = [
                '@type' => 'ImageObject',
                'url'   => $s['image'],
            ];
        }
        $steps[] = $step;
    }
    if (!empty($steps)) {
        $_schema['step'] = $steps;
    }
}
?>
<script type="application/ld+json">
<?php echo json_encode($_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
