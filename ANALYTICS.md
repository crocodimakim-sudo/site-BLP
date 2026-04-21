# BLP Board — Analytics & Tracking Documentation

*2026-04-20 | worker-analytics*

---

## GA4 Integration

**File:** `blocks/template.php`

GA4 snippet is injected in `<head>` on every page via the shared template. The Measurement ID placeholder is `G-XXXXXXXXXX` — replace with the real ID from Google Analytics > Admin > Data Streams.

```php
$ga4_id = 'G-XXXXXXXXXX'; // Set once in template.php
```

The `gtag('config', ...)` call sends `page_title` and `page_location` automatically on every page load.

---

## Event Tracking

**File:** `js/analytics.js` — loaded on every page via `template.php` (`defer`).

| Event | Trigger | Key Parameters |
|---|---|---|
| `cta_click` | Click on `.btn-primary`, `.cta-button`, `.mobile-cta` | `event_label`, `cta_destination` |
| `phone_click` | Click on `a[href^="tel:"]` | `event_label` (number) |
| `email_click` | Click on `a[href^="mailto:"]` | `event_label` (address) |
| `nav_click` | Click on nav links / dropdown items | `event_label`, `nav_destination` |
| `form_submit_attempt` | Form `submit` event | `form_id` |
| `form_submit_success` | Success message becomes visible (`.form-message.success.show`) | `form_id` |
| `scroll_depth` | Scroll reaches 25 / 50 / 75 / 90% of page | `depth_percent` |
| `section_view` | Section enters viewport (30% threshold, fires once) | `section_name` |

All events include stored UTM parameters as extra dimensions (see UTM section below).

---

## UTM Strategy

UTM parameters are captured on landing and stored in `sessionStorage` under key `blp_utm`.

**Supported parameters:** `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `utm_content`

They are automatically merged into every GA4 event so you can segment any event by campaign in GA4 Explorations.

**Standard UTM templates:**

| Channel | Example URL |
|---|---|
| Email newsletter | `/blp/?utm_source=email&utm_medium=newsletter&utm_campaign=spring2026` |
| Google Ads | `/blp/?utm_source=google&utm_medium=cpc&utm_campaign=fibro-facade` |
| Yandex Direct | `/blp/?utm_source=yandex&utm_medium=cpc&utm_campaign=fibro-facade` |
| Social (VK) | `/blp/?utm_source=vk&utm_medium=social&utm_campaign=brand` |
| Partner referral | `/blp/?utm_source=partner_name&utm_medium=referral&utm_campaign=dealer` |

---

## Meta Tags & OG / Twitter Cards

**File:** `blocks/template.php`

Per-page variables (set at the top of each `pages_php/*.php`):

| Variable | Default | Purpose |
|---|---|---|
| `$page_title` | `'BLP Board'` | `<title>`, `og:title`, `twitter:title` |
| `$page_desc` | `''` | `meta description`, `og:description`, `twitter:description` |
| `$page_og_image` | `og-default.jpg` | `og:image`, `twitter:image` (1200×630 recommended) |
| `$page_canonical` | `''` | `<link rel="canonical">`, `og:url` |
| `$page_og_type` | `'website'` | `og:type` |

**OG image location:** `images/og-default.jpg` — create a 1200×630px branded image and place it there, then sync to XAMPP.

---

## Conversion Tracking

Key conversions to monitor in GA4:

1. **Form submission** — event `form_submit_success`, `form_id = contactForm`
2. **Phone click** — event `phone_click`
3. **CTA to contacts page** — event `cta_click`, `cta_destination = /blp/contacts`

**GA4 setup:** Go to Admin > Events > Mark as conversion for `form_submit_success` and `phone_click`.

---

## Required Actions Before Go-Live

- [ ] Replace `G-XXXXXXXXXX` in `blocks/template.php` with real GA4 Measurement ID
- [ ] Create `images/og-default.jpg` (1200×630px) and sync to XAMPP/production
- [ ] Set `$page_canonical` on remaining pages: `kreplenie`, `projects`, `sertificate`, `policy`
- [ ] Verify GA4 events in DebugView after replacing the Measurement ID
- [ ] Mark `form_submit_success` and `phone_click` as conversions in GA4
