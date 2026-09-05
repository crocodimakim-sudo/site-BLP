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

// 2026-09-05: цены для JSON-LD (ItemList, AggregateOffer) из того же catalog.json, что и страница — раньше в разметке были захардкожены старые 7200/7950
function blp_price_digits(string $v): int {
    return (int)preg_replace('/\D+/', '', $v);
}
function blp_price_min(string $key): string {
    $vals = array_filter(array_map('blp_price_digits', get_catalog_prices($key)));
    return $vals ? (string)min($vals) : '';
}
function blp_offer_prices(string $key): string {
    $vals = array_filter(array_map('blp_price_digits', get_catalog_prices($key)));
    if (!$vals) return '';
    return '"lowPrice": "' . min($vals) . '",' . "\n        " . '"highPrice": "' . max($vals) . '",' . "\n        " . '"offerCount": "' . count($vals) . '",';
}

