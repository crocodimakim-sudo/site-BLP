<div class="partners-section section-card" style="
    padding-top: 0px;
    padding-bottom: 0px;
    margin-bottom: 40px;">
    <h2 class="partners-title" style="
    margin-top: 16px;
    margin-bottom: 0;">Партнеры</h2>

    <div class="slider-wrapper">
        <button class="slider-btn prev" onclick="moveSlide(-1)">‹</button>

        <div class="partners-slider-container">
            <div class="partners-slider-track" id="partnersTrack">
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/kaft.svg" alt="KAFT System"></div></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/alt-msk.svg" alt="ALT MSK"></div></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/nordfox.png" alt="NordFox"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/ronson.svg" alt="Ronson"></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/tehnopress.png" alt="Технопресс"></div></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/smartfasad.svg" alt="SmartFassad"></div></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/enwall.png" alt="Enwall"></div></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/sirius.png" alt="Сириус"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/utech.svg" alt="UTech"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/favorit.svg" alt="Фаворит Фасад"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/vektorfasad.jpg" alt="VectorFassad"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/aventa.jpg" alt="Авента-Pro"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/ukon.png" alt="Ukon"></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/simplex.svg" alt="Simplex"></div></div>
                <div class="partner-slide"><div class="partner-bg"><img src="/blp/images-convert/blocks/partners/alfanvf.png" alt="Альфа-Проф"></div></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/zias.png" alt="Zias"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/kts.jpg" alt="KTS"></div>
                <div class="partner-slide"><img src="/blp/images-convert/blocks/partners/silma.jpg" alt="Силма"></div>
            </div>
        </div>

        <button class="slider-btn next" onclick="moveSlide(1)">›</button>
    </div>
</div>

<script>
let currentPosition = 0;
const track = document.getElementById('partnersTrack');

if (track) {
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
        origSlides.forEach(s => track.appendChild(s.cloneNode(true)));
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

    window.addEventListener('resize', () => {
        const slideWidth = 100 / getVisibleSlides();
        track.style.transition = 'none';
        track.style.transform = `translateX(-${currentPosition * slideWidth}%)`;
    });
}
</script>