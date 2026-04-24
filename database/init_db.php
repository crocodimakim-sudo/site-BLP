<?php
// 2026-04-24: инициализация SQLite базы заявок
if (php_sapi_name() !== 'cli') { http_response_code(403); exit; }
$db = new PDO('sqlite:' . __DIR__ . '/leads.db');
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
echo "OK\n";
