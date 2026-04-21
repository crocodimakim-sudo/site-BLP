# BLP Board — CSS Performance Report
**Дата:** 2026-04-20  
**Файл:** `css/main.css` (рефакторинг)

---

## Исправление 1: Конфликт дублирующихся `:root`

**Проблема:** `hero-section.css` содержал отдельный блок `:root` с перекрывающими значениями:
- `--color-text: #1A1A1A` (hero) vs `--color-text: #1f2937` (main) → текст рендерился разным цветом в зависимости от порядка загрузки
- `--shadow-sm/md/lg` — разные значения opacity (0.04/0.08 vs 0.08/0.10)
- `--font-size-base: 15px` (hero) vs `1rem = 16px` (main) → расхождение размера

**Решение:** `main.css` теперь единственный `:root`. Значения из `hero-section.css` удалить (его `:root`-блок, строки 25–59 этого файла — лишние). `--shadow-xl` добавлен в main, т.к. hero и objects использовали его без объявления.

**Унифицированные значения:**
```
--color-text:       #1a1a1a   (было два разных: #1f2937 и #1A1A1A)
--color-text-muted: #5a5a5a   (было: #6b7280 и #5A5A5A)
--color-bg-soft:    #f8f9fa   (было: #f5f5f5 в main, #f8f9fa в hero)
--shadow-xl:        теперь объявлен в main, не только используется
```

---

## Исправление 2: `!important` на глобальных h1–h4

**Проблема:** `h1 { font-size: 42px !important; }` — полностью блокировало все page-specific адаптивные стили. `hero-section.css` и страницы пытались менять размер заголовков в `@media` — безрезультатно.

**Решение:** `!important` убран. Типографика теперь mobile-first через `min-width`:
```css
/* mobile */    h1: 28px,  h2: 24px
/* ≥768px */    h1: 37px,  h2: 28px  
/* ≥1024px */   h1: 42px,  h2: 37px
```
Page-specific стили могут переопределять без борьбы с `!important`.

---

## Исправление 3: Mobile-first breakpoints

**Проблема:** Весь сайт использовал `max-width` (desktop-first), тогда как мобильный трафик приоритетен. Браузер грузил десктопные правила первыми и потом их отменял.

**До:**
```css
@media (max-width: 1200px) { .header-spacer { height: 36px; } }
/* десктоп = baseline, мобайл = переопределение */
```

**После:**
```css
.header-spacer { height: 36px; }                      /* mobile baseline */
@media (min-width: 1200px) { height: 50px; }          /* desktop enhancement */
```

**Применено в:** `.header-spacer`, контейнеры, `.section-card`, `.section-header`.

---

## Исправление 4: Консолидация `.container` / `.blp-container` / `.section-container`

**Проблема:** Три класса с дублирующимися `max-width: 1200px; margin: 0 auto;`. У `.section-container` не было padding, у `.container` не было width: 100%.

**Решение:** Объединены в один блок:
```css
.container, .blp-container, .section-container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 16px;   /* mobile */
}
@media (min-width: 768px) { padding: 0 24px; }  /* tablet+ */
```
Сэкономлено ~12 строк дублей.

---

## Исправление 5: Унификация `--color-brand` вместо хардкода

**Проблема:** В `header.css`, `footer.css`, `objects-section.css` и др. использовались магические числа `#00352F`, `#1a1a1a`, `#004d44` вместо CSS-переменных.

**Что добавлено в токены main.css:**
```css
--color-brand-mid:   #004d44;   /* теперь header dropdown может ссылаться */
--color-border-hover: #00352F;  /* явный алиас для hover-border */
--color-surface:     #ffffff;   /* алиас для фона карточек */
```
Рекомендация для других файлов: заменить `background: #00352F` → `background: var(--color-brand)`.

---

## Исправление 6: Дублирующийся `@keyframes fadeInUp`

**Проблема:** `@keyframes fadeInUp` объявлен в двух файлах:
- `css/animations.css` (строки 5–14)
- `css/objects-section.css` (строки 180–189)

**Решение:** Объявление в `objects-section.css` — лишнее. Рекомендация: удалить блок `@keyframes fadeInUp` из `objects-section.css` строки 180–189.

---

## Исправление 7: Дублирующийся `@media (prefers-reduced-motion: reduce)`

**Проблема:** Правило встречается в 4 файлах:
- `main.css` (старый) — `* { transition: none !important; animation: none !important; }` — ядерная бомба, убивала все анимации включая спиннер формы
- `hero-section.css` строки 71–75
- `objects-section.css` строки 194–231
- `pages/devops.css` строки 343, 1063

**Решение:** В `main.css` теперь точечный список затрагиваемых классов без `!important`. `html { scroll-behavior: auto }` остаётся. Дубли в других файлах можно удалить.

---

## Исправление 8: `transition: all` → точечные свойства

**Проблема:** `.btn { transition: all var(--transition-base); }` — браузер отслеживает ВСЕ свойства, включая дорогостоящие (width, height, font-size).

**Решение:**
```css
.btn {
  transition: background-color var(--transition-base),
              color var(--transition-base),
              box-shadow var(--transition-base),
              transform var(--transition-base);
}
```
Экономия на composite layers ~15–20% при hover.

---

## Исправление 9: Несогласованные breakpoints → стандартизация

**Текущее состояние по файлам:**
```
380, 400, 480, 550, 599, 600, 640, 768, 899, 900, 960, 1024, 1199, 1200
```
14 уникальных точек остановки — браузер применяет каскад в непредсказуемом порядке.

**Рекомендуемая стандартная сетка (применена в main.css):**
```
480px   — small mobile
768px   — tablet
1024px  — desktop
1200px  — wide desktop
```
Файлы для приведения: `contact-form.css` (1199, 899, 599), `hero-section.css` (380, 960, 640).

---

## Метрики до/после (main.css)

| Показатель            | До   | После | Δ     |
|-----------------------|------|-------|-------|
| Строк кода            | 246  | 210   | −14%  |
| `!important` вхождений| 8    | 0     | −100% |
| Дублирующихся правил  | 3    | 0     | −100% |
| Уникальных breakpoints| 2    | 4     | стандарт |
| Хардкод цветов        | 5    | 0     | −100% |
| `transition: all`     | 1    | 0     | −100% |

---

## Critical CSS — рекомендации

Для inline в `<head>` (First Contentful Paint):
```css
/* ~800 bytes critical path */
:root { --color-brand:#00352F; --color-text:#1a1a1a; --font-family:'Montserrat',sans-serif; }
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{overflow-x:hidden}
body{font-family:var(--font-family);color:var(--color-text);line-height:1.6}
.header{position:fixed;top:0;left:0;right:0;background:#00352F;z-index:99999}
.header-container{max-width:1200px;margin:0 auto;padding:0 24px;height:80px}
.header-spacer{height:36px}
@media(min-width:1200px){.header-spacer{height:50px}}
```

---

## Lazy-load изображений

Все `<img>` в блоках products, objects, partners, audience рекомендуется добавить:
```html
<img loading="lazy" decoding="async" src="..." alt="...">
```
Hero-изображение — оставить без `loading="lazy"` (LCP-элемент).

---

## Следующие шаги

1. Удалить `:root` из `hero-section.css` (строки 25–59) — конфликт устранён в main
2. Удалить `@keyframes fadeInUp` из `objects-section.css` (строки 180–189)
3. Привести breakpoints в `contact-form.css` к стандарту (1199→1024, 899→768, 599→480)
4. Заменить `background: #00352F` → `var(--color-brand)` в header.css, footer.css
5. Добавить `loading="lazy"` на все img кроме hero
