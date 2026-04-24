# Site-Kimi — BLP Board (XAMPP локально)

**Язык:** Русский | **XAMPP:** `http://localhost/blp/`  
**Бэкап:** `D:/Claude Code/site-blp/site-kimi-backup/`

---

## 🔴 ПРАВИЛО №1 — SYNC ПОСЛЕ КАЖДОГО ИЗМЕНЕНИЯ

```bash
cp -f "D:/Claude Code/site-blp/site-kimi/[файл]" "C:/xampp/htdocs/blp/[файл]"
```
Никогда не говорить "проверяй" без синхронизации.

---

## 🔴 ПРАВИЛО №2 — ИЗОБРАЖЕНИЯ

- Оригиналы: `images/` (только загрузка, не трогать скриптами)
- Оптимизированные: `images-convert/` (всегда использовать в PHP)
- Пути в PHP → всегда `/blp/images-convert/...`

Обновление: `php scripts/convert_images.php` + `robocopy images-convert C:/xampp/htdocs/blp/images-convert /E /PURGE`

---

## ⚠️ ВАЖНЫЕ ТЕХНИЧЕСКИЕ НЮАНСЫ

### Мобильный скролл к якорям
`html { scroll-behavior: smooth }` в main.css + `[id] { scroll-margin-top: 90px }` в catalog.css → JS-скролл (`window.scrollTo`, `scrollTop`) **не работает** — браузерная анимация затирает его.

**Решение:** только CSS `scroll-margin-top` в inline `<style>` на каждой странице:
```css
@media (max-width: 768px) {
    #nature, #polished, #texture, #walypan { scroll-margin-top: 65px !important; }
}
```

### WALYPAN слайдер — цепочка flex
`.blp-image-section { height: 600px; display: flex; flex-direction: column }`
→ `#slider-container { flex: 1; min-height: 0; display: flex; flex-direction: column }`
→ `.blp-main-image { flex: 1; min-height: 0 }` (без `height: auto` — ломает `img { height: 100% }`)

### html { overflow-x: hidden } в main.css
Создаёт BFC. Не использовать `window.scrollTo()` для позиционирования — не работает на мобиле.

---

## ⏳ P0 БАГИ

1. Форма `/contacts`: `contactsPageForm` ≠ `contactForm` в JS → лиды теряются
2. CSRF+JSON конфликт → все AJAX формы падают с 403
3. GA4 `G-PLACEHOLDER20260420` → заменить на реальный ID
4. Изображения проектов до 13 МБ → нужен srcset + compress

---

## 📁 СТРУКТУРА ПРОЕКТА

```
blocks/
  template.php          — общий шаблон (header → breadcrumbs → main → footer)
  header.php            — шапка сайта
  footer.php            — подвал сайта
  breadcrumbs.php       — крошки (рендерит если >1 элемента в $breadcrumbs)
  contact-form.php      — форма обратной связи (переиспользуется)
  send-form.php         — обработчик формы (AJAX + fallback)
  benefits.php          — преимущества (index, architect, devops, projects)
  benefits-section.php  — вариант для catalog (p вместо h4)
  specs-section.php     — технические характеристики (id="characteristics")
  objects-section.php   — объекты/проекты
  partners-section.php  — партнёры
  partners-slider.php   — слайдер партнёров
  products-section.php  — блок продуктов
  audience-section.php  — блок аудитории
  cookie-consent-banner.php
  get_projects.php      — API получения проектов
  image-helper.php      — WebP + lazy load хелпер

css/
  main.css              — reset, типографика, глобальные правила
  hero-section.css      — загружается глобально
  header.css, footer.css, contact-form.css
  benefits.css, specs-section.css, objects-section.css
  partners-section.css, products-section.css, audience-section.css, animations.css
  pages/                — постраничные стили (подключаются через $extra_css)

js/
  header.js             — бургер, sticky header
  contact-form.js       — AJAX отправка формы
  analytics.js          — GA4
  pages/                — постраничные скрипты (подключаются через $extra_js)

pages_php/
  template.php          — layout-обёртка (включает blocks/template.php)
  index.php, catalog.php, contacts.php, kreplenie.php
  architect.php, devops.php, dealer.php, projects.php
  sertificate.php, policy.php, cookies.php, consent.php, 404.php
  schema_*.php          — JSON-LD схемы (breadcrumbs, localbusiness, org, products, webpage)
  — Будущие страницы: compare.php, faq.php, install.php, showcase.php

images/                 — оригиналы (не трогать)
images-convert/         — оптимизированные WebP + fallback JPG/PNG
scripts/
  convert_images.php    — конвертация в WebP
  generate_webp.php     — генерация WebP
  generate_og_default.php
  auto_sync.php, run_sync.bat
robots.txt, sitemap.xml, .htaccess
.well-known/llms.txt
```

---

## ⚙️ СТРАНИЦЫ

| URL | PHP файл | CSS | JS |
|-----|----------|-----|----|
| `/` | index.php | css/pages/index.css | js/pages/index.js |
| `/catalog` | catalog.php | css/pages/catalog.css | js/pages/catalog.js |
| `/kreplenie` | kreplenie.php | css/pages/kreplenie.css | js/pages/kreplenie.js |
| `/devops` | devops.php | css/pages/devops.css | — |
| `/architect` | architect.php | css/pages/architect.css | js/pages/architect.js |
| `/projects` | projects.php | css/pages/projects.css | js/pages/projects.js |
| `/dealer` | dealer.php | css/pages/dealer.css | — |
| `/sertificate` | sertificate.php | css/pages/sertificate.css | js/pages/sertificate.js |
| `/contacts` | contacts.php | css/pages/contacts.css | js/pages/contacts.js |
| `/policy` | policy.php | css/pages/policy.css | — |
| `/cookies` | cookies.php | css/pages/policy.css | — |
| `/consent` | consent.php | css/pages/policy.css | — |
| `/404` | 404.php | — | — |

---

## 📋 БЭКЛОГ

### 🔧 Инфраструктура
- [ ] База данных — MySQL/SQLite для хранения заявок из форм
- [ ] Почтовые отбивки — "Спасибо, ваше обращение принято"

### 🖥️ Админ-панель
- [ ] Редактирование контента (для контент-менеджера)
- [ ] Управление проектами/объектами и заявками

### 📄 Новые страницы
- [ ] Блог (структура не определена)
- [ ] 404 с брендированным дизайном

### 📦 Контент
- [ ] Объекты — загрузить больше проектов с фото (сейчас до 13 МБ, нужен compress)

### 🧹 Очистка от Tilda
- [ ] Найти и удалить классы `t-*`, `tl-*`, ссылки на tildacdn.com
