# Промпт для продолжения правок сайта BLP Board

## Контекст проекта
- **Путь к исходникам:** `D:\Claude Code\site-blp\site-kimi\`
- **XAMPP (для теста):** `C:\xampp\htdocs\blp\`
- **Локальный URL:** `http://localhost/blp/`
- **Стек:** PHP 8+ (XAMPP), HTML/CSS/JS, никакого фреймворка
- **Синхронизация:** После КАЖДОГО изменения файла копировать в XAMPP: `Copy-Item -Force`
- **Референс:** https://blpboard.tilda.ws/
- **Шрифт:** Montserrat (400,500,600,700,800)
- **Контейнер:** max-width: 1200px
- **Критически важно:** `css/hero-section.css` подключается в `template.php` ГЛОБАЛЬНО для ВСЕХ страниц. Его стили перебивают page-specific CSS из-за высокой специфичности (`.hero-main .hero-content`).
- **Критически важно:** `.blp-container`, `.container`, `.section-container` в `main.css` имеют `padding-left/right: 24px` на десктопе. Это создаёт "невидимые" отступы внутри многих блоков.

---

## Процесс работы
1. Берём ОДНУ страницу из чек-листа ниже.
2. Исправляем ВСЕ пункты по этой странице.
3. Копируем файлы в XAMPP (`Copy-Item -Force`).
4. Пользователь проверяет в браузере (`Ctrl+F5`), говорит "окей".
5. Переходим к следующей странице.
6. НИКОГДА не правим несколько страниц одновременно без подтверждения.



---



## Страница 6: Дилерам (dealer)
**Файлы:** `pages_php/dealer.php`, `css/pages/dealer.css`

### Чек-лист правок:
- [x] **Hero — зелёная пластина (как Tilda).** Сейчас `.blp-hero-section { background: #fff; }`. Нужен зелёный фон (как на Tilda: `#00352F` или градиент) + белый текст. Сейчас текст чёрный, фон белый.
- [x] **Убрать гигантские SVG / редирект diler→dealer.** В текущем `dealer.php` нет SVG в hero (там `<img>`). Если пользователь видит SVG — возможно, старая версия `diler.php`/`diler.css` в кеше или где-то ещё. Убедиться, что `/diler` редиректит на `/dealer`.
- [x] **Padding секций:** в `dealer.css` `.dealer-why-section, .dealer-tiers-section, .dealer-support-section, .dealer-steps-section { padding: 20px 0; }` — ✅ уже 20px. Но проверить, чтобы на странице не было 80px.
- [x] **Отступы сверху/снизу между секциями.** Проверить margin между блоками. Сейчас `.blp-partner-card-wrap { margin-bottom: 40px; }` и другие margin. Возможно, нужно уменьшить.
- [x] **Подложка — сероватая вместо белой.** Сейчас `.dealer-support-section { background: #fff; }`, `.dealer-tier-card { background: #fff; }`, `.dealer-why-card { background: #fff; }`. Нужно использовать `#f8f9fa` или `var(--color-bg-soft)` как на других страницах.
- [x] **Заголовки секций — padding-left 32px.** Сейчас `.dealer-section-title { padding-left: 0; }` — добавить `32px`.
- [x] **Описания секций — margin-bottom 24px.** Сейчас `.dealer-section-desc { margin: 0 0 3rem; }` — сделать `0 0 24px`.

---

## Страница 7: Сертификаты (sertificate)
**Файлы:** `pages_php/sertificate.php`, `css/pages/sertificate.css`

### Чек-лист правок:
- [x] **Container — фон не белый, а серый как у сайта.** Сейчас `.cert-container { background: #fff; }`. Сделать `background: var(--color-bg-soft, #f8f9fa);` или убрать background вообще (чтобы был фон секции).
- [x] **Тень на контейнере.** Сейчас `box-shadow: 0 4px 16px rgba(0,0,0,0.08)` — проверить, видна ли. Если нет — увеличить.
- [x] **Заголовки — padding-left 32px.** `.cert-title`, `.cert-section-title`, `.cert-header-accent` добавить `padding-left: 32px`.
- [x] **Padding-bottom секции.** Сейчас `.certificates-section { padding: 40px 0 50px; }` — пользователь просил `padding-bottom: 0` (или меньше).

---

## Страница 8: Крепление (kreplenie)
**Файлы:** `pages_php/kreplenie.php`, `css/pages/kreplenie.css`

### Чек-лист правок:
- [x] **Заголовки "Видимый" / "Скрытый" — стиль H2.** Сейчас `.blp-method-header { font-size: 28px; font-weight: 700; }` — это уже похоже на H2. Проверить, соответствует ли типографике сайта (H2 = 37px / 600 в `main.css`). Возможно, увеличить до `var(--fs-3xl)` и `font-weight: 600`.

---

## Страница 9: Объекты (projects)
**Файлы:** `pages_php/projects.php`, `css/pages/projects.css`, `js/pages/projects.js`

### Чек-лист правок:
- [x] **Убрать дубли фото.** Проверить `projects.js` — возможно, массив объектов содержит повторяющиеся изображения. Также проверить директорию `images-convert/pages/projects/`.

---

## Страница 10: Контакты (contacts)
**Файлы:** `pages_php/contacts.php`, `css/pages/contacts.css`

### Чек-лист правок:
- [x] **Телефон/e-mail — label над value (вертикально).** Сейчас `.contacts-card { text-align: center; }` и `.contacts-label` + `.contacts-value` inline. Сделать flex- или block-раскладку, чтобы label был сверху, value снизу (как адрес).

---

## Ключевые технические замечания для новой сессии
1. `css/hero-section.css` глобален и имеет высокую специфичность (`.hero-main .hero-content`). Любые правки hero на главной нужно делать с селектором `.hero-main .hero-content`, иначе они не применятся.
2. `.blp-container` в `main.css` даёт `padding: 0 24px`. Этот padding "съедает" ширину во многих блоках. Чтобы растянуть блок на 1200px, нужно либо убрать `.blp-container`, либо переопределить padding на 0.
3. `index.css` содержит много дублирующих/конфликтующих стилей для audience-grid, benefits и т.д., которые перебивают глобальные компонентные CSS. Лучше удалить эти дубли из `index.css`.
4. После каждой правки обязательно `Copy-Item -Force` в `C:\xampp\htdocs\blp\`.
5. Проверять в браузере только после `Ctrl+F5` (жёсткий рефреш).
