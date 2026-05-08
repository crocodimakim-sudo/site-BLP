<?php
// 2026-05-06: dev-router для PHP built-in server (mimics .htaccess)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = __DIR__ . $uri;

// Реальный файл (статика: css/js/images/...) — отдать как есть
if ($uri !== '/' && file_exists($path) && !is_dir($path)) {
    return false;
}

// Маршруты из .htaccess
$routes = [
    '#^/$#'                              => '/pages_php/index.php',
    '#^/admin/?$#'                       => '/pages_php/admin/index.php',
    '#^/api/slider$#'                    => '/pages_php/api/slider.php',
    '#^/blog$#'                          => '/pages_php/blog.php',
    '#^/blog/([a-z0-9\-]+)$#'            => '/pages_php/blog-post.php?slug=$1',
];

// 2026-05-08: helper — Apache mod_php выставляет CWD в директорию скрипта,
// чтобы относительные include типа `../blocks/X.php` резолвились корректно.
// Built-in PHP сервер этого не делает — повторяем здесь.
$run = function(string $absScript) {
    chdir(dirname($absScript));
    require $absScript;
};

foreach ($routes as $pattern => $target) {
    if (preg_match($pattern, $uri, $m)) {
        $target = preg_replace_callback('/\$(\d+)/', fn($x) => $m[(int)$x[1]] ?? '', $target);
        [$script, $qs] = array_pad(explode('?', $target, 2), 2, '');
        if ($qs) {
            parse_str($qs, $extra);
            $_GET = array_merge($_GET, $extra);
            $_SERVER['QUERY_STRING'] = http_build_query($_GET);
        }
        $run(__DIR__ . $script);
        return true;
    }
}

// /<name> -> /pages_php/<name>.php
if (preg_match('#^/([a-z0-9\-]+)$#', $uri, $m)) {
    $candidate = __DIR__ . '/pages_php/' . $m[1] . '.php';
    if (file_exists($candidate)) { $run($candidate); return true; }
}

http_response_code(404);
$run(__DIR__ . '/pages_php/404.php');
