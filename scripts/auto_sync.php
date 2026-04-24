<?php
/**
 * auto_sync.php
 * Автоматическая синхронизация изображений:
 * 1. Конвертирует новые PNG→WebP из images/ в images-convert/
 * 2. Синхронизирует только новые файлы на XAMPP
 * 3. Логирует все операции
 *
 * Запуск: php scripts/auto_sync.php
 * Или добавить в cron: 0 * * * * php /path/to/scripts/auto_sync.php
 */

// 2026-04-24: этот скрипт только для CLI
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only'); }

define('BASE_DIR', __DIR__ . '/..');
define('SRC_DIR', BASE_DIR . '/images');
define('DST_DIR', BASE_DIR . '/images-convert');
define('XAMPP_DIR', 'C:/xampp/htdocs/blp/images-convert');
define('LOG_FILE', BASE_DIR . '/scripts/sync.log');

$startTime = microtime(true);
$logLines = [];

function log_msg(string $msg): void {
    global $logLines;
    $timestamp = date('Y-m-d H:i:s');
    $logLines[] = "[$timestamp] $msg";
    echo "$msg\n";
}

function log_to_file(): void {
    global $logLines;
    if (empty($logLines)) return;
    file_put_contents(LOG_FILE, implode("\n", $logLines) . "\n\n", FILE_APPEND);
}

function countFiles(string $dir): int {
    if (!is_dir($dir)) return 0;
    $count = 0;
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($files as $file) {
        if ($file->isFile()) $count++;
    }
    return $count;
}

try {
    log_msg('=== SYNC START ===');

    // Шаг 1: Запустить конвертацию
    log_msg('Step 1: Converting images...');
    ob_start();
    // 2026-04-22: Suppress warnings about already defined constants
    @include BASE_DIR . '/scripts/convert_images.php';
    $convOutput = ob_get_clean();
    log_msg('Conversion done');

    // Шаг 2: Синхронизировать на XAMPP
    if (!is_dir(XAMPP_DIR)) {
        log_msg('Warning: XAMPP dir not found, skipping sync');
        throw new Exception('XAMPP dir not accessible');
    }

    log_msg('Step 2: Syncing to XAMPP...');
    $cmd = sprintf(
        'robocopy "%s" "%s" /E /PURGE /R:1 /W:1 /NP /NC /NS /NFL /NDL',
        DST_DIR,
        XAMPP_DIR
    );
    exec($cmd, $output, $returnCode);

    // robocopy return codes: 0-3 это успех, 4+ это ошибки
    if ($returnCode <= 3) {
        log_msg('Sync completed successfully');
    } else {
        log_msg("Sync warning (code $returnCode)");
    }

    // Шаг 3: Проверка
    $srcCount = countFiles(DST_DIR);
    $xamppCount = countFiles(XAMPP_DIR);

    log_msg("Files: src=$srcCount, xampp=$xamppCount");

    if ($srcCount !== $xamppCount) {
        log_msg("Warning: File count mismatch!");
    }

    $elapsed = round(microtime(true) - $startTime, 2);
    log_msg("=== SYNC DONE ($elapsed sec) ===");

} catch (Exception $e) {
    log_msg("ERROR: " . $e->getMessage());
} finally {
    log_to_file();
}
