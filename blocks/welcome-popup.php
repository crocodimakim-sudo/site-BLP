<?php
// 2026-05-08: Welcome popup — уведомление новых пользователей о смежных проектах:
//   blite-light.ru (светильники, переехал) + blp.building-port.ru (фиброцемент 6мм)
// Показывается один раз: localStorage key `blp_welcome_popup_shown_v1`.
?>

<div id="welcome-popup" class="welcome-popup" hidden aria-hidden="true" role="dialog" aria-labelledby="welcome-popup-title" aria-modal="true">
    <div class="welcome-popup__overlay" data-wpop-close></div>

    <div class="welcome-popup__content">
        <button type="button" class="welcome-popup__close" data-wpop-close aria-label="Закрыть">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <h2 id="welcome-popup-title" class="welcome-popup__title">Мы переехали и расширились</h2>

        <p class="welcome-popup__text">
            <strong>Светильники BLP</strong> теперь живут по новому адресу.<br>
            А для внутренней отделки мы запустили отдельный проект — <strong>фиброцементные панели MDBoard и BLP FCB Decor</strong>.
        </p>

        <div class="welcome-popup__actions">
            <a href="https://blite-light.ru/" target="_blank" rel="noopener noreferrer" class="welcome-popup__btn welcome-popup__btn--secondary" data-wpop-cta="blite">
                Светильники BLP
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"></path><path d="M7 7h10v10"></path></svg>
            </a>
            <a href="https://blp.building-port.ru/" target="_blank" rel="noopener noreferrer" class="welcome-popup__btn welcome-popup__btn--primary" data-wpop-cta="fcb">
                MDBoard и BLP FCB Decor
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"></path><path d="M7 7h10v10"></path></svg>
            </a>
        </div>
    </div>
</div>

<style>
.welcome-popup {
    position: fixed;
    inset: 0;
    z-index: 10001;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: wpopFade 0.25s ease-out;
}
.welcome-popup[hidden] { display: none; }

.welcome-popup__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 32, 28, 0.55);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}

.welcome-popup__content {
    position: relative;
    background: var(--color-surface, #ffffff);
    border-radius: var(--radius-lg, 16px);
    padding: 36px 32px 28px;
    max-width: 520px;
    width: 100%;
    box-shadow: 0 24px 64px rgba(0, 32, 28, 0.25);
    animation: wpopRise 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.welcome-popup__close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    border-radius: 50%;
    color: var(--color-text-muted, #5a5a5a);
    cursor: pointer;
    transition: background 200ms ease, color 200ms ease;
}
.welcome-popup__close:hover {
    background: var(--color-bg-soft, #f4f4f4);
    color: var(--color-text, #1a1a1a);
}

.welcome-popup__title {
    margin: 0 0 14px;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 24px;
    font-weight: 700;
    line-height: 1.25;
    color: var(--color-text, #1a1a1a);
    padding-right: 32px;
}

.welcome-popup__text {
    margin: 0 0 24px;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 15px;
    line-height: 1.6;
    color: var(--color-text-secondary, #4a4a4a);
}
.welcome-popup__text strong { color: var(--color-text, #1a1a1a); font-weight: 700; }

.welcome-popup__actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.welcome-popup__btn {
    flex: 1 1 200px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 18px;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border-radius: var(--border-radius, 8px);
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: transform 200ms ease, box-shadow 200ms ease, background 200ms ease, color 200ms ease, border-color 200ms ease;
    white-space: nowrap;
}

.welcome-popup__btn--primary {
    background: var(--color-brand, #00352F);
    color: #ffffff;
    border-color: var(--color-brand, #00352F);
}
.welcome-popup__btn--primary:hover {
    background: var(--color-brand-dark, #002420);
    border-color: var(--color-brand-dark, #002420);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 32, 28, 0.18);
}

.welcome-popup__btn--secondary {
    background: transparent;
    color: var(--color-brand, #00352F);
    border-color: var(--color-brand, #00352F);
}
.welcome-popup__btn--secondary:hover {
    background: var(--color-brand, #00352F);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 32, 28, 0.12);
}

@keyframes wpopFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes wpopRise { from { opacity: 0; transform: translateY(16px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }

@media (max-width: 560px) {
    .welcome-popup__content { padding: 28px 22px 22px; }
    .welcome-popup__title { font-size: 20px; }
    .welcome-popup__text { font-size: 14px; }
    .welcome-popup__actions { flex-direction: column; }
    .welcome-popup__btn { flex: none; width: 100%; }
}

@media (prefers-reduced-motion: reduce) {
    .welcome-popup, .welcome-popup__content, .welcome-popup__btn { animation: none; transition: none; }
}
</style>

<script>
(function(){
    // 2026-05-10: умная логика повторов — клик по CTA = миссия выполнена,
    // dismiss = повторить через COOLDOWN, максимум MAX_DISMISS показов.
    var KEY = 'blp_welcome_popup_state_v3';
    var DELAY_MS = 1500;
    var COOLDOWN_MS = 48 * 60 * 60 * 1000;  // 48 часов между повторами после dismiss
    var MAX_DISMISS = 3;                     // не более 3 dismiss всего
    var force = /[?&]welcome=1\b/.test(location.search);
    var popup = document.getElementById('welcome-popup');
    if (!popup) return;

    function getState(){
        try { return JSON.parse(localStorage.getItem(KEY)) || {}; } catch(e) { return {}; }
    }
    function setState(s){
        try { localStorage.setItem(KEY, JSON.stringify(s)); } catch(e) {}
    }

    function shouldShow(){
        if (force) return true;
        var s = getState();
        if (s.clicked) return false;                          // юзер ушёл по CTA
        if ((s.dismissCount || 0) >= MAX_DISMISS) return false;
        if (s.lastDismissAt && (Date.now() - s.lastDismissAt) < COOLDOWN_MS) return false;
        return true;
    }

    function open(){
        popup.hidden = false;
        popup.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function close(){
        popup.hidden = true;
        popup.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        var s = getState();
        s.dismissCount = (s.dismissCount || 0) + 1;
        s.lastDismissAt = Date.now();
        setState(s);
    }
    function ctaClick(e){
        var which = e.currentTarget && e.currentTarget.getAttribute('data-wpop-cta');
        var s = getState();
        s.clicked = which || true;
        s.clickedAt = Date.now();
        setState(s);
        // не предотвращаем переход — ссылка откроется в новой вкладке
    }

    function init(){
        if (!shouldShow()) return;
        setTimeout(open, force ? 0 : DELAY_MS);
    }

    popup.querySelectorAll('[data-wpop-close]').forEach(function(el){
        el.addEventListener('click', close);
    });
    popup.querySelectorAll('[data-wpop-cta]').forEach(function(el){
        el.addEventListener('click', ctaClick);
    });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && !popup.hidden) close();
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
