<?php
// 2026-04-24: единый шаблон для всех HTTP-ошибок
// Подключается из 400.php, 403.php, 404.php, 405.php, 500.php, 503.php
// Ожидает: $error_code (int), опционально $error_title, $error_desc

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['csrf_token'])) {
    session_regenerate_id(true);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [
    400 => [
        'title' => 'Неверный запрос',
        'desc'  => 'Ваш браузер отправил запрос, который сервер не смог обработать. Попробуйте обновить страницу.',
    ],
    403 => [
        'title' => 'Доступ запрещён',
        'desc'  => 'У вас нет прав для просмотра этой страницы.',
    ],
    404 => [
        'title' => 'Страница не найдена',
        'desc'  => 'Возможно, страница была удалена или адрес введён неверно. Воспользуйтесь навигацией ниже.',
    ],
    405 => [
        'title' => 'Метод не поддерживается',
        'desc'  => 'Запрошенный метод не поддерживается для этого адреса.',
    ],
    500 => [
        'title' => 'Ошибка сервера',
        'desc'  => 'На сервере произошла внутренняя ошибка. Мы уже работаем над её устранением. Попробуйте позже.',
    ],
    503 => [
        'title' => 'Сервис недоступен',
        'desc'  => 'Сайт временно недоступен — ведётся техническое обслуживание. Попробуйте через несколько минут.',
    ],
];

$code  = isset($error_code) ? (int)$error_code : 404;
$info  = $errors[$code] ?? ['title' => 'Ошибка', 'desc' => 'Что-то пошло не так.'];
$title = $error_title ?? $info['title'];
$desc  = $error_desc  ?? $info['desc'];

http_response_code($code);

$page_title    = $code . ' — ' . $title . ' | BLP Board';
$page_desc     = $desc;
$page_canonical = '';
// 2026-04-24: SEO — noindex on all error pages to prevent indexation of error states
$page_robots   = 'noindex, nofollow';
$extra_css     = '<link rel="stylesheet" href="/blp/css/pages/error.css">';

ob_start();
?>
<section class="error-section">
    <div class="error-inner">
        <div class="error-code"><?= $code ?></div>
        <div class="error-divider"></div>
        <h1 class="error-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="error-desc"><?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?></p>
        <div class="error-actions">
            <a href="/blp/" class="error-btn-primary">На главную</a>
            <a href="/blp/catalog" class="error-btn-secondary">Каталог</a>
            <a href="/blp/contacts" class="error-btn-secondary">Написать нам</a>
        </div>
    </div>
</section>
<?php
$page_content = ob_get_clean();
include __DIR__ . '/template.php';
