<?php
/**
 * Deploy receiver — распаковка ZIP-архива от deploy.bat
 * Защита: секретный ключ в HTTP-заголовке X-Deploy-Key
 * 2026-06-11: ключ из env BLP_DEPLOY_KEY (или файла .deploy-key), hash_equals (timing-safe),
 *             zip-slip защита в цикле распаковки. Захардкоженный ключ удалён.
 */

// 2026-06-11: ключ из env. Fallback: .deploy-key в docroot (защищён .htaccess) или родителе.
$DEPLOY_KEY = getenv('BLP_DEPLOY_KEY') ?: '';
if ($DEPLOY_KEY === '') {
    foreach ([__DIR__, dirname(__DIR__)] as $dir) {
        $keyFile = $dir . '/.deploy-key';
        if (is_file($keyFile)) {
            $DEPLOY_KEY = trim(@file_get_contents($keyFile));
            if ($DEPLOY_KEY !== '') break;
        }
    }
}
if ($DEPLOY_KEY === '') {
    http_response_code(500);
    die(json_encode(['ok' => false, 'error' => 'Server misconfiguration: deploy key not set']));
}

$DOCROOT    = realpath(__DIR__);
$MAX_SIZE   = 200 * 1024 * 1024; // 200 MB

// 1. Проверка ключа (timing-safe)
$headers = getallheaders();
$clientKey = $headers['X-Deploy-Key'] ?? $_SERVER['HTTP_X_DEPLOY_KEY'] ?? '';
if (!is_string($clientKey) || !hash_equals($DEPLOY_KEY, $clientKey)) {
    http_response_code(403);
    die(json_encode(['ok' => false, 'error' => 'Invalid deploy key']));
}

// 2. Проверка файла
if (empty($_FILES['zip'])) {
    http_response_code(400);
    die(json_encode(['ok' => false, 'error' => 'No zip file uploaded']));
}

$zipFile = $_FILES['zip']['tmp_name'];
$zipSize = $_FILES['zip']['size'];

if ($zipSize > $MAX_SIZE) {
    http_response_code(413);
    die(json_encode(['ok' => false, 'error' => 'Zip too large: ' . round($zipSize/1024/1024,1) . ' MB']));
}

if (!is_uploaded_file($zipFile)) {
    http_response_code(400);
    die(json_encode(['ok' => false, 'error' => 'Invalid upload']));
}

// 3. Распаковка
$zip = new ZipArchive();
if ($zip->open($zipFile) !== true) {
    http_response_code(400);
    die(json_encode(['ok' => false, 'error' => 'Cannot open zip']));
}

$extracted = 0;
$skipped   = 0;
$errors    = [];

for ($i = 0; $i < $zip->numFiles; $i++) {
    $stat = $zip->statIndex($i);
    $name = $stat['name'];

    // Не трогаем database/ — там живые данные сервера
    if (strpos($name, 'database/') === 0) {
        $skipped++;
        continue;
    }

    // Не трогаем images/ — оригиналы, не в git
    if (strpos($name, 'images/') === 0) {
        $skipped++;
        continue;
    }

    // Не трогаем deploy.php самого себя — иначе распаковка оборвётся
    if ($name === 'deploy.php') {
        $skipped++;
        continue;
    }

    // Не трогаем .git/
    if (strpos($name, '.git/') === 0) {
        $skipped++;
        continue;
    }

    // 2026-06-11: zip-slip защита — нормализация имени и отклонение опасных путей
    $normalized = str_replace('\\', '/', $name);
    if ($normalized === '' || $normalized[0] === '/'
        || preg_match('#(^|/)\.\.(/|$)#', $normalized)) {
        $errors[] = 'rejected suspicious path';
        continue;
    }

    $target = $DOCROOT . '/' . $normalized;

    if (substr($normalized, -1) === '/') {
        // Директория
        if (!is_dir($target)) {
            mkdir($target, 0755, true);
        }
    } else {
        // Файл
        $dir = dirname($target);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        // 2026-06-11: проверка что итоговая директория внутри docroot (realpath-префикс)
        $resolved = realpath($dir);
        if ($resolved === false || strpos($resolved, $DOCROOT) !== 0) {
            $errors[] = 'rejected after resolve';
            continue;
        }
        $content = $zip->getFromIndex($i);
        if ($content === false) {
            $errors[] = 'read error';
            continue;
        }
        if (file_put_contents($target, $content) === false) {
            $errors[] = 'write error';
            continue;
        }
        $extracted++;
    }
}

$zip->close();
unlink($zipFile);

// 4. Ответ
http_response_code(200);
header('Content-Type: application/json');
echo json_encode([
    'ok'        => true,
    'extracted' => $extracted,
    'skipped'   => $skipped,
    'errors'    => count($errors), // 2026-06-11: не раскрываем пути
    'time'      => date('Y-m-d H:i:s')
], JSON_UNESCAPED_UNICODE);
