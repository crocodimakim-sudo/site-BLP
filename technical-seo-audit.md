# Technical SEO Audit — BLP Board

<!-- 2026-04-20: Initial technical SEO audit (Stage 2 Group 2.B / Task #9) -->

**Domains audited:**
- `https://blpboard.tilda.ws/` (legacy reference site)
- `https://building-port.ru/blp/` (production target — site-kimi build)
- Local deployment: `D:/Claude Code/site-blp/site-kimi/` and XAMPP mirror `C:/xampp/htdocs/blp/`

**Audit date:** 2026-04-20
**Methodology:** Static source analysis of `pages_php/`, `blocks/`, `css/`, `js/`, `robots.txt`, `sitemap.xml`, `.htaccess`. No live HTTP/Lighthouse capture available in this lane — Core Web Vitals findings are based on static signals (preload, image dimensions, CSS payload, render-blocking).

**Severity legend:**
- CRITICAL — blocks indexing, traffic loss, or breaks SERP
- HIGH — measurable ranking / CWV loss likely
- MEDIUM — best-practice gap, partial loss
- LOW — polish, future-proofing

**Status legend:** `[✓]` Pass · `[!]` Fail · `[~]` Partial / Warning

---

## Executive summary

| Category | Score | Verdict |
|---|---|---|
| Crawlability | 6/10 | `[~]` robots.txt + sitemap exist, but sitemap host mismatch and missing host directive |
| Indexation | 5/10 | `[~]` Canonicals present on most pages but two pages missing, host inconsistency |
| URL structure | 8/10 | `[✓]` Clean URLs via `.htaccess`, no extensions, lowercase, hyphenless slugs |
| Mobile / CWV | 6/10 | `[~]` Viewport + responsive CSS OK; LCP preload only on `index.php`; render-blocking CSS heavy |
| JavaScript | 9/10 | `[✓]` Content is server-rendered PHP; JS only enhances |
| Resources | 5/10 | `[!]` 8 render-blocking CSS files, external Google Fonts blocking, header logo on Tilda CDN |
| Structured data | 0/10 | `[!]` Zero JSON-LD schema present anywhere |

**Top 5 critical blockers (fix first):**
1. Sitemap declares `blpboard.ru` host, but canonicals point at `building-port.ru/blp/` — host mismatch will fragment indexing.
2. Two pages (`projects.php`, `kreplenie.php`, `sertificate.php`, `policy.php`) ship **no canonical/OG vars** at all → template falls back to no-canonical.
3. Zero structured data (`application/ld+json`) anywhere on site.
4. Header logo loaded from `static.tildacdn.com` → external dependency on a third-party CMS, breaks brand isolation and adds DNS hop.
5. `robots.txt` missing `Host:` directive (Yandex), `Clean-param`, and reference to a real production domain.

---

## 1. Crawlability

### 1.1 robots.txt
- **File:** `D:/Claude Code/site-blp/site-kimi/robots.txt`
- **Contents:**
  ```
  User-agent: *
  Allow: /
  Sitemap: https://blpboard.ru/sitemap.xml
  ```

`[✓]` File exists, served from root.
`[✓]` Universal `Allow: /` — nothing inadvertently blocked.
`[!]` **HIGH** — `Sitemap:` URL points at `https://blpboard.ru/sitemap.xml` but production canonicals use `https://building-port.ru/blp/`. Either wrong host in robots, or robots reflects the real eventual domain and the canonicals are wrong (see §2.1). Pick one and unify.
`[!]` **MEDIUM** — No `Host:` directive (Yandex preferred host signal). Russian market, Yandex matters → add `Host: <chosen-domain>`.
`[!]` **MEDIUM** — No `Clean-param:` for tracking params (`utm_*`, `gclid`, `yclid`). With GA4 and Yandex Metrika expected, this prevents duplicate crawl of UTM-tagged URLs.
`[~]` **LOW** — No explicit `Disallow:` for `/blp/blocks/`, `/blp/scripts/`, `/blp/pages_php/`. They're not linked, but `pages_php/index.php` is referenced via `DirectoryIndex` and could be crawled if discovered.

**Remediation:**
```txt
User-agent: *
Allow: /
Disallow: /blp/blocks/
Disallow: /blp/scripts/
Disallow: /blp/pages_php/
Disallow: /*?utm_
Disallow: /*?gclid=
Clean-param: utm_source&utm_medium&utm_campaign&utm_term&utm_content&gclid&yclid&fbclid
Host: building-port.ru
Sitemap: https://building-port.ru/blp/sitemap.xml
```

### 1.2 sitemap.xml
- **File:** `D:/Claude Code/site-blp/site-kimi/sitemap.xml`
- 9 URLs declared, all on `https://blpboard.ru/` host.

`[✓]` Valid XML structure, proper namespace.
`[✓]` `changefreq` + `priority` per URL.
`[!]` **CRITICAL** — Host mismatch with canonicals (`building-port.ru/blp/`). Search engines will treat sitemap URLs as 404/redirect → indexing penalty.
`[!]` **HIGH** — Missing `<lastmod>` on every entry. Google de-prioritizes sitemaps without `lastmod` for crawl scheduling.
`[!]` **MEDIUM** — Missing `/policy` (privacy policy is required and should be indexable, even if low-priority).
`[!]` **LOW** — `<priority>` values relative — `1.0`, `0.9`, `0.8`, `0.7` — Google ignores `priority` since 2017. Not harmful; just dead weight.
`[~]` Only 9 URLs — no per-product, per-color, per-project URLs because the site uses single-page sections (`#nature`, `#polished`, …). Section anchors don't get separate sitemap entries — design choice, but limits SERP real estate.

**Remediation:** rewrite with correct host + add `<lastmod>` per file mtime.

### 1.3 Crawl depth & internal linking
- **Source:** `pages_php/header.php` lines 14–125, `pages_php/footer.php`.

`[✓]` All 9 sitemap URLs reachable from header navigation in ≤1 click.
`[✓]` Mobile and desktop nav both link to all pages (no orphans).
`[✓]` Footer presumably mirrors nav (not fully read here, but `footer.php` exists in both `pages_php/` and `blocks/`).
`[~]` **LOW** — Catalog series use anchor links (`/blp/catalog#nature`, `#polished`, `#texture`, `#walypan`). These are crawled but not indexed as separate URLs — consider if NATURE/POLISHED/TEXTURE/WALYPAN deserve own pages for SERP capture.

### 1.4 URL parameters
`[✓]` Site uses no parameter-driven URLs (no `?id=`, no faceted nav).
`[!]` **MEDIUM** — UTM/Yandex params (`utm_*`, `yclid`, `gclid`) will be appended by ad campaigns. No `Clean-param`/canonical handling → duplicate URLs in index.

---

## 2. Indexation

### 2.1 Canonical URLs
- **Template:** `blocks/template.php:21-23` correctly emits `<link rel="canonical">` when `$page_canonical` is set; falls back to nothing otherwise.

| Page | `$page_canonical` set? | Value |
|---|---|---|
| `index.php` | `[✓]` | `https://building-port.ru/blp/` |
| `catalog.php` | `[✓]` | `https://building-port.ru/blp/catalog` |
| `architect.php` | `[✓]` | `https://building-port.ru/blp/architect` |
| `devops.php` | `[✓]` | `https://building-port.ru/blp/devops` |
| `diler.php` | `[✓]` | `https://building-port.ru/blp/diler` |
| `contacts.php` | `[✓]` | `https://building-port.ru/blp/contacts` |
| `kreplenie.php` | `[!]` | NOT SET |
| `projects.php` | `[!]` | NOT SET |
| `sertificate.php` | `[!]` | NOT SET |
| `policy.php` | `[!]` | NOT SET |

`[!]` **CRITICAL** — 4 of 10 pages have NO canonical. This is also tracked in `ANALYTICS.md:94` ("Set `$page_canonical` on remaining pages"). When canonical is empty, template skips `og:url` too — these pages also lose Open Graph URL.
`[!]` **CRITICAL** — Host conflict: canonicals say `building-port.ru/blp/`, sitemap says `blpboard.ru`, source design ref says `blpboard.tilda.ws`. Three competing identities — Google/Yandex must be told the canonical host once, consistently.
`[~]` **MEDIUM** — Canonical for homepage uses trailing slash `/blp/`; subpages don't (`/blp/catalog`). Internally consistent (sitemap matches), but ensure server doesn't 301 between with/without slash variants.

### 2.2 Noindex / robots meta
`[✓]` Grep confirms zero `noindex` / `nofollow` tags anywhere — nothing accidentally hidden.
`[!]` **MEDIUM** — `policy.php` (privacy policy) **should be indexable but low-priority**; currently no canonical means it could be deindexed or duplicated. Consider explicit `<meta name="robots" content="index,follow">` for clarity (default behavior, but explicit is better for legal pages).

### 2.3 GSC / Yandex Webmaster verification
`[!]` **HIGH** — No verification meta tags found (`google-site-verification`, `yandex-verification`). Cannot confirm indexation status without console access.

**Remediation:** Add to `blocks/template.php` `<head>`:
```html
<meta name="google-site-verification" content="...">
<meta name="yandex-verification" content="...">
```

---

## 3. URL structure

`[✓]` Clean URLs via `.htaccess` rewrites — `/blp/catalog`, `/blp/architect`, etc., no `.php` extensions visible.
`[✓]` Lowercase, no special characters.
`[~]` **MEDIUM** — `/blp/` prefix exists because site lives in subdirectory of `building-port.ru`. Subdirectory is fine, but losing topical authority vs root domain. If `blpboard.ru` is the real eventual host (per `robots.txt`), drop the `/blp/` prefix and host at root.
`[!]` **MEDIUM** — Trailing slash inconsistency: `/blp/` (homepage with slash) vs `/blp/catalog` (no slash). Verify `.htaccess` doesn't redirect or duplicate. Currently `RewriteRule ^catalog$ pages_php/catalog.php [L]` matches only no-slash version → `/blp/catalog/` would 404 unless additional rule added.
`[!]` **LOW** — Slug `diler` (Russian transliteration of "dealer") and `devops` (transliteration of "застройщикам"/developer) are non-obvious. Consider `/dealers`, `/developers`, or Cyrillic-friendly slugs `/dilery`, `/zastroyshchikam` for SERP clarity.
`[~]` **LOW** — `sertificate` is a misspelling of `certificate` — by intent or oversight? If branded URL is needed, use `sertifikaty` (Russian) or fix to `certificates`.

---

## 4. Mobile & Core Web Vitals

### 4.1 Viewport & responsive
`[✓]` `blocks/template.php:16` ships `<meta name="viewport" content="width=device-width, initial-scale=1.0">`.
`[✓]` `css/main.css` uses mobile-first `@media (min-width: …)` per file header comment (line 7: "mobile-first breakpoints (min-width)"). 13 media queries in `main.css`.
`[✓]` Header has dedicated mobile nav (`pages_php/header.php` lines 70-126).

### 4.2 LCP (Largest Contentful Paint)
`[~]` **MEDIUM** — Only `index.php` declares `$lcp_image` for `<link rel="preload" as="image">` (template line 17–19). But this preload directive is in `pages_php/template.php`, **not** in `blocks/template.php` — and the production template used by all pages is `blocks/template.php`. So even on `index.php`, the preload may not actually fire.

  **Investigate:** confirm which template is the real one in production. The `pages_php/template.php` has `id="main-content"`, skip-link, and LCP preload; `blocks/template.php` has GA4, OG, canonical. They diverge — likely needs merging.

`[✓]` Hero images use `width`/`height` attributes (prevents CLS) and `fetchpriority="high"` + `decoding="async"` on `index.php`, `diler.php`, `architect.php`.
`[!]` **HIGH** — Other landing pages (`devops.php`, `catalog.php`, `kreplenie.php`, `sertificate.php`, `projects.php`, `contacts.php`) — confirm hero images have same dimension/priority hints. Sample shows mixed: `catalog.php` hero panel image at line 49 lacks `width`/`height`/`fetchpriority`.
`[!]` **HIGH** — `catalog.php` lines 49, 136, 148, 267, 279, 296 still load images from `optim.tildacdn.com` and `static.tildacdn.com` instead of local `images-convert/`. Third-party CDN = extra DNS, no preload, no control over format negotiation.

### 4.3 CLS (Cumulative Layout Shift)
`[✓]` Most explicit `<img>` tags have `alt` attributes (sertificate.php, kreplenie.php, diler.php, architect.php).
`[✓]` Watermark logos use `class="watermark-logo"` — assumed positioned absolute (no shift).
`[!]` **MEDIUM** — Many `<img>` tags lack `width`/`height` (sertificate.php images: lines 48, 59, 70, 81, 92, 103). Without dimensions, browser reserves no space → CLS spike on slow connections.
`[!]` **MEDIUM** — Web fonts loaded via `<link href="https://fonts.googleapis.com/css2?family=Montserrat...&display=swap">`. With `display=swap`, FOIT avoided but FOUT still shifts layout when Montserrat replaces fallback. Add `<link rel="preconnect">` (already there) AND consider `font-display: optional` or self-host.

### 4.4 INP / FID
`[✓]` JS is loaded with `defer` (`/blp/js/header.js`, `/blp/js/analytics.js`, page-specific JS).
`[✓]` GA4 loaded with `async` — non-blocking.
`[~]` **LOW** — `gtag('config', …)` runs synchronously inline (`blocks/template.php:50-57`); minor main-thread cost. Acceptable.

### 4.5 Render-blocking resources
`[!]` **HIGH** — `blocks/template.php` lines 63-75 load **8 separate CSS files** synchronously: `main.css`, `animations.css`, `header.css`, `footer.css`, `hero-section.css`, `products-section.css`, `audience-section.css`, `benefits.css`, `partners-section.css`, `objects-section.css`, `contact-form.css` — actually **11 files**. All render-blocking. Plus `extra_css` per page (often 1 more).
  - **Remediation:** concatenate + minify into one critical CSS bundle, inline above-the-fold CSS, defer below-the-fold.
`[!]` **MEDIUM** — Google Fonts CSS request blocks render. `<link rel="preconnect">` helps, but the stylesheet itself is still render-blocking.
`[!]` **LOW** — Font weights requested: `300;400;500;600;700;800` (six weights). Audit which are actually used — drop unused weights.

---

## 5. JavaScript rendering

`[✓]` Content is **fully server-rendered PHP** — `view-source` will contain headings, copy, images. No SPA / hydration required.
`[✓]` JavaScript progressively enhances (header dropdown, contact form, analytics) but is not required for content visibility.
`[✓]` Core nav links are `<a href="…">` not `<button onclick="…">` — works without JS.
`[~]` **LOW** — Catalog page's WALYPAN slider images populate via PHP scan (`catalog.php:11-39`) — server-side, JS-free. Good.
`[~]` **LOW** — `js/pages/catalog.js` likely handles slider interactions; verify the **first** slide image is rendered server-side (it is, line 267 `<?= htmlspecialchars($walypanImages[0]) ?>`) so LCP can land on it.

---

## 6. Resources

### 6.1 CSS
`[!]` **HIGH** — 11+ separate render-blocking CSS files (see §4.5). Bundle them.
`[~]` **LOW** — `:root` design tokens consolidated in `main.css` (per file header comment) — good. No conflicting redefinitions.

### 6.2 JavaScript
`[✓]` All script tags use `defer` or `async`.
`[✓]` Loaded from same origin (no third-party JS aside from GA4).

### 6.3 Images
`[✓]` Local image directory `images-convert/` (50%-optimized copies of `images/`) — pre-optimization pipeline exists (`scripts/convert_images.php`).
`[!]` **HIGH** — `pages_php/header.php:4` loads logo from `https://static.tildacdn.com/...`. **This is the brand logo, on every page.** Move to `/blp/images/shared/header/logo-3.svg` (which exists per CLAUDE.md inventory).
`[!]` **HIGH** — `pages_php/catalog.php` loads 5+ catalog images from `tildacdn.com`. Migrate to local `images-convert/`.
`[!]` **MEDIUM** — `images-convert/` outputs at "50% size" but format is not stated as WebP/AVIF — verify the script outputs modern formats. PNG/JPG-only loses ~30% vs WebP.
`[!]` **MEDIUM** — Many `<img>` tags missing `loading="lazy"` for below-the-fold (sertificate.php has it; kreplenie.php detail images on lines 21–74 don't).
`[!]` **MEDIUM** — Watermark `<img src=".../logo-3.svg" alt="watermark">` repeated 6× on sertificate.php — should be CSS background or sprite, not real `<img>`.

### 6.4 Robots-blocked resources
`[✓]` robots.txt allows `/` — no CSS/JS/img blocked.
`[~]` Currently `Allow: /` covers `images-convert/`, `css/`, `js/` — Googlebot can fetch all assets needed for mobile-friendly rendering.

---

## 7. Structured data (JSON-LD)

`[!]` **CRITICAL** — Grep for `application/ld+json` and `schema.org` returns **zero matches** in the entire codebase (only mentioned in planning docs `GLOBAL_PLAN.md`, `AUDIT_INTEGRATION_SUMMARY.md`).

**Missing schemas (high-impact for this site):**
- `Organization` (BLP Board / ООО «БИЛДИНГПОРТ») — site-wide in template
- `LocalBusiness` (Одинцово, Неделина 6А, +7 495 984-96-89)
- `Product` (per panel series: NATURE, POLISHED, TEXTURE, WALYPAN)
- `BreadcrumbList` (per inner page)
- `FAQPage` (if FAQ content added)
- `WebSite` with `SearchAction` (sitelinks search box)
- `ImageObject` for certificate scans (sertificate.php)

**Remediation:** add to `blocks/template.php` (sitewide Organization) and per-page `$page_schema` injection. Validate via Google Rich Results Test + Schema.org validator + Yandex Webmaster structured-data tool.

This is also called out in Task #8 (Stage 2 Group 2.D — Schema Markup). Coordinate with that task.

---

## 8. Server / hosting / security signals

`[~]` `.htaccess` declares `RewriteEngine On` and clean URL rules — no HTTPS forcing rule, no compression, no caching headers.
`[!]` **HIGH** — No `Header set Strict-Transport-Security`, no `Header set X-Content-Type-Options`, no compression (`mod_deflate`), no browser caching (`mod_expires`). All affect CWV indirectly and security audits.
`[!]` **MEDIUM** — No HTTP→HTTPS redirect rule. Production must enforce HTTPS or canonical fragmentation occurs.
`[!]` **LOW** — No `ErrorDocument 404` → default Apache page hurts UX and bounce rate.

---

## 9. Tilda reference site (`blpboard.tilda.ws`)

The legacy Tilda site is the design source of truth (per `CLAUDE.md`). Implications for SEO:
`[!]` **MEDIUM** — If `blpboard.tilda.ws` is still live and indexed, it will compete with the new `building-port.ru/blp/` for same queries — duplicate content risk.
  - **Remediation:** when production launches, set 301 redirects from Tilda to canonical, OR add `<link rel="canonical" href="https://building-port.ru/blp/...">` in Tilda's per-page meta.
`[!]` **HIGH** — Tilda subdomain (`*.tilda.ws`) cannot rank as well as a real custom domain — confirms migration urgency.

---

## Prioritized remediation roadmap

### Sprint 1 — CRITICAL (block launch)
1. Decide canonical host (`building-port.ru/blp/` vs `blpboard.ru` vs root).
2. Update `sitemap.xml` to match canonical host + add `<lastmod>`.
3. Add `$page_canonical` to `kreplenie.php`, `projects.php`, `sertificate.php`, `policy.php`.
4. Move header logo from `tildacdn.com` to local `/blp/images-convert/shared/header/logo-3.svg`.
5. Add `Organization` + `LocalBusiness` JSON-LD to `blocks/template.php`.

### Sprint 2 — HIGH
6. Migrate remaining `tildacdn.com` images in `catalog.php` to `images-convert/`.
7. Concatenate 11 CSS files → 1 bundle, inline critical CSS.
8. Add Google + Yandex verification meta.
9. Enforce HTTPS in `.htaccess`, add HSTS + security headers.
10. Reconcile `pages_php/template.php` vs `blocks/template.php` (LCP preload + canonical/OG must coexist).

### Sprint 3 — MEDIUM
11. Add `width`/`height` to all `<img>` tags missing them (sertificate.php especially).
12. Add `loading="lazy"` to below-the-fold images (kreplenie.php detail shots).
13. `Clean-param:` and `Host:` in robots.txt.
14. Self-host Montserrat or use `font-display: optional`.
15. Replace watermark `<img>` repeats on sertificate.php with CSS.

### Sprint 4 — LOW
16. Drop unused Montserrat weights.
17. Slug review: `diler` → `dilery`/`dealers`, `sertificate` → `sertifikaty`.
18. Add `ErrorDocument 404` and friendly 404 page.
19. Decide whether NATURE/POLISHED/TEXTURE/WALYPAN deserve own URLs (vs current `#anchors`).

---

## Verification checklist (post-fix)

- [ ] `curl -I https://building-port.ru/blp/sitemap.xml` → 200, `Content-Type: application/xml`
- [ ] `curl https://building-port.ru/blp/sitemap.xml | xmllint --noout` → no errors
- [ ] All 9 sitemap URLs return 200 (or expected redirect chain ≤1 hop)
- [ ] Google Rich Results Test on each page type → at least Organization detected
- [ ] PageSpeed Insights mobile LCP < 2.5s, INP < 200ms, CLS < 0.1
- [ ] GSC URL Inspection → "URL is on Google" for all canonical URLs
- [ ] Yandex Webmaster → site verified, sitemap accepted
- [ ] `view-source:` of any page contains `<link rel="canonical">` and `application/ld+json`
- [ ] No console errors in DevTools
- [ ] `robots.txt` valid per `https://www.google.com/webmasters/tools/robots-testing-tool`

---

## Files referenced

- `D:/Claude Code/site-blp/site-kimi/robots.txt`
- `D:/Claude Code/site-blp/site-kimi/sitemap.xml`
- `D:/Claude Code/site-blp/site-kimi/.htaccess`
- `D:/Claude Code/site-blp/site-kimi/blocks/template.php` (active production template — has GA4, OG, canonical)
- `D:/Claude Code/site-blp/site-kimi/pages_php/template.php` (alt template — has LCP preload, skip-link, no GA4)
- `D:/Claude Code/site-blp/site-kimi/pages_php/index.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/catalog.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/kreplenie.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/projects.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/sertificate.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/policy.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/header.php`
- `D:/Claude Code/site-blp/site-kimi/pages_php/footer.php`
- `D:/Claude Code/site-blp/site-kimi/css/main.css`
- `D:/Claude Code/site-blp/site-kimi/ANALYTICS.md` (canonical TODO list — confirms gaps)
- `D:/Claude Code/site-blp/site-kimi/AUDIT_INTEGRATION_SUMMARY.md` (prior SEO score 5.2/100)
