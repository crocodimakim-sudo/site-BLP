# Аудит шрифтов BLP Board

## 1. Общая информация

**Базовый шрифт:** `Montserrat` (Google Fonts) + системный fallback.
- Переменная: `--font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;`
- Используется во всех файлах через `var(--font-family)` или жёстко прописан `'Montserrat', sans-serif`.

**Исключения / жёсткие переопределения:**
- `header.css` — `font-family: 'Montserrat', sans-serif` на всех элементах навигации.
- `footer.css` — `font-family: 'Montserrat', sans-serif !important` на весь футер.
- `css/pages/kreplenie.css` — `@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');`
- `css/pages/diler.css` — тот же `@import` + `var(--font-main)`.

---

## 2. Базовая типографика H1–H3

| Элемент | Файл | font-size | font-weight | Проблема |
|---------|------|-----------|-------------|----------|
| h1 | css/main.css | `var(--fs-2xl)` → `var(--fs-3xl)` → `var(--fs-4xl)` (28→37→42px) | 700 | — |
| h2 | css/main.css | `var(--fs-xl)` → `var(--fs-2xl)` → `var(--fs-3xl)` (24→28→37px) | **600** | Базовый вес 600 |
| h3 | css/main.css | `var(--fs-lg)` (20px) | 700 | — |
| h1 | css/pages/index.css | `var(--font-size-4xl)` (42px) → `var(--font-size-xl)` (24px) @≤960 | **700** | Переопределяет базовый |
| h2 | css/pages/index.css | `var(--font-size-3xl)` (37px) → `var(--font-size-xl)` (24px) @≤640 | **700** | **Конфликт: weight 700 против 600 в main.css** |
| h3 | css/pages/index.css | `var(--font-size-lg)` (18px) | 700 | Переопределяет базовый (20→18px) |

---

## 3. Жёстко заданные размеры в px (не через переменные)

| Файл | Селектор | font-size | Примечание |
|------|----------|-----------|------------|
| css/main.css | .section-label | 12px (в комментарии `var(--fs-sm)=0.875rem=14px`, но `.section-label` использует `var(--fs-sm)`) | Ок, через переменную |
| **css/contact-form.css** | **.contact-form-title** | **37px** | ❌ Жёсткий px |
| **css/contact-form.css** | **.form-label** | **13px** | ❌ Жёсткий px |
| **css/contact-form.css** | **.form-input, .form-textarea** | **14px** | ❌ Жёсткий px |
| **css/contact-form.css** | **.form-checkbox-label** | **13px** | ❌ Жёсткий px |
| **css/contact-form.css** | **.btn-primary** (в форме) | **14px** | ❌ Жёсткий px |
| **css/partners-section.css** | **.partners-title** | **40px** | ❌ Жёсткий px |
| **css/objects-section.css** | **.section-title** | **37px** | ❌ Жёсткий px |
| **css/objects-section.css** | **.object-title** | **24px** | ❌ Жёсткий px |
| **css/benefits.css** | **.benefit-title** | **20px** | ❌ Жёсткий px |
| **css/benefits.css** | **.benefits-section > h2** | **37px** | ❌ Жёсткий px |
| **css/hero-section.css** | **.badge** | **12px** | ❌ Жёсткий px |
| **css/hero-section.css** | **.tag** | **13px** | ❌ Жёсткий px |
| **css/hero-section.css** | **.hero-intro** | **16px** | ❌ Жёсткий px |
| **css/hero-section.css** | **.hero-main .btn** | **14px** | ❌ Жёсткий px |
| **css/header.css** | **.nav-link** | **14px** | ❌ Жёсткий px |
| **css/header.css** | **.phone** | **15px** | ❌ Жёсткий px |
| **css/header.css** | **.email** | **13px** | ❌ Жёсткий px |
| **css/header.css** | **.cta-button** | **14px** | ❌ Жёсткий px |
| **css/header.css** | **.mobile-nav-link** | **16px** | ❌ Жёсткий px |
| **css/header.css** | **.mobile-phone** | **20px** | ❌ Жёсткий px |
| **css/header.css** | **.mobile-email** | **14px** | ❌ Жёсткий px |
| **css/header.css** | **.mobile-cta** | **16px** | ❌ Жёсткий px |
| **css/footer.css** | **.footer-tagline** | **13px** | ❌ Жёсткий px |
| **css/footer.css** | **.footer-column-title** | **10px** | ❌ Жёсткий px |
| **css/footer.css** | **.footer-link** | **14px** | ❌ Жёсткий px |
| **css/footer.css** | **.footer-copyright** | **13px** | ❌ Жёсткий px |
| **css/audience-section.css** | **.audience-title** | **20px** | ❌ Жёсткий px |
| **css/pages/index.css** | **.hero-intro** | **20px** | ❌ Жёсткий px |
| **css/pages/index.css** | **p @≤640** | **15px** | ❌ Жёсткий px |
| **css/pages/index.css** | **.text-label @≤640** | **11px** | ❌ Жёсткий px |
| **css/pages/index.css** | **.objects-section .section-title** | **40px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-architect-hero__title** | **36px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-architect-hero__subtitle** | **16px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-section-title** | **28px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **h2.blp-card-title** | **40px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-card-title** | **18px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **h2.blp-support-title** | **40px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-support-title** | **20px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-partner-card__title** | **40px** | ❌ Жёсткий px |
| **css/pages/architect.css** | **.blp-specs-title** | **37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.catalog-main-title** | **42px / 37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.product-title** | **37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.palette-title** | **37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.blp-specs-title** | **37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.blp-product-block .blp-title** | **37px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.spec-label, .colors-label** | **13px** | ❌ Жёсткий px |
| **css/pages/catalog.css** | **.color-name** | **13px** | ❌ Жёсткий px |
| **css/pages/contacts.css** | **.contact-form-title** | **18px** | ❌ Жёсткий px (переопределяет 37px) |
| **css/pages/devops.css** | **.hero-title** | **42px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.hero-subtitle** | **18px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.hero-cta** | **15px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.devops-section .section-title** | **32px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.section-subtitle** | **18px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.tech-title** | **20px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.tech-text** | **15px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.tech-list li** | **14px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.blp-benefits .section-title** | **32px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.blp-benefits .benefit-title** | **18px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.blp-benefits .benefit-text** | **15px** | ❌ Жёсткий px |
| **css/pages/devops.css** | **.blp-benefits .benefits-summary** | **15px** | ❌ Жёсткий px |
| **css/pages/diler.css** | **.blp-hero-title** | **42px** | ❌ Жёсткий px |
| **css/pages/diler.css** | **.blp-benefits-title** | **32px** | ❌ Жёсткий px |
| **css/pages/diler.css** | **.blp-interesting-title** | **36px** | ❌ Жёсткий px |
| **css/pages/kreplenie.css** | **.blp-mounting-title** | **14px** | ❌ Жёсткий px |
| **css/pages/kreplenie.css** | **.blp-method-header** | **28px** | ❌ Жёсткий px |
| **css/pages/kreplenie.css** | **.blp-method-description** | **15px** | ❌ Жёсткий px |
| **css/pages/kreplenie.css** | **.blp-hardware-title** | **13px** | ❌ Жёсткий px |
| **css/pages/kreplenie.css** | **.blp-material-name** | **15px** | ❌ Жёсткий px |
| **css/pages/policy.css** | **.policy-section h1** | **2rem** | ❌ rem, но жёстко |
| **css/pages/policy.css** | **.policy-content h2** | **1.3rem** | ❌ rem, но жёстко |
| **css/pages/projects.css** | **.section-label** | **12px** | ❌ Жёсткий px |
| **css/pages/projects.css** | **.projects-section .section-title** | **32px** | ❌ Жёсткий px |
| **css/pages/projects.css** | **.project-name** | **20px** | ❌ Жёсткий px |
| **css/pages/projects.css** | **.project-location** | **14px** | ❌ Жёсткий px |
| **css/pages/sertificate.css** | **.cert-title** | **clamp(18px,2.5vw,28px)** | Ок, относительный |
| **css/pages/sertificate.css** | **.cert-section-title** | **22px** | ❌ Жёсткий px |
| **css/pages/sertificate.css** | **.cert-subtitle** | **15px** | ❌ Жёсткий px |

---

## 4. Таблица несоответствий H2 (размер / weight)

| Элемент | Файл | font-size | font-weight | Проблема |
|---------|------|-----------|-------------|----------|
| h2 | css/main.css | 24→28→37px (var) | **600** | Базовый canonical |
| h2 | css/pages/index.css | 37→28→24px (var) | **700** | **Конфликт weight: 700 vs 600** |
| .benefits-section > h2 | css/benefits.css | **37px** | **600** | Жёсткий px, выровнен с main.css desktop, но без адаптива |
| .section-title | css/objects-section.css | **37px** | **600** | Жёсткий px, дублирует benefits |
| .partners-title | css/partners-section.css | **40px** | **700** | ❌ Другой размер (40≠37) и weight (700≠600) |
| .objects-section .section-title | css/pages/index.css | **40px** | **700** | ❌ Другой размер и weight, конфликт с css/objects-section.css |
| h2.blp-card-title | css/pages/architect.css | **40px** | **700** | ❌ Другой размер и weight |
| h2.blp-support-title | css/pages/architect.css | **40px** | **700** | ❌ Другой размер и weight |
| .blp-specs-title | css/pages/architect.css | **37px** | **600** | Жёсткий px, но совпадает с базой |
| .product-title | css/pages/catalog.css | **37px** | **600** | Жёсткий px, совпадает с базой |
| .palette-title | css/pages/catalog.css | **37px** | **600** | Жёсткий px, совпадает с базой |
| .blp-specs-title | css/pages/catalog.css | **37px** | **600** | Жёсткий px, совпадает с базой |
| .devops-section .section-title | css/pages/devops.css | **32px** | **600** | ❌ Другой размер (32≠37) |
| .blp-benefits .section-title | css/pages/devops.css | **32px** | **600** | ❌ Другой размер (32≠37) |
| .blp-benefits-title | css/pages/diler.css | **32px** | **600** | ❌ Другой размер (32≠37) |
| .blp-interesting-title | css/pages/diler.css | **36px** | **600** | ❌ Другой размер (36≠37) |
| .projects-section .section-title | css/pages/projects.css | **32px** | **600** | ❌ Другой размер (32≠37) |
| .catalog-main-title | css/pages/catalog.css | 42→37→28→22px | **700** | Это H1, но жёсткие px |
| .faq-section-title | css/pages/faq.css | 1.35rem (~22px) | **600** | Это H2-уровень, но меньше базы |
| .install-section-title | css/pages/install.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |
| .compare-section-title | css/pages/compare.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |
| .dealer-section-title | css/pages/dealer.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |
| .showcase-section-title | css/pages/showcase.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |
| .catalog-uc-title | css/pages/catalog.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |
| .index-mb-title | css/pages/index.css | 1.75rem (~28px) | **700** | H2-уровень, weight 700≠600 |

---

## 5. Выводы и критические проблемы

### 🔴 Критично
1. **Конфликт H2 weight:** `main.css` задаёт `font-weight: 600`, а `css/pages/index.css` переопределяет глобально `h2 { font-weight: 700 }`. На главной все H2 будут толще, чем на остальных страницах.
2. **Разброс размеров H2-заголовков:** от 28px (rem) до 40px (px). Нет единого канонического размера для section-title на разных страницах.
3. **Жёсткие px повсюду:** Более 50 объявлений `font-size` в `px` вместо CSS-переменных, что ломает масштабируемость и единообразие.

### 🟡 Рекомендации
- Унифицировать все section-title через `var(--fs-3xl)` (37px desktop / 28px tablet / 24px mobile).
- Привести `font-weight` для H2 к единому значению (600 или 700 — нужно решить в рамках дизайн-системы).
- Перевести жёсткие `px` в форме и хедере на переменные `--fs-*`.
- Убрать дубли `@import` Montserrat (уже подключен в `<head>`).
