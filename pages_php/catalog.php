<?php
// 2026-04-20: added meta description, canonical, OG image
// 2026-04-20: SEO — title keyword-first, meta desc 155-160 chars
$page_title    = 'Каталог фиброцементных панелей BLP Board: NATURE, POLISHED, TEXTURE, WALYPAN';
$page_desc     = 'Каталог фиброцементных панелей BLP Board. 4 серии, 10 цветов, толщина 8–15 мм, размеры до 3050 мм. Характеристики, палитра и сертификаты на каждую серию.';
$page_canonical = 'https://building-port.ru/blp/catalog';
// 2026-04-20: og_image → real hero instead of missing og-default
$page_og_image  = 'https://building-port.ru/blp/images-convert/pages/catalog/catalog_nature_render.jpg';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/catalog.css">';
$extra_js = '<script src="/blp/js/pages/catalog.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',  'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Каталог',  'url' => 'https://building-port.ru/blp/catalog'],
];

// Сканируем папку Walypan слайдера
$walypanDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images-convert' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR;
$walypanImages = [];
if (is_dir($walypanDir)) {
    // Первичный способ: glob с фигурными скобками
    $files = glob($walypanDir . 'walypan_slide_*.png');
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

// 2026-04-22: image-helper for WebP + lazy-loading support
require_once __DIR__ . '/../blocks/image-helper.php';

ob_start();
?>

<!-- 2026-04-20: H1 добавлен (критическая SEO-ошибка — ранее отсутствовал) -->
<!-- 2026-04-20: ограничение ширины H1 до 1200px с отступом как у остальных блоков -->
<div class="catalog-intro-header">
    <h1 class="catalog-main-title">Каталог фиброцементных панелей BLP Board</h1>
    <p class="catalog-intro-text">Крупноформатные фиброцементные панели НГ (К0) для навесных вентилируемых фасадов (НВФ). 4 серии, окрашены в массе — цвет проходит через весь слой материала, не выгорает. Соответствуют ГОСТ.</p>
</div>

<!-- Серия NATURE -->
<div class="catalog-product-grid" id="nature">
        <div class="product-card-wrapper">
            <article class="product-card">
                <div class="product-image">
                    <!-- 2026-04-22: WebP + lazy via render_image() -->
                    <?php echo render_image(
                        '/blp/images-convert/pages/catalog/catalog_nature_render.jpg',
                        'Натуральные фиброцементные панели серия NATURE — фактура под бетон',
                        ['sizes' => '(max-width: 768px) 100vw, 600px']
                    ); ?>
                </div>
                
                <div class="product-info">
                    <!-- 2026-04-20: H2 содержит «фиброцементные» + применение -->
                    <h2 class="product-title">Фиброцементные панели серии NATURE</h2>

                    <p class="product-description">
                        Фактура «под бетон» — индустриальная эстетика в естественном проявлении. Неповторимый рисунок каждой панели создаёт целостный фасад. Применяется для жилых комплексов, бизнес-центров, общественных зданий. Крупный формат до&nbsp;3050&nbsp;мм сокращает количество швов.
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

                    <!-- 2026-04-20: палитра цветов возвращена на карточку -->
                    <div class="colors-section">
                        <div class="colors-label">Палитра цветов:</div>
                        <div class="colors-grid">
                            <div class="color-swatch color-1" title="Жемчужный"></div>
                            <div class="color-swatch color-2" title="Бежевый"></div>
                            <div class="color-swatch color-3" title="Оливковый"></div>
                            <div class="color-swatch color-4" title="Горчичный"></div>
                            <div class="color-swatch color-5" title="Кирпичный"></div>
                            <div class="color-swatch color-6" title="Медный"></div>
                            <div class="color-swatch color-7" title="Пепельно-серый"></div>
                            <div class="color-swatch color-8" title="Дымчато-серый"></div>
                            <div class="color-swatch color-9" title="Графит"></div>
                            <div class="color-swatch color-10" title="Шоколад"></div>
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
                <!-- 2026-04-20: H2 содержит «фиброцементные» + применение -->
                <h2 class="product-title">Фиброцементные панели серии POLISHED</h2>
                <p class="product-description">Фиброцементные плиты в спокойных природных оттенках — сдержанная классика. Матовая поверхность усиливает декоративный эффект. Идеально для административных зданий, медицинских учреждений, школ.</p>
                <div class="specs-section">
                    <div class="spec-row"><span class="spec-label">Толщина, мм:</span><div class="spec-static"><span class="spec-value-plate">8</span><span class="spec-value-plate">9</span><span class="spec-value-plate">10</span><span class="spec-value-plate">12</span><span class="spec-value-plate">15</span></div></div>
                    <div class="spec-row"><span class="spec-label">Длина, мм:</span><div class="spec-static"><span class="spec-value-plate">2440</span><span class="spec-value-plate">3050</span></div></div>
                    <div class="spec-row"><span class="spec-label">Ширина, мм:</span><div class="spec-static"><span class="spec-value-plate">1220</span></div></div>
                </div>
                <!-- 2026-04-20: палитра цветов возвращена на карточку -->
                <div class="colors-section">
                    <div class="colors-label">Палитра цветов:</div>
                    <div class="colors-grid">
                        <div class="color-swatch color-1" title="Жемчужный"></div>
                        <div class="color-swatch color-2" title="Бежевый"></div>
                        <div class="color-swatch color-3" title="Оливковый"></div>
                        <div class="color-swatch color-4" title="Горчичный"></div>
                        <div class="color-swatch color-5" title="Кирпичный"></div>
                        <div class="color-swatch color-6" title="Медный"></div>
                        <div class="color-swatch color-7" title="Пепельно-серый"></div>
                        <div class="color-swatch color-8" title="Дымчато-серый"></div>
                        <div class="color-swatch color-9" title="Графит"></div>
                        <div class="color-swatch color-10" title="Шоколад"></div>
                    </div>
                </div>
            </div>
            <div class="product-image">
                <!-- 2026-04-22: WebP + lazy via render_image() -->
                <?php echo render_image(
                    '/blp/images-convert/pages/catalog/catalog_polished_render.png',
                    'Полированные панели серия BLP-POLISHED',
                    ['sizes' => '(max-width: 768px) 100vw, 600px']
                ); ?>
            </div>
        </article>
    </div>
</div>


<!-- Серия TEXTURE -->
<div class="catalog-product-grid" id="texture">
    <div class="product-card-wrapper">
        <article class="product-card">
            <div class="product-image">
                <!-- 2026-04-22: WebP + lazy via render_image() -->
                <?php echo render_image(
                    '/blp/images-convert/pages/catalog/catalog_texture_render.png',
                    'Текстурированные панели серия BLP-TEXTURE',
                    ['sizes' => '(max-width: 768px) 100vw, 600px']
                ); ?>
            </div>
            
            <div class="product-info">
                <!-- 2026-04-20: H2 содержит «фиброцементные» + применение -->
                <h2 class="product-title">Фиброцементные панели серии TEXTURE</h2>

                <p class="product-description">
                    Стиль и функциональность. Слегка шлифованная поверхность с естественной палитрой даёт фасаду статусный вид. Востребованы в проектах коммерческой и жилой недвижимости бизнес-класса.
                </p>
                
                <div class="specs-section">
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
                    <div class="spec-row">
                        <span class="spec-label">Длина, мм:</span>
                        <div class="spec-static">
                            <span class="spec-value-plate">2440</span>
                            <span class="spec-value-plate">3050</span>
                        </div>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Ширина, мм:</span>
                        <div class="spec-static">
                            <span class="spec-value-plate">1220</span>
                        </div>
                    </div>
                </div>
                <!-- 2026-04-20: палитра цветов возвращена на карточку -->
                <div class="colors-section">
                    <div class="colors-label">Палитра цветов:</div>
                    <div class="colors-grid">
                        <div class="color-swatch color-1" title="Жемчужный"></div>
                        <div class="color-swatch color-2" title="Бежевый"></div>
                        <div class="color-swatch color-3" title="Оливковый"></div>
                        <div class="color-swatch color-4" title="Горчичный"></div>
                        <div class="color-swatch color-5" title="Кирпичный"></div>
                        <div class="color-swatch color-6" title="Медный"></div>
                        <div class="color-swatch color-7" title="Пепельно-серый"></div>
                        <div class="color-swatch color-8" title="Дымчато-серый"></div>
                        <div class="color-swatch color-9" title="Графит"></div>
                        <div class="color-swatch color-10" title="Шоколад"></div>
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
        <?php echo render_image(
          '/blp/images-convert/pages/catalog/color_palette.png',
          'Палитра цветов фиброцементных панелей',
          ['class' => 'palette-image', 'sizes' => '(max-width: 768px) 100vw, 900px']
        ); ?>

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

<!-- 2026-04-20: ProductGroup + Product schemas for catalog page -->
<?php include __DIR__ . '/schema_products.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
?>