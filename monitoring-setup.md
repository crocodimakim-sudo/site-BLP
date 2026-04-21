# SEO Monitoring Setup — BLP Board
<!-- 2026-04-20: Task #16 Stage 3 Group 3.E — Monitoring infrastructure & playbook -->

**Site:** https://building-port.ru/blp/  
**Baseline date:** 2026-04-20 (pre-launch)  
**Primary market:** RU (Yandex + Google.ru), Secondary: EN (Google.com)  
**Geo tracking:** Moscow · Saint Petersburg · Ekaterinburg · Kazan · Krasnodar

---

## 1. Keyword Rank Tracking — 20 Tier-1 Keywords

Baseline rankings are pre-launch estimates (site not yet indexed on building-port.ru/blp/). After launch, establish real baseline within 2–4 weeks via rank tracker.

### Tracking List

| # | Keyword | Monthly Volume (RU) | KD | Intent | Target Page | Baseline | Week 4 | Week 8 | Week 12 |
|---|---------|--------------------|----|--------|-------------|----------|--------|--------|---------|
| 1 | k0 класс пожарной безопасности | 480 | 19 | Info | /blp/catalog | — | | | |
| 2 | что такое фиброцементная плита | 590 | 22 | Info | /blp/ (blog future) | — | | | |
| 3 | крупноформатные фиброцементные панели | 210 | 24 | Commercial | /blp/catalog | — | | | |
| 4 | фиброцементные плиты гост | 260 | 21 | Info | /blp/sertificate | — | | | |
| 5 | окрашенные в массе фасадные панели | 140 | 19 | Commercial | /blp/catalog | — | | | |
| 6 | фасадные материалы для архитекторов | 90 | 14 | B2B | /blp/architect | — | | | |
| 7 | дилерская программа фасадные материалы | 70 | 12 | B2B | /blp/diler | — | | | |
| 8 | образцы фиброцементных плит заказать | 50 | 9 | Transactional | /blp/contacts | — | | | |
| 9 | фиброцемент состав | 480 | 26 | Info | /blp/catalog | — | | | |
| 10 | срок службы фиброцементных плит | 320 | 28 | Info | /blp/catalog | — | | | |
| 11 | фиброцементные плиты для фасада купить | 480 | 38 | Transactional | /blp/catalog | — | | | |
| 12 | фасадные панели нг | 320 | 33 | Commercial | /blp/catalog | — | | | |
| 13 | как крепить фиброцементные панели | 720 | 35 | How-to | /blp/kreplenie | — | | | |
| 14 | подсистема для фиброцементных панелей | 590 | 38 | Info | /blp/kreplenie | — | | | |
| 15 | фиброцемент или керамогранит | 390 | 31 | Comparison | /blp/catalog | — | | | |
| 16 | поставщик фиброцементных панелей оптом | 210 | 26 | B2B-Trans | /blp/diler | — | | | |
| 17 | blp board | 30 | 5 | Branded | /blp/ | — | | | |
| 18 | blp board цена | 20 | 15 | Commercial | /blp/contacts | — | | | |
| 19 | building port фиброцемент | 30 | 18 | Branded | /blp/ | — | | | |
| 20 | фиброцементные панели для вентилируемых фасадов цена | 320 | 36 | Commercial | /blp/catalog | — | | | |

**Total tracked volume:** ~5,800 searches/month  
**Tier-1 targets (KD ≤ 25, keywords 1–9):** Quick-win set, realistic top-10 within 60–90 days  
**Tier-2 targets (KD 26–40, keywords 10–20):** Strategic set, realistic top-20 within 90–150 days

### Traffic Targets (organic sessions/month)

| Period | Target | Basis |
|--------|--------|-------|
| Month 1 (post-launch) | Baseline established | GA4 first data |
| Month 2 | +50–100 sessions vs baseline | First indexation |
| Month 3 | +200 sessions vs baseline | Tier-1 keywords entering top-10 |
| Month 6 | +500 sessions vs baseline | Tier-2 keywords ranking + content expansion |
| Month 12 | +1,500 sessions vs baseline | Blog content compounding |

### Keyword Visibility Score Definition

> **Visibility Score** = (Keywords in Top-10 / Total tracked) × 100%

| Milestone | Score | Timeline |
|-----------|-------|----------|
| Launch (baseline) | 0% | Day 0 |
| Early traction | 10–15% | Week 4–6 |
| Growth phase | 30–40% | Month 3 |
| Mature | 60%+ | Month 6–9 |

---

## 2. Alert Thresholds

### Core Web Vitals Alerts

| Metric | Warning | Critical | Action |
|--------|---------|----------|--------|
| LCP | > 2.8s on any page | > 3.5s | Investigate CSS blocking, image sizes, server TTFB |
| CLS | > 0.12 on any page | > 0.15 | Check image dimensions, font loading |
| INP | > 250ms | > 400ms | Audit JS execution, remove render-blocking scripts |

**Monitoring tool:** PageSpeed Insights API (free) or Google Search Console → Core Web Vitals report

**Manual check command (requires PSI API key):**
```
https://pagespeedonline.googleapis.com/pagespeedonline/v5/runPagespeed
  ?url=https://building-port.ru/blp/
  &strategy=mobile
  &key=YOUR_API_KEY
```

### Search Console Alerts

| Alert | Threshold | Action |
|-------|-----------|--------|
| Crawl errors (4xx) | > 5 new errors in 7 days | Fix broken URLs, update internal links |
| Indexation drop | > 10% of previously indexed pages | Check robots.txt, sitemap, manual actions |
| Coverage warnings | > 10 new excluded pages | Investigate reason (noindex, redirect, canonical conflict) |
| Manual action | Any | Immediate — audit content/links for policy violations |
| Sitemap errors | Any | Revalidate and resubmit sitemap |

### Ranking Alerts

| Alert | Threshold | Action |
|-------|-----------|--------|
| Tier-1 keyword drop | > 5 positions in 7 days | Check competitor activity, content freshness, technical issues |
| Branded keyword drop | Any drop below position 3 | Check domain authority, competitor bidding on brand |
| Top-10 keyword exits top-20 | Any | Priority content refresh or technical fix |

### Traffic Alerts (GA4)

| Alert | Threshold | Action |
|-------|-----------|--------|
| Organic sessions drop | > 25% week-over-week | Cross-reference GSC for ranking changes |
| Bounce rate spike | > 80% on landing pages | UX/CLS issue, page speed regression |
| Conversion rate drop | > 30% vs. 30-day average | Form errors, CTA visibility, page loading issues |
| Zero conversions day | Any business day | Check form functionality (`send-form.php`) |

---

## 3. Monitoring Playbook — 1-Page Quick Reference

```
╔══════════════════════════════════════════════════════════════════════╗
║         BLP BOARD — SEO MONITORING PLAYBOOK (1-PAGE)                ║
╠══════════════════════════════════════════════════════════════════════╣
║                                                                      ║
║  WEEKLY CHECKS (every Monday, ~20 min)                               ║
║  ─────────────────────────────────────                               ║
║  □ GSC → Coverage tab: new errors? Excluded pages growing?           ║
║  □ GSC → Core Web Vitals: any pages moved to "Poor"?                 ║
║  □ GA4 → Acquisition → Organic traffic trend vs prior week           ║
║  □ GA4 → Conversions: form_submit_success + phone_click counts       ║
║  □ Rank tracker: any Tier-1 keywords dropped > 5 positions?          ║
║                                                                      ║
║  MONTHLY CHECKS (1st Monday of month, ~60–90 min)                   ║
║  ──────────────────────────────────────────────────                  ║
║  □ Update tracking table (section 1) with current rankings           ║
║  □ Calculate Visibility Score: Top-10 count / 20 × 100%             ║
║  □ GSC → Performance → Compare: this month vs last month             ║
║    · Clicks, Impressions, CTR, Average Position                      ║
║  □ Review Core Web Vitals in GSC (28-day aggregate)                  ║
║  □ Check new indexation: how many pages indexed total?               ║
║  □ GA4 Explorations → Landing page report: top organic entries       ║
║  □ Check blpboard.tilda.ws: still live? Causing duplicate issues?    ║
║                                                                      ║
║  QUARTERLY CHECKS (every 3 months, ~3–4 hours)                      ║
║  ─────────────────────────────────────────────                       ║
║  □ Full content performance review:                                   ║
║    · Which pages drive most organic traffic?                         ║
║    · Which pages have high impressions but low CTR? (fix meta)       ║
║    · Which Tier-2 keywords entered top-20? Celebrate + accelerate   ║
║  □ Competitor gap analysis: re-run vs cembrit.ru, latonit.ru,        ║
║    krasplit.ru — did they publish new content?                       ║
║  □ Identify content refresh opportunities:                            ║
║    · Pages ranking 11–20 → push to top-10 with content update       ║
║    · Add "2026" + fresh data to info articles                        ║
║  □ Review schema: new product series? Add to schema_products.php     ║
║  □ Backlink audit: GSC → Links → External links growing?             ║
║  □ Plan next content batch (3–5 blog posts or landing pages)         ║
║                                                                      ║
║  KPI TARGETS (90-day post-launch)                                    ║
║  ─────────────────────────────────                                   ║
║  · Tier-1 keywords: 6 of 9 in top-10 ✓                              ║
║  · Tier-2 keywords: 4 of 11 in top-20 ✓                             ║
║  · Branded (blp board, blp фиброцемент): 100% top-3 ✓               ║
║  · Organic sessions: +200/month vs baseline ✓                        ║
║  · Visibility score: ≥ 30% ✓                                        ║
║  · Conversions: ≥ 3 form submissions/month ✓                         ║
╚══════════════════════════════════════════════════════════════════════╝
```

---

## 4. Tool Recommendations & Setup

### 4.1 Primary Tools (Free)

#### Google Search Console
- **Setup:** search.google.com/search-console → Add property → HTML tag verification
- **Key reports:** Performance, Coverage, Core Web Vitals, Links, Manual Actions
- **Frequency:** Weekly
- **Setup time:** 15 min (requires verification tag in template — see launch-readiness-report.md §1.4)

#### Yandex Webmaster
- **Setup:** webmaster.yandex.ru → Add site → Meta tag verification
- **Key reports:** Indexation, Search queries, Quality assessment
- **Frequency:** Weekly (critical for RU market — Yandex ~50% Russian search share)
- **Setup time:** 10 min

#### Google Analytics 4
- **Setup:** analytics.google.com → Create property → Add data stream → copy G-XXXXXXXX ID
- **Configuration checklist:**
  1. Replace placeholder in `blocks/template.php`
  2. Admin → Events → Mark `form_submit_success` as conversion
  3. Admin → Events → Mark `phone_click` as conversion
  4. Configure → Explore → Create "Organic Traffic by Landing Page" exploration
- **Custom dashboard panels to create:**
  - Organic sessions (weekly trend line)
  - Conversion events (form + phone)
  - Top organic landing pages
  - UTM campaign breakdown

#### PageSpeed Insights
- **URL:** pagespeed.web.dev
- **Frequency:** Monthly (or after any significant code changes)
- **Test both:** mobile + desktop for all 9 pages
- **Target:** Performance score ≥ 70 mobile, ≥ 90 desktop

---

### 4.2 Rank Tracking Tools (Paid — Recommended Options)

#### Option A: SE Ranking (Recommended for budget)
- **Price:** ~$23/month (Starter plan, 250 keywords, daily updates)
- **Why:** Best price/value for RU market, native Yandex support, Russian UI
- **Setup:**
  1. Create project → add `building-port.ru/blp/`
  2. Add 20 keywords from section 1
  3. Set search engines: Google.ru + Yandex.ru
  4. Set geos: Moscow, Saint Petersburg, Ekaterinburg
  5. Schedule: weekly reports to email
- **URL:** seranking.com

#### Option B: Semrush (Full-featured)
- **Price:** ~$130/month (Pro plan)
- **Why:** Best-in-class competitor analysis, backlink monitoring, site audit
- **Best for:** Quarterly competitor gap analysis + backlink audit
- **Free alternative:** Semrush free tier (10 reports/day, 10 tracked keywords)
- **URL:** semrush.com

#### Option C: Ahrefs (Best for backlinks)
- **Price:** ~$99/month (Lite plan)
- **Why:** Industry-leading backlink index; Yandex support limited
- **Best for:** Monitoring backlink profile as link-building begins
- **Free alternative:** Ahrefs Webmaster Tools (free, limited to verified domain)
- **URL:** ahrefs.com

#### Option D: Free Rank Tracking (No budget)
- **Google Search Console** → Performance → Queries → filter by keyword
  - Not real rank tracking, but shows average position per query
  - Good enough for basic monitoring of 20 keywords
- **Yandex Webmaster** → Search queries → similar data for Yandex

**Recommendation for BLP Board (startup stage):**
> Start with **SE Ranking Starter** ($23/mo) for rank tracking + **free tools** (GSC + Yandex WM + GA4 + PSI) for everything else. Upgrade to Semrush Pro when monthly organic traffic exceeds 500 sessions.

---

### 4.3 Custom GA4 Dashboard Configuration

#### Dashboard 1: Weekly Health Check
```
Panels:
1. Organic sessions — last 7 days vs prior 7 days (line chart)
2. Conversions by type (form_submit_success, phone_click) — bar chart
3. Top 5 organic landing pages by sessions — table
4. Avg. engagement time by page — table
5. Device breakdown (mobile/desktop/tablet) — pie chart
```

#### Dashboard 2: Monthly SEO Report
```
Panels:
1. Organic sessions trend — last 90 days (line chart)
2. New users vs returning — area chart
3. Top organic keywords (from GSC integration if linked)
4. Conversion funnel: sessions → engaged → converted
5. UTM campaign breakdown (email, cpc, referral)
6. Geographic breakdown (cities)
```

**Linking GSC to GA4:**
- GA4 → Admin → Product Links → Search Console → Link property
- Unlocks: "Queries" dimension in GA4 Explorations, organic keyword data

---

### 4.4 Alert Configuration

#### GA4 Custom Insights (Automated Alerts)
Navigate to: GA4 → Reports → Insights → Create custom insight

```
Alert 1: Organic traffic drop
  Condition: Organic sessions < [baseline × 0.75] in last 7 days
  Compare to: Previous 7 days
  Notify: Email weekly

Alert 2: Zero conversions
  Condition: form_submit_success count = 0 on any day
  Notify: Email immediately

Alert 3: Bounce rate spike
  Condition: Bounce rate > 80% on /blp/ or /blp/catalog
  Notify: Email weekly
```

#### GSC Email Alerts (Built-in)
- GSC → Settings → Email preferences → Enable all alerts
- Automatic notifications for: Manual actions, Coverage errors, Security issues

---

## 5. Competitive Monitoring

### Competitors to Track

| Competitor | Domain | Monitor For |
|------------|--------|-------------|
| Cembrit Russia | cembrit.ru | New product pages, pricing changes |
| Latonit | latonit.ru | Content publishing, schema adoption |
| Krasplit | krasplit.ru | Blog activity, backlink gains |
| Eternit | eternit.ru | New landing pages |
| Etalon Fasad | etalon-fasad.ru | Service page optimization |

### Competitive Monitoring Routine (Monthly)
1. Google search: `site:cembrit.ru` — note number of indexed pages
2. Semrush/Ahrefs: check competitor organic traffic trend (free tier)
3. Manual SERP check for top 5 keywords from tracking list
4. Note any new SERP features competitors appear in (featured snippets, image pack)

---

## 6. Content Performance Review Schedule

### Trigger: Monthly content review
Pages to evaluate:

| Page | Primary Keyword | Review Trigger |
|------|----------------|----------------|
| `/blp/` | blp board, фиброцемент | Impressions > 500/mo but CTR < 3% → rewrite title/description |
| `/blp/catalog` | фиброцементные панели | Position 11–20 → add more product detail content |
| `/blp/architect` | фасадные материалы для архитекторов | < 10 sessions/mo after 60 days → enrich content |
| `/blp/diler` | дилерская программа фасадные материалы | < 5 sessions/mo → add dealer benefit content |
| `/blp/sertificate` | фиброцементные плиты гост | Position > 20 after 90 days → add GOST table content |
| `/blp/kreplenie` | как крепить фиброцементные панели | Position > 15 → add step-by-step content |
| `/blp/projects` | реализованные проекты фиброцемент | < 5 sessions/mo → add more project case studies |
| `/blp/contacts` | building port одинцово | < 10% conversion rate → optimize CTA copy |

### Content Refresh Criteria
- Page ranking 11–30 for target keyword → eligible for refresh
- Page with high impressions but CTR < 2% → rewrite `<title>` and `<meta description>`
- Page with CLS > 0.1 → fix image dimensions
- Page with bounce rate > 75% → improve above-fold content relevance

---

## 7. Monthly Reporting Template

Copy and fill monthly:

```
BLP BOARD — MONTHLY SEO REPORT
Month: ____________  Prepared: ____________

TRAFFIC
  Organic sessions this month:  ______
  vs. last month:               +/- ______  (+/- ___ %)
  vs. baseline (launch month):  +/- ______  (+/- ___ %)
  Top organic landing page:     ______  (__ sessions)
  Mobile vs Desktop split:      __ % / __ %

RANKINGS
  Keywords in Top-10:     __ / 20  (__ %)
  Keywords in Top-20:     __ / 20  (__ %)
  Keywords in Top-50:     __ / 20  (__ %)
  Visibility Score:       __ %
  Best mover:             ______  (__ → __)
  Biggest dropper:        ______  (__ → __)

CONVERSIONS
  form_submit_success:    __ this month
  phone_click:            __ this month
  Total conversions:      __
  Conversion rate:        __ % of organic sessions

TECHNICAL
  Core Web Vitals status: ✅ Good / ⚠️ Needs work
    LCP (mobile):         __s  (target: < 2.5s)
    CLS:                  __   (target: < 0.1)
    INP:                  __ms (target: < 200ms)
  GSC crawl errors:       __  (new this month)
  Indexed pages:          __  (target: 9+)
  PSI mobile score:       __  (target: ≥ 70)

ACTIONS NEXT MONTH
  □ ______________________________
  □ ______________________________
  □ ______________________________
```

---

*Document created: 2026-04-20*  
*Task: #16 Stage 3 Group 3.E*  
*Cross-references: keyword-research.md (Tier-1/2 keyword lists), ANALYTICS.md (event tracking), launch-readiness-report.md (verification checklist)*
