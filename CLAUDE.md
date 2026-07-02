# Site-Kimi — BLP Board

**Язык:** Русский | **Прод:** `https://building-port.ru/`  
**Git:** `github.com/crocodimakim-sudo/site-BLP` (main)  
**Архив для подрядчика:** `D:/Claude Code/01-sites-buildingport/01-site-blpboard-hosting.zip`

---

## 🎨 Дизайн-система (2026-06-23)

**Перед любым визуальным/UI-решением сверяйся с источником истины:**
`D:/Claude Code/01-sites-buildingport/00-ДИЗАЙН-СИСТЕМА/` — `DESIGN.md` (правила) + `tokens.css` (CSS-переменные) + `styleguide.html` (живой гайд).

- Цвета/шрифты/отступы/иерархия — только оттуда. Зелёный `#00352F` + тёплый бетонный нейтрал, БЕЗ золота. Шрифт: Montserrat (веб) / Arial (документы).
- Отклонение от системы — только с согласия владельца + запись в «Журнал решений» DESIGN.md.

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
cd "/d/Claude Code/01-sites-buildingport/01-site-blpboard"
C:/xampp/php/php.exe scripts/convert_images.php   # конвертация images/ → images-convert/
git add -A
git commit -m "описание"
git push
git archive --format=zip → deploy.php (curl POST)  # ZIP-деплой на shared hosting
```

### deploy.php на сервере
- Принимает ZIP через HTTP POST с заголовком `X-Deploy-Key`
- Распаковывает в docroot
- **Пропускает:** `database/`, `images/`, `deploy.php` (сам себя), `.git/`

### 🔑 Ключ деплоя (2026-06-30 — рефакторинг безопасности завершён)
**Захардкоженного ключа в репозитории больше НЕТ** (старый `blp-deploy-2026-key` ротирован и выведен из эксплуатации — он лежал в истории git).
- **Локально (клиент):** `deploy.bat` берёт ключ из env-переменной `BLP_DEPLOY_KEY`. Переменная задана постоянно в User-окружении Windows (`setx`/`[Environment]::SetEnvironmentVariable(...,'User')`).
  - ⚠️ `setx` применяется только к **новым** процессам — после установки нужен **перезапуск терминала/сессии**.
  - Разово в текущей сессии PowerShell: `$env:BLP_DEPLOY_KEY = '<ключ>'`.
- **На сервере:** `deploy.php` читает ключ так: `getenv('BLP_DEPLOY_KEY')` → fallback на файл `.deploy-key`. Файл лежит в **родителе docroot** `/var/www/u2678850/data/www/.deploy-key` (вне веба, HTTP отдаёт 404), сравнение timing-safe (`hash_equals`), есть zip-slip защита.
- **Значение ключа** хранится ТОЛЬКО в этих двух местах (env + `.deploy-key`), в git его нет (`.deploy-key` в `.gitignore`).
- `deploy.php` обновляется только по **FTP** (ZIP-деплой намеренно пропускает сам `deploy.php`).

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
`.blp-image-section { height: 700px; display: flex; flex-direction: column }` (мобайл: `height: 398px` в `@media (max-width: 768px)`)  
→ `#slider-container { flex: 1; min-height: 0; display: flex; flex-direction: column }`  
→ `.blp-main-image { flex: 1; min-height: 0 }`  
→ `.blp-slide-track { height: 100%; flex: 1 }`  
→ `.blp-slide { position: relative }` + `img { position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover }`  
Дубликат точек навигации скрыт: `.blp-product-block .blp-dots { display: none }`

### Аудитория (audience-section)
- Высота фото: `height: 300px` на `.audience-image-wrapper`
- `<picture>` внутри wrapper должен иметь `height: 100%`
- Пропорция для загрузки: **10:7**, рекомендуемый размер: **800×560px**
- **Загрузка только через деплой** (`images/pages/index/audience/`)

### Каталог
- `.product-card { max-height: 700px }` — 3 карточки (NATURE/POLISHED/TEXTURE)
- `.blp-product-block .blp-card` + `.blp-image-section` = WALYPAN, отдельная структура
- **Цены:** хранятся в `database/catalog.json` → `series.{key}.prices` как объект `{"8":"1200","10":"1400",...}`
- `catalog_config.php` → `get_catalog_prices(string $key): array` — читает prices из catalog.json
- В шаблоне `catalog.php` — спан `.product-price__value` внутри `.blp-specs` (под строкой «Ширина, мм»), атрибут `data-prices` содержит JSON с ценами по толщинам
- JS `selectThickness()` — при клике по `.catalog-thickness` обновляет текст `.product-price__value` до `"{цена} руб./м²"`
- `.catalog-thickness.is-active { background: var(--color-brand) }` — активная толщина подсвечивается зелёным (цвет бренда)
- Редактирование цен: `/admin` → Каталог → поля «Цена для толщины X мм»

### Форма контактов — чекбоксы
- `.form-checkbox-group { grid-column: 1 / -1 }` — оба чекбокса растягиваются на все 4 колонки грида
- `.form-checkbox { margin-top: 2px }` — вертикальное выравнивание с текстом
- `.form-checkbox-label { font-size: 13px }` — не менять на 12px
- Marketing-чекбокс: `display: flex; align-items: center; gap: 8px; flex: 1` (label оборачивает input+span)

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
  cookie-consent-banner.php, welcome-popup.php, get_projects.php, image-helper.php
  session_init.php        — CSRF инит (session_start + token)
  site_config.php         — читает database/site_config.json
catalog_config.php         — читает database/catalog.json; get_catalog_series(), get_catalog_prices(key)

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

**Статусы сверены на проде 2026-07-02.** `[ ]` не начат · `[~]` частично · `[x]` готово-и-проверено.
Легенда стадий: техническая SEO-база (Фазы 1-5) — ✅ сделана; дальше рост = контент (Phase 7).

### 🔴 P0 — Критично
- [~] **1. Чекпоинт GSC/Яндекс (планировался ~2026-05-20)** — просрочен на ~6 недель. Извне не проверяется (нужен доступ к GSC/Вебмастеру). → готово когда: в GSC зафиксированы coverage/impressions/ошибки, результат записан в `../05-SEO-И-ОНЛАЙН/`.
- [~] **2. Submit sitemap** — `sitemap.xml` отдаёт 200, прописан в `robots.txt` (+`sitemap-images.xml`). Факт отправки в консоли извне не виден. → готово когда: в GSC и Яндекс.Вебмастере статус sitemap = Success.

### 🟡 P1 — Важно
- [~] **3. Phase 7: Content** — начато: **9 блог-постов** из плана 20-50; всего **22 URL** в sitemap. Нет калькулятора (`/calculator` → 404), нет страниц по городам. План: `../05-SEO-И-ОНЛАЙН/PHASE-7-CONTENT-PLAN.md`. → готово когда: ≥20 статей + калькулятор + ≥3 city-страницы задеплоены.
- [ ] **4. GA Consent Mode v2** — н/п: GA4 сейчас ВЫКЛЮЧЕН (на проде только Яндекс.Метрика, `gtag` отсутствует). Пункт разблокируется только если вернём GA4. → готово когда: включён GA4 + Consent Mode v2.
- [ ] **5. Загрузить больше объектов** — проекты через `images/pages/projects/` + deploy.bat. → готово когда: добавлено ≥N новых объектов (N уточнить у владельца).

### 🟢 P2 — Улучшения
- [ ] **6. H1 на /kreplenie** — по-прежнему отсутствует (проверено: 0 тегов h1). → готово когда: на странице ровно один осмысленный `<h1>` с ключом.
- [ ] **7. H1 на /architect** — по-прежнему «Кому можем помочь» (слабый для SEO). → готово когда: `<h1>` переписан под запрос.
- [ ] **8. Дальнейший LCP-фикс** — defer non-critical CSS, устранить forced reflow в JS. База: LCP 4.5s (замер 2026-05-06). → готово когда: LCP mobile < 2.5s по Lighthouse.
- [ ] **9. MySQL миграция** — только если SQLite не тянет нагрузку. → готово когда: лиды/блог на MySQL, старые данные перенесены.
- [ ] **10. CSP enforce mode** — сейчас заголовок `Content-Security-Policy-Report-Only` (проверено). → готово когда: после аудита inline-скриптов заголовок переведён в enforce без поломок.

### ✅ Свежий цикл (2026-06-30) — закрыто
- [x] Цены каталога приведены к прайсу с НДС; лишние дисклеймеры оферты убраны (оставлен один внизу).
- [x] Убрана «деревянная подсистема» (faq, install), «СФБ» → «Стеклофибробетон (GFRC)».
- [x] Рефакторинг ключа деплоя докатан (env + `.deploy-key`, старый ключ ротирован), git синхронизирован с продом.

### ⚙️ Мелкие тех-долги (обнаружены 2026-06-30)
- [ ] **11. Битые PNG** — `images/blocks/color/palette.png` и `images/pages/catalog/color_palette.png` не валидны, `convert_images.php` их пропускает с warning. → готово когда: файлы пересохранены/удалены, конвертация без warning.
- [ ] **12. `deploy.bat` exit 1** — падает на финальном `call scripts\generate_html.bat` (файл в .gitignore, локальный). Деплой при этом проходит (HTTP 200). → готово когда: вызов убран/защищён, `deploy.bat` возвращает 0.

---

## ✅ ВЫПОЛНЕНО (2026-05-10) — Welcome popup: кросс-промо BLP + MDBoard / FCB Decor

Уведомление новых пользователей о двух смежных проектах:
- **Светильники BLP** → `https://blite-light.ru/`
- **Фиброцементные панели для внутренней отделки 6 мм** (MDBoard и BLP FCB Decor) → `https://blp.building-port.ru/`

**Реализация:**
- ✅ Новый блок `blocks/welcome-popup.php` — модальное окно с overlay, две CTA-кнопки, дизайн в стиле сайта (брендовый зелёный, Montserrat, плавная анимация)
- ✅ Подключён в `blocks/template.php` после `footer.php` → автоматически на всех страницах, но JS показывает **только на главной** (`/` или `/index.php`)
- ✅ **Логика:** 1 раз в **2 часа** на браузер (`localStorage['blp_welcome_popup_last_shown']` = timestamp). Вышел и вернулся через 2+ часа → попап снова
- ✅ Закрытие: ✕, Esc, клик на overlay
- ✅ Параметр `?welcome=1` для принудительного превью (отладка)

**Сопутствующий фикс — `router.php`:**
- ✅ Добавлен `chdir(dirname($script))` перед `require` — чтобы относительные `include '../blocks/X.php'` из `pages_php/index.php` работали под PHP built-in сервером (Apache mod_php делает это автоматически, dev-роутер до этого — нет). Без фикса главная локально показывалась без секций objects/partners/contact-form.

**Параметры в одном месте** (правка → файл `blocks/welcome-popup.php`, верх `<script>`):
```js
var COOLDOWN_MS = 2 * 60 * 60 * 1000;  // изменить интервал между показами
var DELAY_MS = 1500;                    // изменить задержку появления
```

---

## ✅ ВЫПОЛНЕНО (2026-05-08) — SEO: 301/410 для устранения 4xx в Яндекс.Вебмастере

Реакция на уведомление Вебмастера «страницы начали отвечать 4xx». Робот ходил по легаси WP-URL и `/blp/*` (с VPS-эпохи).

- ✅ **301 `/blp/*` → `/*`** — страховка после переезда с VPS на shared hosting
- ✅ **301 старых WP-карточек товаров → `/catalog`** (4 URL: polished-shokoladnyj, texture, polished, walypan)
- ✅ **301 `/wp-content/uploads/*.pdf` → `/sertificate`** + общая страховка `/wp-content/*`, `/wp-includes/*`, `/wp-admin/*` → `/`
- ✅ **410 Gone для `/shop/*`** — WooCommerce-наследие, окончательно удалено
- ✅ **Все правила добавлены ДО блока блога** — не конфликтуют со slug блог-постов
- ✅ **Verified на проде** — все 4 типа редиректов отдают корректный код (curl `-I`)

**Файл:** `.htaccess` строки 14-33. Подробности в `CHANGELOG.md` (2026-05-08).

**TODO для пользователя:** в Вебмастере отправить на переобход 4 страницы со статусом «URL неизвестен роботу» (200 OK): `/kreplenie`, `/projects`, `/sertificate`, `/compare-materials`. Через 7-14 дней проверить статистику 4xx повторно.

---

## ✅ ВЫПОЛНЕНО (2026-05-06) — Каталог: цены + UI

- ✅ **Цены в каталоге** — 4 серии (NATURE/POLISHED/TEXTURE/WALYPAN), цены зависят от толщины, кликабельный выбор
- ✅ **JS selectThickness()** — автовыбор первой толщины при загрузке, обновление цены по клику через `data-prices` JSON
- ✅ **Активная толщина** — зелёная подсветка `var(--color-brand)` вместо оранжевой
- ✅ **Блоки каталога +100px** — `.product-card` и `.blp-image-section` высота 700px (было 600px)
- ✅ **WALYPAN мобайл** — `height: 398px` в `@media (max-width: 768px)`
- ✅ **Цена как pill** — `.product-price__value` с фоном и рамкой, унифицирован текст «{цена} руб./м²» в одну строку
- ✅ **Дубль навигации удалён** — `.blp-product-block .blp-dots { display: none }`
- ✅ **Форма: чекбоксы** — `grid-column: 1/-1` (4 колонки), `align-items: flex-start`, шрифт 13px
- ✅ **Цены в админке** — `/admin` → Каталог: поля для каждой толщины каждой серии
- ✅ **deploy.bat** — `chcp 65001`, убраны Кириллица и `msg *` (работает из PowerShell/CMD без ошибок)

## ✅ ВЫПОЛНЕНО (2026-05-06) — SEO Фазы 1-5

5 коммитов, ветка merged в main, задеплоено. История: `git log` или `../05-SEO-И-ОНЛАЙН/PLAN-IMPLEMENTATION.md`.

- ✅ **Фаза 1** — robots.txt (+14 Disallow: admin, api, error-pages, schema-эндпоинты), sitemap.xml (-3 × 404, +1)
- ✅ **Фаза 2** — schema.org: dealer.php trailing comma (JSON-LD теперь валиден), schema_webpage.php @id/url fallback на $_SERVER, AggregateOffer для 4 продуктов, WALYPAN.image
- ✅ **Фаза 3** — Title/Meta на 8 страницах: /catalog 76→51, /compare 84→51, /sertificate 77→56, /architect desc 117→150, и др. Все в лимитах Google.
- ✅ **Фаза 4** — alt-теги: проверено, всё уже корректно (предыдущая работа)
- ✅ **Фаза 5** — производительность: objects-section.php → render_image() даёт **-1.6 МБ** на главной, footer logo width/height (CLS=0), preconnect к Yandex.Metrika и flaticon CDN
- ✅ **Замеры live (2026-05-06):** размер главной 2862 KB → **655 KB (-77%)**, LCP 6.7s → 4.5s (-32%), CLS 0.02 → 0
- ✅ **GSC + Яндекс.Вебмастер** — оба домен подтверждён
- ✅ **Drift baseline зафиксирован** — `../05-SEO-И-ОНЛАЙН/audit/seo-drift-baseline.json` для детекции будущих регрессий

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
- ✅ **CHANGELOG.md** — история изменений в корне проекта.
- ✅ **deploy.php защита** — пропускает database/, images/, deploy.php, .git/
- ✅ **FTP доступ** — настроен для one-off загрузок (порт 21)

---

## ✅ ВЫПОЛНЕНО (2026-06-30) — цены каталога, дисклеймеры, рефакторинг ключа деплоя

**Каталог — цены и дисклеймеры:**
- ✅ **Цены приведены к прайсу с НДС** (`database/catalog.json` на сервере, через FTP). Источник правды для редактирования — `/admin → Каталог` или серверный `catalog.json` (в git его нет, `database/*.json` в .gitignore).
  - NATURE = TEXTURE: 8→8180, 9→9360, 10→11150, 12→13550, 15→15800
  - POLISHED: 8→9050, 9→10100, 10→11900, 12→14780, 15→16760
  - WALYPAN: 10→12200, 12→15740, 15→17190
- ✅ **Дисклеймер оферты — оставлен только внизу страницы** (`.price-disclaimer` в `catalog.php`). Убраны: верхняя плашка `catalog-price-disclaimer` над ценами и CSS-микропометка «Не оферта · ст. 437 ГК РФ» у каждой цены (`.product-price ... ::after` в `catalog.css`). По закону достаточно одного внизу.

**Контент — соответствие правилам владельца:**
- ✅ **Убрана «деревянная подсистема»** (`faq.php`, `database/add_install_articles.php`) — монтаж только на металл/алюминий.
- ✅ **«СФБ» → «Стеклофибробетон (GFRC)»** (`compare-materials.php`) — бренд/аббревиатура СФБ на сайте не используется.

**Безопасность деплоя — рефакторинг 2026-06-11 завершён и докатан:**
- ✅ Ключ выведен из плейнтекста: `deploy.bat` → env `BLP_DEPLOY_KEY`, `deploy.php` → `.deploy-key` (вне docroot) + `hash_equals` + zip-slip защита. Старый ключ ротирован. Детали — в разделе «🔑 Ключ деплоя».
- ✅ `.gitignore`: добавлены `database/*.bak*` и `.deploy-key`.

**Git синхронизирован с продом** — все изменения закоммичены и задеплоены штатно через `deploy.bat`. Незакоммиченных правок в рабочем дереве не осталось.

---

**Last updated:** 2026-06-30 (цены каталога с НДС, дисклеймеры, рефакторинг ключа деплоя завершён, git синхронизирован)
