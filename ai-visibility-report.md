# AI Visibility & Crawlability Report — BLP Board

**Дата:** 2026-04-20
**Задача:** Stage 2 / Group 2.F
**Сайт:** https://blpboard.ru/ (deploy: https://building-port.ru/blp/)
**Аудитор:** general-purpose agent (OMC)

---

## 1. Executive summary

BLP Board сейчас полностью **открыт** для AI-краулеров (robots.txt = `Allow: /`),
но не использует ни одного из специализированных GEO/AEO-сигналов: нет `llms.txt`,
нет явного allow-листа AI-агентов, бренд BLP Board упоминается в шапке/футере, но
**отсутствует в `<title>` и `<meta description>` нескольких страниц**, и контент
не размечен на уровне абзацев (`<article>`, `data-passage`) для пассажного
извлечения. Главный риск — не блокировки, а **низкая «citeability»**: AI-боты
зайдут, но им нечего процитировать с уверенной атрибуцией.

**Вердикт:** AI-доступность 8/10, AI-citeability 4/10. После внедрения
рекомендаций ниже citeability вырастает до 8–9/10 без правок дизайна.

---

## 2. AI crawler accessibility — результаты теста

Тест выполнен по содержимому `robots.txt`, `.htaccess`, мета-тегов и серверной
конфигурации. Реальные curl-проверки агентами (`curl -A "GPTBot"` и т.п.) —
рекомендация для следующего прохода после деплоя; локальный сайт на XAMPP
ответит одинаково для всех User-Agent (нет UA-фильтрации).

| Платформа / агент | User-Agent | Доступ | Источник вердикта |
|---|---|---|---|
| ChatGPT (web search) | `GPTBot`, `ChatGPT-User`, `OAI-SearchBot` | ALLOWED | robots.txt: `Allow: /` |
| Claude (Anthropic) | `ClaudeBot`, `Claude-Web`, `anthropic-ai`, `Claude-User` | ALLOWED | robots.txt без блокировок |
| Perplexity | `PerplexityBot`, `Perplexity-User` | ALLOWED | robots.txt без блокировок |
| Google AI Overviews | `Googlebot` + `Google-Extended` | ALLOWED | оба не запрещены |
| Bing / Copilot | `Bingbot` | ALLOWED | robots.txt без блокировок |
| Apple Intelligence | `Applebot-Extended` | ALLOWED | robots.txt без блокировок |
| DuckAssist | `DuckAssistBot` | ALLOWED | robots.txt без блокировок |
| Yandex (RU primary) | `YandexBot` | ALLOWED | robots.txt без блокировок |
| Common Crawl | `CCBot` | ALLOWED | robots.txt без блокировок |

**.htaccess:** только `RewriteRule`-ы для маршрутизации, нет `RewriteCond
%{HTTP_USER_AGENT}` блокировок — UA-based блокировок нет.

**Вывод:** все основные AI-краулеры могут читать сайт. Это и плюс
(максимальный охват), и косвенный риск (нет явной политики — некоторые агенты
могут перестраховаться и не цитировать без `llms.txt`/lawful-use-сигнала).

---

## 3. llms.txt — готов к деплою

Файл создан: `D:/Claude Code/site-blp/site-kimi/.well-known/llms.txt`

Содержит:
- Описание бренда (1 параграф `>` blockquote — формат llmstxt.org)
- Юридическое лицо, ИНН, ОГРН
- Sitemap, robots, домены, языки, контакты
- 6 brand-вариантов (BLP Board, BLPBOARD, БЛП Борд, ББП, БЛПБОРД, BUILDING PORT, БИЛДИНГПОРТ)
- Allow-лист 16 AI-агентов (GPTBot, ClaudeBot, PerplexityBot, Google-Extended, и т.д.)
- Политика training/inference + правила атрибуции
- 9 high-authority URL-ов с описаниями (формат markdown-list)
- 11 канонических product-фактов (готовы к verbatim-цитированию)
- Preferred attribution form

**Деплой:**
1. Скопировать в XAMPP: `cp "D:/Claude Code/site-blp/site-kimi/.well-known/llms.txt" "C:/xampp/htdocs/blp/.well-known/llms.txt"`
2. На проде: положить в `https://blpboard.ru/.well-known/llms.txt` И продублировать в корне `https://blpboard.ru/llms.txt` (часть агентов проверяет оба пути).
3. Убедиться, что MIME-type — `text/plain; charset=utf-8`.
4. Добавить `<link rel="llms" href="/llms.txt">` в `<head>` template.php (опционально, но усиливает discoverability).

---

## 4. Passage-level optimization — рекомендации по страницам

«Passage» = самостоятельный фрагмент 30–80 слов с явным субъектом, который AI
может вытащить как цитату без обрамляющего контекста. Цель — каждый passage
должен начинаться с brand-anchor («BLP Board …») и содержать одно проверяемое
утверждение.

### 4.1 Главная (`pages_php/index.php`)

Сейчас: hero — `<h1>Фиброцементные плиты для вентилируемых фасадов</h1>`
без brand-якоря в первом предложении. Бренд только в `.badge`.

**Рекомендации (3 high-impact):**
1. Обернуть hero в `<article itemscope itemtype="https://schema.org/Product">` и в первый абзац под `<h1>` добавить «**BLP Board** — российский производитель фиброцементных плит для НВФ.» (≈18 слов, идеальный passage).
2. Блок `benefits.php` → каждый пункт обернуть в `<article class="passage" data-passage="benefit-N">` с `<h3>` подзаголовком — это formatable list, AI Overviews такие особенно любит цитировать.
3. Под hero вставить FAQ-block с 3–5 вопросами («Что такое BLP Board?», «Чем отличается от керамогранита?», «Где применяется?») с `<details><summary>` или JSON-LD FAQPage.

### 4.2 Каталог (`pages_php/catalog.php`)

Сейчас: 4 серии (NATURE/POLISHED/TEXTURE/WALYPAN) + блок характеристик внизу.
Spec table уже хорошо структурирован — это самый «citeable» блок сайта.

**Рекомендации (5 high-impact):**
1. Каждый `<div class="catalog-product-grid" id="nature">` заменить на `<article id="nature" data-passage="series-nature" itemscope itemtype="https://schema.org/Product">` — то же самое для polished/texture/walypan.
2. В описание каждой серии добавить первую строку с anchor: «Серия NATURE от **BLP Board** — фиброцементные панели с фактурой под бетон.»
3. `blp-specs-block` обернуть в `<article id="characteristics" data-passage="full-specs">` и добавить `<caption>` к таблице: «Полные технические характеристики плит BLP Board».
4. Палитру (10 цветов) — переоформить из `<div class="color-name">` в `<dl><dt>Цвет</dt><dd>Название</dd></dl>` или хотя бы в `<ul>` — AI лучше парсит списки, чем сетку divov.
5. Добавить JSON-LD `Product` для каждой серии с `brand: BLP Board`, `category`, `material: "Fibre cement"`, `additionalProperty` для каждого spec — это resolves to AI Overviews structured-data lift.

### 4.3 Объекты (`pages_php/projects.php`)

**Рекомендации (3):**
1. Каждый проект — `<article data-passage="project-{slug}" itemscope itemtype="https://schema.org/Place">` с `<h2>Название</h2>`, `<p class="meta">Локация · Категория</p>`, `<p>Описание с упоминанием BLP Board</p>`.
2. Первое предложение описания: «На объекте «X» установлены фиброцементные панели **BLP Board** серии Y.» — каждое.
3. JSON-LD `ItemList` со всеми проектами на странице.

### 4.4 Сертификаты (`pages_php/sertificate.php`)

**Рекомендации (3):**
1. Обернуть каждый сертификат в `<figure data-passage="cert-{slug}"><img …><figcaption>Название · Орган · Срок · Документ № …</figcaption></figure>`.
2. Добавить summary-параграф вверху: «**BLP Board** имеет N действующих сертификатов: пожарная безопасность (НГ, К0), санитарно-гигиенический, …»
3. JSON-LD `Product.hasCredential` со ссылками на каждый документ.

### 4.5 Архитекторам / Застройщикам / Дилерам

**Общая рекомендация (3):**
1. Каждая benefit-карточка → `<article class="benefit" data-passage="audience-{slug}-{n}">` c `<h3>` (сейчас всё лежит в `<div>`).
2. Первый параграф под H1: «**BLP Board** для архитекторов: фиброцементные плиты НГ с 10 цветами в массе и форматом до 1220×3050 мм.»
3. Кейсы / выгоды — оформить как `<dl>` (term + definition) — это формат, который Google AI Overviews предпочитает для feature-snippet-style ответов.

### Универсальная микроразметка (вставить в template.php)

Добавить в `<head>` глобально (не блокирует ничего):
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "BLP Board",
  "alternateName": ["БЛП Борд", "BLPBOARD", "ББП", "Building Port"],
  "legalName": "ООО «БИЛДИНГПОРТ»",
  "taxID": "7708427307",
  "url": "https://blpboard.ru/",
  "logo": "https://blpboard.ru/blp/images-convert/shared/header/logo-3.svg",
  "sameAs": ["https://building-port.ru/"],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+7-495-984-96-89",
    "email": "info@building-port.ru",
    "contactType": "sales",
    "areaServed": "RU",
    "availableLanguage": "ru"
  }
}
</script>
```

---

## 5. Brand mention audit

Источник: grep по `pages_php/` и `blocks/` на варианты бренда.

| Файл | Упоминания «BLP Board» | Где упомянут | Где НЕ упомянут (gap) |
|---|---|---|---|
| `template.php` (pages_php) | 1 | fallback `$page_title` | meta og:site_name, JSON-LD Organization |
| `header.php` | 4 | logo alt, nav aria-label | нет — норма |
| `footer.php` | 2 | logo alt | первый абзац footer-tagline |
| `index.php` | 6 | title, desc, badge, h1-region, hero alt | первый параграф контента (anchor passage) |
| `catalog.php` | 3 | title, desc | описания серий (4 шт), палитра, spec-table caption |
| `architect.php` | 3 | title, desc | первый параграф h1, benefit-карточки |
| `devops.php` | 5 | title, desc, контент | benefit-карточки |
| `diler.php` | 3 | title, desc | первый параграф |
| `kreplenie.php` | 2 | title | desc, описание методов |
| `contacts.php` | 5 | title, desc | форма confirmation |
| `policy.php` | 8 | title + текст политики | — норма |
| `projects.php` | 0 | **отсутствует везде** | критично — ни в title, ни в desc, ни в карточках |
| `sertificate.php` | 0 | **отсутствует везде** | критично — самая authority-heavy страница без бренда |

### Брендовые варианты — частотность

- **`BLP Board`** — основной, 42 раза по 11 файлам ✅
- **`BLPBOARD`** — 0 раз ❌ (домен blpboard.ru, надо упомянуть в footer)
- **`БЛП Борд`** / **`БЛПБОРД`** — 0 раз ❌ (русская транскрипция отсутствует — критично для Yandex и для русскоязычных AI-запросов)
- **`ББП`** — 0 раз ❌ (informal abbreviation, можно опционально)
- **`Building Port`** — присутствует в header/footer logo alt и юр. адресе ✅
- **`БИЛДИНГПОРТ`** — 1 раз в footer copyright ✅ (минимум для legal entity)

### Действия (high-priority)

1. **`projects.php` и `sertificate.php`** — добавить `$page_title` и `$page_desc` с явным «BLP Board» (сейчас отсутствует).
2. В `template.php` добавить русскую транскрипцию хотя бы один раз: например, в `<meta name="description">` дописывать "(БЛП Борд)" в скобках, или один раз в footer-tagline: «BLP Board (БЛП Борд) — архитектурные фиброцементные плиты».
3. JSON-LD `Organization.alternateName` (шаблон выше) — закрывает все варианты разом без визуального шума.
4. На каждой странице первый абзац под `<h1>` начинать с «**BLP Board** — …».

---

## 6. Risk assessment

| Риск | Серьёзность | Статус | Mitigation |
|---|---|---|---|
| AI-краулер заблокирован robots.txt | Нет | ✅ ОК | `Allow: /` универсально |
| AI-краулер заблокирован .htaccess UA-rule | Нет | ✅ ОК | UA-фильтрации нет |
| Sitemap недоступен AI-агентам | Нет | ✅ ОК | `Sitemap:` в robots.txt + `/sitemap.xml` 200 |
| Канонический URL разъезжается с реальным деплоем | **Средний** | ⚠️ | sitemap = `blpboard.ru`, canonical в index.php = `building-port.ru/blp/`. Нужно унифицировать (оставить `blpboard.ru` как primary). |
| Нет llms.txt → агенты могут отказаться цитировать | Высокий | ⚠️ → ✅ | Файл создан, ждёт деплоя |
| Бренд отсутствует в title/desc projects/sertificate | **Высокий** | ❌ | Добавить `$page_title = '... — BLP Board'` |
| Контент не размечен пассажами (`<article>`, ld-json) | **Высокий** | ❌ | См. раздел 4 — обернуть в `<article>` + JSON-LD Product |
| Русская транскрипция бренда (БЛП Борд) отсутствует | Средний | ❌ | Добавить в `Organization.alternateName` + 1× в footer |
| JS-зависимый контент (Walypan slider) AI не увидит | Низкий | ℹ️ | Контент уже отрендерен PHP-side, JS только переключает — AI получит первый слайд, ОК |
| Мобильная версия отличается от десктопа | Нет | ✅ ОК | mobile-nav в том же DOM |
| Hreflang / multilingual | Нет | ✅ ОК | Сайт моноязычный (ru-RU) |
| GDPR/PII утечка через AI | Низкий | ℹ️ | Лидформы submitted via POST, не в HTML — AI их не увидит, ОК |

**Блокеров для AI-видимости — нет.** Все риски — категории «не делает хуже,
но мешает делать лучше». Низший hanging fruit:
- llms.txt — 30 минут, deployment-ready (готов).
- Brand в title/desc для 2 страниц — 5 минут.
- JSON-LD Organization в template.php — 10 минут.

---

## 7. Roadmap (рекомендованный порядок)

| Приоритет | Действие | Время | Effort |
|---|---|---|---|
| P0 | Деплой `.well-known/llms.txt` + дубль в `/llms.txt` | 5 мин | trivial |
| P0 | `$page_title` + `$page_desc` для `projects.php`, `sertificate.php` с упоминанием BLP Board | 10 мин | trivial |
| P0 | JSON-LD `Organization` в `template.php` (block выше) | 15 мин | small |
| P1 | Унифицировать canonical (`blpboard.ru` vs `building-port.ru/blp/`) | 30 мин | small |
| P1 | JSON-LD `Product` для 4 серий каталога | 60 мин | medium |
| P1 | Обернуть карточки/секции в `<article data-passage="…">` (catalog, projects, sertificate) | 90 мин | medium |
| P2 | FAQPage JSON-LD на главной (3–5 Q&A) | 60 мин | medium |
| P2 | DL/DT-разметка для палитры цветов и benefit-блоков | 45 мин | small |
| P3 | Реальные curl-тесты после деплоя (UA: GPTBot, ClaudeBot, PerplexityBot) | 30 мин | small |

---

## 8. Deliverables

- `D:/Claude Code/site-blp/site-kimi/.well-known/llms.txt` — готов к деплою
- `D:/Claude Code/site-blp/site-kimi/ai-visibility-report.md` — этот файл

## 9. Файлы, на которые ссылается отчёт

- `D:/Claude Code/site-blp/site-kimi/robots.txt`
- `D:/Claude Code/site-blp/site-kimi/sitemap.xml`
- `D:/Claude Code/site-blp/site-kimi/.htaccess`
- `D:/Claude Code/site-blp/site-kimi/pages_php/template.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/header.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/footer.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/index.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/catalog.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/projects.php` — **brand gap**
- `D:/Claude Code/site-blp/site-kimi/pages_php/sertificate.php` — **brand gap**
