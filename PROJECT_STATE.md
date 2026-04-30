# Состояние проекта site-kimi (BLP Board)

> **Дата фиксации:** 2026-04-30
> **Цель документа:** Зафиксировать текущее состояние проекта, технический стек, незакоммиченные изменения и точку отсчёта для дальнейших работ.

---

## 1. Общая информация

| Параметр | Значение |
|----------|----------|
| **Проект** | Сайт компании BLP Board (фиброцементные панели для вентилируемых фасадов) |
| **Локальный путь** | `D:\Claude Code\01-site-blp\site-kimi` |
| **Репозиторий** | `https://github.com/crocodimakim-sudo/site-BLP` (приватный) |
| **Текущий сервер** | `204.168.247.38` (старый, deploy настроен на него) |
| **Путь на сервере** | `/var/www/html/blp` |
| **Базовый URL** | `https://building-port.ru/blp/` |

---

## 2. Технологический стек

| Компонент | Версия / Реализация |
|-----------|---------------------|
| **Веб-сервер** | Apache 2.x (требуется установка) |
| **PHP** | 8.x (требуется установка + расширение GD) |
| **База данных** | SQLite 3 (`blog.db`, `leads.db`) |
| **Хранилище конфигов** | JSON-файлы (`database/*.json`) |
| **Конвертация изображений** | PHP GD / `scripts/convert_images.php` |
| **Фронтенд** | Vanilla JS, CSS3, адаптивная вёрстка |
| **Админ-панель** | PHP (без фреймворков), базовая HTTP-авторизация |
| **Контроль версий** | Git |

---

## 3. Структура проекта

```
site-kimi/
├── .htaccess                    # Главный конфиг Apache (mod_rewrite, заголовки, кэш)
├── .gitignore                   # Исключения из Git
├── robots.txt                   # Настройки для поисковых роботов
├── sitemap.xml                  # XML-карта сайта
├── deploy.bat                   # Деплой: git push + ssh git pull
├── rollback.bat                 # Откат последнего коммита на сервере
│
├── blocks/                      # PHP-блоки (компоненты)
│   ├── header.php               # Шапка сайта
│   ├── footer.php               # Подвал
│   ├── contact-form.php         # Форма обратной связи
│   ├── cookie-consent-banner.php# Баннер согласия cookies
│   ├── breadcrumbs.php          # Хлебные крошки
│   ├── template.php             # Базовый шаблон страницы
│   ├── site_config.php          # Хелпер для чтения database/site_config.json
│   ├── image-helper.php         # Хелпер WebP + lazy-loading
│   ├── session_init.php         # Инициализация сессии
│   ├── send-form.php            # Обработчик форм
│   ├── get_projects.php         # Получение данных проектов
│   ├── catalog_config.php       # Конфигурация каталога
│   └── ... (другие секции)
│
├── pages_php/                   # Все страницы сайта
│   ├── .htaccess               # Защита от прямого доступа к PHP-файлам
│   ├── index.php               # Главная
│   ├── catalog.php             # Каталог
│   ├── blog.php                # Блог (листинг)
│   ├── blog-post.php           # Статья блога
│   ├── architect.php           # Страница архитектору
│   ├── dealer.php              # Страница дилеру (бывш. diler)
│   ├── devops.php              # Страница девелоперу
│   ├── contacts.php            # Контакты
│   ├── faq.php                 # FAQ
│   ├── compare.php             # Сравнение серий
│   ├── compare-materials.php   # Сравнение материалов
│   ├── install.php             # Монтаж
│   ├── projects.php            # Проекты
│   ├── sertificate.php         # Сертификаты
│   ├── policy.php              # Политика конфиденциальности
│   ├── cookies.php             # Cookies
│   ├── consent.php             # Согласие на обработку
│   ├── kreplenie.php           # Типы крепления
│   ├── showcase.php            # Витрина
│   ├── error.php               # Страница ошибки
│   ├── 400–503.php             # HTTP-ошибки
│   ├── schema_*.php            # Schema.org разметка
│   ├── template.php            # Шаблон
│   ├── api/
│   │   └── slider.php          # API: данные для слайдера
│   └── admin/
│       ├── .htaccess           # Доступ к админке
│       └── index.php           # Панель администратора
│
├── database/                    # Данные (не в Git)
│   ├── .htaccess               # Запрет доступа
│   ├── site_config.json        # Контакты, реквизиты, ID счётчиков
│   ├── catalog.json            # Данные каталога
│   ├── pages.json              # Структура страниц
│   ├── partners.json           # Партнёры
│   ├── certificates.json       # Сертификаты
│   ├── blog.db                 # SQLite: статьи блога
│   ├── leads.db                # SQLite: заявки с форм
│   ├── init_db.php             # Инициализация БД
│   ├── init_blog.php           # Инициализация блога
│   ├── add_compare_faq_articles.php  # Миграция контента
│   ├── add_install_articles.php      # Миграция контента
│   └── update_blog_images.php        # Обновление изображений блога
│
├── images/                      # Исходные изображения (не в Git)
│   ├── blocks/                 # Блоки (benefits, products, partners)
│   ├── pages/                  # Страницы (hero, галереи)
│   ├── diler/                  # Страница дилера
│   └── shared/                 # Общие (логотип, фавикон)
│
├── images-convert/              # Сконвертированные WebP + thumbnails (не в Git)
│   ├── blocks/
│   ├── pages/
│   ├── diler/
│   ├── shared/
│   ├── thumbnails/
│   ├── og-default.webp         # OG-изображение по умолчанию
│   └── watermark-pattern.svg   # Водяной знак
│
├── css/                         # Стили
│   ├── main.css                # Главные стили
│   ├── animations.css          # Анимации
│   ├── header.css, footer.css  # Компоненты
│   └── pages/                  # Стили отдельных страниц
│
├── js/                          # Скрипты
│   ├── main.js                 # Главный скрипт
│   └── pages/                  # Скрипты страниц
│
├── html/                        # HTML-превью (генерируется, не в деплое)
│   ├── index.html
│   ├── catalog.html
│   └── ...
│
├── logs/                        # Логи заявок (не в Git, закрыт доступ)
│
└── scripts/                     # Служебные скрипты
    ├── convert_images.php      # Конвертация в WebP + thumbnails
    ├── generate_webp.php       # Генерация WebP
    ├── compress_heavy.php      # Сжатие тяжёлых файлов
    ├── generate_og_default.php # Генерация OG-изображения
    ├── generate_html.bat       # Генерация HTML-превью
    ├── auto_sync.php           # Автосинхронизация
    └── run_sync.bat            # Запуск синхронизации
```

---

## 4. Состояние Git

### Последние коммиты
```
b9596cb  2026-04-28: audience 300px/green btn/picture fix, architect mobile grid, admin audience section
626b122  2026-04-28: убраны .omc/, CLAUDE.md, локальные скрипты из git
9a1b7e8  2026-04-28: обновлены фото аудитории (architect, dealer, developer)
3e5787e  2026-04-28: catalog product-card max-height 600px, WALYPAN slider images fill container
08627d2  2026-04-28: product-card max-height 600px
```

### Незакоммиченные изменения (modified)
| Файл | Статус | Примечание |
|------|--------|------------|
| `.htaccess` | Modified | Вероятно, изменения в rewrite или заголовках |
| `blocks/get_projects.php` | Modified | Изменения в логике получения проектов |
| `js/pages/projects.js` | Modified | Изменения в JS проектов |
| `pages_php/admin/index.php` | Modified | Изменения в админ-панели |
| `pages_php/contacts.php` | Modified | Изменения в странице контактов |
| `scripts/convert_images.php` | Modified | Изменения в конвертации изображений |
| `images/og-default.jpg` | Deleted | Удалено старое OG-изображение |
| `images/shared/favicon.svg` | Deleted | Удалён старый фавикон |

### Untracked файлы (новые, не в Git)
- **Много `*-sm.webp`** в `images-convert/` — это миниатюры (thumbnails), сгенерированные скриптом `convert_images.php`
- OG-изображения в WebP-формате

### Что НЕ должно попадать в Git
Согласно `.gitignore` и логике проекта:
- `images/` — исходные изображения (тяжёлые)
- `images-convert/` — сконвертированные WebP (генерируются на сервере)
- `database/*.db` — SQLite-базы (данные)
- `logs/` — логи заявок
- `.omc/`, `.gstack/`, `.claude_work_log` — служебные папки агентов
- `*.log`, `*.bat`, `*.sh` — локальные скрипты (частично)

---

## 5. Конфигурация Apache (текущая локальная)

### Корневой .htaccess
- **RewriteBase:** `/blp/`
- **DirectoryIndex:** `pages_php/index.php`
- **Чистые URL:** `/blog`, `/catalog`, `/dealer`, `/faq`, `/admin` и др.
- **Редиректы:** `diler` → `dealer` (301)
- **HTTPS:** редирект закомментирован (ждёт SSL)
- **Security headers:** HSTS, X-Frame-Options, CSP Report-Only
- **Gzip:** `mod_deflate` для текстовых типов
- **Кэширование:** 1 год для статики, 1 час для HTML
- **Защита:** закрыт доступ к `.md`, `.py`, `.bat`, `.sql`, `.env`, `.json`, `.lock`, `.git`, `scripts/`, `html/`, `.omc/`, `logs/`

### pages_php/.htaccess
- Блокирует прямой HTTP-доступ ко всем PHP-файлам страниц
- Исключение: `admin/` (своя авторизация)
- Пропускает внутренние реврайты Apache (`REDIRECT_STATUS`)

---

## 6. База данных и конфигурация

### SQLite
| База | Назначение | Файл |
|------|------------|------|
| `blog.db` | Статьи блога | `database/blog.db` |
| `leads.db` | Заявки с форм | `database/leads.db` |

### JSON-конфиги
| Файл | Назначение |
|------|------------|
| `site_config.json` | Телефон, email, адрес, реквизиты, ID аналитики |
| `catalog.json` | Продукты, серии, характеристики |
| `pages.json` | Структура страниц |
| `partners.json` | Данные партнёров |
| `certificates.json` | Сертификаты и документы |

### site_config.json (ключевые поля)
```json
{
    "phone": "+7 (495) 984-96-89",
    "email": "info@building-port.ru",
    "company_name": "ООО «Билдингпорт»",
    "inn": "7708427307",
    "ogrn": "1237700843390",
    "ga4_id": "G-PLACEHOLDER20260420"
}
```

---

## 7. Процесс деплоя (текущий)

### deploy.bat
1. Конвертация изображений (`scripts/convert_images.php`)
2. `git add -A`
3. `git commit -m "сообщение"`
4. `git push`
5. `ssh root@204.168.247.38 "cd /var/www/html/blp && git pull"`
6. Генерация HTML-превью (`scripts/generate_html.bat`)
7. Открытие сайта в Chrome

### rollback.bat
1. `git revert HEAD --no-edit`
2. `git push`
3. `ssh root@204.168.247.38 "cd /var/www/html/blp && git pull"`

### Важно
- Тяжёлые папки (`images-convert/`, `database/`) **не передаются через Git**
- На сервере они должны быть развёрнуты отдельно (копирование или генерация)
- Текущий сервер `204.168.247.38` — старый, требуется новый

---

## 8. Точка отсчёта (задачи по развёртыванию)

Остановились на следующем списке задач для нового сервера:

1. [ ] **Установить Apache + PHP 8.x + расширение GD**
2. [ ] **Включить mod_rewrite**
3. [ ] **Склонировать репозиторий:**
   ```bash
   git clone https://github.com/crocodimakim-sudo/site-BLP /var/www/html/blp
   ```
4. [ ] **Распаковать архив и положить папки:**
   - `images-convert/` → `/var/www/html/blp/images-convert/`
   - `database/` → `/var/www/html/blp/database/`
5. [ ] **В конфиге Apache (vhost) добавить:**
   ```apache
   <Directory /var/www/html/blp/pages_php>
       AllowOverride All
   </Directory>
   ```
6. [ ] **Настроить SSL через Let's Encrypt / Certbot**
7. [ ] **Дать SSH-доступ (логин + IP нового сервера)**

### Что нужно учесть
- Перед деплоем на новый сервер нужно закоммитить или отменить текущие незакоммиченные изменения
- `images-convert/` и `database/` нужно будет либо скопировать напрямую, либо перегенерировать на сервере
- После установки SSL нужно раскомментировать HTTPS-редирект в `.htaccess`
- `deploy.bat` и `rollback.bat` нужно будет обновить с новым IP сервера

---

## 9. Ключевые файлы и их назначение

| Файл | Назначение |
|------|------------|
| `.htaccess` | Маршрутизация, безопасность, кэш, gzip, CSP |
| `blocks/site_config.php` | Чтение `site_config.json` |
| `blocks/image-helper.php` | WebP + lazy-loading + responsive images |
| `scripts/convert_images.php` | Конвертация JPG/PNG → WebP + thumbnails |
| `pages_php/admin/index.php` | Админ-панель |
| `database/site_config.json` | Контакты, реквизиты, ID счётчиков аналитики |
| `database/blog.db` | SQLite: статьи блога |
| `database/leads.db` | SQLite: заявки |
| `deploy.bat` | Деплой на сервер |
| `rollback.bat` | Откат последнего коммита |

---

## 10. Примечания

- Проект использует **чистый PHP без фреймворков**
- Все страницы используют общий шаблон (`blocks/template.php`) через `require_once`
- SEO-разметка Schema.org реализована отдельными файлами (`schema_*.php`)
- Аналитика: заглушка для GA4 (`G-PLACEHOLDER20260420`), Яндекс.Метрика не настроена
- Cookie-консент и политики (cookies, consent, privacy) — реализованы
- Блог работает на SQLite с ЧПУ (`/blog/nazvanie-stati`)

---

**Фиксация завершена. Готов к продолжению работ.**
