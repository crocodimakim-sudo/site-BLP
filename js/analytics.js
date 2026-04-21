// 2026-04-20: GA4 event tracking, UTM capture, conversion tracking for BLP Board
(function () {
  'use strict';

  // 2026-04-20: placeholder ID — заменить на реальный GA4 Measurement ID перед go-live
  var GA4_ID = 'G-PLACEHOLDER20260420';

  // ── UTM persistence ──────────────────────────────────────────────────────────
  function captureUTM() {
    var params = new URLSearchParams(window.location.search);
    var utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
    var stored = {};
    utmKeys.forEach(function (k) {
      if (params.get(k)) stored[k] = params.get(k);
    });
    if (Object.keys(stored).length) {
      try { sessionStorage.setItem('blp_utm', JSON.stringify(stored)); } catch (e) {}
    }
  }

  function getStoredUTM() {
    try { return JSON.parse(sessionStorage.getItem('blp_utm') || '{}'); } catch (e) { return {}; }
  }

  // ── Safe gtag wrapper ─────────────────────────────────────────────────────────
  function track(eventName, params) {
    if (typeof gtag !== 'function') return;
    var utm = getStoredUTM();
    gtag('event', eventName, Object.assign({}, params, utm));
  }

  // ── CTA button clicks ─────────────────────────────────────────────────────────
  function trackCTAClicks() {
    document.addEventListener('click', function (e) {
      var el = e.target.closest('a.btn-primary, a.cta-button, a.mobile-cta, button.btn-primary');
      if (!el) return;
      var label = (el.textContent || '').trim().slice(0, 60);
      var href = el.getAttribute('href') || '';
      track('cta_click', {
        event_category: 'engagement',
        event_label: label,
        cta_destination: href
      });
    });
  }

  // ── Phone / email click tracking ──────────────────────────────────────────────
  function trackContactLinks() {
    document.addEventListener('click', function (e) {
      var el = e.target.closest('a[href^="tel:"], a[href^="mailto:"]');
      if (!el) return;
      var href = el.getAttribute('href');
      var isPhone = href.indexOf('tel:') === 0;
      track(isPhone ? 'phone_click' : 'email_click', {
        event_category: 'contact',
        event_label: href.replace(/^(tel:|mailto:)/, '')
      });
    });
  }

  // ── Navigation tracking ───────────────────────────────────────────────────────
  function trackNavClicks() {
    document.addEventListener('click', function (e) {
      var el = e.target.closest('.nav a, .dropdown-item, .mobile-dropdown-item');
      if (!el) return;
      track('nav_click', {
        event_category: 'navigation',
        event_label: (el.textContent || '').trim(),
        nav_destination: el.getAttribute('href') || ''
      });
    });
  }

  // ── Form submission tracking ──────────────────────────────────────────────────
  function trackFormSubmits() {
    document.addEventListener('submit', function (e) {
      var form = e.target;
      if (!form || form.tagName !== 'FORM') return;
      var formId = form.id || 'unknown_form';
      track('form_submit_attempt', {
        event_category: 'conversion',
        form_id: formId
      });
    });

    // Success conversion — fired when success message becomes visible
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (m) {
        if (m.type === 'attributes' && m.attributeName === 'class') {
          var el = m.target;
          if (el.classList.contains('success') && el.classList.contains('show')) {
            var form = el.closest('form');
            track('form_submit_success', {
              event_category: 'conversion',
              form_id: form ? (form.id || 'unknown_form') : 'unknown_form'
            });
          }
        }
      });
    });

    document.querySelectorAll('.form-message.success').forEach(function (el) {
      observer.observe(el, { attributes: true });
    });
  }

  // ── Scroll depth ──────────────────────────────────────────────────────────────
  function trackScrollDepth() {
    var milestones = [25, 50, 75, 90];
    var fired = {};
    window.addEventListener('scroll', function () {
      var scrolled = window.scrollY + window.innerHeight;
      var total = document.documentElement.scrollHeight;
      var pct = Math.round((scrolled / total) * 100);
      milestones.forEach(function (m) {
        if (!fired[m] && pct >= m) {
          fired[m] = true;
          track('scroll_depth', { event_category: 'engagement', depth_percent: m });
        }
      });
    }, { passive: true });
  }

  // ── Catalog section engagement ────────────────────────────────────────────────
  function trackProductViews() {
    if (!('IntersectionObserver' in window)) return;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var label = (el.querySelector('h2, h3') || {}).textContent || el.className;
          track('section_view', {
            event_category: 'engagement',
            section_name: label.trim().slice(0, 60)
          });
          io.unobserve(el);
        }
      });
    }, { threshold: 0.3 });

    document.querySelectorAll('section').forEach(function (s) { io.observe(s); });
  }

  // ── Init ──────────────────────────────────────────────────────────────────────
  captureUTM();
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  function init() {
    trackCTAClicks();
    trackContactLinks();
    trackNavClicks();
    trackFormSubmits();
    trackScrollDepth();
    trackProductViews();
  }
})();
