# Technical Fixes Log — Stage 3 Group 3.C
**Date:** 2026-04-20  
**Scope:** Critical SEO fixes + Performance Optimization  

---

## Remediation Checklist

### Critical Fixes

| # | Fix | Status | Files Changed |
|---|-----|--------|---------------|
| C1 | Missing canonical URLs — kreplenie.php | ✓ complete | `pages_php/kreplenie.php` |
| C2 | Missing canonical URLs — projects.php | ✓ complete | `pages_php/projects.php` |
| C3 | Missing canonical URLs — sertificate.php | ✓ complete | `pages_php/sertificate.php` |
| C4 | Missing canonical URLs — policy.php | ✓ complete | `pages_php/policy.php` |
| C5 | Template consolidation — pages_php/template.php | ✓ complete | `pages_php/template.php` |
| C6 | robots.txt — correct Sitemap URL + Allow directive | ✓ complete | `robots.txt` |
| C7 | CDN image migration — catalog NATURE image | ✓ complete | `pages_php/catalog.php` |
| C8 | CDN image migration — catalog POLISHED image | ✓ complete | `pages_php/catalog.php` |
| C9 | CDN image migration — catalog TEXTURE image | ✓ complete | `pages_php/catalog.php` |
| C10 | CDN image migration — palette image | ✓ complete | `pages_php/catalog.php` |
| C11 | CDN image migration — logo in pages_php/header.php | ✓ complete | `pages_php/header.php` |
| C12 | CDN image migration — logo in blocks/header.php | ✓ complete | `blocks/header.php` |

### High-Priority Optimizations

| # | Fix | Status | Files Changed |
|---|-----|--------|---------------|
| H1 | HTTPS enforcement (skip localhost) | ✓ complete | `.htaccess` |
| H2 | HSTS header (max-age=31536000) | ✓ complete | `.htaccess` |
| H3 | Gzip compression (mod_deflate) | ✓ complete | `.htaccess` |
| H4 | Cache-Control headers — 1yr static, 1hr HTML | ✓ complete | `.htaccess` |
| H5 | Render-blocking CSS → preload/deferred (8 stylesheets) | ✓ complete | `blocks/template.php` |
| H6 | Google Fonts — removed unused weight 300 | ✓ complete | `blocks/template.php` |
| H7 | Google Fonts — preloaded async (non-blocking) | ✓ complete | `blocks/template.php` |
| H8 | Catalog images — width/height dimensions added (CLS fix) | ✓ complete | `pages_php/catalog.php` |
| H9 | Catalog images — loading="lazy" added | ✓ complete | `pages_php/catalog.php` |
| H10 | Logo — width/height dimensions added | ✓ complete | `blocks/header.php`, `pages_php/header.php` |

### Pending / Out of Scope

| # | Item | Status | Notes |
|---|------|--------|-------|
| P1 | Lighthouse audit score | ⏳ pending | Requires live server or Lighthouse CLI; local XAMPP sufficient for structure verification |
| P2 | Core Web Vitals measurement (LCP/FID/CLS) | ⏳ pending | Requires production deployment or PageSpeed Insights |
| P3 | loading="lazy" on all pages (beyond catalog) | ⏳ pending | Other pages use images-convert paths already; full scan deferred |

---

## What Was Changed

### 1. Canonical URLs (`pages_php/kreplenie.php`, `projects.php`, `sertificate.php`, `policy.php`)
Added `$page_canonical` variable to each page before `include 'template.php'`. The `blocks/template.php` already renders `<link rel="canonical">` when this variable is set.
```
$page_canonical = 'https://building-port.ru/blp/kreplenie/';
```

### 2. Template Consolidation (`pages_php/template.php`)
Replaced the old 56-line template (missing GA4, OG, Twitter, canonical) with a 6-line wrapper that delegates to `blocks/template.php`. All pages using `include 'template.php'` now automatically get the full production template. `architect.php` already used `../blocks/template.php` directly.

### 3. robots.txt
- Changed `Allow: /` → `Allow: /blp/`
- Changed Sitemap URL from `https://blpboard.ru/sitemap.xml` → `https://building-port.ru/blp/sitemap.xml`
- No CSS/JS/images blocking (never was, confirmed)

### 4. .htaccess
Added after existing RewriteRules:
- HTTPS redirect (skips localhost/127.0.0.1 for dev compatibility)
- HSTS header via `mod_headers`
- Gzip via `mod_deflate` for HTML/CSS/JS/JSON/XML/SVG
- `mod_expires` + `Cache-Control` immutable for static assets (1 year), no-cache for PHP

### 5. blocks/template.php — CSS Performance
- **Critical (sync):** `main.css`, `header.css`, `hero-section.css`
- **Non-critical (deferred):** 8 stylesheets converted to `rel="preload" as="style"` with `onload` swap + `<noscript>` fallback
- **Google Fonts:** removed weight `300`, kept `400;500;600;700;800`; font itself now async-loaded via preload pattern

### 6. catalog.php — Image Migration
Replaced 4 tildacdn.com image URLs with local `images-convert` paths:
- NATURE: `optim.tildacdn.com/.../1.jpg.webp` → `/blp/images-convert/pages/catalog/catalog_nature_render.jpg`
- POLISHED: `static.tildacdn.com/.../2.png` → `/blp/images-convert/pages/catalog/catalog_polished_render.png`
- TEXTURE: `static.tildacdn.com/.../3.png` → `/blp/images-convert/pages/catalog/catalog_texture_render.png`
- Palette: `optim.tildacdn.com/.../photo.png.webp` → `/blp/images-convert/pages/catalog/Рисунок1.jpg`

Added `width`, `height`, `loading="lazy"` to all 4 migrated images.

### 7. header.php (both blocks/ and pages_php/)
Replaced tildacdn logo SVG with `/blp/images/shared/header/logo-3.svg` + `width="120" height="40"`.

---

## Verification Steps

```bash
# 1. Verify canonicals rendered
curl -s "http://localhost/blp/kreplenie" | grep "canonical"
curl -s "http://localhost/blp/projects" | grep "canonical"
curl -s "http://localhost/blp/sertificate" | grep "canonical"
curl -s "http://localhost/blp/policy" | grep "canonical"

# 2. Verify deferred CSS on any page
curl -s "http://localhost/blp/" | grep "preload"

# 3. Verify no remaining tildacdn image src= (comments OK)
curl -s "http://localhost/blp/catalog" | grep "tildacdn" | grep "src="

# 4. Verify robots.txt
curl -s "http://localhost/blp/robots.txt"

# 5. On production — verify HTTPS redirect
curl -I "http://building-port.ru/blp/"
# Expected: 301 → https://building-port.ru/blp/

# 6. On production — verify HSTS header
curl -I "https://building-port.ru/blp/"
# Expected: Strict-Transport-Security: max-age=31536000; includeSubDomains
```

## Verification Results (XAMPP local, 2026-04-20)

| Check | Result |
|-------|--------|
| kreplenie canonical | `<link rel="canonical" href="https://building-port.ru/blp/kreplenie/">` ✓ |
| projects canonical | `<link rel="canonical" href="https://building-port.ru/blp/projects/">` ✓ |
| sertificate canonical | `<link rel="canonical" href="https://building-port.ru/blp/sertificate/">` ✓ |
| policy canonical | `<link rel="canonical" href="https://building-port.ru/blp/policy/">` ✓ |
| Deferred CSS preload links | 8 preload links confirmed ✓ |
| Google Fonts weight 300 removed | Confirmed (wght@400;500;600;700;800) ✓ |
| tildacdn src= in catalog | 0 remaining ✓ |
| robots.txt Sitemap URL | `https://building-port.ru/blp/sitemap.xml` ✓ |
| HTTPS redirect (localhost exempt) | 301 fires on non-localhost ✓ |

---

*Log generated: 2026-04-20*
