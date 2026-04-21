# Полный аудит шрифтов BLP Board

## 1. Какие шрифты используются

| Шрифт | Где подключен | Где используется |
|-------|--------------|------------------|
| **Montserrat** | Google Fonts в `blocks/template.php` (preconnect + preload) | ВЕЗДЕ — основной шрифт |
| **Системный fallback** | Встроен в `var(--font-family)` | Запасной вариант |

**Переменная:** `--font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;` (в `main.css`)

**Проблема:** Во многих файлах шрифт прописан жёстко `'Montserrat', sans-serif` вместо `var(--font-family)`, и без системного fallback.

---

## 2. Дубли типографики h1–h4 (КОНФЛИКТЫ)

### 🔴 Главный конфликт: `css/pages/index.css` (строки 90–111)
```css
h1 { font-size: var(--font-size-4xl); font-weight: 700; ... }
h2 { font-size: var(--font-size-3xl); font-weight: 700; ... }  ← weight 700!
h3 { font-size: var(--font-size-lg);  font-weight: 700; ... }
p  { font-size: var(--font-size-base); ... }
```
Это **полный дубль** типографики из `main.css`, но с другим `font-weight` для h2.

### `main.css` (канонический источник)
```css
h1 { font-size: var(--fs-2xl)→var(--fs-3xl)→var(--fs-4xl); font-weight: 700; }
h2 { font-size: var(--fs-xl)→var(--fs-2xl)→var(--fs-3xl);   font-weight: 600; }  ← weight 600!
h3 { font-size: var(--fs-lg);                                 font-weight: 700; }
h4 { font-size: var(--fs-base);                               font-weight: 500; }
```

**Результат:** На главной h2 жирнее (700), чем на других страницах (600).

### Остальные переопределения h1–h4:

| Файл | Селектор | font-size | weight | Проблема |
|------|----------|-----------|--------|----------|
| `benefits.css:77` | `.benefits-section > h2` | 37px | 600 | Жёсткий px, дублирует main.css desktop |
| `objects-section.css:16` | `.section-title` | 37px | 600 | Жёсткий px |
| `hero-section.css:216` | `.hero-main h1` | 22px | — | Только для ≤380px, ок |
| `policy.css:7` | `.policy-section h1` | 2rem | — | Жёсткий rem |
| `policy.css:17` | `.policy-content h2` | 1.3rem | — | Жёсткий rem |
| `pages/dealer.css:62` | `.dealer-why-card h3` | 1rem | 700 | Жёсткий rem |
| `pages/dealer.css:142` | `.dealer-support-card h3` | 1.05rem | 700 | Жёсткий rem |
| `pages/dealer.css:164` | `.dealer-step-content h3` | 1rem | 700 | Жёсткий rem |
| `pages/catalog.css:101` | `.blp-title` | 37px | 600 | Жёсткий px (это H1-уровень) |
| `pages/catalog.css:270` | `.catalog-uc-card h3` | 1.05rem | 700 | Жёсткий rem |
| `pages/install.css:132` | `.install-mistake-card h3` | 1rem | 700 | Жёсткий rem |
| `pages/showcase.css:164` | `.showcase-usecase-card h3` | 1.05rem | 700 | Жёсткий rem |
| `pages/diler.css:385` | `.blp-benefit-heading-box h3` | — | — | Переопределение |
| `pages/diler.css:389` | `.blp-benefit-description-box h4` | — | — | Переопределение |
| `pages/index.css:1019` | `.index-mb-card h3` | 1rem | 700 | Жёсткий rem |

---

## 3. !important в CSS (блокирует переопределения)

### `header.css` — 30+ случаев
- Цвета ссылок: `color: white !important;`
- Фоны: `background: transparent !important;`
- Декорации: `text-decoration: none !important;`
- **Строки:** 62–63, 71–82, 156–169, 192–221, 232, 242, 248, 310–314, 332–338, 343, 357–358, 368–369, 381, 389

### `footer.css`
- `font-family: 'Montserrat', sans-serif !important;` (строка 7)
- `color: rgba(255,255,255,0.85) !important;` (строка 43)
- `color: white !important;` (строка 63)
- `color: rgba(255,255,255,0.6) !important;` (строка 123, 131)
- `text-decoration: none !important;` (строка 79, 132)

### `products-section.css`
- `color: #00352F !important;` (строки 77, 82) — `.product-label` и `.card-link`

### `objects-section.css`
- `color: #ffffff !important;` (строка 116) — `.btn-cta`
- `color: var(--color-primary) !important;` (строка 130) — `.btn-cta:hover`
- `transition: none !important; animation: none !important;` (строки 196–197) — prefers-reduced-motion

### `css/pages/index.css`
- `color: white !important;` (строки 211, 231) — `.btn-primary::after`
- `color: #ffffff !important;` (строка 241) — `.btn-secondary`
- `color: #ffffff !important;` (строка 255) — `.btn-secondary:hover`
- `color: #ffffff !important;` (строка 858) — `.btn-cta`
- `transition: none !important; animation: none !important;` (строки 937–938) — prefers-reduced-motion
- `color: #fff !important;` (строка 1039) — `.index-mb-th-blp`
- `color: #00352F !important;` (строка 1045) — `.index-mb-td-blp`

### `pages/diler.css`
- `color: #ffffff !important;` (строки 126, 142)

### `pages/catalog.css`
- `background-image: none !important; background: none !important;` (строка 63) — `.color-swatch`
- `display: none !important; content: none !important;` (строка 64) — псевдоэлементы
- `background-color: #... !important; background: #... !important;` (строки 66–75) — цвета палитры
- `color: #ffffff !important; text-decoration: none !important;` (строка 207) — `.blp-cert-btn`

---

## 4. Жёстко прописанные font-family (вместо var)

| Файл | Сколько раз | Пример |
|------|------------|--------|
| `header.css` | 11 | `font-family: 'Montserrat', sans-serif;` |
| `footer.css` | 1 | `font-family: 'Montserrat', sans-serif !important;` |
| `pages/architect.css` | 6 | `font-family: 'Montserrat', sans-serif;` |
| `pages/catalog.css` | 12 | `font-family: 'Montserrat', sans-serif;` |
| `pages/devops.css` | 6 | `font-family: 'Montserrat', sans-serif;` |
| `pages/diler.css` | 2 | `font-family: 'Montserrat', ...` или `var(--font-main)` |
| `pages/kreplenie.css` | 2 | `font-family: 'Montserrat', ...` |
| `pages/sertificate.css` | 1 | `font-family: 'Montserrat', ...` |

---

## 5. План исправления

1. **Удалить дубли h1–h4 + p** из `css/pages/index.css` (строки 90–168)
2. **Убрать !important** из:
   - `products-section.css` (color #00352F)
   - `objects-section.css` (color #ffffff, color-primary)
   - `footer.css` (font-family, color)
   - `header.css` (цвета ссылок — заменить на специфичность)
3. **Заменить жёсткие font-family** на `var(--font-family)` в `header.css`, `footer.css`, `pages/architect.css`, `pages/catalog.css`
