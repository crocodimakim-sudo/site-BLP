<?php
/**
 * Deploy receiver — распаковка ZIP-архива от deploy.bat
 * Защита: секретный ключ в HTTP-заголовке X-Deploy-Key
 */

$DEPLOY_KEY = 'blp-deploy-2026-key';
$DOCROOT    = __DIR__;
$MAX_SIZE   = 200 * 1024 * 1024; // 200 MB

// 1. Проверка ключа
$headers = getallheaders();
$clientKey = $headers['X-Deploy-Key'] ?? $_SERVER['HTTP_X_DEPLOY_KEY'] ?? '';
if ($clientKey !== $DEPLOY_KEY) {
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
    
    $target = $DOCROOT . '/' . $name;
    
    if (substr($name, -1) === '/') {
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
        $content = $zip->getFromIndex($i);
        if ($content === false) {
            $errors[] = 'read error: ' . $name;
            continue;
        }
        if (file_put_contents($target, $content) === false) {
            $errors[] = 'write error: ' . $name;
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
    'errors'    => $errors,
    'time'      => date('Y-m-d H:i:s')
], JSON_UNESCAPED_UNICODE);
