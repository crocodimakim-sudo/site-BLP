/* ========================================
   Каталог - JS для слайдера WALYPAN
   ======================================== */

(function() {
    const images = [
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_1.png', num: 1 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_2.png', num: 2 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_3.png', num: 3 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_4.png', num: 4 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_5.png', num: 5 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_6.png', num: 6 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_7.png', num: 7 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_8.png', num: 8 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_9.png', num: 9 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_10.png', num: 10 },
        { url: '/blp/images-convert/pages/catalog/slider/walypan_slide_11.png', num: 11 }
    ];

    let currentIndex = 0;
    const mainImage = document.getElementById('blpImg');
    const mainImageNumber = document.getElementById('blpImageNumber');
    const thumbnails = document.querySelectorAll('#blpThumbs .blp-thumb');
    const prevArrow = document.getElementById('blpPrev');
    const nextArrow = document.getElementById('blpNext');
    const mainImageContainer = document.getElementById('blpMainImage');
    const sliderDotsContainer = document.getElementById('blpDots');

    function createDots() {
        if (!sliderDotsContainer) return;
        sliderDotsContainer.innerHTML = '';
        images.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = 'blp-dot' + (index === currentIndex ? ' active' : '');
            dot.addEventListener('click', () => goToSlide(index));
            sliderDotsContainer.appendChild(dot);
        });
    }

    function updateDots() {
        if (!sliderDotsContainer) return;
        const dots = sliderDotsContainer.querySelectorAll('.blp-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    function goToSlide(index) {
        if (index < 0) index = images.length - 1;
        if (index >= images.length) index = 0;
        currentIndex = index;
        mainImage.src = images[currentIndex].url;
        mainImageNumber.textContent = images[currentIndex].num;
        thumbnails.forEach((t, i) => t.classList.toggle('active', i === currentIndex));
        updateDots();
        const thumbsContainer = document.getElementById('blpThumbs');
        const activeThumb = thumbnails[currentIndex];
        if (thumbsContainer && activeThumb) {
            const containerWidth = thumbsContainer.offsetWidth;
            const thumbWidth = activeThumb.offsetWidth;
            const thumbLeft = activeThumb.offsetLeft;
            const scrollPos = thumbLeft - (containerWidth / 2) + (thumbWidth / 2);
            thumbsContainer.scrollTo({ left: scrollPos, behavior: 'smooth' });
        }
    }

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', () => {
            goToSlide(parseInt(thumb.dataset.index));
        });
    });

    if (prevArrow) prevArrow.addEventListener('click', () => goToSlide(currentIndex - 1));
    if (nextArrow) nextArrow.addEventListener('click', () => goToSlide(currentIndex + 1));

    let touchStartX = 0;
    if (mainImageContainer) {
        mainImageContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        mainImageContainer.addEventListener('touchend', (e) => {
            const diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) {
                goToSlide(diff > 0 ? currentIndex + 1 : currentIndex - 1);
            }
        }, { passive: true });
    }

    createDots();
})();