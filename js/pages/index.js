/* ========================================
   Главная страница - специфичный JS
   2026-04-24: обёрнут в IIFE — устранён конфликт глобального currentPosition с catalog.js
   ======================================== */

(function() {
    let currentPosition = 0;
    const track = document.getElementById('partnersTrack');
    if (!track) return;

    function getVisibleSlides() {
        const width = window.innerWidth;
        if (width <= 480) return 2;
        if (width <= 640) return 3;
        if (width <= 960) return 5;
        return 7;
    }

    (function initInfiniteSlider() {
        const origSlides = Array.from(track.children);
        const count = origSlides.length;

        // Клонируем в конец
        origSlides.forEach(s => track.appendChild(s.cloneNode(true)));
        // Клонируем в начало (в обратном порядке)
        origSlides.slice().reverse().forEach(s => track.insertBefore(s.cloneNode(true), track.firstChild));

        currentPosition = count;
        track.style.transition = 'none';
        const slideWidth = 100 / getVisibleSlides();
        track.style.transform = `translateX(-${currentPosition * slideWidth}%)`;
    })();

    function moveSlide(direction) {
        const total = track.children.length;
        const origCount = total / 3;
        const visibleSlides = getVisibleSlides();
        const slideWidth = 100 / visibleSlides;

        currentPosition += direction;
        track.style.transition = 'transform 0.4s ease';
        track.style.transform = `translateX(-${currentPosition * slideWidth}%)`;

        track.addEventListener('transitionend', function handler() {
            track.removeEventListener('transitionend', handler);
            if (currentPosition >= origCount * 2) {
                currentPosition -= origCount;
            } else if (currentPosition < origCount) {
                currentPosition += origCount;
            }
            track.style.transition = 'none';
            track.style.transform = `translateX(-${currentPosition * slideWidth}%)`;
        });
    }

    // 2026-04-24: экспорт moveSlide в global для inline-обработчиков (onclick="moveSlide(-1)")
    window.moveSlide = moveSlide;

    window.addEventListener('resize', () => {
        const slideWidth = 100 / getVisibleSlides();
        track.style.transition = 'none';
        track.style.transform = `translateX(-${currentPosition * slideWidth}%)`;
    });
})();
