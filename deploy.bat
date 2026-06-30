@echo off
REM 2026-04-30: deploy.bat - deploy via ZIP + HTTP to shared hosting
REM Usage: deploy.bat "commit message"
chcp 65001 >nul

setlocal

cd /d "D:\Claude Code\01-sites-buildingport\01-site-blpboard"

REM 2026-06-11: ключ из env var BLP_DEPLOY_KEY (плейн-текст в репо больше не хранится)
if "%BLP_DEPLOY_KEY%"=="" (
    echo ERROR: BLP_DEPLOY_KEY env var is not set
    echo Set it once: setx BLP_DEPLOY_KEY "your-secret-key" ^&^& restart terminal
    exit /b 1
)

REM Commit message
if "%~1"=="" (
    for /f "tokens=1-3 delims=/" %%a in ('date /t') do set TODAY=%%c-%%b-%%a
    set MSG=update %TODAY%
) else (
    set MSG=%~1
)

echo.
echo === DEPLOY: %MSG% ===
echo.

echo [0/5] Converting images...
C:\xampp\php\php.exe scripts\convert_images.php
if errorlevel 1 (
    echo ERROR: image conversion failed
    exit /b 1
)

echo [1/5] git add...
git add -A

echo [2/5] git commit...
git commit -m "%MSG%"
if errorlevel 1 (
    echo No changes to commit, continuing...
)

echo [3/5] git push...
git push
if errorlevel 1 (
    echo ERROR: git push failed
    exit /b 1
)

echo [4/5] Creating ZIP from git...
set ZIPFILE=%TEMP%\01-site-blpboard-deploy.zip
git archive --format=zip -o "%ZIPFILE%" HEAD
if errorlevel 1 (
    echo ERROR: failed to create ZIP
    exit /b 1
)
for %%I in ("%ZIPFILE%") do echo ZIP size: %%~zI bytes

echo [5/5] Uploading ZIP to server...
curl.exe -s -X POST "https://building-port.ru/deploy.php" ^
    -H "X-Deploy-Key: %BLP_DEPLOY_KEY%" ^
    -F "zip=@%ZIPFILE%" ^
    -o "%TEMP%\deploy-response.json" ^
    -w "\nHTTP_CODE: %%{http_code}\n"
set CURLCODE=%ERRORLEVEL%
del "%ZIPFILE%"

if %CURLCODE% neq 0 (
    echo ERROR: curl failed (code %CURLCODE%)
    exit /b 1
)

type "%TEMP%\deploy-response.json"
echo.

echo [6/5] Updating HTML preview...
call scripts\generate_html.bat

start chrome --incognito "https://building-port.ru/"
echo.
echo Deploy complete!
