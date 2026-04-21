# WCAG 2.1 AA Accessibility Audit — Task #5

## Issues Fixed

| # | Criterion | File | Fix |
|---|-----------|------|-----|
| 1 | 2.4.7 Focus Visible | `css/header.css:85` | Restored `outline: 2px solid rgba(255,255,255,0.8)` on `:focus-visible` (was `outline: none`) |
| 2 | 1.4.3 Contrast (AA) | `css/footer.css:68` | `.footer-column-title` opacity 0.45 → 0.7 (uppercase text contrast improved) |
| 3 | 1.4.3 Contrast (AA) | `css/footer.css:43` | `.footer-tagline` opacity 0.7 → 0.85 (small text 13px) |
| 4 | 2.1.1 Keyboard | `css/main.css` + `pages_php/template.php` | Added skip-to-content link + `<main id="main-content">` (WCAG 2.4.1) |
| 5 | Link purpose | `blocks/contact-form.php:84` | Fixed broken policy link `/policy` → `/blp/policy` |

## Remaining Issues (require client input)

- Partners slider: alt text generic ("Партнер 1"…) — need real partner names
- `benefits.php` icon from flaticon CDN: alt="Краска" — acceptable but imprecise
- `catalog.php`: 3 images still on tildacdn.com (local files not available)

## Passes

- All `<img>` have non-empty alt text
- Form labels correctly associated via `for`/`id`
- Navigation has proper `aria-label`, `aria-haspopup`, `aria-expanded`, `role="menu/menuitem"`
- Mobile toggle has `aria-label` + `aria-controls`
- SVG icons marked `aria-hidden="true"`
- `prefers-reduced-motion` handled in `main.css`
- `lang="ru"` on `<html>`
