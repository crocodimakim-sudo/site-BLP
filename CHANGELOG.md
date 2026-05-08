# Changelog — BLP Board

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
