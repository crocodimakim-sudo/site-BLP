# AGENTS.md — BLP Board Site

## Критическое правило работы с изображениями

### Два каталога — разные роли

| Папка | Кто работает | Назначение |
|-------|-------------|------------|
| `images/` | Менеджер / Пользователь | Оригиналы — загрузка и удаление |
| `images-convert/` | Скрипт | Оптимизированные копии (50% размера) |

### ⚠️ Ловушка orphaned файлов

**Если фотография удалена из `images/` — конвертированная копия остаётся в `images-convert/` и продолжает отображаться на сайте.**

Скрипт `scripts/convert_images.php` создаёт новые копии, но **не удаляет старые автоматически** при удалении оригинала.

### Алгоритм действий при изменении фотографий

**После ЗАГРУЗКИ новых фото:**
```bash
php D:\Claude Code\site-blp\site-kimi\scripts\convert_images.php
```

**После УДАЛЕНИЯ фото:**
```bash
php D:\Claude Code\site-blp\site-kimi\scripts\convert_images.php
```
Скрипт удалит из `images-convert/` все файлы, оригиналов которых больше нет.

**Затем синхронизировать в XAMPP:**
```powershell
Remove-Item -Recurse -Force "C:\xampp\htdocs\blp\images-convert\pages\projects"
Copy-Item -Recurse -Force "D:\Claude Code\site-blp\site-kimi\images-convert\pages\projects" "C:\xampp\htdocs\blp\images-convert\pages\projects"
```

### Проверка

Всегда проверяй в браузере `Ctrl+F5` после синхронизации.
