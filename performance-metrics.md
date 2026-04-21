# Core Web Vitals & Lighthouse Optimization — Task #6

## LCP Optimizations

| File | Change |
|------|--------|
| `pages_php/index.php` | Added `fetchpriority="high"`, `width="600" height="450"`, `decoding="async"` on hero img |
| `pages_php/diler.php` | Same attrs on diler hero img |
| `pages_php/architect.php` | Same attrs on architect hero img |
| `pages_php/template.php` | Added `<link rel="preload" as="image">` hook via `$lcp_image` variable |

## Render-blocking / FCP

| File | Change |
|------|--------|
| `pages_php/template.php` | Google Fonts weights: 300/400/500/600/700/800 → 400/500/600/700 (smaller payload) |
| `blocks/contact-form.php` | IMask CDN script: added `defer` (was synchronous, blocked rendering) |
| `blocks/contact-form.php` | Fixed path `js/contact-form.js` → `/blp/js/contact-form.js` (was broken on subpages) |

## Already Good

- All `<script>` tags use `defer`
- Images outside viewport use `loading="lazy"`
- `font-display=swap` already in Google Fonts URL
- CSS split into page-specific files (no single large bundle)
- `images-convert/` pipeline produces 50% size optimized copies

## Estimated Lighthouse Impact

- LCP: -0.3–0.8s (preload + fetchpriority for hero image)
- CLS: eliminated for hero images (explicit width/height prevents layout shift)
- FCP: -0.2–0.5s (IMask defer removes render-blocking script)

## Summary

All 3 tasks (WCAG audit, Lighthouse optimization, performance reports) complete. All changes synced to XAMPP at `C:/xampp/htdocs/blp/`.
