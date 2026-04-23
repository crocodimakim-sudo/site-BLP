<?php
// 2026-04-22: Cookie consent banner component with BLP Board design
// Include this in header.php or after <body> tag
// Design: matches BLP Board color scheme and typography
?>

<div id="cookie-consent-banner" class="cookie-consent-banner" style="display: none;">
    <div class="blp-container">
        <div class="cookie-consent-wrapper">
            <div class="cookie-consent-content">
                <h3 class="cookie-consent-title">🍪 Мы используем файлы cookies</h3>
                <p class="cookie-consent-text">
                    На нашем сайте используются файлы cookies для улучшения вашего опыта, анализа трафика и персонализации контента. Продолжив использование сайта, вы соглашаетесь с использованием cookies.
                </p>
                <div class="cookie-consent-links">
                    <a href="/blp/cookies" target="_blank" rel="noopener noreferrer" class="cookie-link">Политика cookies</a>
                    <a href="/blp/policy" target="_blank" rel="noopener noreferrer" class="cookie-link">Политика конфиденциальности</a>
                </div>
            </div>

            <div class="cookie-consent-actions">
                <button id="cookie-consent-accept-all" class="btn-primary cookie-btn">
                    Принять всё
                </button>
                <button id="cookie-consent-reject" class="btn-secondary cookie-btn">
                    Отклонить
                </button>
            </div>
        </div>
    </div>
</div>


<style>
/* 2026-04-22: Cookie Consent Banner — BLP Board Design System */

/* Cookie Consent Banner */
.cookie-consent-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--color-surface, #ffffff);
    border-top: 1px solid var(--color-border, #e5e7eb);
    padding: 24px 20px;
    z-index: 9999;
    box-shadow: var(--shadow-lg, 0 8px 24px rgba(0, 0, 0, 0.12));
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.cookie-consent-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 40px;
}

.cookie-consent-content {
    flex: 1;
}

.cookie-consent-title {
    margin: 0 0 12px 0;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--color-text, #1a1a1a);
    line-height: 1.3;
}

.cookie-consent-text {
    margin: 0 0 12px 0;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: var(--color-text-secondary, #5a5a5a);
}

.cookie-consent-links {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.cookie-link {
    font-size: 13px;
    color: var(--color-brand, #00352F);
    text-decoration: none;
    font-weight: 600;
    border-bottom: 1px solid transparent;
    transition: border-color var(--transition-base, 200ms ease);
}

.cookie-link:hover {
    border-bottom-color: var(--color-brand, #00352F);
}

.cookie-consent-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    min-width: 350px;
}

.cookie-btn {
    padding: 11px 24px;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border-radius: var(--border-radius, 8px);
    transition: all var(--transition-base, 200ms ease);
    white-space: nowrap;
    border: none;
}

.btn-primary {
    background: var(--color-brand, #00352F);
    color: white;
}

.btn-primary:hover {
    background: var(--color-brand-dark, #002420);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md, 0 4px 12px rgba(0, 0, 0, 0.08));
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-secondary {
    background: var(--color-bg-soft, #f8f9fa);
    color: var(--color-text, #1a1a1a);
    border: 1px solid var(--color-border, #e5e7eb);
}

.btn-secondary:hover {
    background: var(--color-border, #e5e7eb);
    border-color: var(--color-text-muted, #5a5a5a);
}

.btn-outline {
    background: transparent;
    color: var(--color-brand, #00352F);
    border: 1.5px solid var(--color-brand, #00352F);
}

.btn-outline:hover {
    background: var(--color-brand, #00352F);
    color: white;
}

/* Cookie Settings Modal */
.cookie-settings-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease-out;
}

.cookie-settings-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.cookie-settings-content {
    position: relative;
    background: var(--color-surface, #ffffff);
    border-radius: var(--radius-lg, 16px);
    max-width: 520px;
    width: 90%;
    box-shadow: var(--shadow-xl, 0 16px 48px rgba(0, 0, 0, 0.15));
    max-height: 85vh;
    overflow-y: auto;
}

.cookie-settings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 28px;
    border-bottom: 1px solid var(--color-border, #e5e7eb);
}

.cookie-settings-header h2 {
    margin: 0;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--color-text, #1a1a1a);
}

.cookie-settings-close {
    background: none;
    border: none;
    color: var(--color-text-muted, #5a5a5a);
    cursor: pointer;
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color var(--transition-base, 200ms ease);
}

.cookie-settings-close:hover {
    color: var(--color-text, #1a1a1a);
}

.cookie-settings-body {
    padding: 28px;
}

.cookie-category {
    margin-bottom: 28px;
}

.cookie-category:last-child {
    margin-bottom: 0;
}

.cookie-category-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 12px;
}

.cookie-category-header input[type="checkbox"] {
    margin-top: 4px;
    cursor: pointer;
    width: 18px;
    height: 18px;
    accent-color: var(--color-brand, #00352F);
}

.cookie-category-header label {
    cursor: pointer;
    color: var(--color-text, #1a1a1a);
    margin: 0;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-weight: 600;
    font-size: 15px;
}

.cookie-category-description {
    margin: 0 0 0 32px;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 13px;
    color: var(--color-text-secondary, #5a5a5a);
    line-height: 1.6;
}

.cookie-settings-footer {
    padding: 24px 28px;
    border-top: 1px solid var(--color-border, #e5e7eb);
    display: flex;
    justify-content: flex-end;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .cookie-consent-banner {
        padding: 20px 16px;
    }

    .cookie-consent-wrapper {
        flex-direction: column;
        gap: 20px;
    }

    .cookie-consent-actions {
        width: 100%;
        flex-direction: column;
        min-width: auto;
    }

    .cookie-btn {
        width: 100%;
    }

    .cookie-consent-links {
        gap: 12px;
    }

    .cookie-settings-content {
        max-height: 90vh;
        max-width: 95vw;
    }

    .cookie-settings-header,
    .cookie-settings-body,
    .cookie-settings-footer {
        padding: 20px;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .cookie-consent-banner,
    .cookie-settings-modal,
    .cookie-btn,
    .cookie-link {
        animation: none;
        transition: none;
    }
}
</style>

<script>
(function() {
    const KEY = 'blp_cookie_consent';
    const banner = document.getElementById('cookie-consent-banner');

    function getConsent() {
        try { return JSON.parse(localStorage.getItem(KEY)); } catch(e) { return null; }
    }

    function saveConsent(accepted) {
        localStorage.setItem(KEY, JSON.stringify({ accepted: accepted, timestamp: new Date().toISOString() }));
        document.cookie = KEY + '=1; max-age=' + (365*24*60*60) + '; path=/';
    }

    function hideBanner() {
        if (banner) banner.style.display = 'none';
    }

    function init() {
        if (!getConsent() && banner) banner.style.display = 'block';
    }

    var acceptBtn = document.getElementById('cookie-consent-accept-all');
    var rejectBtn = document.getElementById('cookie-consent-reject');

    if (acceptBtn) acceptBtn.addEventListener('click', function() { saveConsent(true); hideBanner(); });
    if (rejectBtn) rejectBtn.addEventListener('click', function() { saveConsent(false); hideBanner(); });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
