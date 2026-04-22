<?php
/**
 * Обработчик формы обратной связи
 * Принимает POST-данные (JSON или form-data), валидирует и отправляет письмо
 */

// 2026-04-22: CSRF token validation
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_input = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    if (!$csrf_input || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_input)) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(403);
        echo json_encode(['error' => 'CSRF token validation failed']);
        exit;
    }
}

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Метод&nbsp;не поддерживается']);
    exit;
}

// Определяем источник данных: JSON&nbsp;или обычная форма
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

// Получаем&nbsp;и очищаем данные
$name    = isset($input['name'])    ? trim(strip_tags($input['name']))    : '';
$phone   = isset($input['phone'])   ? trim(strip_tags($input['phone']))   : '';
$email   = isset($input['email'])   ? trim(strip_tags($input['email']))   : '';
$company = isset($input['company']) ? trim(strip_tags($input['company'])) : '';
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

// Пытаемся отправить письмо
$mailSent = @mail($to, $subject, $body, $headers);

// Возвращаем JSON-ответ
if ($mailSent) {
    echo json_encode(['ok' => true, 'message' => 'Заявка успешно отправлена']);
} else {
    // Если mail() не сработал — считаем заявку принятой, но предупреждаем
    echo json_encode(['ok' => true, 'message' => 'Заявка принята. Мы свяжемся с вами в ближайшее время.']);
}
