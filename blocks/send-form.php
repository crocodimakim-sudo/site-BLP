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
// 2026-05-12: добавлен второй honeypot `fax_number` — XRumer знает `website`, новое имя его обманывает
if (!empty($input['website']) || !empty($input['fax_number'])) {
    error_log('FORM_SPAM honeypot triggered: ip=' . ($_SERVER['REMOTE_ADDR'] ?? '?') . ' ua=' . substr($_SERVER['HTTP_USER_AGENT'] ?? '?', 0, 100));
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

// 2026-05-01: Referer — принимаем заявки только со страниц сайта
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (empty($referer) || strpos($referer, 'building-port.ru') === false) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Неверный источник запроса']);
    exit;
}

// 2026-05-06: скорость заполнения — боты заполняют мгновенно (капча заменена на honeypot)
$form_time = $_SESSION['form_time'] ?? 0;
if ($_rl_now - $form_time < 3) {
    http_response_code(429);
    echo json_encode(['ok' => false, 'error' => 'Слишком быстро. Пожалуйста, заполните форму внимательно.']);
    exit;
}

// 2026-05-01: rate limit по email — не более 1 заявки в сутки с одного email
$email_raw = isset($input['email']) ? strtolower(trim((string)$input['email'])) : '';
if ($email_raw) {
    $_rl_email_file = $_rl_dir . '/rl_email_' . md5($email_raw) . '.json';
    $_rl_email_hits = is_file($_rl_email_file) ? (json_decode(file_get_contents($_rl_email_file), true) ?: []) : [];
    $_rl_email_hits = array_values(array_filter($_rl_email_hits, fn($t) => $_rl_now - $t < 86400));
    if (count($_rl_email_hits) >= 1) {
        http_response_code(429);
        echo json_encode(['ok' => false, 'error' => 'С этого email уже отправлена заявка. Попробуйте завтра.']);
        exit;
    }
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
$consent = isset($input['consent']) ? $input['consent'] : false;

// Валидация
$errors = [];

if (empty($name) || mb_strlen($name) < 2) {
    $errors[] = 'Укажите корректное имя';
}
// 2026-05-12: anti-spam — имя только буквы/дефис/пробел, никаких цифр (XRumer шлёт Jennavago7357, Broncofeh)
if (!empty($name) && !preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u', $name)) {
    $errors[] = 'Имя должно содержать только буквы';
}
// 2026-05-12: anti-spam — требуем минимум 1 кириллический символ (сайт русскоязычный)
if (!empty($name) && !preg_match('/[а-яА-ЯёЁ]/u', $name)) {
    error_log('FORM_SPAM latin-only name: name=' . substr($name, 0, 30) . ' ip=' . ($_SERVER['REMOTE_ADDR'] ?? '?'));
    $errors[] = 'Укажите имя на русском языке';
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
$headers = "From: noreply@building-port.ru\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// 2026-04-24: сохранить заявку в SQLite
// 2026-05-07: фиксируем версию текста согласия и время — доказательство ст. 9 152-ФЗ
define('BLP_CONSENT_VERSION', '2026-05-07-v2'); // меняется при изменении текста чекбокса
$consentAt = date('c'); // ISO 8601 с таймзоной
$dbFile = dirname(__DIR__) . '/database/leads.db';
try {
    $pdo = new PDO('sqlite:' . $dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE TABLE IF NOT EXISTS leads (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        created_at TEXT NOT NULL,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        email TEXT,
        company TEXT,
        marketing INTEGER DEFAULT 0,
        mail_sent INTEGER DEFAULT 0,
        ip TEXT,
        consent_text_version TEXT,
        consent_at TEXT,
        user_agent TEXT
    )");
    // 2026-05-07: миграция для существующих БД — добавляем колонки если их нет
    $cols = $pdo->query("PRAGMA table_info(leads)")->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('consent_text_version', $cols, true)) $pdo->exec("ALTER TABLE leads ADD COLUMN consent_text_version TEXT");
    if (!in_array('consent_at', $cols, true))           $pdo->exec("ALTER TABLE leads ADD COLUMN consent_at TEXT");
    if (!in_array('user_agent', $cols, true))           $pdo->exec("ALTER TABLE leads ADD COLUMN user_agent TEXT");

    $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
    $stmt = $pdo->prepare("INSERT INTO leads (created_at, name, phone, email, company, marketing, ip, consent_text_version, consent_at, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        date('Y-m-d H:i:s'),
        $name, $phone, $email, $company,
        isset($input['marketing']) && $input['marketing'] ? 1 : 0,
        $_SERVER['REMOTE_ADDR'] ?? '',
        BLP_CONSENT_VERSION,
        $consentAt,
        $userAgent
    ]);
} catch (Exception $e) {
    // лог не блокирует отправку
    error_log('SQLite error: ' . $e->getMessage());
}

// Отправляем письмо
$mailSent = @mail($to, $subject, $body, $headers);

// 2026-04-24: отбивка пользователю — подтверждение получения заявки
if ($mailSent && !empty($email)) {
    $userSubject = 'Ваша заявка принята — BLP Board';
    $userBody  = "Здравствуйте, " . $name . "!\n\n";
    $userBody .= "Ваша заявка успешно принята. Наш менеджер свяжется с вами в течение рабочего дня.\n\n";
    $userBody .= "Если вопрос срочный, позвоните нам:\n";
    $userBody .= "+7 (495) 984-96-89\n\n";
    $userBody .= "С уважением,\nBLP Board\nhttps://building-port.ru/";
    $userHeaders  = "From: noreply@building-port.ru\r\n";
    $userHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";
    @mail($email, $userSubject, $userBody, $userHeaders);
}

// 2026-04-23: лог заявки в файл независимо от результата mail()
// 2026-05-07: ПД маскируются (R-008) — лог только для отладки SMTP, не для хранения ПД (для этого SQLite)
$logDir = dirname(__DIR__) . '/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logFile = $logDir . '/leads_' . date('Y-m') . '.log';
// маскирование: телефон → последние 4 цифры; email → первый символ + домен; имя → первая буква
$maskPhone = $phone ? '***' . substr(preg_replace('/\D/', '', $phone), -4) : '-';
$maskEmail = $email ? (substr($email, 0, 1) . '***@' . (strpos($email, '@') !== false ? substr($email, strpos($email, '@') + 1) : '?')) : '-';
$maskName  = $name  ? (mb_substr($name, 0, 1) . '***') : '-';
$logLine = date('Y-m-d H:i:s')
    . ' | ' . $maskName
    . ' | ' . $maskPhone
    . ' | ' . $maskEmail
    . ' | ' . ($company ? '[set]' : '-')
    . ' | mail:' . ($mailSent ? 'ok' : 'FAIL')
    . "\n";
@file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

// 2026-05-07: автоматическая ротация — удаляем логи старше 30 дней (R-008)
$logCleanupMarker = $logDir . '/.last_cleanup';
$lastCleanup = is_file($logCleanupMarker) ? (int)@file_get_contents($logCleanupMarker) : 0;
if ($_rl_now - $lastCleanup > 86400) { // не чаще раза в сутки
    @file_put_contents($logCleanupMarker, $_rl_now);
    $cutoff = $_rl_now - 30 * 86400;
    foreach (glob($logDir . '/leads_*.log') ?: [] as $oldLog) {
        if (filemtime($oldLog) < $cutoff) @unlink($oldLog);
    }
}

// 2026-04-24: обновить mail_sent в SQLite
if (isset($stmt)) {
    try {
        $lastId = $pdo->lastInsertId();
        $pdo->prepare("UPDATE leads SET mail_sent = ? WHERE id = ?")->execute([$mailSent ? 1 : 0, $lastId]);
    } catch (Exception $e) {}
}

// 2026-04-24: записать в rate limit + ротация CSRF
$_rl_hits[] = $_rl_now;
@file_put_contents($_rl_file, json_encode($_rl_hits), LOCK_EX);
unset($_SESSION['csrf_token']);
unset($_SESSION['form_time']);

// 2026-05-01: записать rate limit по email
if (!empty($email_raw)) {
    $_rl_email_hits[] = $_rl_now;
    @file_put_contents($_rl_email_file, json_encode($_rl_email_hits), LOCK_EX);
}

if ($mailSent) {
    echo json_encode(['ok' => true, 'message' => 'Заявка успешно отправлена']);
} else {
    // 2026-04-23: честный ответ при ошибке mail() — заявка сохранена в лог
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Не удалось отправить заявку. Позвоните нам: +7 (495) 984-96-89']);
}
