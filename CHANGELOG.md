# Changelog — BLP Board

## 2026-05-08 — Welcome popup: кросс-промо BLP светильники + MDBoard / BLP FCB Decor

**Цель:** Уведомить новых пользователей основного сайта о двух смежных проектах: переехавших светильниках BLP (`blite-light.ru`) и новом продукте — фиброцементных панелях для внутренней отделки 6 мм (`blp.building-port.ru`).

**Реализация:**
- Новый блок `blocks/welcome-popup.php` — модальное окно с overlay по центру экрана, две CTA-кнопки
- Подключён в `blocks/template.php` (после `footer.php`) → автоматически на всех страницах
- Задержка появления: 1.5 сек после загрузки страницы
- **Умная логика повторов** (обновлено 2026-05-10):
  - Кликнул на любую CTA → миссия выполнена, больше не показываем (`clicked: 'blite' | 'fcb'`)
  - Закрыл крестиком/Esc/overlay → повтор через **48 часов** (`COOLDOWN_MS`)
  - Максимум **3 dismiss** на пользователя (`MAX_DISMISS`) — после третьего отказа больше не дёргаем
  - Состояние в `localStorage['blp_welcome_popup_state_v3']` как JSON: `{ clicked, clickedAt, dismissCount, lastDismissAt }`
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
