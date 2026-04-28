<?php
// 2026-04-27: данные партнёров берутся из database/partners.json вместо хардкода
$partners_data = [];
$partners_json = __DIR__ . '/../database/partners.json';
if (file_exists($partners_json)) {
    $raw = @json_decode(file_get_contents($partners_json), true);
    if (!empty($raw['partners'])) {
        $partners_data = array_filter($raw['partners'], fn($p) => !empty($p['is_active']));
        usort($partners_data, fn($a, $b) => ($a['order'] ?? 999) - ($b['order'] ?? 999));
    }
}
?>
<div class="partners-section section-card">
    <h2 class="partners-title">Партнеры</h2>

    <div class="slider-wrapper">
        <button class="slider-btn prev" onclick="moveSlide(-1)">‹</button>

        <div class="partners-slider-container">
            <div class="partners-slider-track" id="partnersTrack">
                <?php foreach ($partners_data as $p):
                    $logo = htmlspecialchars($p['logo'] ?? '', ENT_QUOTES);
                    $name = htmlspecialchars($p['name'] ?? '', ENT_QUOTES);
                    $dark = !empty($p['dark_bg']);
                ?>
                <div class="partner-slide">
                    <?php if ($dark): ?><div class="partner-bg"><?php endif; ?>
                    <img src="<?= $logo ?>" alt="<?= $name ?>">
                    <?php if ($dark): ?></div><?php endif; ?>
                </div>
                <?php endforeach; ?>
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
