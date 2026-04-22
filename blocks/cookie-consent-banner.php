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
                    <a href="/blp/cookies" target="_blank" class="cookie-link">Политика cookies</a>
                    <a href="/blp/policy" target="_blank" class="cookie-link">Политика конфиденциальности</a>
                </div>
            </div>

            <div class="cookie-consent-actions">
                <button id="cookie-consent-accept-all" class="btn-primary cookie-btn">
                    Принять всё
                </button>
                <button id="cookie-consent-reject" class="btn-secondary cookie-btn">
                    Отклонить
                </button>
                <button id="cookie-consent-manage" class="btn-outline cookie-btn">
                    Настройки
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-settings-modal" class="cookie-settings-modal" style="display: none;">
    <div class="cookie-settings-overlay"></div>
    <div class="cookie-settings-content">
        <div class="cookie-settings-header">
            <h2>Управление cookies</h2>
            <button id="cookie-settings-close" class="cookie-settings-close" aria-label="Закрыть">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="cookie-settings-body">
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <input type="checkbox" id="cookie-technical" checked disabled>
                    <label for="cookie-technical">
                        <strong>Технические cookies (обязательные)</strong>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Необходимы для функционирования сайта, безопасности и защиты от мошенничества. Не могут быть отключены.
                </p>
            </div>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <input type="checkbox" id="cookie-analytics">
                    <label for="cookie-analytics">
                        <strong>Аналитические cookies</strong>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Помогают нам понять, как вы используете сайт, какие страницы наиболее популярны. Используется Google Analytics и Яндекс.Метрика.
                </p>
            </div>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <input type="checkbox" id="cookie-marketing">
                    <label for="cookie-marketing">
                        <strong>Маркетинговые cookies</strong>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Используются для показа релевантной рекламы и отслеживания эффективности рекламных кампаний.
                </p>
            </div>
        </div>

        <div class="cookie-settings-footer">
            <button id="cookie-settings-save" class="btn-primary">
                Сохранить настройки
            </button>
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
    const COOKIE_CONSENT_KEY = 'blp_cookie_consent';
    const COOKIE_EXPIRY_DAYS = 365;

    // Elements
    const banner = document.getElementById('cookie-consent-banner');
    const acceptAllBtn = document.getElementById('cookie-consent-accept-all');
    const rejectBtn = document.getElementById('cookie-consent-reject');
    const manageBtn = document.getElementById('cookie-consent-manage');
    const modal = document.getElementById('cookie-settings-modal');
    const closeModalBtn = document.getElementById('cookie-settings-close');
    const saveSettingsBtn = document.getElementById('cookie-settings-save');

    // Checkboxes
    const technicalCheckbox = document.getElementById('cookie-technical');
    const analyticsCheckbox = document.getElementById('cookie-analytics');
    const marketingCheckbox = document.getElementById('cookie-marketing');

    // Initialize
    function init() {
        const consent = getConsent();

        if (!consent) {
            // First visit - show banner
            showBanner();
        } else {
            // Already consented - apply settings
            applyConsent(consent);
        }
    }

    // Get consent from localStorage
    function getConsent() {
        const stored = localStorage.getItem(COOKIE_CONSENT_KEY);
        return stored ? JSON.parse(stored) : null;
    }

    // Save consent to localStorage
    function saveConsent(consent) {
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + COOKIE_EXPIRY_DAYS);

        const consentData = {
            ...consent,
            timestamp: new Date().toISOString(),
            expires: expiryDate.toISOString()
        };

        localStorage.setItem(COOKIE_CONSENT_KEY, JSON.stringify(consentData));

        // Also set a cookie as backup
        document.cookie = `${COOKIE_CONSENT_KEY}=true; max-age=${COOKIE_EXPIRY_DAYS * 24 * 60 * 60}; path=/`;
    }

    // Show banner
    function showBanner() {
        if (banner) {
            banner.style.display = 'block';
        }
    }

    // Hide banner
    function hideBanner() {
        if (banner) {
            banner.style.display = 'none';
        }
    }

    // Show modal
    function showModal() {
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    // Hide modal
    function hideModal() {
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Apply consent settings
    function applyConsent(consent) {
        if (consent.analytics) {
            loadGoogleAnalytics();
            loadYandexMetrica();
        }

        if (consent.marketing) {
            loadMarketingScripts();
        }
    }

    // Load Google Analytics
    function loadGoogleAnalytics() {
        if (window.gtag) return; // Already loaded

        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=G-PLACEHOLDER20260422';
        document.head.appendChild(script);

        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-PLACEHOLDER20260422');
    }

    // Load Yandex Metrica
    function loadYandexMetrica() {
        if (window.ym) return; // Already loaded

        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) { return; }
            }
            k=e.createElement(t);a=e.getElementsByTagName(t)[0];
            k.async=1;k.src=r;a.parentNode.insertBefore(k,a)
        })(window,document,"script","https://mc.yandex.ru/metrika/tag.js","ym");

        ym(0000000, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    }

    // Load marketing scripts (Facebook Pixel, etc.)
    function loadMarketingScripts() {
        // Add your marketing scripts here
    }

    // Get current settings from checkboxes
    function getSettings() {
        return {
            technical: true, // Always required
            analytics: analyticsCheckbox ? analyticsCheckbox.checked : false,
            marketing: marketingCheckbox ? marketingCheckbox.checked : false
        };
    }

    // Update checkboxes from consent
    function updateCheckboxes(consent) {
        if (analyticsCheckbox) {
            analyticsCheckbox.checked = consent.analytics || false;
        }
        if (marketingCheckbox) {
            marketingCheckbox.checked = consent.marketing || false;
        }
    }

    // Event listeners
    if (acceptAllBtn) {
        acceptAllBtn.addEventListener('click', function() {
            const consent = {
                technical: true,
                analytics: true,
                marketing: true
            };
            saveConsent(consent);
            applyConsent(consent);
            hideBanner();
        });
    }

    if (rejectBtn) {
        rejectBtn.addEventListener('click', function() {
            const consent = {
                technical: true,
                analytics: false,
                marketing: false
            };
            saveConsent(consent);
            hideBanner();
        });
    }

    if (manageBtn) {
        manageBtn.addEventListener('click', function() {
            const consent = getConsent() || { technical: true, analytics: false, marketing: false };
            updateCheckboxes(consent);
            showModal();
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', hideModal);
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });
    }

    if (saveSettingsBtn) {
        saveSettingsBtn.addEventListener('click', function() {
            const consent = getSettings();
            saveConsent(consent);
            applyConsent(consent);
            hideModal();
            hideBanner();
        });
    }

    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
