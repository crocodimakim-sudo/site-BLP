<?php
// 2026-04-27: хелпер данных каталога из database/catalog.json
function get_catalog_series(string $key, string $field, string $default = ''): string {
    static $data = null;
    if ($data === null) {
        $file = __DIR__ . '/../database/catalog.json';
        $data = file_exists($file) ? (json_decode(file_get_contents($file), true) ?? []) : [];
    }
    return (string)($data['series'][$key][$field] ?? $default);
}

// 2026-05-06: возвращает массив цен по толщинам: ['8' => '1 200 руб/м²', ...]
function get_catalog_prices(string $key): array {
    static $data = null;
    if ($data === null) {
        $file = __DIR__ . '/../database/catalog.json';
        $data = file_exists($file) ? (json_decode(file_get_contents($file), true) ?? []) : [];
    }
    $prices = $data['series'][$key]['prices'] ?? [];
    return is_array($prices) ? $prices : [];
}
