/* ========================================
   Каталог - JS для слайдера WALYPAN
   2026-04-24: автоплей + бесконечный loop через CSS transform
   ======================================== */

(function() {
    let images = [];
    let currentPosition = 0;
    let origCount = 0;
    let autoplayTimer = null;

    const sliderRoot = document.getElementById('slider-container');
    if (!sliderRoot) return;

    function buildSliderHTML(slides) {
        const slidesHTML = slides.map((img, i) => `
            <div class="blp-slide">
                <img src="${img.image}" alt="${img.title || 'Линеарные панели WALYPAN серия ' + (i + 1)}" loading="${i === 0 ? 'eager' : 'lazy'}">
            </div>
        `).join('');

        const thumbsHTML = slides.map((img, i) => `
            <div class="blp-thumb${i === 0 ? ' active' : ''}" data-index="${i}">
                <img class="blp-thumb-img" src="${img.image}" alt="Слайд ${i + 1}" loading="lazy">
            </div>
        `).join('');

        const dotsHTML = slides.map((_, i) => `
            <div class="blp-dot${i === 0 ? ' active' : ''}"></div>
        `).join('');

        return `
            <div id="blpMainImage" class="blp-main-image">
                <div class="blp-slide-track" id="blpTrack">${slidesHTML}</div>
                <button class="blp-arrow prev" id="blpPrev" aria-label="Назад">
                    <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="blp-arrow next" id="blpNext" aria-label="Вперёд">
                    <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
            <div id="blpThumbs" class="blp-thumbnails">${thumbsHTML}</div>
            <div id="blpDots" class="blp-dots">${dotsHTML}</div>
        `;
    }

    function initSlider() {
        const track = document.getElementById('blpTrack');
        const dotsContainer = document.getElementById('blpDots');
        const prevArrow = document.getElementById('blpPrev');
        const nextArrow = document.getElementById('blpNext');
        const mainImageContainer = document.getElementById('blpMainImage');

        origCount = images.length;

        // Клонируем 3x: [клоны-конца | оригиналы | клоны-начала]
        const origSlides = Array.from(track.children);
        origSlides.forEach(s => track.appendChild(s.cloneNode(true)));
        origSlides.slice().reverse().forEach(s => track.insertBefore(s.cloneNode(true), track.firstChild));

        currentPosition = origCount;
        track.style.transition = 'none';
        track.style.transform = `translateX(-${currentPosition * 100}%)`;

        const thumbsContainer = document.getElementById('blpThumbs');
        const thumbs = thumbsContainer ? thumbsContainer.querySelectorAll('.blp-thumb') : [];
        const dots = dotsContainer ? dotsContainer.querySelectorAll('.blp-dot') : [];

        function getRealIndex() {
            return ((currentPosition - origCount) % origCount + origCount) % origCount;
        }

        function updateUI() {
            const ri = getRealIndex();
            dots.forEach((d, i) => d.classList.toggle('active', i === ri));
            thumbs.forEach((t, i) => t.classList.toggle('active', i === ri));
            const activeThumb = thumbs[ri];
            if (activeThumb && thumbsContainer) {
                const scrollPos = activeThumb.offsetLeft - thumbsContainer.offsetWidth / 2 + activeThumb.offsetWidth / 2;
                thumbsContainer.scrollTo({ left: scrollPos, behavior: 'smooth' });
            }
        }

        function slide(newPos) {
            currentPosition = newPos;
            track.style.transition = 'transform 0.4s ease';
            track.style.transform = `translateX(-${currentPosition * 100}%)`;
            updateUI();
        }

        // Постоянный обработчик — нормализует позицию после анимации без визуального эффекта
        track.addEventListener('transitionend', () => {
            if (currentPosition >= origCount * 2) currentPosition -= origCount;
            else if (currentPosition < origCount) currentPosition += origCount;
            track.style.transition = 'none';
            track.style.transform = `translateX(-${currentPosition * 100}%)`;
        });

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(() => slide(currentPosition + 1), 3500);
        }
        function stopAutoplay() {
            if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
        }

        // Стрелки — ручное листание + сброс таймера
        if (prevArrow) prevArrow.addEventListener('click', () => { stopAutoplay(); slide(currentPosition - 1); startAutoplay(); });
        if (nextArrow) nextArrow.addEventListener('click', () => { stopAutoplay(); slide(currentPosition + 1); startAutoplay(); });

        // Пауза при наведении мышью
        if (mainImageContainer) {
            mainImageContainer.addEventListener('mouseenter', stopAutoplay);
            mainImageContainer.addEventListener('mouseleave', startAutoplay);
        }

        // Свайп
        let touchStartX = 0;
        if (mainImageContainer) {
            mainImageContainer.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
                stopAutoplay();
            }, { passive: true });
            mainImageContainer.addEventListener('touchend', e => {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 50) slide(diff > 0 ? currentPosition + 1 : currentPosition - 1);
                startAutoplay();
            }, { passive: true });
        }

        // Клики по миниатюрам и точкам — прямой переход без анимации
        function jumpTo(realIndex) {
            stopAutoplay();
            currentPosition = origCount + realIndex;
            track.style.transition = 'none';
            track.style.transform = `translateX(-${currentPosition * 100}%)`;
            updateUI();
            startAutoplay();
        }

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => jumpTo(parseInt(thumb.dataset.index)));
        });
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => jumpTo(i));
        });

        startAutoplay();
    }

    fetch('/blp/api/slider')
        .then(res => {
            if (!res.ok) throw new Error('API error ' + res.status);
            return res.json();
        })
        .then(data => {
            images = Array.isArray(data) ? data : (data.slides || []);
            if (!images.length) throw new Error('empty');
            sliderRoot.innerHTML = buildSliderHTML(images);
            initSlider();
        })
        .catch(() => {
            images = Array.from({ length: 16 }, (_, i) => ({
                image: `/blp/images-convert/pages/catalog/slider/walypan_slide_${i + 1}.png`,
                title: `Линеарные панели WALYPAN серия ${i + 1}`,
            }));
            sliderRoot.innerHTML = buildSliderHTML(images);
            initSlider();
        });
})();
