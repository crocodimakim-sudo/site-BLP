<?php
/**
 * Обработчик формы обратной связи
 * Принимает POST-данные (JSON или form-data), валидирует и отправляет письмо
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Метод не поддерживается']);
    exit;
}

// 2026-04-23: определяем источник данных ДО CSRF-проверки — JSON body или form-data
$contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
if (strpos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Некорректный JSON']);
        exit;
    }
} else {
    $input = $_POST;
}

// 2026-04-23: CSRF-проверка после парсинга input (работает для JSON и form-data)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$csrf_input = isset($input['csrf_token']) ? $input['csrf_token'] : '';
if (!$csrf_input || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_input)) {
    http_response_code(403);
    echo json_encode(['error' => 'CSRF token validation failed']);
    exit;
}

// 2026-04-24: honeypot — тихо игнорируем ботов
if (!empty($input['website'])) {
    echo json_encode(['ok' => true, 'message' => 'Спасибо!']);
    exit;
}

// 2026-04-24: rate limit — максимум 5 отправок в час с одного IP
$_rl_ip   = preg_replace('/[^a-f0-9:.]/', '', $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
$_rl_dir  = __DIR__ . '/../logs';
if (!is_dir($_rl_dir)) @mkdir($_rl_dir, 0755, true);
$_rl_file = $_rl_dir . '/rl_' . md5($_rl_ip) . '.json';
$_rl_now  = time();
$_rl_hits = is_file($_rl_file) ? (json_decode(file_get_contents($_rl_file), true) ?: []) : [];
$_rl_hits = array_values(array_filter($_rl_hits, fn($t) => $_rl_now - $t < 3600));
if (count($_rl_hits) >= 5) {
    http_response_code(429);
    echo json_encode(['ok' => false, 'error' => 'Слишком много запросов. Попробуйте через час.']);
    exit;
}

// 2026-04-24: защита от SMTP header injection (CRLF)
function sanitize_header_field(string $v): string {
    $v = trim((string)$v);
    if (preg_match('/[\r\n\0]/', $v)) return '';
    return strip_tags($v);
}

// Получаем и очищаем данные
$name    = sanitize_header_field($input['name']    ?? '');
$phone   = sanitize_header_field($input['phone']   ?? '');
$email   = sanitize_header_field($input['email']   ?? '');
$company = sanitize_header_field($input['company'] ?? '');
$message = isset($input['message']) ? trim(strip_tags($input['message'])) : '';
$consent = isset($input['consent']) ? $input['consent'] : false;

// Валидация
$errors = [];

if (empty($name) || mb_strlen($name) < 2) {
    $errors[] = 'Укажите корректное имя';
}

if (empty($phone) || !preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
    $errors[] = 'Укажите корректный телефон';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Укажите корректный email';
}

if (!$consent) {
    $errors[] = 'Необходимо согласие на обработку персональных данных';
}

// Если есть ошибки — возвращаем JSON с ошибками
if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => implode('; ', $errors)]);
    exit;
}

// Формируем письмо
$to      = 'info@building-port.ru';
$subject = 'Сообщение со страницы Контакты — BLP Board';

$body  = "Имя: " . $name . "\n";
$body .= "Телефон: " . $phone . "\n";
if (!empty($email)) {
    $body .= "Email: " . $email . "\n";
}
if (!empty($company)) {
    $body .= "Компания: " . $company . "\n";
}
if (!empty($message)) {
    $body .= "Сообщение:\n" . $message . "\n";
}

$headers = "From: noreply@building-port.ru\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Отправляем письмо
$mailSent = @mail($to, $subject, $body, $headers);

// 2026-04-23: лог заявки в файл независимо от результата mail()
$logDir = dirname(__DIR__) . '/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logFile = $logDir . '/leads_' . date('Y-m') . '.log';
$logLine = date('Y-m-d H:i:s')
    . ' | ' . $name
    . ' | ' . $phone
    . ' | ' . $email
    . ' | ' . ($company ?: '-')
    . ' | mail:' . ($mailSent ? 'ok' : 'FAIL')
    . "\n";
@file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

// 2026-04-24: записать в rate limit + ротация CSRF
$_rl_hits[] = $_rl_now;
@file_put_contents($_rl_file, json_encode($_rl_hits), LOCK_EX);
unset($_SESSION['csrf_token']);

if ($mailSent) {
    echo json_encode(['ok' => true, 'message' => 'Заявка успешно отправлена']);
} else {
    // 2026-04-23: честный ответ при ошибке mail() — заявка сохранена в лог
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Не удалось отправить заявку. Позвоните нам: +7 (495) 984-96-89']);
}
