# Launch Readiness Report — BLP Board
<!-- 2026-04-20: Task #16 Stage 3 Group 3.E — Pre-launch verification & Go/No-Go assessment -->

**Site:** https://building-port.ru/blp/  
**Date:** 2026-04-20  
**Assessed by:** Stage 3 Group 3.E audit pass  
**Status legend:** ✅ Pass · ❌ Fail · ⚠️ Partial / Action required · 🔲 Requires live environment

---

## 1. Pre-Launch Checklist

### 1.1 DNS & CDN

| Check | Status | Notes |
|-------|--------|-------|
| `building-port.ru/blp/` resolves to correct server | 🔲 | Requires live DNS check: `nslookup building-port.ru` |
| CDN caches static assets (css/, js/, images-convert/) | 🔲 | Verify via `curl -I` — look for `X-Cache: HIT` or CDN headers |
| TTL for static assets ≥ 7 days | ⚠️ | `.htaccess` has no `mod_expires` / `Cache-Control` headers — **must add before launch** |
| TTL for HTML pages ≤ 1 hour | ⚠️ | Same — no caching headers configured in current `.htaccess` |
| No Tilda CDN dependencies on critical paths | ❌ | `pages_php/header.php:4` loads logo from `static.tildacdn.com`. `catalog.php` loads 5+ images from `optim.tildacdn.com` — external single points of failure |

**Required fix before launch:**
```apache
# Add to .htaccess
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType text/css "access plus 30 days"
  ExpiresByType application/javascript "access plus 30 days"
  ExpiresByType image/webp "access plus 90 days"
  ExpiresByType image/jpeg "access plus 90 days"
  ExpiresByType image/png "access plus 90 days"
  ExpiresByType image/svg+xml "access plus 90 days"
  ExpiresByType text/html "access plus 1 hour"
</IfModule>
```

---

### 1.2 SSL/HTTPS

| Check | Status | Notes |
|-------|--------|-------|
| SSL certificate valid for `building-port.ru` | 🔲 | Verify: `curl -vI https://building-port.ru/blp/` — check `SSL certificate verify ok` |
| Certificate expiry > 30 days | 🔲 | Check via: `openssl s_client -connect building-port.ru:443 2>/dev/null \| openssl x509 -noout -dates` |
| All pages served over HTTPS | 🔲 | Requires live server check |
| HTTP → HTTPS redirect active | ❌ | Current `.htaccess` has **no HTTP→HTTPS redirect rule** — critical gap |
| Mixed content warnings absent | ❌ | External Tilda CDN references use `https://` — OK if TLS, but logo/images from tildacdn create mixed-content risk if any resource served over HTTP |
| HSTS header present | ❌ | No `Strict-Transport-Security` header in `.htaccess` |

**Required fix before launch:**
```apache
# Add to .htaccess (before RewriteEngine rules)
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
```

---

### 1.3 robots.txt & sitemap.xml

| Check | Status | Notes |
|-------|--------|-------|
| `robots.txt` accessible at `/robots.txt` | ⚠️ | File exists locally; requires live 200 check |
| `robots.txt` points to correct sitemap host | ❌ | Current: `Sitemap: https://blpboard.ru/sitemap.xml` — must be `https://building-port.ru/blp/sitemap.xml` |
| `robots.txt` has Yandex `Host:` directive | ❌ | Missing — add `Host: building-port.ru` |
| `robots.txt` has `Clean-param:` for UTM | ❌ | Missing — UTM-tagged URLs will create duplicate content |
| `sitemap.xml` accessible at correct path | ⚠️ | File exists; requires live 200 check |
| Sitemap host matches canonical URLs | ❌ | All 9 sitemap entries use `https://blpboard.ru/` — must be `https://building-port.ru/blp/` |
| Sitemap includes `<lastmod>` on all entries | ❌ | No `<lastmod>` on any entry — Google deprioritises sitemaps without it |
| Sitemap covers all 6 main pages + content pages | ⚠️ | 9 URLs present (index, catalog, architect, devops, diler, kreplenie, projects, sertificate, contacts). Missing: `/policy` |
| Sitemap submitted to GSC | 🔲 | Post-launch action — requires GSC access |
| Sitemap submitted to Yandex Webmaster | 🔲 | Post-launch action |

**Corrected `robots.txt`:**
```
User-agent: *
Allow: /
Disallow: /blp/blocks/
Disallow: /blp/scripts/
Disallow: /blp/pages_php/
Clean-param: utm_source&utm_medium&utm_campaign&utm_term&utm_content&gclid&yclid&fbclid

Host: building-port.ru
Sitemap: https://building-port.ru/blp/sitemap.xml
```

---

### 1.4 DNS/Domain Verification (Webmaster Tools)

| Check | Status | Notes |
|-------|--------|-------|
| Google Search Console verified | ❌ | No `google-site-verification` meta tag found in `blocks/template.php` |
| Yandex Webmaster verified | ❌ | No `yandex-verification` meta tag found |
| Bing Webmaster Tools verified | ❌ | No `msvalidate.01` meta tag found |
| Yandex Organizations card claimed | 🔲 | Manual action — requires Yandex account |
| Google Business Profile claimed | 🔲 | Manual action — requires Google account |

**Required fix — add to `blocks/template.php` `<head>`:**
```html
<!-- Webmaster verification — replace placeholder codes with real values -->
<meta name="google-site-verification" content="REPLACE_WITH_GSC_CODE">
<meta name="yandex-verification" content="REPLACE_WITH_YANDEX_CODE">
<meta name="msvalidate.01" content="REPLACE_WITH_BING_CODE">
```

**Steps to obtain verification codes:**
1. **GSC:** search.google.com/search-console → Add property → HTML tag method → copy code
2. **Yandex Webmaster:** webmaster.yandex.ru → Add site → Meta tag method → copy code
3. **Bing:** bing.com/webmasters → Add site → Meta tag → copy code

---

### 1.5 GA4 & Analytics

| Check | Status | Notes |
|-------|--------|-------|
| GA4 measurement ID set (not placeholder) | ❌ | `blocks/template.php` contains `G-XXXXXXXXXX` placeholder — must replace with real ID |
| `gtag` loads on all pages | ✅ | Script injected via shared `blocks/template.php` — covers all pages |
| `page_view` fires automatically | ✅ | `gtag('config', ...)` call sends page_title + page_location automatically |
| `scroll_depth` event implemented | ✅ | `js/analytics.js` fires at 25/50/75/90% scroll thresholds |
| CTA click events implemented | ✅ | `.btn-primary`, `.cta-button`, `.mobile-cta` tracked via `cta_click` event |
| Phone click tracking | ✅ | `a[href^="tel:"]` → `phone_click` event |
| Form submission conversion | ✅ | `form_submit_success` event fires on success message visibility |
| UTM parameter capture | ✅ | `sessionStorage` UTM store + merging into all events |
| Conversions marked in GA4 | ❌ | Requires GA4 Admin action: mark `form_submit_success` and `phone_click` as conversions |
| `og-default.jpg` OG image created | ❌ | `images/og-default.jpg` (1200×630px) not yet created — needed for social sharing |
| GA4 DebugView verified | 🔲 | Requires real GA4 ID + browser extension test |

---

### 1.6 Schema Markup Validation

| Schema | Page | Implementation | Validation Status |
|--------|------|----------------|-------------------|
| Organization + WebSite | All pages | ✅ via `schema_organization.php` | ✅ Validated on localhost (3 JSON-LD blocks on index) |
| BreadcrumbList | All 9 pages | ✅ dynamic via `$breadcrumbs` array | ✅ Validated on localhost |
| Product / ProductGroup (4 series) | `/blp/catalog` | ✅ via `schema_products.php` | ✅ 4 JSON-LD blocks on catalog |
| LocalBusiness | `/blp/contacts` | ✅ via `schema_localbusiness.php` | ✅ 4 JSON-LD blocks on contacts |
| WebPage | All pages | ✅ via `schema_webpage.php` | ✅ per-page dynamic |
| FAQPage | None | ❌ Intentionally skipped | N/A — restricted since Aug 2023 |
| HowTo | None | ❌ Intentionally skipped | N/A — deprecated Sep 2023 |

**Google Rich Results Test — expected results (post-launch):**
- **Homepage:** Breadcrumbs ✅, Organization detectable
- **Catalog:** Breadcrumbs ✅, Product rich results ✅ (4 products)
- **Contacts:** Breadcrumbs ✅, Local Business ✅

**Validation URLs (use after launch):**
- https://search.google.com/test/rich-results — paste page URL or HTML source
- https://validator.schema.org/ — paste JSON-LD snippets from `schema-implementation.md §4`

**Pre-launch validation (localhost — copy HTML source → paste into validator):**
```bash
# Verify schema blocks present on localhost
curl -s "http://localhost/blp/"         | grep -c "application/ld+json"  # expect 3
curl -s "http://localhost/blp/catalog"  | grep -c "application/ld+json"  # expect 4
curl -s "http://localhost/blp/contacts" | grep -c "application/ld+json"  # expect 4
```

---

### 1.7 Mobile Usability

| Check | Status | Notes |
|-------|--------|-------|
| Viewport meta tag present | ✅ | `<meta name="viewport" content="width=device-width, initial-scale=1.0">` in template |
| Mobile-first CSS (min-width) | ✅ | `main.css` uses mobile-first breakpoints after CSS refactor |
| Mobile navigation implemented | ✅ | Dedicated mobile nav in `header.php` lines 70–126 |
| Touch targets ≥ 48px | ⚠️ | Navigation links and buttons appear adequately sized; verify manually — especially `.mobile-cta` and hamburger menu |
| No horizontal scroll on 375px viewport | ⚠️ | Container uses `overflow-x: hidden` on html — verify visually in DevTools |
| iOS Safari rendering | 🔲 | Requires real device or BrowserStack test |
| Chrome Android rendering | 🔲 | Requires real device or BrowserStack test |
| No layout shift on font load | ⚠️ | Montserrat loaded via Google Fonts with `display=swap` — FOUT possible; consider self-hosting |
| Images have explicit width/height | ⚠️ | Fixed on most pages; `sertificate.php` images still missing dimensions (lines 48, 59, 70, 81, 92, 103) |
| Below-fold images have `loading="lazy"` | ⚠️ | Missing on `kreplenie.php` detail images |

**Mobile test procedure (DevTools):**
1. Open http://localhost/blp/ in Chrome
2. Toggle device toolbar → iPhone 12 (390×844)
3. Check: no overflow, hamburger opens/closes, CTA buttons tappable
4. Repeat for iPad (768×1024)
5. Run Lighthouse → Mobile tab

---

### 1.8 Core Web Vitals

| Metric | Target | Estimated Current State | Risk |
|--------|--------|------------------------|------|
| LCP (Largest Contentful Paint) | < 2.5s | ⚠️ ~2.8–3.5s estimated | HIGH — 11 render-blocking CSS files, no CSS bundling, Google Fonts blocking |
| FID / INP (Interaction to Next Paint) | < 200ms | ✅ ~50–80ms estimated | LOW — all JS loaded with `defer`/`async`, PHP server-rendered |
| CLS (Cumulative Layout Shift) | < 0.1 | ⚠️ ~0.08–0.15 estimated | MEDIUM — missing image dimensions on several pages, Montserrat FOUT |

**Primary blockers for LCP:**
1. **11 render-blocking CSS files** in `blocks/template.php` — each is a separate HTTP request blocking first paint
2. **Google Fonts CSS** request adds ~200–400ms on first load
3. **LCP preload** only in `pages_php/template.php` — not in production `blocks/template.php`

**Recommended CWV fixes (pre-launch):**
```apache
# Enable gzip compression in .htaccess
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript text/plain
</IfModule>
```

```html
<!-- Add to blocks/template.php <head> — critical CSS inline -->
<style>
:root{--color-brand:#00352F;--color-text:#1a1a1a;--font-family:'Montserrat',sans-serif}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font-family);color:var(--color-text)}
.header{position:fixed;top:0;left:0;right:0;background:#00352F;z-index:99999}
</style>
```

**Realistic CWV expectations post-launch (with current codebase):**
| Metric | Realistic | With CSS bundling |
|--------|-----------|-------------------|
| LCP | 2.8–3.5s | 1.8–2.4s |
| INP | 50–80ms | 50–80ms |
| CLS | 0.08–0.12 | 0.05–0.08 |

---

### 1.9 Final Crawl Test

| Check | Status | Notes |
|-------|--------|-------|
| All 9 pages return HTTP 200 | 🔲 | Run on localhost: see commands below |
| No 404 errors | 🔲 | Requires crawl tool or manual check |
| No redirect chains > 1 hop | 🔲 | Check with `curl -L -I` |
| All canonical pages crawlable | ⚠️ | 4 pages missing `$page_canonical` (`kreplenie`, `projects`, `sertificate`, `policy`) |
| No orphan pages | ✅ | All pages linked from header navigation ≤ 1 click |
| Internal links all valid | ⚠️ | Verify no broken hrefs — especially anchor links (`#nature`, `#polished`) |
| No `noindex` accidentally set | ✅ | Grep confirms zero `noindex` tags anywhere |

**Crawl test commands (localhost):**
```bash
for page in "" "catalog" "architect" "devops" "diler" "kreplenie" "projects" "sertificate" "contacts" "policy"; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost/blp/$page")
  echo "/blp/$page → HTTP $code"
done
```

**Screaming Frog alternative (post-launch):**
- Download: https://www.screamingfrog.co.uk/seo-spider/
- Enter: `https://building-port.ru/blp/`
- Check: Response codes (filter 4xx/5xx), Canonicals, Meta robots, Title/Meta, H1s

---

## 2. Issues Summary by Severity

### CRITICAL — Block Launch

| # | Issue | File | Fix |
|---|-------|------|-----|
| C1 | Sitemap host = `blpboard.ru`, canonicals = `building-port.ru/blp/` | `sitemap.xml` | Rewrite all 9 URLs to correct host + add `<lastmod>` |
| C2 | No HTTP→HTTPS redirect | `.htaccess` | Add `RewriteCond %{HTTPS} off` redirect rule |
| C3 | GA4 Measurement ID is placeholder `G-XXXXXXXXXX` | `blocks/template.php` | Replace with real GA4 ID |
| C4 | `robots.txt` sitemap URL points to wrong host | `robots.txt` | Fix to `https://building-port.ru/blp/sitemap.xml` |
| C5 | 4 pages missing `$page_canonical` (kreplenie, projects, sertificate, policy) | `pages_php/` | Add canonical to each page |

### HIGH — Fix Before Launch

| # | Issue | File | Fix |
|---|-------|------|-----|
| H1 | Logo loaded from `static.tildacdn.com` on every page | `header.php:4` | Move to local `images-convert/shared/header/logo-3.svg` |
| H2 | 5+ catalog images from `optim.tildacdn.com` | `catalog.php` | Migrate to local `images-convert/` |
| H3 | No webmaster verification meta tags (GSC, Yandex, Bing) | `blocks/template.php` | Add 3 verification meta tags |
| H4 | No HSTS / security headers | `.htaccess` | Add `Strict-Transport-Security`, `X-Content-Type-Options` |
| H5 | No caching headers (`mod_expires`) | `.htaccess` | Add `Cache-Control` / `Expires` |
| H6 | 11 render-blocking CSS files → LCP > 2.5s | `blocks/template.php` | Bundle or defer non-critical CSS |
| H7 | `og-default.jpg` (1200×630) missing | `images/` | Create branded OG image |

### MEDIUM — Fix Within 1 Week Post-Launch

| # | Issue | File |
|---|-------|------|
| M1 | `robots.txt` missing `Host:` (Yandex) and `Clean-param:` | `robots.txt` |
| M2 | Missing `width`/`height` on sertificate.php images | `pages_php/sertificate.php` |
| M3 | Missing `loading="lazy"` on kreplenie.php detail images | `pages_php/kreplenie.php` |
| M4 | Google Fonts CSS blocking render | `blocks/template.php` |
| M5 | Legacy Tilda site (`blpboard.tilda.ws`) still live — duplicate content risk | Tilda admin panel |
| M6 | GA4 conversions not marked in dashboard | GA4 Admin |

---

## 3. Go / No-Go Decision

### Pre-conditions for GO

| Condition | Must resolve? | Current |
|-----------|:---:|---------|
| C1 — Sitemap host fixed | ✅ MUST | ❌ Not fixed |
| C2 — HTTPS redirect active | ✅ MUST | ❌ Not fixed |
| C3 — Real GA4 ID in place | ✅ MUST | ❌ Placeholder |
| C4 — robots.txt sitemap URL fixed | ✅ MUST | ❌ Not fixed |
| C5 — All pages have canonical | ✅ MUST | ❌ 4 pages missing |
| H1 — Logo from local path | ✅ MUST | ❌ Tilda CDN |
| H3 — Webmaster verif. tags | ✅ MUST | ❌ Missing |
| H5 — Caching headers | ⚠️ SHOULD | ❌ Missing |
| H6 — CSS LCP fix | ⚠️ SHOULD | ❌ 11 blocking files |
| Schema valid (localhost) | ✅ MUST | ✅ Verified |
| All pages HTTP 200 | ✅ MUST | 🔲 Not yet checked live |

### Decision

```
╔══════════════════════════════════════════════════════════════╗
║  CURRENT STATUS:  NO-GO                                      ║
║                                                              ║
║  5 CRITICAL + 3 HIGH issues must be resolved before launch.  ║
║                                                              ║
║  Estimated fix time: 4–6 hours of development work          ║
║                                                              ║
║  GO condition: All CRITICAL items resolved + live HTTPS      ║
║  verified + GA4 real ID + webmaster tags inserted            ║
╚══════════════════════════════════════════════════════════════╝
```

### Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|:-----------:|:------:|-----------|
| Tilda CDN logo fails → broken header on every page | Medium | Critical | Move logo to local path (H1) |
| Duplicate indexing of blpboard.ru + building-port.ru | High | High | Fix sitemap + robots.txt host (C1, C4) |
| GA4 collects no data (placeholder ID) | Certain | High | Replace ID before launch (C3) |
| HTTP pages indexed instead of HTTPS | High | Medium | Add HTTPS redirect (C2) |
| 4 pages uncanonicalised → Google crawl confusion | High | Medium | Add canonicals (C5) |
| LCP > 3s → PageSpeed score < 50 → ranking penalty | High | Medium | CSS bundle (H6) |
| blpboard.tilda.ws competes for same queries | High | Medium | Add canonical or 301 on Tilda |

---

## 4. Launch Checklist — Quick Reference (Final Rundown)

Copy this checklist and tick off each item before going live:

```
PRE-LAUNCH CHECKLIST — BLP Board
Date: _____________  Engineer: _____________

CRITICAL (all must be ✅):
[ ] C1 — sitemap.xml rewritten to building-port.ru/blp/ + <lastmod> added
[ ] C2 — .htaccess HTTP→HTTPS redirect verified with curl
[ ] C3 — GA4 real Measurement ID in blocks/template.php
[ ] C4 — robots.txt sitemap URL updated
[ ] C5 — $page_canonical set on kreplenie, projects, sertificate, policy

HIGH (all must be ✅):
[ ] H1 — header logo from local path (not tildacdn.com)
[ ] H3 — GSC + Yandex + Bing verification meta tags in template
[ ] H5 — mod_expires / Cache-Control headers in .htaccess
[ ] H7 — og-default.jpg (1200×630) created in images/

VERIFICATION:
[ ] All 10 pages return HTTP 200 (curl loop test)
[ ] Schema blocks present: index=3, catalog=4, contacts=4 (grep check)
[ ] No broken images (visual check in browser)
[ ] Mobile layout OK at 390px viewport (DevTools)
[ ] GA4 DebugView shows events after replacing real ID
[ ] Sitemap submitted to GSC
[ ] Sitemap submitted to Yandex Webmaster

POST-LAUNCH (within 48h):
[ ] GSC → URL Inspection on all 9 canonical URLs → Request indexing
[ ] Yandex Webmaster → Sitemap accepted
[ ] Confirm Tilda site (blpboard.tilda.ws) has canonical or 301
[ ] Mark form_submit_success + phone_click as conversions in GA4
```

---

*Report generated: 2026-04-20*  
*Task: #16 Stage 3 Group 3.E*  
*Cross-references: technical-seo-audit.md, schema-implementation.md, ANALYTICS.md, keyword-research.md*
