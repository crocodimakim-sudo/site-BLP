# Site-Kimi — BLP Board

**Язык:** Русский | **Прод:** `https://building-port.ru/`  
**Git:** `github.com/crocodimakim-sudo/site-BLP` (main)  
**Архив для подрядчика:** `D:/Claude Code/01-site-blp/site-kimi-hosting.zip`

---

## 🔴 КРИТИЧЕСКАЯ ИНФОРМАЦИЯ (2026-05-01)

### Переезд на shared хостинг — ЗАВЕРШЁН
- **Старый VPS `204.168.247.38` отключён.** Сайт работает на shared hosting.
- **Все пути изменены:** убран префикс `/blp/` из всего проекта. Сайт работает из корня домена.
- **Новый сервер:** shared хостинг, путь `/var/www/u2678850/data/www/building-port.ru/`
- **SSL:** активен, продление через панель хостинга.

### Деплой — ZIP через HTTP (автоматический)
- `deploy.bat` → `git archive` → ZIP → `curl POST` → `deploy.php` на сервере → распаковка
- `deploy.php` пропускает `database/` и `images/` — живые данные не перетираются
- `database/*.json` живут только на сервере, НЕ в git
- FTP (порт 21): `u2678850` / `55Ru4lCeOvO5wIjz` — для одноразовых загрузок (например, deploy.php сам)

### Единый источник правды для файлов
| Куда класть | Что происходит | Куда деплоится |
|-------------|---------------|----------------|
| `images/` | `convert_images.php` создаёт `images-convert/` | `images-convert/` на сервер |
| `images/pages/projects/название/` | Конвертация + `meta.json` | `images-convert/pages/projects/название/` |
| `images/pages/catalog/` | Конвертация | `images-convert/pages/catalog/` |
| `images/pages/catalog/slider/` | Конвертация | `images-convert/pages/catalog/slider/` |
| `images/pages/index/audience/` | Конвертация | `images-convert/pages/index/audience/` |

**Правило:** ВСЕГДА класть в `images/`, НИКОГДА руками в `images-convert/`.

---

## 🔴 ПРАВИЛО №1 — Единый workflow

```
1. Локальные изменения → git commit → git push
2. Новые картинки → images/ → convert_images.php
3. deploy.bat → ZIP → сервер (автоматически)
```

---

## 🔴 ПРАВИЛО №2 — Контент через админку vs деплой

| Что | Через админку | Через деплой |
|-----|--------------|--------------|
| **Тексты, настройки, видимость страниц** | ✅ `database/*.json` | ❌ |
| **Партнёры, сертификаты, каталог (тексты)** | ✅ `database/*.json` | ❌ |
| **Проекты (meta: название, локация, тег)** | ✅ `database/projects.json` | ❌ |
| **Фото проектов** | ❌ Отключено | ✅ `images/pages/projects/` |
| **Фото каталога / слайдер** | ❌ Отключено | ✅ `images/pages/catalog/` |
| **Фото аудитории** | ❌ Отключено | ✅ `images/pages/index/audience/` |
| **Favicon, og-default** | ❌ | ✅ `images/favicon.*`, `images/og-default.*` |

**Админка НЕ загружает фото** — кнопки загрузки удалены, вместо них инструкции.

---

## 🚀 ДЕПЛОЙ

### deploy.bat (автоматический)
```bash
cd "/d/Claude Code/01-site-blp/site-kimi"
C:/xampp/php/php.exe scripts/convert_images.php   # конвертация images/ → images-convert/
git add -A
git commit -m "описание"
git push
git archive --format=zip → deploy.php (curl POST)  # ZIP-деплой на shared hosting
```

### deploy.php на сервере
- Принимает ZIP через HTTP POST с `X-Deploy-Key: blp-deploy-2026-key`
- Распаковывает в docroot
- **Пропускает:** `database/`, `images/`, `deploy.php`, `.git/`

---

## ⚠️ ВАЖНЫЕ ТЕХНИЧЕСКИЕ НЮАНСЫ

### Аналитика (через админку)
- `template.php` читает `database/site_config.json`
- **GA4** — код рендерится если `ga4_id` заполнен
- **Яндекс.Метрика** — код рендерится если `yandex_metrika_id` заполнен
- **VK Pixel** — код рендерится если `vk_pixel_id` заполнен
- Админка показывает статус: 🟢 Подключен / 🔴 Не на сайте / ⚪ Не настроен

### Yandex Verification
```html
<meta name="yandex-verification" content="5c0035a8d8486cab" />
```
— встроен в `template.php` (все страницы).

### Мобильный скролл к якорям
`html { scroll-behavior: smooth }` + `[id] { scroll-margin-top: 90px }` → JS-скролл не работает на мобиле.  
**Решение:** только CSS `scroll-margin-top`.

### WALYPAN слайдер — цепочка flex
`.blp-image-section { height: 600px; display: flex; flex-direction: column }`  
→ `#slider-container { flex: 1; min-height: 0; display: flex; flex-direction: column }`  
→ `.blp-main-image { flex: 1; min-height: 0 }`  
→ `.blp-slide-track { height: 100%; flex: 1 }`  
→ `.blp-slide { position: relative }` + `img { position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover }`

### Аудитория (audience-section)
- Высота фото: `height: 300px` на `.audience-image-wrapper`
- `<picture>` внутри wrapper должен иметь `height: 100%`
- Пропорция для загрузки: **10:7**, рекомендуемый размер: **800×560px**
- **Загрузка только через деплой** (`images/pages/index/audience/`)

### Каталог
- `.product-card { max-height: 600px }` — 3 карточки (NATURE/POLISHED/TEXTURE)
- `.blp-product-block .blp-card` + `.blp-image-section` = WALYPAN, отдельная структура

### Architect мобайл
- `.blp-audience-block` — `display: grid; grid-template-columns: 1fr 1fr`
- На мобайл: `@media (max-width: 900px) { .blp-audience-block { grid-template-columns: 1fr } }`

### html { overflow-x: hidden } в main.css
Создаёт BFC. `window.scrollTo()` не работает на мобиле.

### pages_php/.htaccess — защита от прямого доступа
Логика: `REDIRECT_STATUS` пустой только при прямом HTTP-запросе → 403. Внутренние rewrites и error documents проходят. Admin (`^admin/`) исключён явно.  
Чистый URL для admin: `/admin` → `pages_php/admin/index.php` (добавлен в корневой `.htaccess`).

### Форма контактов
- `contact-form.js` — обрабатывает `id="contactForm"` (глобальный блок), НЕ загружается глобально
- `contacts.js` — обрабатывает `id="contactsPageForm"` (страница /contacts), загружается через `$extra_js`
- SQLite INSERT выполняется ДО `mail()` — лиды не теряются даже при сбое SMTP
- IMask загружается через CDN в `$extra_js` contacts.php

---

## 📁 СТРУКТУРА ПРОЕКТА

```
blocks/
  template.php, header.php, footer.php, breadcrumbs.php
  contact-form.php, send-form.php
  benefits.php, benefits-section.php, specs-section.php
  objects-section.php, partners-section.php, partners-slider.php
  products-section.php, audience-section.php
  cookie-consent-banner.php, get_projects.php, image-helper.php
  session_init.php        — CSRF инит (session_start + token)
  site_config.php         — читает database/site_config.json
catalog_config.php         — читает database/catalog.json

css/
  main.css                — reset, типографика, глобальные правила, .btn, .btn-secondary
  hero-section.css        — глобально
  header.css, footer.css, contact-form.css
  benefits.css, specs-section.css, objects-section.css
  partners-section.css, products-section.css, audience-section.css, animations.css
  pages/                  — постраничные стили

pages_php/
  index.php, catalog.php, contacts.php, kreplenie.php
  architect.php, devops.php, dealer.php, projects.php
  sertificate.php, policy.php, cookies.php, consent.php
  faq.php, install.php, compare-materials.php, blog.php, blog-post.php
  showcase.php, compare.php
  schema_*.php            — JSON-LD схемы
  admin/index.php         — Админ-панель (пароль blp2026admin), URL: /admin
  .htaccess               — блокирует прямой доступ к pages_php/ (REDIRECT_STATUS guard)

deploy.php                 — Приёмник ZIP-деплоя (shared hosting)
deploy.bat                 — Автоматический деплой: git → ZIP → HTTP POST

scripts/
  convert_images.php      — images/ → images-convert/ (PNG/JPG/WebP + -sm.webp + thumbnails)

database/                  — НЕ в git, живёт на сервере
  leads.db                — SQLite заявки
  blog.db                 — SQLite блог
  pages.json              — статусы страниц (is_live)
  site_config.json        — телефон, адрес, GA4 ID, Метрика ID, VK Pixel ID
  projects.json           — метаданные проектов (название, локация, тег, order)
  partners.json, certificates.json, catalog.json
```

---

## ⚙️ СТРАНИЦЫ (актуально)

| URL | PHP файл | Статус |
|-----|----------|--------|
| `/` | index.php | ✅ live |
| `/catalog` | catalog.php | ✅ live |
| `/kreplenie` | kreplenie.php | ✅ live |
| `/architect` | architect.php | ✅ live |
| `/devops` | devops.php | ✅ live |
| `/dealer` | dealer.php | ✅ live |
| `/projects` | projects.php | ✅ live |
| `/sertificate` | sertificate.php | ✅ live |
| `/contacts` | contacts.php | ✅ live |
| `/blog` | blog.php | ✅ live |
| `/blog/{slug}` | blog-post.php | ✅ live |
| `/faq` | faq.php | ✅ live |
| `/install` | install.php | ✅ live |
| `/compare-materials` | compare-materials.php | ✅ live (noindex снят) |
| `/policy`, `/cookies`, `/consent` | — | ✅ live |
| `/admin` | pages_php/admin/index.php | ✅ чистый URL |
| `/showcase` | showcase.php | ⏸ noindex |

---

## 📋 БЭКЛОГ — АКТУАЛЬНЫЙ ПЛАН

### 🔴 P0 — Критично
- [ ] **Google Search Console** — верификация домена (DNS TXT или HTML-метатег)

### 🟡 P1 — Важно
- [ ] **GA Consent Mode v2** — после подтверждения GSC
- [ ] **Загрузить больше объектов** — проекты через `images/pages/projects/` + deploy.bat

### 🟢 P2 — Улучшения
- [ ] **MySQL миграция** — если SQLite недостаточно для нагрузки
- [ ] **CSP enforce mode** — после аудита всех inline-скриптов
- [ ] **Больше статей в блог** — сейчас 19 статей

---

## ✅ ВЫПОЛНЕНО (2026-05-01)

- ✅ **ZIP-деплой на shared hosting** — deploy.bat + deploy.php (HTTP POST), database/ и images/ защищены
- ✅ **Favicon** — логотип BLITE с blite-light.ru (SVG), yandex-verification meta tag
- ✅ **images/ удалена из git** — ZIP уменьшен с 188 MB до ~40 MB
- ✅ **convert_images.php** — поддержка `.ico` (просто копирует)
- ✅ **Единый источник правды** — `images/` → `images-convert/` через конвертацию
- ✅ **projects meta в database/** — `database/projects.json`, editable в админке, не перетирается деплоем
- ✅ **Админка без загрузки фото** — проекты, каталог, слайдер, аудитория: только через deploy.bat
- ✅ **Аналитика из админки** — GA4, Яндекс.Метрика, VK Pixel читаются из `site_config.json`, статус-индикаторы в админке
- ✅ **GA4 отключён (2026-05-01)** — убран с сайта до получения уведомления Роскомнадзора о трансграничной передаче. Очищен `ga4_id` в `site_config.json` на сервере, код удалён из `template.php`, политики обновлены.
- ✅ **Яндекс.Метрика** — единственный счётчик аналитики. Указана во всех политиках как получатель обезличенных данных.
- ✅ **Защита формы от спама (2026-05-01)** — комплекс: серверная CAPTCHA (математическая задача), проверка скорости (min 3 сек), Referer, rate limit по IP (5/час) и email (1/сутки), убрано скрытое поле `message` (боты отправляли напрямую).
- ✅ **Cookie Secure** — `session.cookie_secure=1` в `template.php` (HTTPS).
- ✅ **deploy.php защита** — пропускает database/, images/, deploy.php, .git/
- ✅ **FTP доступ** — настроен для one-off загрузок (порт 21)

---

**Last updated:** 2026-05-01
