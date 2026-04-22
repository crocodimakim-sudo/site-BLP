<?php
// 2026-04-22: Cookie consent banner component
// Include this in header.php or after <body> tag
?>

<div id="cookie-consent-banner" class="cookie-consent-banner" style="display: none;">
    <div class="cookie-consent-container">
        <div class="cookie-consent-content">
            <h3 class="cookie-consent-title">Мы используем файлы cookies</h3>
            <p class="cookie-consent-text">
                На нашем сайте используются файлы cookies для улучшения вашего опыта, анализа трафика и персонализации контента.
                Продолжив использование сайта, вы соглашаетесь с использованием cookies.
            </p>
            <p class="cookie-consent-link">
                <a href="/blp/cookies" target="_blank">Узнать больше о cookies</a> |
                <a href="/blp/policy" target="_blank">Политика конфиденциальности</a>
            </p>
        </div>
        <div class="cookie-consent-actions">
            <button id="cookie-consent-accept-all" class="cookie-consent-btn cookie-consent-btn-primary">
                Принять всё
            </button>
            <button id="cookie-consent-reject" class="cookie-consent-btn cookie-consent-btn-secondary">
                Отклонить
            </button>
            <button id="cookie-consent-manage" class="cookie-consent-btn cookie-consent-btn-tertiary">
                Настройки
            </button>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-settings-modal" class="cookie-settings-modal" style="display: none;">
    <div class="cookie-settings-content">
        <div class="cookie-settings-header">
            <h2>Управление cookies</h2>
            <button id="cookie-settings-close" class="cookie-settings-close">&times;</button>
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
                    Необходимы для функционирования сайта, безопасности и защиты от мошенничества.
                    Не могут быть отключены.
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
                    Помогают нам понять, как вы используете сайт, какие страницы наиболее популярны.
                    Используется Google Analytics и Яндекс.Метрика.
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
                    Используются для показа релевантной рекламы и отслеживания эффективности кампаний.
                </p>
            </div>
        </div>

        <div class="cookie-settings-footer">
            <button id="cookie-settings-save" class="cookie-consent-btn cookie-consent-btn-primary">
                Сохранить настройки
            </button>
        </div>
    </div>
</div>

<style>
/* Cookie Consent Banner */
.cookie-consent-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #1a1a1a;
    color: #fff;
    padding: 20px;
    z-index: 9999;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
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

.cookie-consent-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 30px;
}

.cookie-consent-content {
    flex: 1;
}

.cookie-consent-title {
    margin: 0 0 10px 0;
    font-size: 18px;
    font-weight: 600;
}

.cookie-consent-text {
    margin: 0 0 8px 0;
    font-size: 14px;
    line-height: 1.5;
    color: #ddd;
}

.cookie-consent-link {
    margin: 0;
    font-size: 13px;
}

.cookie-consent-link a {
    color: #00d4ff;
    text-decoration: none;
    border-bottom: 1px solid #00d4ff;
    transition: color 0.2s;
}

.cookie-consent-link a:hover {
    color: #00b8d4;
}

.cookie-consent-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    min-width: 400px;
}

.cookie-consent-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.cookie-consent-btn-primary {
    background: #00d4ff;
    color: #000;
}

.cookie-consent-btn-primary:hover {
    background: #00b8d4;
    transform: translateY(-1px);
}

.cookie-consent-btn-secondary {
    background: transparent;
    color: #ddd;
    border: 1px solid #555;
}

.cookie-consent-btn-secondary:hover {
    background: #333;
    border-color: #777;
}

.cookie-consent-btn-tertiary {
    background: transparent;
    color: #00d4ff;
    border: 1px solid #00d4ff;
}

.cookie-consent-btn-tertiary:hover {
    background: #00d4ff;
    color: #000;
}

/* Cookie Settings Modal */
.cookie-settings-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.cookie-settings-content {
    background: #fff;
    border-radius: 8px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    max-height: 80vh;
    overflow-y: auto;
}

.cookie-settings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px;
    border-bottom: 1px solid #eee;
}

.cookie-settings-header h2 {
    margin: 0;
    font-size: 20px;
    color: #1a1a1a;
}

.cookie-settings-close {
    background: none;
    border: none;
    font-size: 28px;
    color: #999;
    cursor: pointer;
    width: 30px;
    height: 30px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.cookie-settings-close:hover {
    color: #1a1a1a;
}

.cookie-settings-body {
    padding: 25px;
}

.cookie-category {
    margin-bottom: 25px;
}

.cookie-category-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 10px;
}

.cookie-category-header input[type="checkbox"] {
    margin-top: 2px;
    cursor: pointer;
    width: 18px;
    height: 18px;
}

.cookie-category-header label {
    cursor: pointer;
    color: #1a1a1a;
    margin: 0;
}

.cookie-category-description {
    margin: 0 0 0 30px;
    font-size: 13px;
    color: #666;
    line-height: 1.5;
}

.cookie-settings-footer {
    padding: 20px 25px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
}

.cookie-settings-footer .cookie-consent-btn {
    min-width: 150px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .cookie-consent-container {
        flex-direction: column;
        gap: 20px;
    }

    .cookie-consent-actions {
        min-width: auto;
        width: 100%;
        flex-direction: column;
    }

    .cookie-consent-btn {
        width: 100%;
    }

    .cookie-settings-content {
        max-height: 90vh;
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
