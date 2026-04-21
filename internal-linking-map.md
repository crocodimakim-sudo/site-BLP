# Internal Linking Map — BLP Board
<!-- 2026-04-20: Stage 3 Group 3.D — Internal Linking & Navigation Architecture -->

**Project:** BLP Board (building-port.ru)
**Created:** 2026-04-20
**Scope:** All 10 pages + blocks + planned blog/landing pages

---

## 1. Topical Silo Diagram

```
                        ┌─────────────────┐
                        │   index.php      │
                        │   (Homepage)     │
                        └────────┬────────┘
                                 │ internal links to all silos
           ┌─────────────────────┼─────────────────────┐
           │                     │                     │
           ▼                     ▼                     ▼
  ┌────────────────┐   ┌─────────────────┐   ┌─────────────────┐
  │  PRODUCT SILO  │   │ AUDIENCE SILO   │   │ SUPPORT SILO    │
  └────────────────┘   └─────────────────┘   └─────────────────┘
  catalog.php          architect.php          kreplenie.php
  ├── #nature          devops.php             sertificate.php
  ├── #polished        diler.php              contacts.php (FAQ)
  ├── #texture         └── → catalog          └── → catalog
  ├── #walypan         └── → sertificate
  ├── #palette         └── → kreplenie
  └── #characteristics └── → contacts
       │
       ▼
  COMMERCIAL SILO
  projects.php
  └── → catalog (related products)
  └── → contacts (request quote)
```

---

## 2. Full Link Matrix

### SOURCE: index.php (Главная)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| catalog.php | "Каталог фиброцементных панелей" | Product Silo Hub | Nav dropdown |
| catalog.php#nature | "Серия NATURE — фактура под бетон" | Product Deep | Products block |
| catalog.php#polished | "Серия POLISHED — матовые плиты" | Product Deep | Products block |
| catalog.php#texture | "Серия TEXTURE — текстурированные" | Product Deep | Products block |
| catalog.php#walypan | "Серия WALYPAN — линеарные панели" | Product Deep | Products block |
| architect.php | "Архитекторам и проектировщикам" | Audience Silo | Audience block |
| devops.php | "Застройщикам" | Audience Silo | Audience block |
| diler.php | "Дилерам" | Audience Silo | Audience block |
| projects.php | "Реализованные объекты" | Commercial | Objects block |
| contacts.php | "Оставить заявку" | CTA Primary | Hero button |
| contacts.php | "Обратный звонок" | CTA Secondary | Header |
| sertificate.php | "Сертификаты и ГОСТ" | Support | Footer |
| kreplenie.php | "Способы крепления панелей" | Support | Footer |

---

### SOURCE: catalog.php (Каталог)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| sertificate.php | "Сертификаты соответствия НГ" | Topical — product proof | Characteristics block |
| kreplenie.php | "Способы крепления к подсистеме" | Topical — product support | After specs block |
| architect.php | "Техническая документация для проекта" | Audience cross-link | After characteristics |
| contacts.php | "Запросить прайс-лист" | CTA Transactional | Bottom of each series |
| contacts.php | "Заказать образцы панелей" | CTA High-intent | After color palette |
| projects.php | "Объекты с фиброцементными панелями" | Related content | After WALYPAN |
| catalog.php#polished | "Серия POLISHED" | In-page sequential | After NATURE section |
| catalog.php#texture | "Серия TEXTURE" | In-page sequential | After POLISHED section |
| catalog.php#walypan | "Серия WALYPAN" | In-page sequential | After TEXTURE section |
| catalog.php#nature | "Серия NATURE" | In-page sequential | After WALYPAN section |

---

### SOURCE: architect.php (Архитекторам)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Полный каталог фиброцементных панелей" | Product Silo | Products block |
| catalog.php#nature | "NATURE — фактура под бетон для фасада" | Product Deep | Specs section |
| catalog.php#palette | "Палитра цветов RAL" | Product Deep | Color section |
| sertificate.php | "Техническая документация и сертификаты" | Support Silo | Support list |
| kreplenie.php | "Узлы крепления и типовые решения" | Support Silo | Support list |
| contacts.php | "Запросить образцы и документацию" | CTA B2B | Hero CTA |
| contacts.php | "Получить консультацию по проекту" | CTA Contextual | After support block |
| projects.php | "Реализованные архитектурные проекты" | Related content | Bottom |
| devops.php | "Застройщикам — условия поставки" | Audience cross | Footer area |

---

### SOURCE: devops.php (Застройщикам)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Каталог фасадных панелей" | Product Silo | Products section |
| catalog.php#characteristics | "Технические характеристики НВФ" | Product Deep | Specs mention |
| sertificate.php | "Сертификаты класса НГ и К0" | Support Silo | Trust section |
| kreplenie.php | "Системы крепления для НВФ" | Support Silo | Technical section |
| contacts.php | "Обсудить объём поставки" | CTA B2B | Hero CTA |
| contacts.php | "Запросить коммерческое предложение" | CTA Transactional | Bottom CTA |
| projects.php | "Реализованные объекты" | Commercial | Objects section |
| architect.php | "Для архитекторов и проектировщиков" | Audience cross | Footer area |
| diler.php | "Дилерская сеть" | Audience cross | Footer area |

---

### SOURCE: diler.php (Дилерам)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Весь ассортимент фиброцементных плит" | Product Silo | Products section |
| catalog.php#characteristics | "Характеристики и форматы" | Product Deep | Specs section |
| sertificate.php | "Сертификаты для работы с заказчиком" | Support Silo | Resources block |
| contacts.php | "Обсудить дилерское сотрудничество" | CTA B2B Primary | Hero CTA |
| contacts.php | "Стать дилером BLP Board" | CTA Conversion | Program section |
| projects.php | "Проекты дилерской сети" | Related content | Bottom |
| devops.php | "Застройщикам — проектные поставки" | Audience cross | Footer area |

---

### SOURCE: projects.php (Объекты)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Фиброцементные панели в каталоге" | Product Silo | After each project |
| catalog.php#nature | "NATURE — как на этом объекте" | Product Deep | Project-specific |
| contacts.php | "Запросить расчёт для своего объекта" | CTA Commercial | Bottom CTA |
| contacts.php | "Обсудить аналогичный проект" | CTA Contextual | After each case |
| architect.php | "Документация для архитекторов" | Audience cross | Bottom |
| devops.php | "Условия для застройщиков" | Audience cross | Bottom |

---

### SOURCE: sertificate.php (Сертификаты)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Каталог сертифицированных панелей" | Product Silo | After certificates |
| catalog.php#characteristics | "Характеристики класса НГ и К0" | Product Deep | After ГОСТ info |
| kreplenie.php | "Технические решения крепления" | Support Silo | Related docs |
| contacts.php | "Запросить полный пакет документации" | CTA B2B | Bottom CTA |
| architect.php | "Проектная документация для архитекторов" | Audience cross | Top intro |

---

### SOURCE: kreplenie.php (Крепление)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Выбрать фиброцементные панели" | Product Silo | After method descriptions |
| catalog.php#characteristics | "Технические параметры панелей" | Product Deep | Specs cross-ref |
| sertificate.php | "Сертификаты и испытания" | Support Silo | Footer area |
| contacts.php | "Получить консультацию по подсистеме" | CTA Technical | Bottom CTA |
| architect.php | "Узлы крепления для проектировщиков" | Audience cross | Intro text |

---

### SOURCE: contacts.php (Контакты)

| Target | Anchor Text | Link Type | Element |
|--------|-------------|-----------|---------|
| index.php | "Главная" | Breadcrumb | Breadcrumb trail |
| catalog.php | "Ознакомиться с каталогом" | Product Silo | After form |
| catalog.php#palette | "Палитра цветов" | Product Deep | After form |
| sertificate.php | "Скачать сертификаты" | Support | Side block |

---

## 3. "Related Products" Navigation (внутри catalog.php)

Реализовать блок **"Другие серии"** после каждой серии:

```
[NATURE section] → "Смотрите также:"
  • Полированные плиты POLISHED →  #polished
  • Текстурированные TEXTURE    →  #texture
  • Линеарные WALYPAN            →  #walypan

[POLISHED section] → "Смотрите также:"
  • Фактура под бетон NATURE    →  #nature
  • Текстурированные TEXTURE    →  #texture

[TEXTURE section] → "Смотрите также:"
  • NATURE — индустриальный стиль →  #nature
  • POLISHED — матовые плиты      →  #polished

[WALYPAN section] → "Смотрите также:"
  • Плоские серии: NATURE, POLISHED, TEXTURE (links)
  • "Запросить каталог серии WALYPAN" → contacts.php
```

---

## 4. Sequential "Next Product" Navigation

Добавить микро-навигацию внутри catalog.php между секциями:

```html
<!-- После описания NATURE -->
<div class="series-nav">
  <span>Следующая серия:</span>
  <a href="#polished">POLISHED — матовые фиброцементные плиты →</a>
</div>

<!-- После описания POLISHED -->
<div class="series-nav">
  <a href="#nature">← NATURE</a>
  <a href="#texture">TEXTURE →</a>
</div>

<!-- После описания TEXTURE -->
<div class="series-nav">
  <a href="#polished">← POLISHED</a>
  <a href="#walypan">WALYPAN →</a>
</div>

<!-- После описания WALYPAN -->
<div class="series-nav">
  <a href="#texture">← TEXTURE</a>
  <a href="/blp/contacts">Запросить прайс-лист на серию →</a>
</div>
```

---

## 5. Breadcrumb Navigation — Verification Checklist

Breadcrumb schema (BreadcrumbList) уже реализована во всех PHP страницах через `$breadcrumbs` variable. Визуальные хлебные крошки нужно добавить:

| Страница | Schema | Visual Breadcrumbs | Status |
|----------|--------|--------------------|--------|
| index.php | ✅ | N/A (homepage) | OK |
| catalog.php | ✅ | Главная → Каталог | ⚠️ Добавить HTML |
| architect.php | ✅ | Главная → Архитекторам | ⚠️ Добавить HTML |
| devops.php | ✅ | Главная → Застройщикам | ⚠️ Добавить HTML |
| diler.php | ✅ | Главная → Дилерам | ⚠️ Добавить HTML |
| projects.php | ✅ | Главная → Объекты | ⚠️ Добавить HTML |
| sertificate.php | ✅ | Главная → Сертификаты | ⚠️ Добавить HTML |
| kreplenie.php | ✅ | Главная → Способы крепления | ⚠️ Добавить HTML |
| contacts.php | ✅ | Главная → Контакты | ⚠️ Добавить HTML |

**HTML шаблон хлебных крошек (добавить в начало каждой страницы):**
```html
<nav class="breadcrumb" aria-label="Хлебные крошки">
  <ol class="breadcrumb-list">
    <li class="breadcrumb-item"><a href="/blp/">Главная</a></li>
    <li class="breadcrumb-item breadcrumb-current" aria-current="page">[Название страницы]</li>
  </ol>
</nav>
```

---

## 6. Footer Link Optimization

**Текущее состояние footer.php:** 4 колонки — Каталог, Сотрудничество, Партнёрам, Компания.

**Рекомендуемые изменения:**

| Колонка | Добавить ссылки | Anchor Text | Приоритет |
|---------|-----------------|-------------|-----------|
| Каталог | contacts.php | "Заказать образцы" | HIGH |
| Каталог | catalog.php#characteristics | "Технические характеристики" | HIGH |
| Партнёрам | sertificate.php | "Сертификаты НГ/К0" | HIGH |
| Партнёрам | *(планируемый)* /blog/ | "Статьи и руководства" | MED |
| Компания | sitemap.xml | "Карта сайта" | MED |
| Компания | projects.php | "Реализованные объекты" | LOW |

**Добавить в footer (низ, под copyright):**
```html
<a href="/blp/sitemap.xml" class="footer-sitemap">Карта сайта</a>
```

---

## 7. Anchor Text Strategy

### Правила якорного текста

| Правило | Пример ПРАВИЛЬНО | Пример НЕПРАВИЛЬНО |
|---------|-----------------|---------------------|
| 1–5 слов, описывает цель | "Каталог фиброцементных панелей" | "нажмите здесь" |
| Ключевое слово если естественно | "Негорючие фасадные панели НГ" | "подробнее" |
| Специфично для целевой страницы | "Сертификаты соответствия ГОСТ" | "документы" |
| CTA — действие + выгода | "Запросить образцы панелей" | "связаться" |
| Breadcrumb — точное название | "Главная", "Каталог" | любой другой текст |

### Tier-1 keyword anchors (по keyword-research.md)

| Target Page | Рекомендованный anchor | Keyword | KD |
|-------------|----------------------|---------|-----|
| catalog.php | "Фиброцементные панели для фасада" | B3 | 49 |
| catalog.php | "Крупноформатные фиброцементные панели" | B7 | 24 |
| catalog.php | "Негорючие фасадные панели НГ" | B8-B9 | 41/33 |
| catalog.php | "Панели окрашенные в массе" | B10 | 19 |
| sertificate.php | "Класс пожарной безопасности К0" | C10 | 19 |
| sertificate.php | "Фиброцементные плиты ГОСТ" | C9 | 21 |
| kreplenie.php | "Как крепить фиброцементные панели" | C7 | 35 |
| kreplenie.php | "Подсистема для фиброцементных панелей" | C8 | 38 |
| architect.php | "Фасадные материалы для архитекторов" | D1 | 14 |
| diler.php | "Дилерская программа фасадные материалы" | D5 | 12 |
| contacts.php | "Заказать образцы фиброцементных плит" | Gap KW | 9 |

---

## 8. Topical Silo Groups

### Silo 1 — PRODUCT (catalog cluster)
**Hub:** catalog.php  
**Spokes:** catalog.php#nature, #polished, #texture, #walypan, #palette, #characteristics  
**Support:** sertificate.php (proof), kreplenie.php (technical)  
**Cross-cluster:** → architect.php (docs), → contacts.php (CTA)

```
catalog.php
  ↔ sertificate.php  [anchor: "Сертификаты НГ для фиброцементных панелей"]
  ↔ kreplenie.php    [anchor: "Способы крепления к вентилируемому фасаду"]
  → architect.php    [anchor: "Техническая документация для проектировщиков"]
  → contacts.php     [anchor: "Запросить прайс-лист"]
```

### Silo 2 — AUDIENCE (persona cluster)
**Hub:** index.php (audience section)  
**Spokes:** architect.php, devops.php, diler.php  
**Cross-links within silo:** architect ↔ devops ↔ diler (через footer/bottom-page)

```
architect.php ↔ devops.php   [anchor: "Застройщикам — условия поставки"]
devops.php    ↔ diler.php    [anchor: "Дилерская сеть"]
diler.php     ↔ architect.php [anchor: "Для архитекторов и проектировщиков"]
```

### Silo 3 — COMMERCIAL (projects cluster)
**Hub:** projects.php  
**Connection to product:** → catalog.php (per project — что за серия)  
**Connection to CTA:** → contacts.php

```
projects.php
  → catalog.php      [anchor: "Использованные материалы: фиброцементные панели"]
  → contacts.php     [anchor: "Запросить расчёт для аналогичного объекта"]
```

### Silo 4 — SUPPORT (technical cluster)
**Nodes:** sertificate.php ↔ kreplenie.php  
**Feed into:** catalog.php (proof), architect.php (docs)

```
sertificate.php ↔ kreplenie.php [anchor: "Технические решения монтажа"]
sertificate.php → catalog.php   [anchor: "Сертифицированные панели в каталоге"]
kreplenie.php   → catalog.php   [anchor: "Выбрать фиброцементные панели"]
```

---

## 9. Planned Pages — Link Integration

При создании новых страниц (из keyword-research.md) интегрировать так:

| Планируемая страница | Входящие links из | Anchor | Исходящие links в |
|---------------------|------------------|--------|------------------|
| /blog/k0-klass-pozharnoj-bezopasnosti/ | sertificate.php, catalog.php#char | "Класс К0 — что это значит" | sertificate.php, catalog.php |
| /blog/chto-takoe-fibrocement/ | index.php (hero), catalog.php | "Что такое фиброцементная плита" | catalog.php, kreplenie.php |
| /blog/krepleniye-fibrocementa/ | kreplenie.php, catalog.php | "Инструкция по монтажу" | kreplenie.php, sertificate.php |
| /blog/srok-sluzhby/ | catalog.php, index.php | "Срок службы 50+ лет" | catalog.php, sertificate.php |
| /blog/fibrocement-vs-keramogranit/ | catalog.php, index.php | "Сравнение с керамогранитом" | catalog.php, contacts.php |
| /catalog/negoryuchie/ | catalog.php, index.php | "Негорючие панели НГ" | catalog.php, sertificate.php |
| /uslugi/montazh/ | kreplenie.php, contacts.php | "Монтаж под ключ" | kreplenie.php, contacts.php |

---

## 10. Navigation Architecture Changes Checklist

### Немедленные (реализовать сейчас)

- [ ] **catalog.php** — добавить блок "Смотрите также" после каждой серии (→ другие серии)
- [ ] **catalog.php** — добавить sequential nav стрелки между секциями
- [ ] **catalog.php** — добавить CTA "Заказать образцы" после #palette → contacts.php
- [ ] **catalog.php** — добавить ссылку "Способы крепления" после #characteristics → kreplenie.php
- [ ] **Все страницы** — добавить визуальные breadcrumbs (HTML `<nav class="breadcrumb">`)
- [ ] **footer.php** — добавить ссылку "Карта сайта" → /blp/sitemap.xml
- [ ] **footer.php** — добавить "Заказать образцы" → contacts.php в колонке Каталог
- [ ] **footer.php** — добавить "Технические характеристики" → catalog.php#characteristics

### Среднесрочные (при создании новых страниц)

- [ ] **sertificate.php** — добавить ссылку на будущий /blog/k0-klass/ как "Подробнее о классе К0"
- [ ] **kreplenie.php** — добавить ссылку на /blog/krepleniye-fibrocementa/ как "Пошаговая инструкция монтажа"
- [ ] **index.php** — добавить в hero тег "НГ (негорючие)" как ссылку → sertificate.php
- [ ] **projects.php** — добавить тег серии панелей к каждому проекту со ссылкой → catalog.php#[series]
- [ ] **architect.php** — добавить ссылку "образцы фиброцементных плит" → contacts.php с UTM

### Долгосрочные (блог + программный SEO)

- [ ] Создать `/blog/` hub-page с ссылками на все статьи → обратные ссылки из catalog, index
- [ ] Добавить "Related Articles" виджет на страницах sertificate, kreplenie
- [ ] Реализовать "Related Projects" блок на catalog.php → projects.php (2–3 кейса)
- [ ] Добавить "Project Filter by Series" на projects.php → catalog.php#[series] anchors

---

## 11. Priority Implementation Order

| Priority | Action | Impact | Effort |
|----------|--------|--------|--------|
| 🔴 P1 | Визуальные breadcrumbs на всех страницах | High (UX + SEO) | Low |
| 🔴 P1 | CTA "Заказать образцы" после #palette в catalog | High (Conversion) | Low |
| 🔴 P1 | Ссылка sertificate.php → catalog.php и обратно | High (Authority flow) | Low |
| 🟡 P2 | Sequential nav в catalog.php | Medium (Engagement) | Low |
| 🟡 P2 | "Смотрите также" блок между сериями | Medium (PageRank) | Low |
| 🟡 P2 | Footer: sitemap.xml + "Заказать образцы" | Medium (Crawlability) | Low |
| 🟢 P3 | Контекстные ссылки audience→product в architect/devops/diler | Medium (Topical) | Medium |
| 🟢 P3 | projects.php → catalog.php#[series] per project | Low-Medium | Medium |

---

**Cross-references:**
- keyword-research.md (Tier-1 anchors, cluster mapping)
- schema-implementation.md (BreadcrumbList schema — уже реализована)
- sitemap.xml (все страницы для footer link)
- GLOBAL_PLAN.md Stage 3 Group 3.D

**Author:** Stage 3 Group 3.D — Internal Linking & Navigation Architecture
**Version:** 1.0
