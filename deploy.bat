@echo off
REM 2026-04-30: deploy.bat — деплой через ZIP + HTTP на shared hosting
REM Использование: deploy.bat "Описание изменений"

setlocal

cd /d "D:\Claude Code\01-site-blp\site-kimi"

REM Сообщение коммита
if "%~1"=="" (
    for /f "tokens=1-3 delims=/" %%a in ('date /t') do set TODAY=%%c-%%b-%%a
    set MSG=update %TODAY%
) else (
    set MSG=%~1
)

echo.
echo === DEPLOY: %MSG% ===
echo.

echo [0/5] Конвертация изображений...
C:\xampp\php\php.exe scripts\convert_images.php
if errorlevel 1 (
    msg * "DEPLOY ОШИБКА: конвертация изображений не удалась"
    exit /b 1
)

echo [1/5] git add...
git add -A

echo [2/5] git commit...
git commit -m "%MSG%"
if errorlevel 1 (
    echo Нет изменений для коммита, продолжаем...
)

echo [3/5] git push...
git push
if errorlevel 1 (
    msg * "DEPLOY ОШИБКА: git push не удался"
    exit /b 1
)

echo [4/5] Создаю ZIP из git...
set ZIPFILE=%TEMP%\site-kimi-deploy.zip
git archive --format=zip -o "%ZIPFILE%" HEAD
if errorlevel 1 (
    msg * "DEPLOY ОШИБКА: не удалось создать ZIP"
    exit /b 1
)
for %%I in ("%ZIPFILE%") do echo Размер ZIP: %%~zI байт

echo [5/5] Загружаю ZIP на сервер...
curl.exe -s -X POST "https://building-port.ru/deploy.php" ^
    -H "X-Deploy-Key: blp-deploy-2026-key" ^
    -F "zip=@%ZIPFILE%" ^
    -o "%TEMP%\deploy-response.json" ^
    -w "\nHTTP_CODE: %%{http_code}\n"
set CURLCODE=%ERRORLEVEL%
del "%ZIPFILE%"

if %CURLCODE% neq 0 (
    msg * "DEPLOY ОШИБКА: curl не удался (код %CURLCODE%)"
    exit /b 1
)

type "%TEMP%\deploy-response.json"
echo.

echo [6/5] Обновляю HTML-превью...
call scripts\generate_html.bat

start chrome --incognito "https://building-port.ru/"
msg * "✓ Deploy готов! Сайт обновлён."
