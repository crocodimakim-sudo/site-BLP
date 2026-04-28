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
