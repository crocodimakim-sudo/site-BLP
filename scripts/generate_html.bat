@echo off
REM 2026-04-24: generate_html.bat — генерация статических HTML-превью всех страниц
REM Требует: XAMPP запущен на localhost/blp
REM Использование: scripts\generate_html.bat

setlocal
cd /d "D:\Claude Code\site-blp\site-kimi"

echo.
echo === ГЕНЕРАЦИЯ HTML-ПРЕВЬЮ ===
echo.

REM Очищаем старые файлы
echo Удаляю старые превью...
if exist html\ (
    del /q html\*.html 2>nul
)

REM Список страниц: URL → имя файла
set BASE=http://localhost/blp

echo Скачиваю страницы с localhost...

curl -s -o html\index.html    "%BASE%/"
echo   [OK] index.html

curl -s -o html\catalog.html  "%BASE%/catalog"
echo   [OK] catalog.html

curl -s -o html\kreplenie.html "%BASE%/kreplenie"
echo   [OK] kreplenie.html

curl -s -o html\devops.html   "%BASE%/devops"
echo   [OK] devops.html

curl -s -o html\architect.html "%BASE%/architect"
echo   [OK] architect.html

curl -s -o html\projects.html "%BASE%/projects"
echo   [OK] projects.html

curl -s -o html\dealer.html   "%BASE%/dealer"
echo   [OK] dealer.html

curl -s -o html\sertificate.html "%BASE%/sertificate"
echo   [OK] sertificate.html

curl -s -o html\contacts.html "%BASE%/contacts"
echo   [OK] contacts.html

curl -s -o html\policy.html   "%BASE%/policy"
echo   [OK] policy.html

curl -s -o html\cookies.html  "%BASE%/cookies"
echo   [OK] cookies.html

curl -s -o html\consent.html  "%BASE%/consent"
echo   [OK] consent.html

echo.
echo === ГОТОВО! HTML-превью сохранены в папку html\ ===
echo.
