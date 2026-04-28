<?php
// 2026-04-27: хелпер настроек сайта из database/site_config.json
function get_site_config(string $key, string $default = ''): string {
    static $config = null;
    if ($config === null) {
        $file = __DIR__ . '/../database/site_config.json';
        $config = file_exists($file) ? (json_decode(file_get_contents($file), true) ?? []) : [];
    }
    return (string)($config[$key] ?? $default);
}
