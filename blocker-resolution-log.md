# Blocker Resolution Log — Stage 4 Critical Launch Blockers
# 2026-04-20: Created during Stage 4 launch-readiness fixes

| Blocker # | Status | Action Taken | Verification | Go/No-Go |
|-----------|--------|--------------|--------------|----------|
| C1 — sitemap.xml host mismatch | FIXED | Replaced all 9 `<loc>` URLs from `https://blpboard.ru/...` to `https://building-port.ru/blp/...` in `sitemap.xml`. Synced to XAMPP. | `grep -c "building-port.ru" sitemap.xml` → 9 matches. Zero blpboard.ru references remain. | GO |
| C2 — HTTP→HTTPS redirect missing | ALREADY FIXED (prior session) | `.htaccess` already contains correct RewriteRule block: `RewriteCond %{HTTPS} off` + localhost exemptions + `RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]`. No change needed. | Read `.htaccess` lines 3–8: rule present with XAMPP-safe localhost/127.0.0.1 exemptions. Syntax valid. | GO |
| C3 — GA4 ID placeholder | CLIENT-BLOCKED — requires real GA4 Property ID | `blocks/template.php` line 10 still contains `G-XXXXXXXXXX`. No fake ID inserted — placeholder is intentional until client provides real Measurement ID. Deployment checklist item added. | Confirmed placeholder present. **ACTION REQUIRED BEFORE GO-LIVE:** Client must provide real GA4 Property ID and replace `G-XXXXXXXXXX` in `blocks/template.php` line 10. | NO-GO (CLIENT ACTION REQUIRED) |
| C4 — robots.txt Sitemap host | ALREADY FIXED (prior session) | `robots.txt` already contains `Sitemap: https://building-port.ru/blp/sitemap.xml`. No change needed. | Read `robots.txt` line 5: correct URL confirmed. | GO |
| C5 — Missing canonicals on 4 pages | ALREADY FIXED (prior session) | All 4 pages confirmed to have `$page_canonical` set: `kreplenie.php` → `/blp/kreplenie/`, `projects.php` → `/blp/projects/`, `sertificate.php` → `/blp/sertificate/`, `policy.php` → `/blp/policy/`. Template renders `<link rel="canonical">` when variable is set. | `grep page_canonical pages_php/{kreplenie,projects,sertificate,policy}.php` — all 4 lines present with correct building-port.ru URLs. | GO |

---

## Final Status

**4 of 5 blockers: RESOLVED**
**1 of 5 blockers: CLIENT-BLOCKED (C3 — GA4 ID)**

### Overall: NOT GO-LIVE READY until C3 resolved

**Pre-launch checklist item:**
- [ ] Client provides real GA4 Measurement ID (format: `G-XXXXXXXXXX`)
- [ ] Replace placeholder in `D:/Claude Code/site-blp/site-kimi/blocks/template.php` line 10
- [ ] Sync `blocks/template.php` to production server
- [ ] Verify GA4 tracking in Google Analytics Real-Time report after deploy

Once C3 is resolved: **GO-LIVE READY** (all other blockers cleared).
