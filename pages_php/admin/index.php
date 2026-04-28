<?php
// 2026-04-27: admin-панель BLP Board (заявки + блог + страницы + проекты)
// 2026-04-27: display_errors отключён — не раскрывать пути и конфиг на проде
error_reporting(0);
ini_set('display_errors', '0');

session_start();

// ===== Constants =====
// 2026-04-27: bcrypt вместо sha256 — password_verify при логине
define('ADMIN_PASSWORD_HASH', '$2y$10$zDWEW3298HRSZ9dhM58zduhVnf18Ripi/XvHb3EklYRyx9fdPFc9y');
// 2026-04-27: относительные пути через __DIR__ — Windows-хардкод убран
define('LEADS_DB_PATH', realpath(__DIR__ . '/../../database/leads.db') ?: __DIR__ . '/../../database/leads.db');
define('BLOG_DB_PATH',  realpath(__DIR__ . '/../../database/blog.db')  ?: __DIR__ . '/../../database/blog.db');

// 2026-04-27: пути к pages.json (database/) — приоритет тому, который существует
$pages_json_d = __DIR__ . '/../../database/pages.json';
if (file_exists($pages_json_d)) {
    define('PAGES_JSON_PATH', realpath($pages_json_d));
} else {
    define('PAGES_JSON_PATH', $pages_json_d);
}

// 2026-04-27: пути к JSON-конфигам настроек / партнёров / сертификатов
function resolve_json_path(string $relative): string {
    $candidate = __DIR__ . '/../../database/' . $relative;
    if (file_exists($candidate)) {
        $real = realpath($candidate);
        if ($real !== false) return $real;
    }
    return $candidate;
}
define('SITE_CONFIG_JSON_PATH',  resolve_json_path('site_config.json'));
define('PARTNERS_JSON_PATH',     resolve_json_path('partners.json'));
define('CERTIFICATES_JSON_PATH', resolve_json_path('certificates.json'));
// 2026-04-27: catalog.json — тексты серий каталога
define('CATALOG_JSON_PATH',      resolve_json_path('catalog.json'));

// 2026-04-27: пути к директории проектов — пробуем оба варианта
function projects_root_path(): string {
    static $path = null;
    if ($path !== null) return $path;
    $candidates = [
        'C:/xampp/htdocs/blp/images-convert/pages/projects',
        __DIR__ . '/../../images-convert/pages/projects',
    ];
    foreach ($candidates as $c) {
        if (is_dir($c)) {
            $path = rtrim(str_replace('\\', '/', realpath($c)), '/');
            return $path;
        }
    }
    // По умолчанию — путь относительно D:
    $path = rtrim(str_replace('\\', '/', __DIR__ . '/../../images-convert/pages/projects'), '/');
    return $path;
}

// ===== CSRF =====
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

function check_csrf(string $token): bool {
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function h(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ===== DB connections =====
function leads_db(): PDO {
    static $db = null;
    if ($db === null) {
        $db = new PDO('sqlite:' . LEADS_DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("CREATE TABLE IF NOT EXISTS leads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            created_at TEXT NOT NULL,
            name TEXT NOT NULL,
            phone TEXT NOT NULL,
            email TEXT,
            company TEXT,
            message TEXT,
            marketing INTEGER DEFAULT 0,
            mail_sent INTEGER DEFAULT 0,
            ip TEXT
        )");
    }
    return $db;
}

function blog_db(): PDO {
    static $db = null;
    if ($db === null) {
        $db = new PDO('sqlite:' . BLOG_DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $db;
}

// ===== pages.json helpers =====
function load_pages_config(): array {
    $path = PAGES_JSON_PATH;
    if (!file_exists($path)) return ['pages' => []];
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    if (!is_array($data) || empty($data['pages'])) return ['pages' => []];
    return $data;
}

function save_pages_config(array $data): bool {
    $path = PAGES_JSON_PATH;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents($path, $json) !== false;
}

// 2026-04-27: site_config / partners / certificates helpers
function load_site_config(): array {
    if (!file_exists(SITE_CONFIG_JSON_PATH)) return [];
    $data = json_decode((string)file_get_contents(SITE_CONFIG_JSON_PATH), true);
    return is_array($data) ? $data : [];
}

function save_site_config(array $data): bool {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents(SITE_CONFIG_JSON_PATH, $json) !== false;
}

function load_partners(): array {
    if (!file_exists(PARTNERS_JSON_PATH)) return [];
    $data = json_decode((string)file_get_contents(PARTNERS_JSON_PATH), true);
    if (!is_array($data) || empty($data['partners']) || !is_array($data['partners'])) return [];
    return $data['partners'];
}

function save_partners(array $partners): bool {
    $payload = ['partners' => array_values($partners)];
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents(PARTNERS_JSON_PATH, $json) !== false;
}

function next_partner_id(array $partners): int {
    $max = 0;
    foreach ($partners as $p) {
        $id = (int)($p['id'] ?? 0);
        if ($id > $max) $max = $id;
    }
    return $max + 1;
}

function load_certificates(): array {
    if (!file_exists(CERTIFICATES_JSON_PATH)) return [];
    $data = json_decode((string)file_get_contents(CERTIFICATES_JSON_PATH), true);
    if (!is_array($data) || empty($data['certificates']) || !is_array($data['certificates'])) return [];
    return $data['certificates'];
}

function save_certificates(array $certs): bool {
    $payload = ['certificates' => array_values($certs)];
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents(CERTIFICATES_JSON_PATH, $json) !== false;
}

function next_certificate_id(array $certs): int {
    $max = 0;
    foreach ($certs as $c) {
        $id = (int)($c['id'] ?? 0);
        if ($id > $max) $max = $id;
    }
    return $max + 1;
}

// 2026-04-27: catalog.json helpers (тексты серий каталога)
function load_catalog(): array {
    if (!file_exists(CATALOG_JSON_PATH)) return ['series' => []];
    $data = json_decode((string)file_get_contents(CATALOG_JSON_PATH), true);
    if (!is_array($data) || empty($data['series']) || !is_array($data['series'])) return ['series' => []];
    return $data;
}

function save_catalog(array $data): bool {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents(CATALOG_JSON_PATH, $json) !== false;
}

// ===== projects helpers =====
function read_project_meta(string $folder): array {
    $base = projects_root_path();
    $metaFile = $base . '/' . $folder . '/meta.json';
    if (!file_exists($metaFile)) {
        return ['name' => '', 'location' => '', 'tag' => '', 'category' => '', 'order' => 999];
    }
    $data = json_decode(file_get_contents($metaFile), true);
    if (!is_array($data)) return ['name' => '', 'location' => '', 'tag' => '', 'category' => '', 'order' => 999];
    return [
        'name'     => (string)($data['name']     ?? ''),
        'location' => (string)($data['location'] ?? ''),
        'tag'      => (string)($data['tag']      ?? ''),
        'category' => (string)($data['category'] ?? ''),
        'order'    => (int)($data['order']       ?? 999),
    ];
}

function write_project_meta(string $folder, array $meta): bool {
    $base = projects_root_path();
    $dir = $base . '/' . $folder;
    if (!is_dir($dir)) return false;
    $payload = [
        'name'     => (string)($meta['name']     ?? ''),
        'location' => (string)($meta['location'] ?? ''),
        'tag'      => (string)($meta['tag']      ?? ''),
        'category' => (string)($meta['category'] ?? ''),
        'order'    => (int)($meta['order']       ?? 999),
    ];
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return file_put_contents($dir . '/meta.json', $json) !== false;
}

function list_project_folders(): array {
    $base = projects_root_path();
    if (!is_dir($base)) return [];
    $folders = [];
    foreach (scandir($base) ?: [] as $f) {
        if ($f === '.' || $f === '..') continue;
        if (is_dir($base . '/' . $f)) $folders[] = $f;
    }
    sort($folders);
    return $folders;
}

function count_project_images(string $folder): int {
    $base = projects_root_path();
    $dir = $base . '/' . $folder;
    if (!is_dir($dir)) return 0;
    $exts = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG'];
    $unique = [];
    foreach ($exts as $ext) {
        foreach (glob($dir . '/*.' . $ext) ?: [] as $file) {
            $unique[pathinfo($file, PATHINFO_FILENAME)] = true;
        }
    }
    return count($unique);
}

// 2026-04-27: авто-конвертация загружаемого изображения → JPEG + WebP через GD
function convert_and_save_image(string $tmp_path, string $dest_dir, string $basename): array {
    if (!function_exists('imagecreatefromjpeg')) return [];
    $info = @getimagesize($tmp_path);
    if (!$info) return [];
    switch ($info[2]) {
        case IMAGETYPE_JPEG: $src = @imagecreatefromjpeg($tmp_path); break;
        case IMAGETYPE_PNG:  $src = @imagecreatefrompng($tmp_path);  break;
        case IMAGETYPE_WEBP: $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmp_path) : false; break;
        case IMAGETYPE_GIF:  $src = @imagecreatefromgif($tmp_path);  break;
        default: return [];
    }
    if (!$src) return [];
    $w = imagesx($src); $h = imagesy($src);
    $flat = imagecreatetruecolor($w, $h);
    imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
    imagecopy($flat, $src, 0, 0, 0, 0, $w, $h);
    imagedestroy($src);
    $created = [];
    if (imagejpeg($flat, $dest_dir . '/' . $basename . '.jpg', 82))
        $created[] = $basename . '.jpg';
    if (function_exists('imagewebp') && imagewebp($flat, $dest_dir . '/' . $basename . '.webp', 82))
        $created[] = $basename . '.webp';
    imagedestroy($flat);
    return $created;
}

// 2026-04-27: список файлов фотографий в папке проекта (имена без пути)
function list_project_photos(string $folder): array {
    $base = projects_root_path();
    $dir = $base . '/' . $folder;
    if (!is_dir($dir)) return [];
    $exts = ['jpg', 'jpeg', 'png', 'webp'];
    $byName = [];
    foreach ($exts as $ext) {
        foreach (glob($dir . '/*.{' . $ext . ',' . strtoupper($ext) . '}', GLOB_BRACE) ?: [] as $f) {
            $name   = pathinfo($f, PATHINFO_FILENAME);
            $curExt = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (!isset($byName[$name]) || $curExt === 'webp') {
                $byName[$name] = basename($f);
            }
        }
    }
    $files = array_values($byName);
    sort($files);
    return $files;
}

function valid_folder_slug(string $s): bool {
    return (bool)preg_match('/^[a-z0-9-]+$/', $s);
}

// ===== Login handler =====
$login_error = '';
if (($_POST['action'] ?? '') === 'login') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        $login_error = 'Сессия истекла. Обновите страницу.';
    } else {
        $pw = (string)($_POST['password'] ?? '');
        if (password_verify($pw, ADMIN_PASSWORD_HASH)) {
            $_SESSION['admin_authed'] = true;
            session_regenerate_id(true);
            header('Location: ?s=leads');
            exit;
        }
        $login_error = 'Неверный пароль';
    }
}

// Logout
if (($_GET['action'] ?? '') === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header('Location: ?');
    exit;
}

// ===== AUTH GATE =====
$is_authed = !empty($_SESSION['admin_authed']);

if (!$is_authed) {
    // Render login form and exit
    ?><!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Админ-панель — Вход — BLP Board</title>
<link rel="stylesheet" href="/blp/css/pages/admin.css">
</head>
<body class="admin-login-body">
<div class="admin-login-card">
    <h1 class="admin-login-title">BLP Admin</h1>
    <p class="admin-login-subtitle">Вход в админ-панель</p>
    <?php if ($login_error): ?>
        <div class="admin-alert admin-alert-error"><?= h($login_error) ?></div>
    <?php endif; ?>
    <form method="post" action="" class="admin-login-form">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
        <label for="pw" class="admin-label">Пароль</label>
        <input type="password" name="password" id="pw" class="admin-input" autofocus required>
        <button type="submit" class="btn-primary admin-login-submit">Войти</button>
    </form>
</div>
</body>
</html><?php
    exit;
}

// ===== Authenticated actions =====
$flash = '';

// 2026-04-27: batch-save — накопленные toggle-изменения через JSON POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'batch-save') {
    header('Content-Type: application/json; charset=UTF-8');
    $token = $_GET['csrf'] ?? '';
    if (!check_csrf($token)) {
        echo json_encode(['ok' => false, 'error' => 'CSRF']);
        exit;
    }
    $body = json_decode((string)file_get_contents('php://input'), true);
    $changes = is_array($body) && isset($body['changes']) && is_array($body['changes']) ? $body['changes'] : [];

    $applied = 0;
    $errors = [];
    // Сбор изменений по разделам — чтобы JSON-файлы загружать/сохранять один раз
    $blog_updates = [];
    $pages_dirty = false; $pages_cfg = null;
    $partners_dirty = false; $partners_arr = null;
    $certs_dirty = false; $certs_arr = null;

    foreach ($changes as $ch) {
        $section_ch = (string)($ch['section'] ?? '');
        $id_ch      = $ch['id'] ?? '';
        $field_ch   = (string)($ch['field'] ?? '');
        $newValue   = !empty($ch['newValue']);

        try {
            if ($section_ch === 'blog' && $field_ch === 'is_published') {
                $blog_updates[] = [(int)$id_ch, $newValue ? 1 : 0];
            } elseif ($section_ch === 'pages' && $field_ch === 'is_live') {
                if ($pages_cfg === null) $pages_cfg = load_pages_config();
                foreach ($pages_cfg['pages'] as &$pg) {
                    if (($pg['slug'] ?? '') === (string)$id_ch) { $pg['is_live'] = $newValue; $pages_dirty = true; break; }
                }
                unset($pg);
            } elseif ($section_ch === 'partners' && $field_ch === 'is_active') {
                if ($partners_arr === null) $partners_arr = load_partners();
                foreach ($partners_arr as &$pp) {
                    if ((int)($pp['id'] ?? 0) === (int)$id_ch) { $pp['is_active'] = $newValue; $partners_dirty = true; break; }
                }
                unset($pp);
            } elseif ($section_ch === 'partners' && $field_ch === 'dark_bg') {
                // 2026-04-27: toggle тёмного фона для логотипа партнёра
                if ($partners_arr === null) $partners_arr = load_partners();
                foreach ($partners_arr as &$pp) {
                    if ((int)($pp['id'] ?? 0) === (int)$id_ch) { $pp['dark_bg'] = $newValue; $partners_dirty = true; break; }
                }
                unset($pp);
            } elseif ($section_ch === 'certificates' && $field_ch === 'is_active') {
                if ($certs_arr === null) $certs_arr = load_certificates();
                foreach ($certs_arr as &$cc) {
                    if ((int)($cc['id'] ?? 0) === (int)$id_ch) { $cc['is_active'] = $newValue; $certs_dirty = true; break; }
                }
                unset($cc);
            } else {
                $errors[] = 'Неизвестный раздел: ' . $section_ch . '/' . $field_ch;
                continue;
            }
            $applied++;
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    try {
        if (!empty($blog_updates)) {
            $db = blog_db();
            $st = $db->prepare('UPDATE articles SET is_published = ? WHERE id = ?');
            foreach ($blog_updates as $row) {
                $st->execute([$row[1], $row[0]]);
            }
        }
        if ($pages_dirty)    save_pages_config($pages_cfg);
        if ($partners_dirty) save_partners($partners_arr);
        if ($certs_dirty)    save_certificates($certs_arr);
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['ok' => true, 'applied' => $applied, 'errors' => $errors]);
    exit;
}

// POST: save article
if (($_POST['action'] ?? '') === 'save-article') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_POST['id'] ?? 0);
    $slug = trim((string)($_POST['slug'] ?? ''));
    $category = trim((string)($_POST['category'] ?? ''));
    $title = trim((string)($_POST['title'] ?? ''));
    $subtitle = trim((string)($_POST['subtitle'] ?? ''));
    $content = (string)($_POST['content'] ?? '');
    $image = trim((string)($_POST['image'] ?? ''));
    $read_time = (int)($_POST['read_time'] ?? 5);
    $published_at_raw = trim((string)($_POST['published_at'] ?? ''));
    if ($published_at_raw !== '') {
        $published_at = str_replace('T', ' ', $published_at_raw);
        if (strlen($published_at) === 16) $published_at .= ':00';
    } else {
        $published_at = date('Y-m-d H:i:s');
    }
    $is_published = !empty($_POST['is_published']) ? 1 : 0;

    if ($slug === '' || $title === '' || $category === '') {
        $flash = 'Поля slug, title, category обязательны';
    } else {
        $db = blog_db();
        if ($id > 0) {
            $st = $db->prepare("UPDATE articles SET slug=?, category=?, title=?, subtitle=?, content=?, image=?, read_time=?, published_at=?, is_published=? WHERE id=?");
            $st->execute([$slug, $category, $title, $subtitle, $content, $image, $read_time, $published_at, $is_published, $id]);
        } else {
            $st = $db->prepare("INSERT INTO articles (slug, category, title, subtitle, content, image, read_time, views, published_at, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, ?)");
            $st->execute([$slug, $category, $title, $subtitle, $content, $image, $read_time, $published_at, $is_published]);
        }
        header('Location: ?s=blog&saved=1');
        exit;
    }
}

// 2026-04-27: POST save-page-note — обновление поля notes для страницы
if (($_POST['action'] ?? '') === 'save-page-note') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $slug = trim((string)($_POST['slug'] ?? ''));
    $note = trim((string)($_POST['note'] ?? ''));
    if ($slug !== '') {
        $cfg = load_pages_config();
        $found = false;
        foreach ($cfg['pages'] as &$pg) {
            if (($pg['slug'] ?? '') === $slug) {
                $pg['notes'] = $note;
                $found = true;
                break;
            }
        }
        unset($pg);
        if ($found && save_pages_config($cfg)) {
            header('Location: ?s=pages&note_saved=1');
            exit;
        }
    }
    $flash = 'Не удалось сохранить примечание';
}

// 2026-04-27: POST save-project — сохранение/создание проекта
if (($_POST['action'] ?? '') === 'save-project') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $folder_in = trim((string)($_POST['folder'] ?? ''));
    $is_new = (($_POST['is_new'] ?? '0') === '1');
    $name = trim((string)($_POST['name'] ?? ''));
    $location = trim((string)($_POST['location'] ?? ''));
    $tag = trim((string)($_POST['tag'] ?? ''));
    $category = trim((string)($_POST['category'] ?? ''));
    $order = (int)($_POST['order'] ?? 999);

    if ($is_new) {
        if (!valid_folder_slug($folder_in)) {
            $flash = 'Имя папки: только латиница, цифры и дефис';
        } else {
            $base = projects_root_path();
            $dir = $base . '/' . $folder_in;
            if (is_dir($dir)) {
                $flash = 'Папка с таким именем уже существует';
            } else {
                if (!@mkdir($dir, 0775, true)) {
                    $flash = 'Не удалось создать папку: ' . h($dir);
                } else {
                    write_project_meta($folder_in, compact('name', 'location', 'tag', 'category', 'order'));
                    header('Location: ?s=projects&proj_saved=1');
                    exit;
                }
            }
        }
    } else {
        if (!valid_folder_slug($folder_in)) {
            $flash = 'Некорректное имя папки';
        } else {
            $base = projects_root_path();
            if (!is_dir($base . '/' . $folder_in)) {
                $flash = 'Папка не найдена';
            } else {
                if (write_project_meta($folder_in, compact('name', 'location', 'tag', 'category', 'order'))) {
                    header('Location: ?s=projects&proj_saved=1');
                    exit;
                }
                $flash = 'Не удалось записать meta.json';
            }
        }
    }
}

// 2026-04-27: POST upload-photo — загрузка фотографий в папку проекта
if (($_GET['action'] ?? '') === 'upload-photo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $folder = trim((string)($_GET['folder'] ?? ''));
    if (!valid_folder_slug($folder)) {
        $flash = 'Некорректное имя папки';
    } else {
        $base = projects_root_path();
        $dir = $base . '/' . $folder;
        if (!is_dir($dir)) {
            $flash = 'Папка проекта не найдена';
        } else {
            $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];
            $allowed_ext  = ['jpg', 'jpeg', 'png', 'webp'];
            $max_size = 10 * 1024 * 1024; // 10 MB
            $uploaded_count = 0;
            $errors = [];
            if (!empty($_FILES['photos']['name']) && is_array($_FILES['photos']['name'])) {
                $count = count($_FILES['photos']['name']);
                for ($i = 0; $i < $count; $i++) {
                    if (($_FILES['photos']['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
                    $tmp  = $_FILES['photos']['tmp_name'][$i];
                    $orig = (string)$_FILES['photos']['name'][$i];
                    $size = (int)$_FILES['photos']['size'][$i];
                    if ($size > $max_size) { $errors[] = $orig . ' — больше 10 МБ'; continue; }
                    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowed_ext, true)) { $errors[] = $orig . ' — неподдерживаемый формат'; continue; }
                    $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
                    $mime = $finfo ? finfo_file($finfo, $tmp) : ($_FILES['photos']['type'][$i] ?? '');
                    if ($finfo) finfo_close($finfo);
                    if (!in_array($mime, $allowed_mime, true)) { $errors[] = $orig . ' — MIME не разрешён'; continue; }
                    // sanitize: только латиница, цифры, дефис, подчёркивание
                    $base_name = pathinfo($orig, PATHINFO_FILENAME);
                    $safe = preg_replace('/[^a-zA-Z0-9_-]/', '-', $base_name);
                    if ($safe === '' || $safe === '-') $safe = 'photo';
                    $safe = mb_substr($safe, 0, 80);
                    // защита от перезаписи по базовому имени (без расширения)
                    $candidate = $safe;
                    $n = 1;
                    while (file_exists($dir . '/' . $candidate . '.webp') || file_exists($dir . '/' . $candidate . '.jpg')) {
                        $candidate = $safe . '-' . $n;
                        $n++;
                        if ($n > 999) break;
                    }
                    $converted = convert_and_save_image($tmp, $dir, $candidate);
                    if (!empty($converted)) {
                        $uploaded_count++;
                    } else {
                        $errors[] = $orig . ' — не удалось конвертировать';
                    }
                }
            }
            if ($uploaded_count > 0) {
                $msg = '?s=project-edit&folder=' . urlencode($folder) . '&uploaded=' . $uploaded_count;
                if (!empty($errors)) $msg .= '&upload_errors=' . urlencode(implode('; ', $errors));
                header('Location: ' . $msg);
                exit;
            } else {
                $flash = 'Не загружено ни одного файла' . (!empty($errors) ? ': ' . implode('; ', $errors) : '');
            }
        }
    }
}

// 2026-04-27: GET del-photo — удаление фотографии из папки проекта
if (($_GET['action'] ?? '') === 'del-photo') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $folder = trim((string)($_GET['folder'] ?? ''));
    $file   = trim((string)($_GET['file'] ?? ''));
    if (!valid_folder_slug($folder)) {
        $flash = 'Некорректное имя папки';
    } elseif ($file === '' || basename($file) !== $file || strpos($file, '..') !== false) {
        $flash = 'Некорректное имя файла';
    } else {
        $base = projects_root_path();
        $target = $base . '/' . $folder . '/' . $file;
        if (file_exists($target) && is_file($target)) {
            $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed_ext, true)) {
                $stem = pathinfo($target, PATHINFO_FILENAME);
                @unlink($target);
                // Удалить все форматы того же базового имени
                foreach ($allowed_ext as $ex) {
                    $sibling = $base . '/' . $folder . '/' . $stem . '.' . $ex;
                    if ($sibling !== $target && file_exists($sibling)) @unlink($sibling);
                }
                header('Location: ?s=project-edit&folder=' . urlencode($folder) . '&photo_deleted=1');
                exit;
            }
        }
        $flash = 'Файл не найден';
    }
}

// 2026-04-27: POST save-settings — обновление site_config.json
if (($_POST['action'] ?? '') === 'save-settings') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $fields = ['phone', 'phone_link', 'email', 'address', 'working_hours',
               'company_name', 'inn', 'ogrn', 'kpp', 'legal_address', 'ga4_id',
               'yandex_metrika_id', 'yandex_direct_id', 'vk_pixel_id'];
    $cfg = load_site_config();
    foreach ($fields as $f) {
        $cfg[$f] = trim((string)($_POST[$f] ?? ''));
    }
    if (save_site_config($cfg)) {
        header('Location: ?s=settings&settings_saved=1');
        exit;
    }
    $flash = 'Не удалось сохранить настройки';
}

// 2026-04-27: POST save-partner — создание/обновление партнёра
if (($_POST['action'] ?? '') === 'save-partner') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id        = (int)($_POST['id'] ?? 0);
    $name      = trim((string)($_POST['name'] ?? ''));
    $url       = trim((string)($_POST['url'] ?? ''));
    $logo      = trim((string)($_POST['logo'] ?? ''));
    $order     = (int)($_POST['order'] ?? 999);
    $is_active = !empty($_POST['is_active']);
    // 2026-04-27: dark_bg — превью на тёмной плашке
    $dark_bg   = !empty($_POST['dark_bg']);

    if ($name === '' || $logo === '') {
        $flash = 'Поля «Название» и «Логотип» обязательны';
    } else {
        $partners = load_partners();
        if ($id > 0) {
            $found = false;
            foreach ($partners as &$p) {
                if ((int)($p['id'] ?? 0) === $id) {
                    $p['name'] = $name; $p['url'] = $url; $p['logo'] = $logo;
                    $p['order'] = $order; $p['is_active'] = $is_active;
                    $p['dark_bg'] = $dark_bg;
                    $found = true;
                    break;
                }
            }
            unset($p);
            if (!$found) {
                $flash = 'Партнёр не найден';
            } else {
                save_partners($partners);
                header('Location: ?s=partners&partner_saved=1');
                exit;
            }
        } else {
            $partners[] = [
                'id'        => next_partner_id($partners),
                'name'      => $name,
                'url'       => $url,
                'logo'      => $logo,
                'order'     => $order,
                'is_active' => $is_active,
                'dark_bg'   => $dark_bg,
            ];
            save_partners($partners);
            header('Location: ?s=partners&partner_saved=1');
            exit;
        }
    }
}

// 2026-04-27: POST save-certificate — создание/обновление сертификата
if (($_POST['action'] ?? '') === 'save-certificate') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id          = (int)($_POST['id'] ?? 0);
    $name        = trim((string)($_POST['name'] ?? ''));
    $file        = trim((string)($_POST['file'] ?? ''));
    $description = trim((string)($_POST['description'] ?? ''));
    $order       = (int)($_POST['order'] ?? 999);
    $is_active   = !empty($_POST['is_active']);

    if ($name === '' || $file === '') {
        $flash = 'Поля «Название» и «Файл» обязательны';
    } else {
        $certs = load_certificates();
        if ($id > 0) {
            $found = false;
            foreach ($certs as &$c) {
                if ((int)($c['id'] ?? 0) === $id) {
                    $c['name'] = $name; $c['file'] = $file; $c['description'] = $description;
                    $c['order'] = $order; $c['is_active'] = $is_active;
                    $found = true;
                    break;
                }
            }
            unset($c);
            if (!$found) {
                $flash = 'Сертификат не найден';
            } else {
                save_certificates($certs);
                header('Location: ?s=certificates&cert_saved=1');
                exit;
            }
        } else {
            $certs[] = [
                'id'          => next_certificate_id($certs),
                'name'        => $name,
                'file'        => $file,
                'description' => $description,
                'order'       => $order,
                'is_active'   => $is_active,
            ];
            save_certificates($certs);
            header('Location: ?s=certificates&cert_saved=1');
            exit;
        }
    }
}

// 2026-04-27: POST upload-catalog-image — загрузка изображения серии каталога
if (($_POST['action'] ?? '') === 'upload-catalog-image') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $series = trim((string)($_POST['series'] ?? ''));
    $allowed_series = ['nature', 'polished', 'texture', 'walypan'];
    if (!in_array($series, $allowed_series, true)) {
        $flash = 'Неизвестная серия каталога';
    } elseif (empty($_FILES['image_file']['name']) || ($_FILES['image_file']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $flash = 'Файл не загружен';
    } else {
        $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];
        $allowed_ext  = ['jpg', 'jpeg', 'png', 'webp'];
        $tmp  = $_FILES['image_file']['tmp_name'];
        $orig = (string)$_FILES['image_file']['name'];
        $size = (int)$_FILES['image_file']['size'];
        $max_size = 10 * 1024 * 1024;
        $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
        $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
        $mime = $finfo ? finfo_file($finfo, $tmp) : ($_FILES['image_file']['type'] ?? '');
        if ($finfo) finfo_close($finfo);

        if ($size > $max_size) {
            $flash = 'Файл больше 10 МБ';
        } elseif (!in_array($ext, $allowed_ext, true) || !in_array($mime, $allowed_mime, true)) {
            $flash = 'Неподдерживаемый формат (нужен JPG, PNG или WEBP)';
        } else {
            // Целевая папка: пробуем XAMPP, затем D:
            $candidates = [
                'C:/xampp/htdocs/blp/images-convert/pages/catalog',
                __DIR__ . '/../../images-convert/pages/catalog',
            ];
            $target_dir = null;
            foreach ($candidates as $c) {
                if (is_dir($c)) { $target_dir = rtrim(str_replace('\\', '/', realpath($c)), '/'); break; }
            }
            if ($target_dir === null) {
                $target_dir = rtrim(str_replace('\\', '/', __DIR__ . '/../../images-convert/pages/catalog'), '/');
                @mkdir($target_dir, 0775, true);
            }

            // Удалить все предыдущие версии series-{name}.*
            foreach ($allowed_ext as $ex) {
                $old = $target_dir . '/series-' . $series . '.' . $ex;
                if (file_exists($old)) @unlink($old);
            }
            $catalog_basename = 'series-' . $series;
            $converted = convert_and_save_image($tmp, $target_dir, $catalog_basename);
            if (!empty($converted)) {
                $has_webp = in_array($catalog_basename . '.webp', $converted);
                $final_name = $catalog_basename . ($has_webp ? '.webp' : '.jpg');
                $cfg = load_catalog();
                if (!isset($cfg['series']) || !is_array($cfg['series'])) $cfg['series'] = [];
                if (!isset($cfg['series'][$series]) || !is_array($cfg['series'][$series])) $cfg['series'][$series] = [];
                $cfg['series'][$series]['image'] = '/blp/images-convert/pages/catalog/' . $final_name;
                save_catalog($cfg);
                header('Location: ?s=catalog&catalog_image_uploaded=1');
                exit;
            }
            $flash = 'Не удалось конвертировать файл';
        }
    }
}

// 2026-04-27: POST upload-walypan-slide — добавление фото в слайдер WALYPAN
if (($_GET['action'] ?? '') === 'upload-walypan-slide' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!check_csrf($_GET['csrf'] ?? '')) { http_response_code(400); die('CSRF'); }
    $candidates = [
        'C:/xampp/htdocs/blp/images-convert/pages/catalog/slider',
        __DIR__ . '/../../images-convert/pages/catalog/slider',
    ];
    $slider_dir = null;
    foreach ($candidates as $c) {
        if (is_dir($c)) { $slider_dir = rtrim(str_replace('\\', '/', realpath($c)), '/'); break; }
    }
    if ($slider_dir === null) {
        $slider_dir = rtrim(str_replace('\\', '/', __DIR__ . '/../../images-convert/pages/catalog/slider'), '/');
        @mkdir($slider_dir, 0775, true);
    }
    $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $allowed_ext  = ['jpg', 'jpeg', 'png', 'webp'];
    $max_size = 10 * 1024 * 1024;
    $uploaded = 0;
    $errors = [];
    if (!empty($_FILES['slides']['name']) && is_array($_FILES['slides']['name'])) {
        $count = count($_FILES['slides']['name']);
        for ($i = 0; $i < $count; $i++) {
            if (($_FILES['slides']['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
            $tmp  = $_FILES['slides']['tmp_name'][$i];
            $orig = (string)$_FILES['slides']['name'][$i];
            $size = (int)$_FILES['slides']['size'][$i];
            if ($size > $max_size) { $errors[] = $orig . ' > 10 МБ'; continue; }
            $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed_ext, true)) { $errors[] = $orig . ' — не поддерживается'; continue; }
            $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
            $mime = $finfo ? finfo_file($finfo, $tmp) : ($_FILES['slides']['type'][$i] ?? '');
            if ($finfo) finfo_close($finfo);
            if (!in_array($mime, $allowed_mime, true)) { $errors[] = $orig . ' — MIME не разрешён'; continue; }
            $n = 1;
            while (file_exists($slider_dir . '/walypan_slide_' . $n . '.webp')
                || file_exists($slider_dir . '/walypan_slide_' . $n . '.jpg')
                || file_exists($slider_dir . '/walypan_slide_' . $n . '.png')) {
                $n++;
                if ($n > 999) break;
            }
            $converted = convert_and_save_image($tmp, $slider_dir, 'walypan_slide_' . $n);
            if (!empty($converted)) $uploaded++;
            else $errors[] = $orig . ' — не удалось конвертировать';
        }
    }
    $msg = '?s=catalog';
    if ($uploaded > 0) $msg .= '&walypan_uploaded=' . $uploaded;
    if (!empty($errors)) $msg .= '&upload_errors=' . urlencode(implode('; ', $errors));
    header('Location: ' . $msg);
    exit;
}

// 2026-04-27: GET del-walypan-slide — удаление фото из слайдера WALYPAN
if (($_GET['action'] ?? '') === 'del-walypan-slide') {
    if (!check_csrf($_GET['csrf'] ?? '')) { http_response_code(400); die('CSRF'); }
    $file = basename(trim((string)($_GET['file'] ?? '')));
    if ($file !== '' && strpos($file, '..') === false) {
        $candidates = [
            'C:/xampp/htdocs/blp/images-convert/pages/catalog/slider',
            __DIR__ . '/../../images-convert/pages/catalog/slider',
        ];
        $slider_dir = null;
        foreach ($candidates as $c) {
            if (is_dir($c)) { $slider_dir = rtrim(str_replace('\\', '/', realpath($c)), '/'); break; }
        }
        if ($slider_dir) {
            $stem = pathinfo($file, PATHINFO_FILENAME);
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ex) {
                $t = $slider_dir . '/' . $stem . '.' . $ex;
                if (file_exists($t)) @unlink($t);
            }
        }
        header('Location: ?s=catalog&walypan_deleted=1');
        exit;
    }
    $flash = 'Некорректное имя файла';
}

// 2026-04-27: POST save-catalog-series — обновление одной серии каталога в catalog.json
if (($_POST['action'] ?? '') === 'save-catalog-series') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $series_key = trim((string)($_POST['series'] ?? ''));
    $allowed_series = ['nature', 'polished', 'texture', 'walypan'];
    $title = trim((string)($_POST['title'] ?? ''));
    $description = trim((string)($_POST['description'] ?? ''));
    $image = trim((string)($_POST['image'] ?? ''));

    if (!in_array($series_key, $allowed_series, true)) {
        $flash = 'Неизвестная серия каталога';
    } elseif ($title === '') {
        $flash = 'Заголовок серии обязателен';
    } else {
        $cfg = load_catalog();
        if (!isset($cfg['series']) || !is_array($cfg['series'])) $cfg['series'] = [];
        $cfg['series'][$series_key] = [
            'title'       => $title,
            'description' => $description,
            'image'       => $image,
        ];
        if (save_catalog($cfg)) {
            header('Location: ?s=catalog&catalog_saved=1');
            exit;
        }
        $flash = 'Не удалось сохранить catalog.json';
    }
}

// GET actions (CSRF-protected via token)
$action = $_GET['action'] ?? '';
if ($action === 'del-lead') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $st = leads_db()->prepare("DELETE FROM leads WHERE id = ?");
        $st->execute([$id]);
    }
    header('Location: ?s=leads&deleted=1');
    exit;
}

if ($action === 'export-csv') {
    $rows = leads_db()->query("SELECT id, created_at, name, phone, email, company, message, marketing, mail_sent, ip FROM leads ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="leads_' . date('Y-m-d_His') . '.csv"');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM для Excel
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID','Дата','Имя','Телефон','Email','Компания','Сообщение','Рассылка','Письмо','IP'], ';');
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['id'], $r['created_at'], $r['name'], $r['phone'], $r['email'],
            $r['company'], $r['message'], $r['marketing'] ? 'Да' : 'Нет',
            $r['mail_sent'] ? 'Да' : 'Нет', $r['ip']
        ], ';');
    }
    fclose($out);
    exit;
}

if ($action === 'toggle-pub') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $st = blog_db()->prepare("UPDATE articles SET is_published = CASE is_published WHEN 1 THEN 0 ELSE 1 END WHERE id = ?");
        $st->execute([$id]);
    }
    header('Location: ?s=blog&toggled=1');
    exit;
}

if ($action === 'del-article') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $st = blog_db()->prepare("DELETE FROM articles WHERE id = ?");
        $st->execute([$id]);
    }
    header('Location: ?s=blog&deleted=1');
    exit;
}

// 2026-04-27: GET toggle-page — переключение is_live для страницы
if ($action === 'toggle-page') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $slug = trim((string)($_GET['slug'] ?? ''));
    if ($slug !== '') {
        $cfg = load_pages_config();
        foreach ($cfg['pages'] as &$pg) {
            if (($pg['slug'] ?? '') === $slug) {
                $pg['is_live'] = empty($pg['is_live']);
                break;
            }
        }
        unset($pg);
        save_pages_config($cfg);
    }
    header('Location: ?s=pages&toggled=1');
    exit;
}

// 2026-04-27: GET del-partner / toggle-partner
if ($action === 'del-partner') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $partners = array_values(array_filter(load_partners(), fn($p) => (int)($p['id'] ?? 0) !== $id));
        save_partners($partners);
    }
    header('Location: ?s=partners&partner_deleted=1');
    exit;
}

if ($action === 'toggle-partner') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $partners = load_partners();
        foreach ($partners as &$p) {
            if ((int)($p['id'] ?? 0) === $id) {
                $p['is_active'] = empty($p['is_active']);
                break;
            }
        }
        unset($p);
        save_partners($partners);
    }
    header('Location: ?s=partners&partner_toggled=1');
    exit;
}

// 2026-04-27: GET del-certificate / toggle-certificate
if ($action === 'del-certificate') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $certs = array_values(array_filter(load_certificates(), fn($c) => (int)($c['id'] ?? 0) !== $id));
        save_certificates($certs);
    }
    header('Location: ?s=certificates&cert_deleted=1');
    exit;
}

if ($action === 'toggle-certificate') {
    if (!check_csrf($_GET['csrf'] ?? '')) {
        http_response_code(400);
        die('CSRF token mismatch');
    }
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $certs = load_certificates();
        foreach ($certs as &$c) {
            if ((int)($c['id'] ?? 0) === $id) {
                $c['is_active'] = empty($c['is_active']);
                break;
            }
        }
        unset($c);
        save_certificates($certs);
    }
    header('Location: ?s=certificates&cert_toggled=1');
    exit;
}

// ===== Section routing =====
$section = $_GET['s'] ?? 'leads';
$valid_sections = ['leads', 'blog', 'blog-edit', 'pages', 'projects', 'project-edit',
                   'settings', 'partners', 'partner-edit', 'certificates', 'certificate-edit',
                   'catalog'];
if (!in_array($section, $valid_sections, true)) $section = 'leads';

// Flash messages from query
if (isset($_GET['saved'])) $flash = 'Статья сохранена';
if (isset($_GET['deleted'])) $flash = 'Удалено';
if (isset($_GET['toggled'])) $flash = 'Статус публикации изменён';
if (isset($_GET['note_saved'])) $flash = 'Примечание сохранено';
if (isset($_GET['proj_saved'])) $flash = 'Проект сохранён';
if (isset($_GET['uploaded'])) {
    $n = (int)$_GET['uploaded'];
    $flash = 'Загружено фото: ' . $n;
    if (!empty($_GET['upload_errors'])) $flash .= '. Ошибки: ' . (string)$_GET['upload_errors'];
}
if (isset($_GET['photo_deleted'])) $flash = 'Фото удалено';
if (isset($_GET['settings_saved'])) $flash = 'Настройки сохранены';
if (isset($_GET['partner_saved'])) $flash = 'Партнёр сохранён';
if (isset($_GET['partner_deleted'])) $flash = 'Партнёр удалён';
if (isset($_GET['partner_toggled'])) $flash = 'Статус партнёра изменён';
if (isset($_GET['cert_saved'])) $flash = 'Сертификат сохранён';
if (isset($_GET['cert_deleted'])) $flash = 'Сертификат удалён';
if (isset($_GET['cert_toggled'])) $flash = 'Статус сертификата изменён';
if (isset($_GET['catalog_saved'])) $flash = 'Серия каталога сохранена';
if (isset($_GET['catalog_image_uploaded'])) $flash = 'Изображение серии загружено';
if (isset($_GET['walypan_uploaded'])) $flash = 'Загружено в слайдер: ' . (int)$_GET['walypan_uploaded'];
if (isset($_GET['walypan_deleted'])) $flash = 'Слайд удалён';

// ===== Data load =====
$leads = [];
$leads_count = 0;
$articles = [];
$edit_article = null;
$pages_list = [];
$projects_list = [];
$edit_project = null;
$edit_project_is_new = false;
$site_config = [];
$partners_list = [];
$edit_partner = null;
$edit_partner_is_new = false;
$certificates_list = [];
$edit_certificate = null;
$edit_certificate_is_new = false;
// 2026-04-27: каталог
$catalog_data = ['series' => []];

if ($section === 'leads') {
    try {
        $leads = leads_db()->query("SELECT * FROM leads ORDER BY datetime(created_at) DESC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $leads_count = count($leads);
    } catch (Exception $e) {
        $flash = 'Ошибка БД заявок: ' . $e->getMessage();
    }
} elseif ($section === 'blog') {
    try {
        $articles = blog_db()->query("SELECT id, slug, category, title, views, published_at, is_published FROM articles ORDER BY datetime(published_at) DESC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $flash = 'Ошибка БД блога: ' . $e->getMessage();
    }
} elseif ($section === 'blog-edit') {
    $edit_id = (int)($_GET['id'] ?? 0);
    if ($edit_id > 0) {
        $st = blog_db()->prepare("SELECT * FROM articles WHERE id = ?");
        $st->execute([$edit_id]);
        $edit_article = $st->fetch(PDO::FETCH_ASSOC);
        if (!$edit_article) {
            $flash = 'Статья не найдена';
            $edit_article = null;
        }
    }
    if (!$edit_article) {
        $edit_article = [
            'id' => 0,
            'slug' => '',
            'category' => 'Монтаж',
            'title' => '',
            'subtitle' => '',
            'content' => '',
            'image' => '',
            'read_time' => 5,
            'published_at' => date('Y-m-d H:i:s'),
            'is_published' => 1,
        ];
    }
} elseif ($section === 'pages') {
    $pages_list = load_pages_config()['pages'] ?? [];
} elseif ($section === 'projects') {
    foreach (list_project_folders() as $folder) {
        $meta = read_project_meta($folder);
        $projects_list[] = [
            'folder'   => $folder,
            'name'     => $meta['name'],
            'location' => $meta['location'],
            'tag'      => $meta['tag'],
            'category' => $meta['category'],
            'order'    => $meta['order'],
            'images'   => count_project_images($folder),
        ];
    }
    usort($projects_list, function($a, $b) {
        $oa = (int)$a['order']; $ob = (int)$b['order'];
        if ($oa === $ob) return strcmp($a['folder'], $b['folder']);
        return $oa - $ob;
    });
} elseif ($section === 'project-edit') {
    $folder_param = trim((string)($_GET['folder'] ?? ''));
    if ($folder_param === 'new' || $folder_param === '') {
        $edit_project_is_new = true;
        $edit_project = [
            'folder'   => '',
            'name'     => '',
            'location' => '',
            'tag'      => '',
            'category' => '',
            'order'    => 999,
        ];
    } else {
        if (!valid_folder_slug($folder_param)) {
            $flash = 'Некорректное имя папки';
            $section = 'projects';
            $projects_list = [];
            foreach (list_project_folders() as $folder) {
                $meta = read_project_meta($folder);
                $projects_list[] = ['folder' => $folder, 'name' => $meta['name'], 'location' => $meta['location'], 'tag' => $meta['tag'], 'category' => $meta['category'], 'order' => $meta['order'], 'images' => count_project_images($folder)];
            }
        } else {
            $base = projects_root_path();
            if (!is_dir($base . '/' . $folder_param)) {
                $flash = 'Папка проекта не найдена';
                $section = 'projects';
            } else {
                $meta = read_project_meta($folder_param);
                $edit_project = [
                    'folder'   => $folder_param,
                    'name'     => $meta['name'],
                    'location' => $meta['location'],
                    'tag'      => $meta['tag'],
                    'category' => $meta['category'],
                    'order'    => $meta['order'],
                ];
            }
        }
    }
}

if ($section === 'settings') {
    $site_config = load_site_config();
} elseif ($section === 'partners') {
    $partners_list = load_partners();
    usort($partners_list, function($a, $b) {
        $oa = (int)($a['order'] ?? 999); $ob = (int)($b['order'] ?? 999);
        if ($oa === $ob) return strcmp((string)($a['name'] ?? ''), (string)($b['name'] ?? ''));
        return $oa - $ob;
    });
} elseif ($section === 'partner-edit') {
    $id_param = (int)($_GET['id'] ?? 0);
    if ($id_param > 0) {
        foreach (load_partners() as $p) {
            if ((int)($p['id'] ?? 0) === $id_param) {
                $edit_partner = [
                    'id'        => (int)$p['id'],
                    'name'      => (string)($p['name'] ?? ''),
                    'url'       => (string)($p['url'] ?? ''),
                    'logo'      => (string)($p['logo'] ?? ''),
                    'order'     => (int)($p['order'] ?? 999),
                    'is_active' => !empty($p['is_active']),
                    'dark_bg'   => !empty($p['dark_bg']),
                ];
                break;
            }
        }
        if ($edit_partner === null) {
            $flash = 'Партнёр не найден';
        }
    }
    if ($edit_partner === null) {
        $edit_partner_is_new = true;
        $edit_partner = ['id' => 0, 'name' => '', 'url' => '', 'logo' => '', 'order' => 999, 'is_active' => true, 'dark_bg' => false];
    }
} elseif ($section === 'certificates') {
    $certificates_list = load_certificates();
    usort($certificates_list, function($a, $b) {
        $oa = (int)($a['order'] ?? 999); $ob = (int)($b['order'] ?? 999);
        if ($oa === $ob) return strcmp((string)($a['name'] ?? ''), (string)($b['name'] ?? ''));
        return $oa - $ob;
    });
} elseif ($section === 'certificate-edit') {
    $id_param = (int)($_GET['id'] ?? 0);
    if ($id_param > 0) {
        foreach (load_certificates() as $c) {
            if ((int)($c['id'] ?? 0) === $id_param) {
                $edit_certificate = [
                    'id'          => (int)$c['id'],
                    'name'        => (string)($c['name'] ?? ''),
                    'file'        => (string)($c['file'] ?? ''),
                    'description' => (string)($c['description'] ?? ''),
                    'order'       => (int)($c['order'] ?? 999),
                    'is_active'   => !empty($c['is_active']),
                ];
                break;
            }
        }
        if ($edit_certificate === null) {
            $flash = 'Сертификат не найден';
        }
    }
    if ($edit_certificate === null) {
        $edit_certificate_is_new = true;
        $edit_certificate = ['id' => 0, 'name' => '', 'file' => '', 'description' => '', 'order' => 999, 'is_active' => true];
    }
} elseif ($section === 'catalog') {
    $catalog_data = load_catalog();
    if (!isset($catalog_data['series']) || !is_array($catalog_data['series'])) {
        $catalog_data['series'] = [];
    }
}

$categories = ['Монтаж', 'Материалы', 'Новости', 'Инструкции', 'Проекты'];
$project_tags = ['Медицина', 'Образование', 'Государственное', 'Жилое', 'Коммерческое', 'Промышленное', 'Международные'];
?><!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Админ-панель — BLP Board</title>
<link rel="stylesheet" href="/blp/css/pages/admin.css">
</head>
<body class="admin-body">
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="admin-logo">BLP Admin</div>
        </div>
        <nav class="admin-nav">
            <a href="?s=leads" class="admin-nav-link <?= $section === 'leads' ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[#]</span> Заявки
            </a>
            <a href="?s=blog" class="admin-nav-link <?= ($section === 'blog' || $section === 'blog-edit') ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[B]</span> Блог
            </a>
            <a href="?s=pages" class="admin-nav-link <?= $section === 'pages' ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[P]</span> Страницы
            </a>
            <a href="?s=projects" class="admin-nav-link <?= ($section === 'projects' || $section === 'project-edit') ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[O]</span> Проекты
            </a>
            <a href="?s=partners" class="admin-nav-link <?= ($section === 'partners' || $section === 'partner-edit') ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[Pn]</span> Партнёры
            </a>
            <a href="?s=certificates" class="admin-nav-link <?= ($section === 'certificates' || $section === 'certificate-edit') ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[C]</span> Сертификаты
            </a>
            <a href="?s=catalog" class="admin-nav-link <?= $section === 'catalog' ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[K]</span> Каталог
            </a>
            <a href="?s=settings" class="admin-nav-link <?= $section === 'settings' ? 'is-active' : '' ?>">
                <span class="admin-nav-icon">[S]</span> Настройки
            </a>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="?action=logout" class="admin-logout">Выйти</a>
            <a href="/blp/" class="admin-link-back" target="_blank">К сайту &rarr;</a>
        </div>
    </aside>

    <main class="admin-main">
        <?php if ($flash): ?>
            <div class="admin-alert admin-alert-info"><?= h($flash) ?></div>
        <?php endif; ?>

        <?php if ($section === 'leads'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Заявки <span class="admin-counter">(<?= (int)$leads_count ?>)</span></h1>
                <div class="admin-header-actions">
                    <a href="?action=export-csv" class="btn-secondary">Экспорт CSV</a>
                </div>
            </header>

            <?php if ($leads_count === 0): ?>
                <div class="admin-empty">Заявок пока нет.</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Дата</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Компания</th>
                            <th>Сообщение</th>
                            <th>Рассылка</th>
                            <th>Письмо</th>
                            <th>Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $l):
                            $msg = (string)($l['message'] ?? '');
                            $msg_short = mb_substr($msg, 0, 80, 'UTF-8');
                            if (mb_strlen($msg, 'UTF-8') > 80) $msg_short .= '...';
                        ?>
                            <tr>
                                <td><?= (int)$l['id'] ?></td>
                                <td class="admin-td-date"><?= h($l['created_at']) ?></td>
                                <td><?= h($l['name']) ?></td>
                                <td><a href="tel:<?= h($l['phone']) ?>"><?= h($l['phone']) ?></a></td>
                                <td><?php if (!empty($l['email'])): ?><a href="mailto:<?= h($l['email']) ?>"><?= h($l['email']) ?></a><?php endif; ?></td>
                                <td><?= h($l['company']) ?></td>
                                <td title="<?= h($msg) ?>"><?= h($msg_short) ?></td>
                                <td class="admin-td-center"><?= !empty($l['marketing']) ? 'да' : '—' ?></td>
                                <td class="admin-td-center"><?= !empty($l['mail_sent']) ? 'да' : '—' ?></td>
                                <td class="admin-td-center">
                                    <a href="?action=del-lead&id=<?= (int)$l['id'] ?>&csrf=<?= h($csrf) ?>"
                                       class="btn-danger btn-sm"
                                       onclick="return confirm('Удалить заявку №<?= (int)$l['id'] ?>?');">×</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>

        <?php elseif ($section === 'blog'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Статьи блога <span class="admin-counter">(<?= count($articles) ?>)</span></h1>
                <div class="admin-header-actions">
                    <a href="?s=blog-edit&id=0" class="btn-primary">+ Добавить статью</a>
                </div>
            </header>

            <?php if (empty($articles)): ?>
                <div class="admin-empty">Статей пока нет. <a href="?s=blog-edit&id=0">Добавить первую</a>.</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Заголовок</th>
                            <th>Категория</th>
                            <th>Дата</th>
                            <th>Просм.</th>
                            <th>Опубл.</th>
                            <th>Ред.</th>
                            <th>Удал.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $a): ?>
                            <tr>
                                <td><?= (int)$a['id'] ?></td>
                                <td>
                                    <strong><?= h($a['title']) ?></strong>
                                    <div class="admin-muted">/<?= h($a['slug']) ?></div>
                                </td>
                                <td><?= h($a['category']) ?></td>
                                <td class="admin-td-date"><?= h($a['published_at']) ?></td>
                                <td class="admin-td-center"><?= (int)$a['views'] ?></td>
                                <td class="admin-td-center">
                                    <button type="button"
                                            class="admin-toggle <?= !empty($a['is_published']) ? 'is-on' : 'is-off' ?>"
                                            data-section="blog"
                                            data-id="<?= (int)$a['id'] ?>"
                                            data-field="is_published"
                                            data-value="<?= !empty($a['is_published']) ? '1' : '0' ?>"
                                            title="Переключить публикацию"
                                            onclick="adminToggle(this)">
                                        <?= !empty($a['is_published']) ? 'ON' : 'OFF' ?>
                                    </button>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?s=blog-edit&id=<?= (int)$a['id'] ?>" class="btn-secondary btn-sm">Ред.</a>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?action=del-article&id=<?= (int)$a['id'] ?>&csrf=<?= h($csrf) ?>"
                                       class="btn-danger btn-sm"
                                       onclick="return confirm('Удалить статью &laquo;<?= h(addslashes($a['title'])) ?>&raquo;?');">×</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>

        <?php elseif ($section === 'blog-edit'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">
                    <?= ((int)$edit_article['id'] > 0) ? 'Редактирование статьи #' . (int)$edit_article['id'] : 'Новая статья' ?>
                </h1>
                <div class="admin-header-actions">
                    <a href="?s=blog" class="btn-secondary">&larr; К списку</a>
                </div>
            </header>

            <form method="post" action="" class="admin-form">
                <input type="hidden" name="action" value="save-article">
                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$edit_article['id'] ?>">

                <div class="admin-form-row admin-form-row-2col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-slug">Slug <span class="admin-req">*</span></label>
                        <input type="text" id="f-slug" name="slug" class="admin-input" required value="<?= h($edit_article['slug']) ?>" pattern="[a-z0-9-]+" title="Только латиница, цифры и дефис">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-cat">Категория <span class="admin-req">*</span></label>
                        <select id="f-cat" name="category" class="admin-input" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= h($cat) ?>" <?= ($edit_article['category'] === $cat) ? 'selected' : '' ?>><?= h($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-title">Заголовок <span class="admin-req">*</span></label>
                    <input type="text" id="f-title" name="title" class="admin-input" required value="<?= h($edit_article['title']) ?>">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-subtitle">Подзаголовок</label>
                    <input type="text" id="f-subtitle" name="subtitle" class="admin-input" value="<?= h($edit_article['subtitle']) ?>">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-content">Контент (HTML)</label>
                    <textarea id="f-content" name="content" class="admin-input admin-textarea" rows="20"><?= h($edit_article['content']) ?></textarea>
                </div>

                <div class="admin-form-row admin-form-row-3col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-image">Изображение (путь)</label>
                        <input type="text" id="f-image" name="image" class="admin-input" value="<?= h($edit_article['image']) ?>" placeholder="/blp/images-convert/blog/...">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-rt">Время чтения (мин)</label>
                        <input type="number" id="f-rt" name="read_time" class="admin-input" min="1" max="60" value="<?= (int)$edit_article['read_time'] ?>">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-pub">Дата публикации</label>
                        <input type="datetime-local" id="f-pub" name="published_at" class="admin-input"
                               value="<?= h(str_replace(' ', 'T', mb_substr((string)$edit_article['published_at'], 0, 16))) ?>">
                    </div>
                </div>

                <div class="admin-form-field admin-form-checkbox">
                    <label class="admin-checkbox-label">
                        <input type="checkbox" name="is_published" value="1" <?= !empty($edit_article['is_published']) ? 'checked' : '' ?>>
                        <span>Опубликовано (видно на сайте)</span>
                    </label>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-primary">Сохранить</button>
                    <a href="?s=blog" class="btn-secondary">Отмена</a>
                    <?php if ((int)$edit_article['id'] > 0): ?>
                        <a href="?action=del-article&id=<?= (int)$edit_article['id'] ?>&csrf=<?= h($csrf) ?>"
                           class="btn-danger admin-form-delete"
                           onclick="return confirm('Удалить статью безвозвратно?');">Удалить</a>
                    <?php endif; ?>
                </div>
            </form>

        <?php elseif ($section === 'pages'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Страницы сайта <span class="admin-counter">(<?= count($pages_list) ?>)</span></h1>
            </header>

            <?php if (empty($pages_list)): ?>
                <div class="admin-empty">Файл pages.json пуст или недоступен (<?= h(PAGES_JSON_PATH) ?>).</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Страница</th>
                            <th>URL</th>
                            <th>Статус</th>
                            <th>Примечание</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages_list as $pg):
                            $slug = (string)($pg['slug'] ?? '');
                            $name = (string)($pg['name'] ?? $slug);
                            $url  = (string)($pg['url']  ?? '');
                            $live = !empty($pg['is_live']);
                            $note = (string)($pg['notes'] ?? '');
                        ?>
                            <tr>
                                <td><strong><?= h($name) ?></strong><div class="admin-muted"><?= h($slug) ?></div></td>
                                <td>
                                    <?php if ($url !== ''): ?>
                                        <a href="/blp<?= h($url === '/' ? '/' : $url) ?>" target="_blank"><?= h($url) ?></a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge <?= $live ? 'badge-live' : 'badge-hidden' ?>"><?= $live ? 'На сайте' : 'Скрыт' ?></span>
                                </td>
                                <td>
                                    <form method="post" action="" class="admin-inline-form">
                                        <input type="hidden" name="action" value="save-page-note">
                                        <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                                        <input type="hidden" name="slug" value="<?= h($slug) ?>">
                                        <input type="text" name="note" class="admin-input admin-input-sm" value="<?= h($note) ?>" placeholder="—">
                                        <button type="submit" class="btn-secondary btn-sm">OK</button>
                                    </form>
                                </td>
                                <td class="admin-td-center">
                                    <button type="button"
                                            class="btn-toggle <?= $live ? 'btn-secondary' : 'btn-primary' ?> btn-sm"
                                            data-section="pages"
                                            data-id="<?= h($slug) ?>"
                                            data-field="is_live"
                                            data-value="<?= $live ? '1' : '0' ?>"
                                            onclick="adminToggle(this)">
                                        <?= $live ? 'Скрыть' : 'Опубликовать' ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <p class="admin-muted" style="margin-top:1rem;">
                    Если страница помечена «Скрыта» — на её рендере добавится <code>noindex, nofollow</code>
                    (если страница уже не задаёт robots вручную). Конфиг: <code><?= h(PAGES_JSON_PATH) ?></code>
                </p>
            <?php endif; ?>

        <?php elseif ($section === 'projects'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Проекты <span class="admin-counter">(<?= count($projects_list) ?>)</span></h1>
                <div class="admin-header-actions">
                    <a href="?s=project-edit&folder=new" class="btn-primary">+ Добавить проект</a>
                </div>
            </header>

            <?php if (empty($projects_list)): ?>
                <div class="admin-empty">Проектов пока нет. <a href="?s=project-edit&folder=new">Добавить первый</a>.</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Папка</th>
                            <th>Название</th>
                            <th>Локация</th>
                            <th>Тег</th>
                            <th>Порядок</th>
                            <th>Изображений</th>
                            <th>Редактировать</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects_list as $p): ?>
                            <tr>
                                <td><code><?= h($p['folder']) ?></code></td>
                                <td><strong><?= h($p['name']) ?></strong></td>
                                <td><?= h($p['location']) ?></td>
                                <td><?= h($p['tag']) ?></td>
                                <td class="admin-td-center"><?= (int)$p['order'] ?></td>
                                <td class="admin-td-center"><?= (int)$p['images'] ?></td>
                                <td class="admin-td-center">
                                    <a href="?s=project-edit&folder=<?= h(urlencode($p['folder'])) ?>" class="btn-secondary btn-sm">Ред.</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <p class="admin-muted" style="margin-top:1rem;">
                    Папки проектов: <code><?= h(projects_root_path()) ?></code>
                </p>
            <?php endif; ?>

        <?php elseif ($section === 'project-edit' && $edit_project !== null): ?>
            <header class="admin-header">
                <h1 class="admin-h1">
                    <?= $edit_project_is_new ? 'Новый проект' : 'Редактирование: ' . h($edit_project['folder']) ?>
                </h1>
                <div class="admin-header-actions">
                    <a href="?s=projects" class="btn-secondary">&larr; К списку</a>
                </div>
            </header>

            <form method="post" action="" class="admin-form">
                <input type="hidden" name="action" value="save-project">
                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                <input type="hidden" name="is_new" value="<?= $edit_project_is_new ? '1' : '0' ?>">

                <div class="admin-form-field">
                    <label class="admin-label" for="f-folder">Имя папки <span class="admin-req">*</span></label>
                    <?php if ($edit_project_is_new): ?>
                        <input type="text" id="f-folder" name="folder" class="admin-input" required
                               pattern="[a-z0-9-]+" title="Только латиница, цифры и дефис"
                               value="<?= h($edit_project['folder']) ?>"
                               placeholder="например: residential-house">
                        <small class="admin-muted">Только латиница, цифры и дефис. Папка будет создана автоматически.</small>
                    <?php else: ?>
                        <input type="text" id="f-folder" name="folder" class="admin-input" readonly
                               value="<?= h($edit_project['folder']) ?>">
                        <small class="admin-muted">Имя папки нельзя менять у существующего проекта.</small>
                    <?php endif; ?>
                </div>

                <div class="admin-form-row admin-form-row-2col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-name">Название <span class="admin-req">*</span></label>
                        <input type="text" id="f-name" name="name" class="admin-input" required
                               value="<?= h($edit_project['name']) ?>" placeholder="Поликлиника">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-loc">Локация</label>
                        <input type="text" id="f-loc" name="location" class="admin-input"
                               value="<?= h($edit_project['location']) ?>" placeholder="г.о. Видное, Московская область">
                    </div>
                </div>

                <div class="admin-form-row admin-form-row-3col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-tag">Тег</label>
                        <select id="f-tag" name="tag" class="admin-input">
                            <option value="">— без тега —</option>
                            <?php foreach ($project_tags as $tg): ?>
                                <option value="<?= h($tg) ?>" <?= ($edit_project['tag'] === $tg) ? 'selected' : '' ?>><?= h($tg) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-cat2">Категория</label>
                        <input type="text" id="f-cat2" name="category" class="admin-input"
                               value="<?= h($edit_project['category']) ?>" placeholder="государственная">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-ord">Порядок сортировки</label>
                        <input type="number" id="f-ord" name="order" class="admin-input" min="1" max="9999"
                               value="<?= (int)$edit_project['order'] ?>">
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-primary">Сохранить</button>
                    <a href="?s=projects" class="btn-secondary">Отмена</a>
                </div>
            </form>

            <?php if (!$edit_project_is_new && !empty($edit_project['folder'])):
                $photos = list_project_photos($edit_project['folder']);
                $folder_url_path = '/blp/images-convert/pages/projects/' . rawurlencode($edit_project['folder']);
            ?>
                <div class="admin-form" style="margin-top:1.5rem;">
                    <h2 class="admin-h2" style="margin-top:0;">Фотографии объекта <span class="admin-counter">(<?= count($photos) ?>)</span></h2>

                    <?php if (!empty($photos)): ?>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <?php foreach ($photos as $fname): ?>
                                <div style="display:flex;align-items:center;gap:12px;padding:8px;border:1px solid #eee;border-radius:5px;background:#fafafa;">
                                    <img src="<?= h($folder_url_path . '/' . rawurlencode($fname)) ?>"
                                         alt="<?= h($fname) ?>"
                                         style="height:60px;width:auto;max-width:100px;object-fit:contain;border:1px solid #ddd;background:#fff;">
                                    <code style="flex:1;font-size:12px;word-break:break-all;"><?= h($fname) ?></code>
                                    <a href="?action=del-photo&folder=<?= h(urlencode($edit_project['folder'])) ?>&file=<?= h(urlencode($fname)) ?>&csrf=<?= h($csrf) ?>"
                                       class="btn-danger btn-sm"
                                       onclick="return confirm('Удалить файл «<?= h(addslashes($fname)) ?>»?');">Удалить</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="admin-empty" style="padding:20px;">Фотографий пока нет.</div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data"
                          action="?s=project-edit&folder=<?= h(urlencode($edit_project['folder'])) ?>&action=upload-photo&csrf=<?= h($csrf) ?>"
                          style="margin-top:1rem;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                        <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/webp" required>
                        <button type="submit" class="btn-primary">Загрузить фото</button>
                        <small class="admin-muted">JPG, PNG, WEBP. Макс. 10 МБ на файл.</small>
                    </form>
                </div>
            <?php endif; ?>

        <?php elseif ($section === 'settings'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Настройки сайта</h1>
            </header>

            <form method="post" action="" class="admin-form">
                <input type="hidden" name="action" value="save-settings">
                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">

                <h2 class="admin-h2" style="margin-top:0;">Контактные данные</h2>

                <div class="admin-form-row admin-form-row-2col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-phone">Телефон</label>
                        <input type="text" id="f-phone" name="phone" class="admin-input"
                               value="<?= h((string)($site_config['phone'] ?? '')) ?>"
                               placeholder="+7 (495) 984-96-89">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-phone-link">Телефон для ссылки</label>
                        <input type="text" id="f-phone-link" name="phone_link" class="admin-input"
                               value="<?= h((string)($site_config['phone_link'] ?? '')) ?>"
                               placeholder="tel:+74959849689">
                        <small class="admin-muted">Формат: tel:+74959849689</small>
                    </div>
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-email">Email</label>
                    <input type="email" id="f-email" name="email" class="admin-input"
                           value="<?= h((string)($site_config['email'] ?? '')) ?>"
                           placeholder="info@building-port.ru">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-address">Адрес</label>
                    <textarea id="f-address" name="address" class="admin-input admin-textarea" rows="2"><?= h((string)($site_config['address'] ?? '')) ?></textarea>
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-hours">Часы работы</label>
                    <input type="text" id="f-hours" name="working_hours" class="admin-input"
                           value="<?= h((string)($site_config['working_hours'] ?? '')) ?>"
                           placeholder="Пн-Пт: 9:00-18:00">
                </div>

                <h2 class="admin-h2">Реквизиты компании</h2>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-company">Название компании</label>
                    <input type="text" id="f-company" name="company_name" class="admin-input"
                           value="<?= h((string)($site_config['company_name'] ?? '')) ?>"
                           placeholder="ООО «Билдингпорт»">
                </div>

                <div class="admin-form-row admin-form-row-3col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-inn">ИНН</label>
                        <input type="text" id="f-inn" name="inn" class="admin-input"
                               value="<?= h((string)($site_config['inn'] ?? '')) ?>">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-ogrn">ОГРН</label>
                        <input type="text" id="f-ogrn" name="ogrn" class="admin-input"
                               value="<?= h((string)($site_config['ogrn'] ?? '')) ?>">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-kpp">КПП</label>
                        <input type="text" id="f-kpp" name="kpp" class="admin-input"
                               value="<?= h((string)($site_config['kpp'] ?? '')) ?>">
                    </div>
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-legal">Юридический адрес</label>
                    <textarea id="f-legal" name="legal_address" class="admin-input admin-textarea" rows="2"><?= h((string)($site_config['legal_address'] ?? '')) ?></textarea>
                </div>

                <h2 class="admin-h2">Аналитика</h2>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-ga4">GA4 ID</label>
                    <input type="text" id="f-ga4" name="ga4_id" class="admin-input"
                           value="<?= h((string)($site_config['ga4_id'] ?? '')) ?>"
                           placeholder="G-XXXXXXXXXX">
                </div>

                <div class="admin-form-row admin-form-row-3col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-ym">Яндекс.Метрика ID</label>
                        <input type="text" id="f-ym" name="yandex_metrika_id" class="admin-input"
                               value="<?= h((string)($site_config['yandex_metrika_id'] ?? '')) ?>"
                               placeholder="98765432">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-yd">Яндекс.Директ (ClientID)</label>
                        <input type="text" id="f-yd" name="yandex_direct_id" class="admin-input"
                               value="<?= h((string)($site_config['yandex_direct_id'] ?? '')) ?>"
                               placeholder="для ретаргетинга">
                    </div>
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-vk">VK Pixel ID</label>
                        <input type="text" id="f-vk" name="vk_pixel_id" class="admin-input"
                               value="<?= h((string)($site_config['vk_pixel_id'] ?? '')) ?>"
                               placeholder="необязательно">
                    </div>
                </div>

                <div class="admin-notice warning">
                    После добавления новых систем аналитики необходимо обновить
                    <a href="/blp/policy" target="_blank">Политику конфиденциальности</a> и
                    <a href="/blp/consent" target="_blank">Согласие на обработку данных</a> —
                    Яндекс является отдельным оператором данных (трансграничная передача).
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-primary">Сохранить</button>
                </div>
            </form>

        <?php elseif ($section === 'partners'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Партнёры <span class="admin-counter">(<?= count($partners_list) ?>)</span></h1>
                <div class="admin-header-actions">
                    <a href="?s=partner-edit" class="btn-primary">+ Добавить партнёра</a>
                </div>
            </header>

            <?php if (empty($partners_list)): ?>
                <div class="admin-empty">Партнёров пока нет. <a href="?s=partner-edit">Добавить первого</a>.</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Логотип</th>
                            <th>Название</th>
                            <th>Порядок</th>
                            <th>Активен</th>
                            <th>Фон</th>
                            <th>Ред.</th>
                            <th>Удал.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partners_list as $p):
                            $pid    = (int)($p['id'] ?? 0);
                            $pname  = (string)($p['name'] ?? '');
                            $purl   = (string)($p['url']  ?? '');
                            $plogo  = (string)($p['logo'] ?? '');
                            $pord   = (int)($p['order'] ?? 999);
                            $pact   = !empty($p['is_active']);
                            $pdark  = !empty($p['dark_bg']);
                        ?>
                            <tr>
                                <td>
                                    <?php if ($plogo !== ''): ?>
                                        <div style="background:<?= $pdark ? '#222' : '#fff' ?>;padding:4px;display:inline-block;border-radius:4px;">
                                            <img src="<?= h($plogo) ?>" alt="<?= h($pname) ?>" style="height:40px;width:auto;max-width:120px;object-fit:contain;display:block;">
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= h($pname) ?></strong></td>
                                <td class="admin-td-center"><?= $pord ?></td>
                                <td class="admin-td-center">
                                    <button type="button"
                                            class="admin-toggle <?= $pact ? 'is-on' : 'is-off' ?>"
                                            data-section="partners"
                                            data-id="<?= $pid ?>"
                                            data-field="is_active"
                                            data-value="<?= $pact ? '1' : '0' ?>"
                                            title="Переключить активность"
                                            onclick="adminToggle(this)">
                                        <?= $pact ? 'ON' : 'OFF' ?>
                                    </button>
                                </td>
                                <td class="admin-td-center">
                                    <button type="button"
                                            class="admin-toggle <?= $pdark ? 'is-on' : 'is-off' ?>"
                                            data-section="partners"
                                            data-id="<?= $pid ?>"
                                            data-field="dark_bg"
                                            data-value="<?= $pdark ? '1' : '0' ?>"
                                            title="Тёмный фон логотипа"
                                            onclick="adminToggle(this)">
                                        <?= $pdark ? '◑' : '○' ?>
                                    </button>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?s=partner-edit&id=<?= $pid ?>" class="btn-secondary btn-sm">Ред.</a>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?action=del-partner&id=<?= $pid ?>&csrf=<?= h($csrf) ?>"
                                       class="btn-danger btn-sm"
                                       onclick="return confirm('Удалить партнёра «<?= h(addslashes($pname)) ?>»?');">×</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>

        <?php elseif ($section === 'partner-edit' && $edit_partner !== null): ?>
            <header class="admin-header">
                <h1 class="admin-h1">
                    <?= $edit_partner_is_new ? 'Новый партнёр' : 'Редактирование партнёра #' . (int)$edit_partner['id'] ?>
                </h1>
                <div class="admin-header-actions">
                    <a href="?s=partners" class="btn-secondary">&larr; К списку</a>
                </div>
            </header>

            <form method="post" action="" class="admin-form">
                <input type="hidden" name="action" value="save-partner">
                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$edit_partner['id'] ?>">

                <div class="admin-form-field">
                    <label class="admin-label" for="f-pname">Название <span class="admin-req">*</span></label>
                    <input type="text" id="f-pname" name="name" class="admin-input" required
                           value="<?= h($edit_partner['name']) ?>">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-purl">Сайт партнёра</label>
                    <input type="url" id="f-purl" name="url" class="admin-input"
                           value="<?= h($edit_partner['url']) ?>" placeholder="https://example.com">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-plogo">Логотип (путь) <span class="admin-req">*</span></label>
                    <input type="text" id="f-plogo" name="logo" class="admin-input" required
                           value="<?= h($edit_partner['logo']) ?>"
                           placeholder="/blp/images-convert/blocks/partners/...">
                    <?php if (!empty($edit_partner['logo'])): ?>
                        <div style="margin-top:0.5rem;"><img src="<?= h($edit_partner['logo']) ?>" alt="превью" style="height:60px;width:auto;max-width:200px;object-fit:contain;border:1px solid #eee;padding:4px;background:<?= !empty($edit_partner['dark_bg']) ? '#222' : '#fafafa' ?>;"></div>
                    <?php endif; ?>
                </div>

                <div class="admin-form-row admin-form-row-2col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-pord">Порядок сортировки</label>
                        <input type="number" id="f-pord" name="order" class="admin-input" min="1" max="9999"
                               value="<?= (int)$edit_partner['order'] ?>">
                    </div>
                    <div class="admin-form-field admin-form-checkbox">
                        <label class="admin-checkbox-label">
                            <input type="checkbox" name="is_active" value="1" <?= !empty($edit_partner['is_active']) ? 'checked' : '' ?>>
                            <span>Активен (видно на сайте)</span>
                        </label>
                    </div>
                </div>

                <div class="admin-form-field admin-form-checkbox">
                    <label class="admin-checkbox-label">
                        <input type="checkbox" name="dark_bg" value="1" <?= !empty($edit_partner['dark_bg']) ? 'checked' : '' ?>>
                        <span>Тёмный фон для логотипа (если логотип светлый/белый)</span>
                    </label>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-primary">Сохранить</button>
                    <a href="?s=partners" class="btn-secondary">Отмена</a>
                    <?php if ((int)$edit_partner['id'] > 0): ?>
                        <a href="?action=del-partner&id=<?= (int)$edit_partner['id'] ?>&csrf=<?= h($csrf) ?>"
                           class="btn-danger admin-form-delete"
                           onclick="return confirm('Удалить партнёра безвозвратно?');">Удалить</a>
                    <?php endif; ?>
                </div>
            </form>

        <?php elseif ($section === 'certificates'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Сертификаты <span class="admin-counter">(<?= count($certificates_list) ?>)</span></h1>
                <div class="admin-header-actions">
                    <a href="?s=certificate-edit" class="btn-primary">+ Добавить сертификат</a>
                </div>
            </header>

            <?php if (empty($certificates_list)): ?>
                <div class="admin-empty">Сертификатов пока нет. <a href="?s=certificate-edit">Добавить первый</a>.</div>
            <?php else: ?>
                <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Превью</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Порядок</th>
                            <th>Активен</th>
                            <th>Ред.</th>
                            <th>Удал.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificates_list as $c):
                            $cid    = (int)($c['id'] ?? 0);
                            $cname  = (string)($c['name'] ?? '');
                            $cfile  = (string)($c['file'] ?? '');
                            $cdesc  = (string)($c['description'] ?? '');
                            $cord   = (int)($c['order'] ?? 999);
                            $cact   = !empty($c['is_active']);
                            $cdesc_short = mb_substr($cdesc, 0, 80, 'UTF-8');
                            if (mb_strlen($cdesc, 'UTF-8') > 80) $cdesc_short .= '...';
                        ?>
                            <tr>
                                <td>
                                    <?php if ($cfile !== ''): ?>
                                        <img src="<?= h($cfile) ?>" alt="<?= h($cname) ?>" style="height:50px;width:auto;max-width:80px;object-fit:contain;">
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= h($cname) ?></strong></td>
                                <td title="<?= h($cdesc) ?>"><?= h($cdesc_short) ?></td>
                                <td class="admin-td-center"><?= $cord ?></td>
                                <td class="admin-td-center">
                                    <button type="button"
                                            class="admin-toggle <?= $cact ? 'is-on' : 'is-off' ?>"
                                            data-section="certificates"
                                            data-id="<?= $cid ?>"
                                            data-field="is_active"
                                            data-value="<?= $cact ? '1' : '0' ?>"
                                            title="Переключить активность"
                                            onclick="adminToggle(this)">
                                        <?= $cact ? 'ON' : 'OFF' ?>
                                    </button>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?s=certificate-edit&id=<?= $cid ?>" class="btn-secondary btn-sm">Ред.</a>
                                </td>
                                <td class="admin-td-center">
                                    <a href="?action=del-certificate&id=<?= $cid ?>&csrf=<?= h($csrf) ?>"
                                       class="btn-danger btn-sm"
                                       onclick="return confirm('Удалить сертификат «<?= h(addslashes($cname)) ?>»?');">×</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>

        <?php elseif ($section === 'certificate-edit' && $edit_certificate !== null): ?>
            <header class="admin-header">
                <h1 class="admin-h1">
                    <?= $edit_certificate_is_new ? 'Новый сертификат' : 'Редактирование сертификата #' . (int)$edit_certificate['id'] ?>
                </h1>
                <div class="admin-header-actions">
                    <a href="?s=certificates" class="btn-secondary">&larr; К списку</a>
                </div>
            </header>

            <form method="post" action="" class="admin-form">
                <input type="hidden" name="action" value="save-certificate">
                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$edit_certificate['id'] ?>">

                <div class="admin-form-field">
                    <label class="admin-label" for="f-cname">Название <span class="admin-req">*</span></label>
                    <input type="text" id="f-cname" name="name" class="admin-input" required
                           value="<?= h($edit_certificate['name']) ?>">
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-cfile">Файл (путь) <span class="admin-req">*</span></label>
                    <input type="text" id="f-cfile" name="file" class="admin-input" required
                           value="<?= h($edit_certificate['file']) ?>"
                           placeholder="/blp/images-convert/pages/sertificate/...">
                    <?php if (!empty($edit_certificate['file'])): ?>
                        <div style="margin-top:0.5rem;"><img src="<?= h($edit_certificate['file']) ?>" alt="превью" style="height:120px;width:auto;max-width:200px;object-fit:contain;border:1px solid #eee;padding:4px;background:#fafafa;"></div>
                    <?php endif; ?>
                </div>

                <div class="admin-form-field">
                    <label class="admin-label" for="f-cdesc">Описание</label>
                    <textarea id="f-cdesc" name="description" class="admin-input admin-textarea" rows="3"><?= h($edit_certificate['description']) ?></textarea>
                </div>

                <div class="admin-form-row admin-form-row-2col">
                    <div class="admin-form-field">
                        <label class="admin-label" for="f-cord">Порядок сортировки</label>
                        <input type="number" id="f-cord" name="order" class="admin-input" min="1" max="9999"
                               value="<?= (int)$edit_certificate['order'] ?>">
                    </div>
                    <div class="admin-form-field admin-form-checkbox">
                        <label class="admin-checkbox-label">
                            <input type="checkbox" name="is_active" value="1" <?= !empty($edit_certificate['is_active']) ? 'checked' : '' ?>>
                            <span>Активен (видно на сайте)</span>
                        </label>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-primary">Сохранить</button>
                    <a href="?s=certificates" class="btn-secondary">Отмена</a>
                    <?php if ((int)$edit_certificate['id'] > 0): ?>
                        <a href="?action=del-certificate&id=<?= (int)$edit_certificate['id'] ?>&csrf=<?= h($csrf) ?>"
                           class="btn-danger admin-form-delete"
                           onclick="return confirm('Удалить сертификат безвозвратно?');">Удалить</a>
                    <?php endif; ?>
                </div>
            </form>

        <?php elseif ($section === 'catalog'): ?>
            <header class="admin-header">
                <h1 class="admin-h1">Каталог — серии продуктов</h1>
            </header>

            <p class="admin-muted" style="margin-bottom:1.25rem;">
                Редактирование текстов 4 серий каталога. Структура HTML (характеристики, палитра, изображения слайдера) не меняется. Конфиг: <code><?= h(CATALOG_JSON_PATH) ?></code>
            </p>

            <?php
            $catalog_series_meta = [
                'nature'   => 'NATURE',
                'polished' => 'POLISHED',
                'texture'  => 'TEXTURE',
                'walypan'  => 'WALYPAN',
            ];
            foreach ($catalog_series_meta as $skey => $slabel):
                $sdata = $catalog_data['series'][$skey] ?? [];
                $stitle = (string)($sdata['title'] ?? '');
                $sdesc  = (string)($sdata['description'] ?? '');
                $simg   = (string)($sdata['image'] ?? '');
            ?>
                <div class="admin-form" style="margin-bottom:1.5rem; padding:1.25rem; background:#fafafa; border:1px solid #eee; border-radius:8px;">
                    <h2 class="admin-h2" style="margin-top:0;">Серия <?= h($slabel) ?></h2>

                    <?php if ($skey === 'walypan'): ?>
                        <?php
                        // Слайдер WALYPAN: читаем папку slider/, показываем webp-версии
                        $slider_candidates = [
                            'C:/xampp/htdocs/blp/images-convert/pages/catalog/slider',
                            __DIR__ . '/../../images-convert/pages/catalog/slider',
                        ];
                        $slider_dir_ui = null;
                        foreach ($slider_candidates as $c) {
                            if (is_dir($c)) { $slider_dir_ui = rtrim(str_replace('\\', '/', realpath($c)), '/'); break; }
                        }
                        $slide_files = [];
                        if ($slider_dir_ui) {
                            $by_stem = [];
                            foreach (['jpg','jpeg','png','webp'] as $ex) {
                                foreach (glob($slider_dir_ui . '/*.' . $ex) ?: [] as $f) {
                                    $stem = pathinfo($f, PATHINFO_FILENAME);
                                    $ce = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                    if (!isset($by_stem[$stem]) || $ce === 'webp') $by_stem[$stem] = basename($f);
                                }
                            }
                            $slide_files = array_values($by_stem);
                            natsort($slide_files);
                            $slide_files = array_values($slide_files);
                        }
                        ?>
                        <p class="admin-muted" style="margin-bottom:0.75rem;">Слайдер: <?= count($slide_files) ?> фото. Сайт читает папку <code>images-convert/pages/catalog/slider/</code> автоматически.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:1rem;">
                            <?php foreach ($slide_files as $sfname): ?>
                            <div style="position:relative;display:inline-block;">
                                <img src="/blp/images-convert/pages/catalog/slider/<?= h(rawurlencode($sfname)) ?>"
                                     alt="<?= h($sfname) ?>"
                                     style="height:70px;width:auto;max-width:110px;object-fit:cover;border:1px solid #ddd;border-radius:4px;background:#fff;">
                                <a href="?action=del-walypan-slide&file=<?= h(urlencode($sfname)) ?>&csrf=<?= h($csrf) ?>"
                                   onclick="return confirm('Удалить слайд <?= h(addslashes($sfname)) ?>?')"
                                   style="position:absolute;top:2px;right:2px;background:rgba(200,0,0,0.8);color:#fff;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:11px;text-decoration:none;line-height:1;"
                                   title="Удалить">×</a>
                            </div>
                            <?php endforeach; ?>
                            <?php if (empty($slide_files)): ?>
                                <div class="admin-muted">Нет фото в слайдере</div>
                            <?php endif; ?>
                        </div>
                        <form method="post" action="?action=upload-walypan-slide&csrf=<?= h($csrf) ?>"
                              enctype="multipart/form-data"
                              style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;padding:10px;border:1px dashed #d4d4d4;border-radius:5px;background:#fff;margin-bottom:1rem;">
                            <input type="file" name="slides[]" multiple accept="image/jpeg,image/png,image/webp" required>
                            <button type="submit" class="btn-secondary btn-sm">Добавить слайды</button>
                            <small class="admin-muted">Авто-нумерация walypan_slide_N. Конвертируется в JPEG + WebP.</small>
                        </form>
                    <?php else: ?>
                        <?php
                        $img_is_local = ($simg !== '' && strpos($simg, '/blp/images-convert/') === 0);
                        ?>
                        <div style="margin-bottom:0.75rem;">
                            <?php if ($img_is_local): ?>
                                <img src="<?= h($simg) ?>" alt="<?= h($slabel) ?>" style="max-height:80px;width:auto;max-width:160px;object-fit:contain;border:1px solid #eee;padding:4px;background:#fff;">
                            <?php else: ?>
                                <div style="display:inline-block;height:80px;width:160px;border:1px dashed #d4d4d4;background:#fff;color:#888;text-align:center;line-height:80px;font-size:12px;">нет изображения</div>
                            <?php endif; ?>
                        </div>

                        <form method="post" action="" enctype="multipart/form-data" style="margin-bottom:1rem;display:flex;gap:10px;align-items:center;flex-wrap:wrap;padding:10px;border:1px dashed #d4d4d4;border-radius:5px;background:#fff;">
                            <input type="hidden" name="action" value="upload-catalog-image">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="series" value="<?= h($skey) ?>">
                            <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp" required>
                            <button type="submit" class="btn-secondary btn-sm">Загрузить новое изображение</button>
                            <small class="admin-muted">JPG, PNG, WEBP. Сохраняется как series-<?= h($skey) ?>.{ext}</small>
                        </form>
                    <?php endif; ?>

                    <form method="post" action="" class="admin-form" style="padding:0;border:none;background:transparent;">
                        <input type="hidden" name="action" value="save-catalog-series">
                        <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                        <input type="hidden" name="series" value="<?= h($skey) ?>">

                        <div class="admin-form-field">
                            <label class="admin-label" for="f-cat-title-<?= h($skey) ?>">Заголовок (H2) <span class="admin-req">*</span></label>
                            <input type="text" id="f-cat-title-<?= h($skey) ?>" name="title" class="admin-input" required
                                   value="<?= h($stitle) ?>">
                        </div>

                        <div class="admin-form-field">
                            <label class="admin-label" for="f-cat-desc-<?= h($skey) ?>">Описание (P)</label>
                            <textarea id="f-cat-desc-<?= h($skey) ?>" name="description" class="admin-input admin-textarea" rows="3"><?= h($sdesc) ?></textarea>
                        </div>

                        <div class="admin-form-field">
                            <label class="admin-label" for="f-cat-img-<?= h($skey) ?>">Путь к изображению</label>
                            <input type="text" id="f-cat-img-<?= h($skey) ?>" name="image" class="admin-input"
                                   value="<?= h($simg) ?>"
                                   placeholder="/blp/images-convert/pages/catalog/series-<?= h($skey) ?>.png">
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn-primary">Сохранить тексты</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<!-- 2026-04-27: глобальный CSRF для batch-save -->
<input type="hidden" id="global-csrf" value="<?= h($csrf) ?>">

<!-- 2026-04-27: sticky pending-bar — накопленные изменения toggles -->
<div id="pending-bar" style="display:none; position:fixed; bottom:0; left:0; right:0;
     background:#00352F; color:#fff; padding:14px 24px; z-index:9999;
     align-items:center; gap:16px; box-shadow:0 -4px 16px rgba(0,0,0,0.2);">
    <span id="pending-count" style="flex:1; font-weight:600;"></span>
    <button type="button" onclick="applyChanges()" style="background:#27AE60; color:#fff; border:none;
            padding:10px 24px; border-radius:8px; font-weight:700; cursor:pointer; font-size:0.9rem;">
        Применить изменения
    </button>
    <button type="button" onclick="discardChanges()" style="background:rgba(255,255,255,0.15); color:#fff;
            border:1px solid rgba(255,255,255,0.3); padding:10px 20px; border-radius:8px;
            cursor:pointer; font-size:0.9rem;">
        Отменить
    </button>
</div>

<script>
// 2026-04-27: Batch save — накопленные toggle-изменения, один POST по «Применить»
var pendingChanges = {}; // ключ: "section:id:field"
var pendingCount = 0;

function adminToggle(btn) {
    var section = btn.dataset.section;
    var id = btn.dataset.id;
    var field = btn.dataset.field;
    var currentVal = btn.dataset.value === '1';
    var newVal = !currentVal;

    // Обновить data-value
    btn.dataset.value = newVal ? '1' : '0';

    // Обновить текст и классы кнопки в зависимости от стиля
    if (btn.classList.contains('admin-toggle')) {
        // ON/OFF стиль
        btn.classList.toggle('is-on', newVal);
        btn.classList.toggle('is-off', !newVal);
        btn.textContent = newVal ? 'ON' : 'OFF';
    } else if (btn.classList.contains('btn-toggle')) {
        // Опубликовать/Скрыть стиль (страницы)
        btn.classList.toggle('btn-primary', !newVal);
        btn.classList.toggle('btn-secondary', newVal);
        btn.textContent = newVal ? 'Скрыть' : 'Опубликовать';
    }

    // Обновить badge статуса в строке (если есть)
    var row = btn.closest('tr');
    if (row) {
        var badge = row.querySelector('.status-badge');
        if (badge) {
            badge.textContent = newVal ? 'На сайте' : 'Скрыт';
            badge.className = 'status-badge ' + (newVal ? 'badge-live' : 'badge-hidden');
        }
        // Live-preview фона логотипа для партнёров
        if (section === 'partners' && field === 'dark_bg') {
            var logoBg = row.querySelector('td:first-child div');
            if (logoBg) logoBg.style.background = newVal ? '#222' : '#fff';
            btn.textContent = newVal ? '◑' : '○';
        }
    }

    // Трекинг изменений
    var key = section + ':' + id + ':' + field;
    if (pendingChanges[key] && pendingChanges[key].originalValue === newVal) {
        // Вернулись к исходному значению — убрать из pending
        delete pendingChanges[key];
        pendingCount--;
        if (row) row.classList.remove('row-pending');
    } else if (!pendingChanges[key]) {
        pendingChanges[key] = {
            section: section, id: id, field: field,
            newValue: newVal, originalValue: currentVal
        };
        pendingCount++;
        if (row) row.classList.add('row-pending');
    } else {
        pendingChanges[key].newValue = newVal;
        if (row) row.classList.add('row-pending');
    }

    updatePendingBar();
}

function updatePendingBar() {
    var bar = document.getElementById('pending-bar');
    var countEl = document.getElementById('pending-count');
    if (!bar || !countEl) return;
    if (pendingCount > 0) {
        bar.style.display = 'flex';
        var word;
        var n = pendingCount;
        var n10 = n % 10, n100 = n % 100;
        if (n10 === 1 && n100 !== 11) word = 'изменение';
        else if (n10 >= 2 && n10 <= 4 && (n100 < 12 || n100 > 14)) word = 'изменения';
        else word = 'изменений';
        countEl.textContent = 'Есть ' + n + ' ' + word + ' — не сохранено';
    } else {
        bar.style.display = 'none';
    }
}

function applyChanges(onSuccess) {
    if (pendingCount === 0) { if (typeof onSuccess === 'function') onSuccess(); return; }
    var csrfEl = document.getElementById('global-csrf');
    var csrf = csrfEl ? csrfEl.value : '';
    var payload = JSON.stringify({changes: Object.keys(pendingChanges).map(function(k) {
        return pendingChanges[k];
    })});
    fetch('?action=batch-save&csrf=' + encodeURIComponent(csrf), {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: payload
    }).then(function(r) {
        return r.json();
    }).then(function(data) {
        if (data && data.ok) {
            pendingChanges = {};
            pendingCount = 0;
            var rows = document.querySelectorAll('.row-pending');
            for (var i = 0; i < rows.length; i++) rows[i].classList.remove('row-pending');
            updatePendingBar();
            if (typeof onSuccess === 'function') onSuccess();
            else showFlash('Изменения сохранены');
        } else {
            alert('Ошибка: ' + ((data && data.error) ? data.error : 'неизвестная'));
        }
    }).catch(function() {
        alert('Ошибка соединения');
    });
}

function discardChanges() {
    if (pendingCount === 0) return;
    pendingChanges = {};
    pendingCount = 0;
    var rows = document.querySelectorAll('.row-pending');
    for (var i = 0; i < rows.length; i++) rows[i].classList.remove('row-pending');
    updatePendingBar();
    showFlash('Изменения отменены');
}

// Кастомный модал при уходе со страницы с несохранёнными изменениями
function showLeaveModal(href) {
    var overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:10001;display:flex;align-items:center;justify-content:center;';
    overlay.innerHTML = '<div style="background:#fff;border-radius:12px;padding:28px 32px;max-width:380px;width:90%;box-shadow:0 8px 40px rgba(0,0,0,0.25);">'
        + '<h3 style="margin:0 0 8px;font-size:1.05rem;color:#1a1a1a;">Есть несохранённые изменения</h3>'
        + '<p style="margin:0 0 20px;color:#666;font-size:0.88rem;">Что сделать перед переходом?</p>'
        + '<div style="display:flex;flex-direction:column;gap:8px;">'
        + '<button id="lm-save" style="background:#27AE60;color:#fff;border:none;padding:11px 16px;border-radius:8px;font-weight:700;cursor:pointer;font-size:0.9rem;">Сохранить и перейти</button>'
        + '<button id="lm-cancel" style="background:#f5f5f5;color:#333;border:1px solid #ddd;padding:11px 16px;border-radius:8px;cursor:pointer;font-size:0.9rem;">Отмена</button>'
        + '<button id="lm-discard" style="background:transparent;color:#c0392b;border:none;padding:8px;cursor:pointer;font-size:0.85rem;text-decoration:underline;">Не сохранять и перейти</button>'
        + '</div></div>';
    document.body.appendChild(overlay);
    overlay.querySelector('#lm-cancel').onclick = function() { document.body.removeChild(overlay); };
    overlay.querySelector('#lm-discard').onclick = function() { pendingCount = 0; window.location.href = href; };
    overlay.querySelector('#lm-save').onclick = function() {
        document.body.removeChild(overlay);
        applyChanges(function() { window.location.href = href; });
    };
}

// Перехват кликов по ссылкам при наличии несохранённых изменений
document.addEventListener('click', function(e) {
    if (pendingCount === 0) return;
    var a = e.target.closest('a[href]');
    if (!a) return;
    var href = a.getAttribute('href');
    if (!href || href.charAt(0) === '#' || href.indexOf('javascript:') === 0) return;
    e.preventDefault();
    showLeaveModal(href);
});

// Для закрытия вкладки/браузера — стандартный диалог (кастомный текст не поддерживается браузерами)
window.addEventListener('beforeunload', function(e) {
    if (pendingCount > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});

function showFlash(msg) {
    var f = document.createElement('div');
    f.className = 'flash-msg';
    f.textContent = msg;
    document.body.appendChild(f);
    setTimeout(function() {
        if (f.parentNode) f.parentNode.removeChild(f);
    }, 3000);
}
</script>
</body>
</html>
