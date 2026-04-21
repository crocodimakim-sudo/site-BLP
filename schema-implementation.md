# Schema Markup Implementation Report — BLP Board
**Date:** 2026-04-20  
**Site:** https://building-port.ru/blp/  
**Validator targets:** Google Rich Results Test, Schema.org Validator

---

## 1. Audit Results — Current State (Before Implementation)

| Check | Result |
|-------|--------|
| JSON-LD blocks found | ❌ None |
| Microdata (itemscope/itemprop) | ❌ None |
| RDFa | ❌ None |
| Organization schema | ❌ Missing |
| Product schema | ❌ Missing |
| BreadcrumbList | ❌ Missing |
| LocalBusiness | ❌ Missing |
| WebSite / WebPage | ❌ Missing |

**Conclusion:** Zero structured data existed before this task. All schemas were built from scratch.

---

## 2. Implementation Summary

### Files Created

| File | Schema Type | Scope |
|------|-------------|-------|
| `pages_php/schema_organization.php` | Organization + WebSite | Global (all pages via template.php) |
| `pages_php/schema_webpage.php` | WebPage | Global, dynamic per-page |
| `pages_php/schema_breadcrumbs.php` | BreadcrumbList | Global, dynamic per-page |
| `pages_php/schema_localbusiness.php` | LocalBusiness | contacts.php only |
| `pages_php/schema_products.php` | ProductGroup + 4× Product | catalog.php only |

### Files Modified

| File | Change |
|------|--------|
| `pages_php/template.php` | Injects organization + webpage + breadcrumb schemas in `<head>` |
| `pages_php/index.php` | Added `$breadcrumbs` array |
| `pages_php/catalog.php` | Added `$breadcrumbs` + includes `schema_products.php` |
| `pages_php/contacts.php` | Added `$breadcrumbs` + includes `schema_localbusiness.php` |
| `pages_php/projects.php` | Added `$breadcrumbs` |
| `pages_php/architect.php` | Added `$breadcrumbs` |
| `pages_php/devops.php` | Added `$breadcrumbs` |
| `pages_php/diler.php` | Added `$breadcrumbs` |
| `pages_php/kreplenie.php` | Added `$breadcrumbs` |
| `pages_php/sertificate.php` | Added `$breadcrumbs` |

### Validation (live XAMPP)

| Page | `application/ld+json` blocks | Status |
|------|------------------------------|--------|
| `/blp/` (index) | 3 | ✅ Organization + WebSite + WebPage + BreadcrumbList |
| `/blp/catalog` | 4 | ✅ + ProductGroup/Products |
| `/blp/contacts` | 4 | ✅ + LocalBusiness |

---

## 3. Schema Type Decision Log

| Type | Decision | Reason |
|------|----------|--------|
| Organization | ✅ Implemented | Required for brand identity signals |
| WebSite + SearchAction | ✅ Implemented | Enables sitelinks searchbox in Google |
| WebPage | ✅ Implemented | Per-page context for crawlers |
| BreadcrumbList | ✅ Implemented on all 9 pages | Rich breadcrumb display in SERPs |
| Product / ProductGroup | ✅ Implemented (catalog) | Product rich results for all 4 series |
| LocalBusiness | ✅ Implemented (contacts) | Maps / local pack eligibility |
| FAQPage | ❌ Skipped | Restricted to gov/healthcare sites since Aug 2023 |
| HowTo | ❌ Skipped | Deprecated Sep 2023 |
| NewsArticle / BlogPosting | ❌ Skipped | No blog/news section on site |
| AggregateRating | ⏳ Deferred | No review data available — add when reviews collected |

---

## 4. JSON-LD Snippets (Copy-Paste Ready)

### 4.1 Organization + WebSite (global — auto-injected by template.php)

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://building-port.ru/blp/#organization",
      "name": "BLP Board",
      "legalName": "ООО «БИЛДИНГПОРТ»",
      "url": "https://building-port.ru/blp/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://building-port.ru/blp/images-convert/shared/header/logo-3.svg",
        "width": 200,
        "height": 60
      },
      "description": "Производитель и поставщик фиброцементных панелей для вентилируемых фасадов.",
      "telephone": "+74959849689",
      "email": "info@building-port.ru",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Неделина, 6А",
        "addressLocality": "Одинцово",
        "addressRegion": "Московская область",
        "addressCountry": "RU"
      },
      "taxID": "7708427307"
    },
    {
      "@type": "WebSite",
      "@id": "https://building-port.ru/blp/#website",
      "url": "https://building-port.ru/blp/",
      "name": "BLP Board — Фиброцементные панели",
      "publisher": { "@id": "https://building-port.ru/blp/#organization" },
      "inLanguage": "ru-RU",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://building-port.ru/blp/catalog?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
```

### 4.2 BreadcrumbList (dynamic — example for catalog page)

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Главная",  "item": "https://building-port.ru/blp/" },
    { "@type": "ListItem", "position": 2, "name": "Каталог",  "item": "https://building-port.ru/blp/catalog" }
  ]
}
```

### 4.3 Product — серия NATURE (example, full set in schema_products.php)

```json
{
  "@context": "https://schema.org",
  "@type": "Product",
  "@id": "https://building-port.ru/blp/catalog#nature",
  "name": "Фиброцементные панели BLP Board — серия NATURE",
  "description": "Натуральные фиброцементные панели с фактурой под бетон.",
  "image": "https://building-port.ru/blp/images-convert/pages/catalog/1.jpg",
  "brand": { "@type": "Brand", "name": "BLP Board" },
  "material": "Фиброцемент",
  "additionalProperty": [
    { "@type": "PropertyValue", "name": "Толщина", "value": "8, 9, 10, 12, 15 мм" },
    { "@type": "PropertyValue", "name": "Класс горючести", "value": "НГ (Негорючий)" },
    { "@type": "PropertyValue", "name": "Содержание асбеста", "value": "0%" }
  ],
  "offers": {
    "@type": "Offer",
    "priceCurrency": "RUB",
    "availability": "https://schema.org/InStock",
    "url": "https://building-port.ru/blp/contacts"
  }
}
```

### 4.4 LocalBusiness (contacts page)

```json
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "BLP Board",
  "legalName": "ООО «БИЛДИНГПОРТ»",
  "telephone": "+74959849689",
  "email": "info@building-port.ru",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "ул. Неделина, 6А",
    "addressLocality": "Одинцово",
    "addressRegion": "Московская область",
    "postalCode": "143006",
    "addressCountry": "RU"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
      "opens": "09:00",
      "closes": "18:00"
    }
  ]
}
```

---

## 5. Per-Page Implementation Checklist

| Page | Organization | WebPage | BreadcrumbList | Page-specific |
|------|:---:|:---:|:---:|:---:|
| `/blp/` (index) | ✅ | ✅ | ✅ | — |
| `/blp/catalog` | ✅ | ✅ | ✅ | ✅ ProductGroup + 4× Product |
| `/blp/contacts` | ✅ | ✅ | ✅ | ✅ LocalBusiness |
| `/blp/projects` | ✅ | ✅ | ✅ | — |
| `/blp/architect` | ✅ | ✅ | ✅ | — |
| `/blp/devops` | ✅ | ✅ | ✅ | — |
| `/blp/diler` | ✅ | ✅ | ✅ | — |
| `/blp/kreplenie` | ✅ | ✅ | ✅ | — |
| `/blp/sertificate` | ✅ | ✅ | ✅ | — |

---

## 6. How to Validate

### Google Rich Results Test
1. Go to https://search.google.com/test/rich-results
2. Enter URL (or paste HTML source for localhost)
3. Expected detections: **Breadcrumbs**, **Product** (catalog), **Local Business** (contacts)

### Schema.org Validator
1. Go to https://validator.schema.org/
2. Paste JSON-LD snippets from section 4
3. All items should show green with no critical errors

### Manual check (localhost)
```bash
curl -s "http://localhost/blp/"          | grep -c "application/ld+json"  # expect 3
curl -s "http://localhost/blp/catalog"   | grep -c "application/ld+json"  # expect 4
curl -s "http://localhost/blp/contacts"  | grep -c "application/ld+json"  # expect 4
```

**Verified results:**
- `/blp/` → 3 blocks ✅
- `/blp/catalog` → 4 blocks ✅
- `/blp/contacts` → 4 blocks ✅

---

## 7. Common Errors to Avoid

| Error | Description | Fix |
|-------|-------------|-----|
| Relative URLs in `image`, `url`, `item` | Schema validators reject relative paths | Always use `https://building-port.ru/blp/...` |
| Missing `@context` | Entire schema ignored by parsers | Always include `"@context": "https://schema.org"` |
| Using FAQPage | Restricted since Aug 2023 to gov/healthcare | Do not use — no rich result benefit for B2B sites |
| Using HowTo | Deprecated Sep 2023 | Do not use |
| `price` without `priceCurrency` | Google flags as invalid Offer | Always pair both fields, or omit price if unknown |
| `AggregateRating` with no real reviews | Google may penalise fabricated ratings | Only add when genuine user reviews exist |
| Schema injected only via JS | Per Google Dec 2025 guidance, JS-injected schema may face delayed indexing | All schemas here are server-rendered PHP — correct |
| Duplicate `@id` across pages | Causes graph conflicts | Each page uses unique `#webpage` ID via `$page_canonical` |

---

## 8. Future Enhancements

| Enhancement | When | Schema Type |
|-------------|------|-------------|
| Add `AggregateRating` to Products | When reviews collected | Product > aggregateRating |
| Add `ItemList` for Projects page | When project data is structured in JS | ItemList |
| Add `Service` schema for architect/devops/diler pages | Next SEO pass | Service |
| Add `geo` coordinates to LocalBusiness | Confirm exact lat/lng | LocalBusiness > GeoCoordinates |
| Add `openingHours` to Organization | Confirm working hours | Organization |
| Implement hreflang if EN version added | When EN version goes live | — (meta tag, not schema) |

---

*Generated: 2026-04-20 | Task #8 Stage 2 Group 2.D*
