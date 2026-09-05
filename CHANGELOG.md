# Changelog — BLP Board

## 2026-09-05 — SEO-аудит: техправки без изменения дизайна (группы 1–3)

**Индексация:** robots.txt перестроен (блок Disallow раньше стоял после группы Bytespider и не действовал ни для кого; добавлены группы OAI-SearchBot, ChatGPT-User, Claude-SearchBot, Claude-User, YandexAdditional, Applebot, Amazonbot, DuckAssistBot; /devops открыт). sitemap.xml — 10 живых URL с lastmod из git, блог убран до открытия. sitemap-images.xml — битые картинки каталога → series-*.webp, дубль / объединён. Ключ IndexNow в корне + scripts/indexnow-key.txt, пинг api.indexnow.org и yandex.com/indexnow (202).
**.htaccess:** www → building-port.ru 301. Инцидент: включённый `RewriteCond %{HTTPS} off` дал петлю редиректов (TLS снимает прокси хостинга) — сайт лежал ~12 минут, починено загрузкой .htaccess по FTP. Правило: на reg.ru условия по HTTPS не использовать.
**Разметка:** Product.image и ItemList.image → series-*.webp (старые пути 404); цены ItemList/AggregateOffer из catalog.json (blp_price_min / blp_offer_prices в blocks/catalog_config.php) — раньше захардкожены старые 7200/7950; og:image каталога → series-nature.png; og-default → /images-convert/; og:image:width/height по реальному файлу; inline LocalBusiness на /dealer удалён (дубль /contacts); BlogPosting больше не печатается поверх 404 (exit после error.php).
**Страницы:** /kreplenie h2 → h1 (класс тот же); /policy canonical без слэша; fallback canonical в template; lang="ru-RU"; версия CSS по filemtime; /projects — серверный вывод карточек (SSR-фолбэк, projects.js очищает сетку перед перерисовкой); eager для первого экрана /sertificate, /kreplenie; /compare-materials — min-height 70vh на десктопе против CLS 0.87.
**llms.txt:** цены с НДС «от», ТС № 7515-26, blp. вместо мёртвого fcb., дата 2026-09-05; .well-known/llms.txt = копия корневого (был домен blpboard.ru).
**Лендинг:** robots.txt Sitemap → blp.building-port.ru.
Отчёт аудита: `05-SEO-И-ОНЛАЙН/audit/building-port.ru-audit-2026-09-05/`.

## 2026-06-30 — Цены каталога (с НДС), дисклеймеры, рефакторинг ключа деплоя

**Каталог:**
- Цены 4 серий приведены к прайсу с НДС (`database/catalog.json` на сервере, через FTP). NATURE=TEXTURE 8180–15800, POLISHED 9050–16760, WALYPAN 12200/15740/17190.
- Убраны лишние дисклеймеры оферты: верхняя плашка над ценами (`catalog.php`) и CSS-микропометка «Не оферта · ст. 437 ГК РФ» у каждой цены (`catalog.css`). Оставлен один общий дисклеймер внизу страницы.

**Контент (правила владельца):**
- `faq.php`, `database/add_install_articles.php` — убрана «деревянная подсистема» (монтаж только на металл/алюминий).
- `compare-materials.php` — «СФБ» → «Стеклофибробетон (GFRC)».

**Безопасность деплоя (докат рефакторинга 2026-06-11):**
- `deploy.bat`: ключ из env `BLP_DEPLOY_KEY` вместо плейнтекста.
- `deploy.php`: ключ из env → fallback `.deploy-key` (вне docroot, HTTP 404), `hash_equals`, zip-slip защита.
- Старый ключ `blp-deploy-2026-key` ротирован. Новый ключ — только в env (User-scope) и серверном `.deploy-key`, в git его нет.
- `.htaccess`: блокировка `.bak`, `.key`, `.deploy-key`, `README-для-админа`.
- `.gitignore`: `database/*.bak*`, `.deploy-key`.

## 2026-05-08 — Welcome popup: кросс-промо BLP светильники + MDBoard / BLP FCB Decor

**Цель:** Уведомить новых пользователей основного сайта о двух смежных проектах: переехавших светильниках BLP (`blite-light.ru`) и новом продукте — фиброцементных панелях для внутренней отделки 6 мм (`blp.building-port.ru`).

**Реализация:**
- Новый блок `blocks/welcome-popup.php` — модальное окно с overlay по центру экрана, две CTA-кнопки
- Подключён в `blocks/template.php` (после `footer.php`) → автоматически на всех страницах
- Задержка появления: 1.5 сек после загрузки страницы
- **Логика повторов** (упрощено 2026-05-10):
  - Показывается **только на главной** (`/` и `/index.php`) — не на внутренних страницах
  - **1 раз в 2 часа** на браузер (`COOLDOWN_MS = 2h`)
  - Без различия dismiss/click — просто факт показа фиксируется в `localStorage['blp_welcome_popup_last_shown'] = timestamp`
  - Если юзер вышел и вернулся через 2+ часа — попап показывается снова
- Закрытие: крестик ✕, клик на overlay, Esc
- Параметр `?welcome=1` для принудительного показа (отладка/превью)
- Дизайн в стиле сайта: `--color-brand`, Montserrat, `--radius-lg`, плавная анимация slideUp+fade

**Кнопки:**
- Outlined: **Светильники BLP** → `https://blite-light.ru/`
- Filled: **MDBoard и BLP FCB Decor** → `https://blp.building-port.ru/`

**Сопутствующий фикс — `router.php`:**
- Добавлен `chdir(dirname($script))` перед `require` — чтобы относительные `include '../blocks/X.php'` из `pages_php/index.php` работали под PHP built-in сервером (Apache mod_php делает это автоматически, dev-роутер до этого — нет). Без фикса главная локально показывалась без секций objects/partners/contact-form.

**Изменённые файлы:** `blocks/welcome-popup.php` (новый), `blocks/template.php`, `router.php`.

---

## 2026-05-08 — SEO: 301/410 редиректы для устранения 4xx в Яндекс.Вебмастере

**Причина:** Уведомление Вебмастера «страницы начали отвечать 4xx». Робот ходит по легаси WordPress-URL (старая версия сайта на WP) и URL с префиксом `/blp/` (с VPS-времён). Получает 404 → угроза выпадения из индекса.

**Реализовано в `.htaccess`:**
- **301 `/blp/*` → `/*`** — страховка с VPS-эпохи (карты-сайт Яндекса помнит старые ссылки)
- **301 старых WP-карточек товаров → `/catalog`:**
  - `/fibroczementnaya-panel-blp-polished-shokoladnyj/`
  - `/fakturnye-paneli-serii-blp-texture/`
  - `/polirovannye-paneli-serii-blp-polished/`
  - `/linearnye-paneli-serii-blp-walypan/`
- **301 `/wp-content/uploads/*.pdf` → `/sertificate`** — старые PDF-сертификаты с WP
- **301 `/wp-content/*`, `/wp-includes/*`, `/wp-admin/*` → `/`** — общая страховка для WP-наследия
- **410 Gone для `/shop/*`** — WooCommerce-листинги и RSS, окончательно удалены (быстрее уйдёт из индекса, чем 404)

**Проверка прода (curl):**
- `/blp/catalog` → 301 → `/catalog` ✅
- `/shop/feed/` → 410 ✅
- `/wp-content/uploads/test.pdf` → 301 → `/sertificate` ✅
- `/fakturnye-paneli-serii-blp-texture/` → 301 → `/catalog` ✅

**Изменённые файлы:** `.htaccess` (правила добавлены до блока блога/основных rewrite, чтобы не конфликтовать с slug блог-постов).

**Дальнейшие шаги:**
- Через 7-14 дней повторно проверить «Статистика обхода» в Вебмастере
- Для страниц с пометкой «URL неизвестен роботу, 200 OK» (`/kreplenie`, `/projects`, `/sertificate`, `/compare-materials`) — отправить в Вебмастер → Переобход страниц вручную

---

## 2026-05-01 — Защита от спама + отключение GA4 + обновление политик

### 🔒 Защита формы обратной связи от спама
**Причина:** На сайт стали поступать спам-заявки от XRumer-ботов и SEO-спамеров (заявки №3–7 в leads.db).

**Реализовано:**
- **Серверная CAPTCHA** — математическая задача «Сколько будет X + Y?» в форме и в `send-form.php`
- **Rate limit по email** — не более 1 заявки в сутки с одного email
- **Rate limit по IP** — не более 5 заявок в час (уже было, оставлено)
- **Проверка скорости заполнения** — минимум 3 секунды между загрузкой страницы и отправкой (боты шлют мгновенно)
- **Referer-проверка** — принимаем заявки только со страниц `building-port.ru`
- **Honeypot** — поле `website` (уже было, оставлено)
- **Убрано скрытое поле `message`** — боты отправляли POST напрямую на `/blocks/send-form.php` с заполненным `message`, хотя в UI его нет

**Изменённые файлы:**
- `blocks/contact-form.php` — генерация CAPTCHA, поле ввода, `form_time`
- `blocks/send-form.php` — валидация CAPTCHA, speed check, referer, email rate limit, убрано `message`
- `js/contact-form.js` — валидация и отправка капчи
- `css/contact-form.css` — `.form-group--full`

---

### 🚫 Отключение Google Analytics 4 (GA4)
**Причина:** Трансграничная передача данных в Google LLC (США) требует уведомления Роскомнадзора по ст. 12 152-ФЗ. Уведомление не подано. GA4 отключён до получения подтверждения от РКН.

**Реализовано:**
- Очищен `ga4_id` в `database/site_config.json` на сервере через FTP
- Удалён блок GA4 из `blocks/template.php`
- Обновлены все юридические политики:
  - `pages_php/policy.php` — убран раздел о трансграничной передаче в Google, добавлена Яндекс.Метрика
  - `pages_php/cookies.php` — убран Google Analytics, исправлено описание cookie-баннера
  - `pages_php/consent.php` — убрано согласие на передачу в Google LLC

**Изменённые файлы:**
- `blocks/template.php` — удалён блок GA4
- `pages_php/policy.php`
- `pages_php/cookies.php`
- `pages_php/consent.php`

---

### 🍪 Cookie security
- Добавлен `session.cookie_secure = 1` в `blocks/template.php` (сайт на HTTPS)

---

### 📎 Связанные изменения ранее (2026-04-30)
- **Фикс вечного спиннера вкладки** — GA4 загружался динамически через `fetch`+`AbortController` (2.5с таймаут), чтобы избежать блокировки `googletagmanager.com` в РФ. Код удалён при полном отключении GA4.
- **Yandex verification** — добавлен meta-tag `yandex-verification` в `template.php`

---

### 📊 Статус счётчиков аналитики (2026-05-01)
| Сервис | Статус | ID |
|--------|--------|-----|
| Яндекс.Метрика | ✅ Активна | 108998553 |
| Google Analytics 4 | ❌ Отключена | — |
| VK Pixel | ❌ Не настроена | — |

---

**Последний деплой:** 2026-05-01 14:09 MSK
