/* ========================================
   Каталог - JS для слайдера WALYPAN
   2026-04-22: рефакторинг — загрузка слайдов из /blp/api/slider, динамическая генерация HTML
   ======================================== */

(function() {
    console.log('[slider] init start');
    let images = [];
    let currentIndex = 0;

    // 2026-04-22: контейнер слайдера — точка монтирования динамического HTML
    const sliderRoot = document.getElementById('slider-container');
    console.log('[slider] container found:', !!sliderRoot);
    if (!sliderRoot) {
        console.log('[slider] container not found, returning');
        return;
    }

    function buildSliderHTML(slides) {
        const thumbsHTML = slides.map((img, i) => `
            <div class="blp-thumb${i === 0 ? ' active' : ''}" data-index="${i}">
                <img class="blp-thumb-img" src="${img.image || img.thumbnail}" alt="Слайд ${i + 1}" loading="lazy">
            </div>
        `).join('');

        const dotsHTML = slides.map((_, i) => `
            <div class="blp-dot${i === 0 ? ' active' : ''}"></div>
        `).join('');

        return `
            <div id="blpMainImage" class="blp-main-image">
                <img id="blpImg" src="${slides[0].image}" alt="WALYPAN слайд 1">
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
        const mainImage = document.getElementById('blpImg');
        const thumbsContainer = document.getElementById('blpThumbs');
        const dotsContainer = document.getElementById('blpDots');
        const prevArrow = document.getElementById('blpPrev');
        const nextArrow = document.getElementById('blpNext');
        const thumbs = thumbsContainer.querySelectorAll('.blp-thumb');
        const dots = dotsContainer.querySelectorAll('.blp-dot');

        function goToSlide(index) {
            if (index < 0) index = images.length - 1;
            if (index >= images.length) index = 0;
            currentIndex = index;

            // 2026-04-22: логирование для отладки бесконечного слайдера
            console.log('[slider] goToSlide:', { index, total: images.length, currentIndex });

            // 2026-04-22: убрана анимация fade — картинка показывается сразу без белого фона
            mainImage.src = images[currentIndex].image;

            thumbs.forEach((t, i) => t.classList.toggle('active', i === currentIndex));
            dots.forEach((d, i) => d.classList.toggle('active', i === currentIndex));

            const activeThumb = thumbs[currentIndex];
            if (activeThumb) {
                const containerWidth = thumbsContainer.offsetWidth;
                const thumbWidth = activeThumb.offsetWidth;
                const scrollPos = activeThumb.offsetLeft - (containerWidth / 2) + (thumbWidth / 2);
                thumbsContainer.scrollTo({ left: scrollPos, behavior: 'smooth' });
            }
        }

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => goToSlide(parseInt(thumb.dataset.index)));
        });

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => goToSlide(i));
        });

        if (prevArrow) prevArrow.addEventListener('click', () => goToSlide(currentIndex - 1));
        if (nextArrow) nextArrow.addEventListener('click', () => goToSlide(currentIndex + 1));

        let touchStartX = 0;
        const mainImageContainer = document.getElementById('blpMainImage');
        if (mainImageContainer) {
            mainImageContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            mainImageContainer.addEventListener('touchend', (e) => {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 50) goToSlide(diff > 0 ? currentIndex + 1 : currentIndex - 1);
            }, { passive: true });
        }
    }

    // 2026-04-22: загрузка слайдов из API
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
            // 2026-04-22: fallback — статические пути если API недоступен
            images = Array.from({ length: 16 }, (_, i) => ({
                image: `/blp/images-convert/pages/catalog/slider/walypan_slide_${i + 1}.png`,
                num: i + 1
            }));
            sliderRoot.innerHTML = buildSliderHTML(images);
            initSlider();
        });
})();
