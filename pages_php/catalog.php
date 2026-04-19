<?php
$page_title = 'Каталог фиброцементных панелей | BLP';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/catalog.css">';
$extra_js = '<script src="/blp/js/pages/catalog.js" defer></script>';

// Сканируем папку Walypan слайдера
$walypanDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images-convert' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR;
$walypanImages = [];
if (is_dir($walypanDir)) {
    // Первичный способ: glob с фигурными скобками
    $files = glob($walypanDir . 'walypan_slide_*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    if (!$files) {
        // Фоллбек: scandir для Windows
        $entries = @scandir($walypanDir);
        if ($entries) {
            $files = [];
            foreach ($entries as $entry) {
                if (preg_match('/^walypan_slide_\d+\.(jpg|jpeg|png|webp)$/i', $entry)) {
                    $files[] = $walypanDir . $entry;
                }
            }
        }
    }
    if ($files) {
        // Натуральная сортировка: slide_2 < slide_10
        usort($files, function($a, $b) {
            preg_match('/walypan_slide_(\d+)/', $a, $mA);
            preg_match('/walypan_slide_(\d+)/', $b, $mB);
            return ((int)($mA[1] ?? 0)) - ((int)($mB[1] ?? 0));
        });
        foreach ($files as $f) {
            $walypanImages[] = '/blp/images-convert/pages/catalog/slider/' . basename($f);
        }
    }
}

ob_start();
?>

<!-- Серия NATURE -->
<div class="catalog-product-grid" id="nature">
        <div class="product-card-wrapper">
            <article class="product-card">
                <div class="product-image">
                    <img src="https://optim.tildacdn.com/tild3434-3965-4462-a566-313036636664/-/format/webp/1.jpg.webp" alt="Натуральные фиброцементные панели серия NATURE — фактура под бетон">
                </div>
                
                <div class="product-info">
                    <h2 class="product-title">Натуральные панели<br>серия NATURE</h2>
                    
                    <p class="product-description">
                        Фактура «под бетон» — индустриальная эстетика&nbsp;в ее естественном проявлении. Неповторимый рисунок каждой панели создает целостный&nbsp;и фактурный образ фасада.
                    </p>
                    
                    <div class="specs-section">
                        <div class="spec-row">
                            <span class="spec-label">Толщина, мм:</span>
                            <div class="spec-values">
                                <span class="spec-value">8</span>
                                <span class="spec-value">9</span>
                                <span class="spec-value">10</span>
                                <span class="spec-value">12</span>
                                <span class="spec-value">15</span>
                            </div>
                        </div>
                        
                        <div class="spec-row">
                            <span class="spec-label">Длина, мм:</span>
                            <div class="spec-values">
                                <span class="spec-value">2440</span>
                                <span class="spec-value">3050</span>
                            </div>
                        </div>
                        
                        <div class="spec-row">
                            <span class="spec-label">Ширина, мм:</span>
                            <div class="spec-values">
                                <span class="spec-value">1220</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="colors-section">
                        <p class="colors-label">Доступные цвета:</p>
                        <div class="colors-grid">
                            <div class="color-swatch color-1" title="Белый"></div>
                            <div class="color-swatch color-2" title="Бежевый светлый"></div>
                            <div class="color-swatch color-3" title="Бежевый"></div>
                            <div class="color-swatch color-4" title="Песочный"></div>
                            <div class="color-swatch color-5" title="Терракота светлая"></div>
                            <div class="color-swatch color-6" title="Терракота"></div>
                            <div class="color-swatch color-7" title="Серый светлый"></div>
                            <div class="color-swatch color-8" title="Серый"></div>
                            <div class="color-swatch color-9" title="Графит"></div>
                            <div class="color-swatch color-10" title="Коричневый"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>

<!-- Серия POLISHED -->
<div class="catalog-product-grid" id="polished">
    <div class="product-card-wrapper">
        <article class="product-card mirrored">
            <div class="product-info">
                <h2 class="product-title">Полированные плиты<br>серия POLISHED</h2>
                <p class="product-description">Фиброцементные плиты&nbsp;в спокойных природных оттенках - сдержанная классика. Матовая поверхность усиливает декоративный эффект, подчеркивая гармонию изысканности&nbsp;и прочности.</p>
                <div class="specs-section">
                    <div class="spec-row"><span class="spec-label">Толщина, мм:</span><div class="spec-static"><span class="spec-value-plate">8</span><span class="spec-value-plate">9</span><span class="spec-value-plate">10</span><span class="spec-value-plate">12</span><span class="spec-value-plate">15</span></div></div>
                    <div class="spec-row"><span class="spec-label">Длина, мм:</span><div class="spec-static"><span class="spec-value-plate">2440</span><span class="spec-value-plate">3050</span></div></div>
                    <div class="spec-row"><span class="spec-label">Ширина, мм:</span><div class="spec-static"><span class="spec-value-plate">1220</span></div></div>
                </div>
                <div class="colors-section">
                    <p class="colors-label">Доступные цвета:</p>
                    <div class="colors-grid">
                        <div class="color-swatch color-1" title="Белый"></div>
                        <div class="color-swatch color-2" title="Бежевый светлый"></div>
                        <div class="color-swatch color-3" title="Бежевый"></div>
                        <div class="color-swatch color-4" title="Песочный"></div>
                        <div class="color-swatch color-5" title="Терракота светлая"></div>
                        <div class="color-swatch color-6" title="Терракота"></div>
                        <div class="color-swatch color-7" title="Серый светлый"></div>
                        <div class="color-swatch color-8" title="Серый"></div>
                        <div class="color-swatch color-9" title="Графит"></div>
                        <div class="color-swatch color-10" title="Коричневый"></div>
                    </div>
                </div>
            </div>
            <div class="product-image">
                <img src="https://static.tildacdn.com/tild6265-6665-4131-a137-366462346663/2.png" alt="Полированные панели серия BLP-POLISHED">
            </div>
        </article>
    </div>
</div>


<!-- Серия TEXTURE -->
<div class="catalog-product-grid" id="texture">
    <div class="product-card-wrapper">
        <article class="product-card">
            <div class="product-image">
                <img src="https://static.tildacdn.com/tild6263-3265-4130-b532-643136353730/3.png" alt="Текстурированные панели серия BLP-TEXTURE">
            </div>
            
            <div class="product-info">
                <h2 class="product-title">Текстурированные плиты<br>серия TEXTURE</h2>
                
                <p class="product-description">
                    Стиль&nbsp;и функциональность. Естественная палитра&nbsp;и слегка шлифованная поверхность дарят фасаду статусный&nbsp;и завершённый вид.
                </p>
                
                <!-- Блок характеристик: статичные значения в рамке, не кликабельные -->
                <div class="specs-section">
                    <!-- Толщина -->
                    <div class="spec-row">
                        <span class="spec-label">Толщина, мм:</span>
                        <div class="spec-static">
                            <span class="spec-value-plate">8</span>
                            <span class="spec-value-plate">9</span>
                            <span class="spec-value-plate">10</span>
                            <span class="spec-value-plate">12</span>
                            <span class="spec-value-plate">15</span>
                        </div>
                    </div>
                    
                    <!-- Длина -->
                    <div class="spec-row">
                        <span class="spec-label">Длина, мм:</span>
                        <div class="spec-static">
                            <span class="spec-value-plate">2440</span>
                            <span class="spec-value-plate">3050</span>
                        </div>
                    </div>
                    
                    <!-- Ширина -->
                    <div class="spec-row">
                        <span class="spec-label">Ширина, мм:</span>
                        <div class="spec-static">
                            <span class="spec-value-plate">1220</span>
                        </div>
                    </div>
                </div>
                
                <!-- Цвета: только чистые плашки без текстур и дополнительных полосок -->
                <div class="colors-section">
                    <p class="colors-label">Доступные цвета:</p>
                    <div class="colors-grid">
                        <div class="color-swatch color-1" title="Белый"></div>
                        <div class="color-swatch color-2" title="Бежевый светлый"></div>
                        <div class="color-swatch color-3" title="Бежевый"></div>
                        <div class="color-swatch color-4" title="Песочный"></div>
                        <div class="color-swatch color-5" title="Терракота светлая"></div>
                        <div class="color-swatch color-6" title="Терракота"></div>
                        <div class="color-swatch color-7" title="Серый светлый"></div>
                        <div class="color-swatch color-8" title="Серый"></div>
                        <div class="color-swatch color-9" title="Графит"></div>
                        <div class="color-swatch color-10" title="Коричневый"></div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>


<!-- Линеарные -->
<div class="blp-product-block" id="walypan">
    <div class="blp-container">
        <article class="blp-card">
            <!-- Левая колонка: текст и характеристики -->
            <div class="blp-info">
                <h2 class="blp-title">Линеарные панели<br>серия WALYPAN</h2>

                <div class="blp-description">
                    <p>Линеарные панели позволяют реализовывать сложные фасадные решения:</p>
                    <ul>
                        <li>комбинация различных текстур</li>
                        <li>создание геометрических рисунков фасада</li>
                    </ul>
                    <p style="margin-top: 12px;">Рельеф поверхности формирует объемный фасад&nbsp;и динамичную игру света&nbsp;и тени.</p>
                </div>

                <div class="blp-specs">
                    <div class="blp-spec-row">
                        <span class="blp-spec-label">Толщина, мм:</span>
                        <div class="blp-spec-options">
                            <span class="blp-spec-plate">10</span>
                            <span class="blp-spec-plate">12</span>
                            <span class="blp-spec-plate">15</span>
                        </div>
                    </div>

                    <div class="blp-spec-row">
                        <span class="blp-spec-label">Длина, мм:</span>
                        <div class="blp-spec-options">
                            <span class="blp-spec-plate">2440</span>
                            <span class="blp-spec-plate">3050</span>
                        </div>
                    </div>

                    <div class="blp-spec-row">
                        <span class="blp-spec-label">Ширина, мм:</span>
                        <div class="blp-spec-options">
                            <span class="blp-spec-plate">1220</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка: слайдер с миниатюрами -->
            <div class="blp-image-section">
                <div class="blp-main-image" id="blpMainImage">
                    <?php if (!empty($walypanImages)): ?>
                    <span class="blp-image-number" id="blpImageNumber">1</span>
                    <button class="blp-arrow prev" id="blpPrev" aria-label="Предыдущее">
                        <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                    </button>
                    <button class="blp-arrow next" id="blpNext" aria-label="Следующее">
                        <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                    </button>
                    <img id="blpImg" src="<?= htmlspecialchars($walypanImages[0]) ?>" alt="Линеарные панели">
                    <?php else: ?>
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#888;font-size:16px;font-family:'Montserrat',sans-serif;">Нет изображений</div>
                    <?php endif; ?>
                </div>

                <div class="blp-dots" id="blpDots"></div>

                <div class="blp-thumbnails" id="blpThumbs">
                  <?php if (!empty($walypanImages)): ?>
                  <?php foreach ($walypanImages as $i => $imgUrl): ?>
                  <div class="blp-thumb <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>">
                    <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Walypan <?= $i+1 ?>" loading="lazy" class="blp-thumb-img">
                  </div>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <div class="blp-thumb active" data-index="0">
                    <div class="blp-thumb-content" style="background-color: #00352f; color: #ffffff;">—</div>
                  </div>
                  <?php endif; ?>
                </div>
            </div>
        </article>
    </div>

    <!-- Палетка цветов -->
    <div class="palette-section" id="palette">
      <div class="palette-wrapper">
        <h2 class="palette-title">Палитра цветов</h2>
        <img
          src="https://optim.tildacdn.com/tild3339-6231-4135-a636-376435336162/-/format/webp/photo.png.webp"
          alt="Палитра цветов фиброцементных панелей"
          class="palette-image"
        >

        <div class="color-names-grid">
          <div class="color-name">Жемчужный</div>
          <div class="color-name">Бежевый</div>
          <div class="color-name">Оливковый</div>
          <div class="color-name">Горчичный</div>
          <div class="color-name">Кирпичный</div>
          <div class="color-name">Медный</div>
          <div class="color-name">Пепельно-серый</div>
          <div class="color-name">Дымчато-серый</div>
          <div class="color-name">Графит</div>
          <div class="color-name">Шоколад</div>
        </div>
      </div>
    </div>
</div>

<!-- Блок характеристик -->
<div class="blp-specs-block" id="characteristics">
    <h2 class="blp-specs-title">Характеристики</h2>
    <div class="blp-specs-layout">
        <div class="blp-specs-table">
            <div class="blp-specs-row"><div class="blp-specs-label">Толщина</div><div class="blp-specs-value">8 / 9 / 10 / 12 / 15 мм</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Ширина</div><div class="blp-specs-value">1220 мм</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Длина</div><div class="blp-specs-value">2440 мм, 3050 мм</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Плотность</div><div class="blp-specs-value">≥ 1450 кг/м³</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Влагопоглощение</div><div class="blp-specs-value">≤ 25%</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Прочность&nbsp;на изгиб</div><div class="blp-specs-value">≥ 20 МПа</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Теплопроводность</div><div class="blp-specs-value">≤ 0.35 Вт/(м · К)</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Морозостойкость</div><div class="blp-specs-value">≥150 циклов (не трескается/ не расслаивается)</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Групп горючести</div><div class="blp-specs-value">НГ (Негорючий)</div></div>
            <div class="blp-specs-row"><div class="blp-specs-label">Класс пожарной опасности</div><div class="blp-specs-value">К0 , в составе конструкций НВФ (навесных вентилируемых фасадов)</div></div>
        </div>
        <div class="blp-cert-btn-wrapper">
            <a href="/blp/sertificate" class="blp-cert-btn" rel="noopener noreferrer">
                <svg class="blp-cert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                Сертификаты
            </a>
        </div>
    </div>
</div>


<script>
(function() {
    const images = <?= json_encode(array_map(fn($url) => ['url' => $url], $walypanImages), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    if (!images.length) return;

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
        if (mainImageNumber) mainImageNumber.textContent = currentIndex + 1;
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
</script>

</body>

<?php include '../blocks/benefits-section.php'; ?>
<?php include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
?>