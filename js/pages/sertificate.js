// Защита от скачивания
    document.querySelector('.certificates-section').addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey && (e.key === 's' || e.key === 'u')) || 
            (e.ctrlKey && e.shiftKey && e.key === 'i') ||
            e.key === 'PrintScreen') {
            e.preventDefault();
            return false;
        }
    });

    const track = document.getElementById('carouselTrack');
    const slides = track.innerHTML;
    track.innerHTML = slides + slides;
    
    let scrollPosition = 0;
    const slideWidth = track.children[0].offsetWidth + 16;
    const originalSlidesCount = 6;

    function scrollCarousel(direction) {
        scrollPosition += direction * slideWidth;
        
        if (scrollPosition >= slideWidth * originalSlidesCount) {
            scrollPosition = 0;
        } else if (scrollPosition < 0) {
            scrollPosition = slideWidth * (originalSlidesCount - 1);
        }
        
        track.style.transform = `translateX(-${scrollPosition}px)`;
    }

    // Свайп для мобильных
    let startX = 0;
    let isDragging = false;

    track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });

    track.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        const currentX = e.touches[0].clientX;
        const diff = startX - currentX;
        
        if (Math.abs(diff) > 50) {
            scrollCarousel(diff > 0 ? 1 : -1);
            isDragging = false;
        }
    });

    track.addEventListener('touchend', () => {
        isDragging = false;
    });