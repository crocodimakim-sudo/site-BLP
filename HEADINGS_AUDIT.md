# Аудит заголовков H1–H4 на сайте BLP Board

**Дата:** 2026-04-20  
**Проверены файлы:** `pages_php/*.php`, `blocks/*.php`, `css/*.css`, `css/pages/*.css`

---

## Краткая сводка

| Проблема | Количество |
|----------|------------|
| OK — чистый тег, CSS по тегу | 8 |
| Дубль — тег + класс с жёстким px (дублирует или почти дублирует размер тега) | 22 |
| Проблема — тег + класс сильно занижает размер | 5 |
| Div/P/span вместо тега заголовка | **0** ✅ |

**Вывод:** Во всех проверенных PHP-файлах семантические теги `h1`–`h4` используются корректно — нет случаев, когда `div`, `p` или `span` заменяют заголовок. Основная проблема — **дублирование стилей**: классы жёстко прописывают `font-size` в px/rem, дублируя (или почти дублируя) размеры из `main.css` для тегов. Это создаёт технический долг: при изменении шкалы типографики в `:root` заголовки с «жёсткими» классами не подстроятся.

---

## Детальная таблица

| Файл | Что написано в HTML | Что в CSS | Проблема |
|------|---------------------|-----------|----------|
| **index.php** | `<h1 style="margin-bottom: 20px;">Фиброцементные плиты…</h1>` | `main.css` `h1 { font-size: var(--fs-4xl) }` → 42px (desktop) | ⚠️ OK по тегу, но есть `style="margin-bottom: 20px"` (лучше вынести в CSS) |
| **index.php** | `<h2 class="index-mb-title">Почему фиброцементные панели…</h2>` | `index.css` `.index-mb-title { font-size: 1.75rem }` → 28px | 🔶 Дубль + занижение — h2 на desktop должен быть 37px, класс ставит 28px |
| **index.php** | `<h3 class="index-mb-compare-title">Фиброцемент vs альтернативы</h3>` | `index.css` `.index-mb-compare-title { font-size: 1.2rem }` → ~19px | 🔶 Дубль — h3 в `main.css` = 20px, класс дублирует почти тот же размер |
| **blocks/products-section.php** | `<h2>BLPboard</h2>` | `main.css` `h2 { … }` + `.products-section h2 { color: … }` | ✅ OK — тег + CSS по тегу |
| **blocks/products-section.php** | `<h3 class="product-title">NATURE</h3>` | `products-section.css` `.product-title { color… margin… }` (без `font-size`) | ✅ OK — наследует `h3` из `main.css` = 20px |
| **blocks/products-section.php** | `<h4 class="product-text">Натуральные плиты</h4>` | `products-section.css` `.product-text { flex: 1 }` (без `font-size`) | ✅ OK — наследует `h4` из `main.css` = 16px |
| **blocks/audience-section.php** | `<h2 id="audience-heading">Кому подойдут наши решения</h2>` | `main.css` `.audience-section h2 { … }` | ✅ OK — тег + CSS по тегу |
| **blocks/audience-section.php** | `<h3 class="audience-title">Архитекторам и проектировщикам</h3>` | `audience-section.css` `.audience-title { font-size: 20px }` | 🔶 Дубль — `main.css` `h3 { font-size: var(--fs-lg) }` = 20px, класс дублирует |
| **blocks/audience-section.php** | `<h4 class="audience-text">Документация, узлы…</h4>` | `audience-section.css` `.audience-text { flex: 1 }` (без `font-size`) | ✅ OK — наследует `h4` из `main.css` |
| **blocks/benefits.php** | `<h2>Преимущества</h2>` | `main.css` `.benefits-section > h2 { … }` | ✅ OK — тег + CSS по тегу |
| **blocks/benefits.php** | `<h3 class="benefit-title">Окрашенные в массе</h3>` | `benefits.css` `.benefit-title { font-size: 20px }` | 🔶 Дубль — `main.css` `h3` = 20px, класс дублирует |
| **blocks/benefits.php** | `<h4 class="benefit-text">Не требует подкрашивания…</h4>` | `benefits.css` `.benefit-text { color: … }` (без `font-size`) | ✅ OK — наследует `h4` из `main.css` |
| **blocks/objects-section.php** | `<h2 class="section-title">Объекты с фасадом…</h2>` | `objects-section.css` `.section-title { font-size: 37px }` | 🔶 Дубль — `main.css` `h2` на desktop = 37px, класс дублирует жёстким px |
| **blocks/objects-section.php** | `<h3 class="object-title">Жилые комплексы</h3>` | `objects-section.css` `.object-title { font-size: 24px }` | 🔶 Дубль — перебивает `h3` = 20px на 24px |
| **blocks/partners-section.php** | `<h2 class="partners-title">Партнеры</h2>` | `partners-section.css` `.partners-title { font-size: 40px }` | 🔶 Дубль — перебивает `h2` = 37px на 40px |
| **blocks/contact-form.php** | `<h2 class="contact-form-title">Получить предложение</h2>` | `contact-form.css` `.contact-form-title { font-size: 37px }` | 🔶 Дубль — `main.css` `h2` на desktop = 37px, класс дублирует |
| **catalog.php** | `<h1 class="catalog-main-title">Каталог фиброцементных панелей…</h1>` | `catalog.css` `.catalog-main-title { font-size: 42px }` | 🔶 Дубль — `main.css` `h1` на desktop = 42px, класс дублирует |
| **catalog.php** | `<h2 class="product-title">Фиброцементные панели серии NATURE</h2>` | `catalog.css` `.product-title { font-size: 37px }` | 🔶 Дубль — `main.css` `h2` на desktop = 37px, класс дублирует |
| **catalog.php** | `<h2 class="product-title">Фиброцементные панели серии POLISHED</h2>` | `catalog.css` `.product-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **catalog.php** | `<h2 class="product-title">Фиброцементные панели серии TEXTURE</h2>` | `catalog.css` `.product-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **catalog.php** | `<h2 class="blp-title">Линеарные панели серия WALYPAN</h2>` | `catalog.css` `.blp-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **catalog.php** | `<h2 class="palette-title">Палитра цветов</h2>` | `catalog.css` `.palette-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **catalog.php** | `<h2 class="blp-specs-title">Характеристики</h2>` | `catalog.css` `.blp-specs-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **architect.php** | `<h1 class="blp-section-title">Кому можем помочь</h1>` | `architect.css` `.blp-section-title { font-size: 28px }` | ❌ Проблема — `h1` на desktop должен быть 42px, класс занижает до 28px |
| **architect.php** | `<h2 class="blp-card-title">Архитекторам</h2>` | `architect.css` `.blp-card-title { font-size: 18px }` | 🔶 Дубль — сильно занижает `h2` (для карточки допустимо, но лучше `h3`) |
| **architect.php** | `<h2 class="blp-partner-card__title">Партнерская модель…</h2>` | `architect.css` `.blp-partner-card__title { font-size: 40px }` | 🔶 Дубль — перебивает `h2` = 37px на 40px |
| **devops.php** | `<h1 class="hero-title">Фиброцементные панели BLP Board…</h1>` | `devops.css` `.hero-title { font-size: 42px }` | 🔶 Дубль — дублирует размер `h1` |
| **devops.php** | `<h2 class="section-title">Почему работают с нами</h2>` | `objects-section.css` `.section-title { font-size: 37px }` | 🔶 Дубль — дублирует размер `h2` |
| **devops.php** | `<h3 class="tech-title">Совместимость с подсистемами</h3>` | `devops.css` `.tech-title { font-size: 20px }` | 🔶 Дубль — `main.css` `h3` = 20px, класс дублирует |
| **diler.php** | `<h1 class="blp-hero-title">Дилерская программа BLP Board…</h1>` | `diler.css` `.blp-hero-title { font-size: 42px }` | 🔶 Дубль — дублирует размер `h1` |
| **diler.php** | `<h2 class="blp-benefits-title">Почему дилеры работают с нами</h2>` | `diler.css` `.blp-benefits-title { font-size: 32px }` | 🔶 Дубль — занижает `h2` с 37px до 32px |
| **diler.php** | `<h3>Работа с проектом, а не просто поставка</h3>` | `main.css` `h3 { font-size: 20px }` | ✅ OK — чистый тег |
| **diler.php** | `<h4>Подключаемся к задаче клиента…</h4>` | `main.css` `h4 { font-size: 16px }` | ✅ OK — чистый тег |
| **diler.php** | `<h2 class="blp-interesting-title">Почему это интересно?</h2>` | `diler.css` `.blp-interesting-title { font-size: 36px }` | 🔶 Дубль — перебивает `h2` с 37px на 36px |
| **sertificate.php** | `<h1 class="cert-title">Сертификаты фиброцементных панелей…</h1>` | `sertificate.css` `.cert-title { font-size: clamp(18px, 2.5vw, 28px) }` | ❌ Проблема — `h1` максимум 28px вместо 42px, белый nowrap с `!important` |
| **sertificate.php** | `<h2 class="cert-section-title">Техническое свидетельство…</h2>` | `sertificate.css` `.cert-section-title { font-size: 22px }` | 🔶 Дубль — занижает `h2` до 22px (используется как подзаголовок) |
| **projects.php** | `<h1 class="section-title">Объекты с фасадом…</h1>` | `objects-section.css` `.section-title { font-size: 37px }` | ❌ Проблема — `h1` = 37px вместо 42px; на странице нет более крупного H1 |
| **contacts.php** | `<h1 class="contacts-title">Контакты BLP Board</h1>` | `contacts.css` `.contacts-title { font-size: var(--fs-3xl) }` → 37px | ❌ Проблема — `h1` = 37px вместо 42px |
| **contacts.php** | `<h3 class="contacts-label">Телефон</h3>` | `contacts.css` `.contacts-label { font-size: var(--fs-xs) }` → 12px | ❌ Проблема — `h3` = 12px вместо 20px; семантически это label, лучше `span` |
| **contacts.php** | `<h2 class="contact-form-title">Написать нам</h2>` | `contacts.css` `.contact-form-title { font-size: 18px }` (перебивает `contact-form.css` 37px) | ❌ Проблема — `h2` = 18px вместо 37px; форма зрительно теряет иерархию |
| **policy.php** | `<h1>Политика конфиденциальности</h1>` | `main.css` `h1 { font-size: var(--fs-4xl) }` → 42px | ✅ OK — чистый тег |
| **policy.php** | `<h2>1. Общие положения</h2>` (и др. h2) | `main.css` `h2 { font-size: var(--fs-3xl) }` → 37px | ✅ OK — чистый тег |

---

## Группировка проблем по типу

### 1. «Дубль» — класс дублирует размер тега (22 случая)
Это не ломает вёрстку, но создаёт технический долг. Если в `main.css` изменить шкалу `h1`–`h4`, эти заголовки не подстроятся.

**Файлы CSS с дублями:**
- `contact-form.css` — `.contact-form-title { font-size: 37px }`
- `objects-section.css` — `.section-title { font-size: 37px }`, `.object-title { font-size: 24px }`
- `partners-section.css` — `.partners-title { font-size: 40px }`
- `audience-section.css` — `.audience-title { font-size: 20px }`
- `benefits.css` — `.benefit-title { font-size: 20px }`
- `catalog.css` — `.catalog-main-title { font-size: 42px }`, `.product-title { font-size: 37px }`, `.blp-title { font-size: 37px }`, `.palette-title { font-size: 37px }`, `.blp-specs-title { font-size: 37px }`
- `architect.css` — `.blp-partner-card__title { font-size: 40px }`
- `devops.css` — `.hero-title { font-size: 42px }`, `.tech-title { font-size: 20px }`
- `diler.css` — `.blp-hero-title { font-size: 42px }`, `.blp-benefits-title { font-size: 32px }`, `.blp-interesting-title { font-size: 36px }`
- `index.css` — `.index-mb-title { font-size: 1.75rem }`, `.index-mb-compare-title { font-size: 1.2rem }`

### 2. «Проблема» — класс сильно занижает размер тега (5 случаев)

| Файл | Тег | Класс | Реальный размер | Ожидаемый по `main.css` |
|------|-----|-------|-----------------|-------------------------|
| `architect.php` | h1 | `.blp-section-title` | 28px | 42px |
| `sertificate.php` | h1 | `.cert-title` | 28px max | 42px |
| `projects.php` | h1 | `.section-title` | 37px | 42px |
| `contacts.php` | h1 | `.contacts-title` | 37px | 42px |
| `contacts.php` | h2 | `.contact-form-title` | 18px | 37px |

### 3. «Проблема» — неправильный тег для роли (1 случай)

| Файл | Что написано | Проблема |
|------|--------------|----------|
| `contacts.php` | `<h3 class="contacts-label">Телефон</h3>` | `h3` используется как мелкая карточная подпись (12px). Семантически это не подзаголовок секции, а label. Лучше `<span class="contacts-label">` или `<p>`. |

---

## Рекомендации

### Приоритет: Высокий
1. **sertificate.php** — `.cert-title` ограничивает `h1` максимум 28px. На странице сертификатов нет более крупного заголовка. Увеличить до 42px или убрать `font-size` у класса, чтобы работала типографика `main.css`.
2. **contacts.php** — `.contact-form-title` = 18px сильно ломает визуальную иерархию формы. Либо убрать переопределение в `contacts.css`, либо заменить тег на `<h3>`/` <p>` если 18px — осознанный выбор.
3. **contacts.php** — `<h3 class="contacts-label">` заменить на `<span>` или `<p>`, т.к. 12px — это label, не подзаголовок.

### Приоритет: Средний
4. **architect.php** — `.blp-section-title` = 28px для `h1`. Это заголовок первого уровня, он должен быть крупнее всех остальных.
5. **projects.php** — `.section-title` на `h1` = 37px. Увеличить до 42px или убрать жёсткий `font-size`.
6. **contacts.php** — `.contacts-title` = 37px для `h1`. Увеличить до 42px.

### Приоритет: Низкий (рефакторинг)
7. Убрать дублирующие `font-size` у классов, которые просто повторяют размеры тегов из `main.css`:
   - `.contact-form-title`, `.section-title`, `.partners-title`, `.product-title`, `.blp-title`, `.palette-title`, `.blp-specs-title`, `.catalog-main-title`, `.hero-title`, `.blp-hero-title`, `.benefit-title`, `.audience-title`, `.tech-title`, `.object-title`
   - Вместо жёсткого px использовать `var(--fs-3xl)` / `var(--fs-4xl)` или вообще не задавать `font-size`, если класс нужен только для цвета/отступов.
8. **index.php** — вынести `style="margin-bottom: 20px"` из `<h1>` в CSS.

---

## Семантическая структура по страницам

| Страница | H1 | H2 | H3 | H4 |
|----------|----|----|----|-----|
| **index.php** | 1 (hero) | 3 (products, audience, material-benefits, compare, objects, partners, contact-form) | 4 (cards) | 2 (cards) |
| **catalog.php** | 1 (intro) | 5 (NATURE, POLISHED, TEXTURE, WALYPAN, palette, specs, benefits, contact-form) | 0 | 0 |
| **architect.php** | 1 (blp-section-title) | 4 (cards + partner-card + objects + partners + contact-form) | 0 | 0 |
| **devops.php** | 1 (hero-title) | 2 (section-title, objects, benefits, partners, contact-form) | 3 (tech-cards) | 0 |
| **diler.php** | 1 (blp-hero-title) | 3 (benefits, interesting, objects, benefits, contact-form) | 4 (benefit-cards) | 4 (benefit-cards) |
| **sertificate.php** | 1 (cert-title) | 1 (cert-section-title, contact-form) | 0 | 0 |
| **projects.php** | 1 (section-title) | 1 (benefits, contact-form) | 0 | 0 |
| **contacts.php** | 1 (contacts-title) | 2 (form-title ×2) | 3 (contacts-label ×3) | 0 |
| **policy.php** | 1 | 10 | 0 | 0 |

---

*Аудит выполнен автоматически по запросу. Изменения не вносились.*
