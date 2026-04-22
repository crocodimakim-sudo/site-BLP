@echo off
REM run_sync.bat — запускает auto_sync.php
REM Используется в Windows Task Scheduler для автоматического запуска каждый час

cd /d "D:\Claude Code\site-blp\site-kimi"
"C:\xampp\php\php.exe" "scripts/auto_sync.php"
