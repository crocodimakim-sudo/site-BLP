<?php
// 2026-04-24: require image-helper для WebP + lazy loading (может быть уже загружен родительской страницей)
if (!function_exists('render_image')) {
    require_once __DIR__ . '/image-helper.php';
}
?>
<section class="products-section">
    <div class="section-header">
        <h2>BLPboard</h2>
    </div>

    <div class="products-grid">
        <div class="product-col">
            <a href="/blp/catalog#nature" class="product-card-link">
                <article class="product-card">
                    <?php echo render_image(
                        '/blp/images-convert/blocks/products/series-nature.png',
                        'Натуральные плиты серия NATURE',
                        ['class' => 'product-image', 'lazy' => true]
                    ); ?>
                    <div class="product-content">
                        <div class="product-label text-label">Серия</div>
                        <h3 class="product-title">NATURE</h3>
                        <h4 class="product-text">Натуральные плиты</h4>
                        <span class="card-link">Подробнее</span>
                    </div>
                </article>
            </a>
        </div>

        <div class="product-col">
            <a href="/blp/catalog#polished" class="product-card-link">
                <article class="product-card">
                    <?php echo render_image(
                        '/blp/images-convert/blocks/products/series-polished.png',
                        'Полированные плиты серия POLISHED',
                        ['class' => 'product-image', 'lazy' => true]
                    ); ?>
                    <div class="product-content">
                        <div class="product-label text-label">Серия</div>
                        <h3 class="product-title">POLISHED</h3>
                        <h4 class="product-text">Полированные плиты</h4>
                        <span class="card-link">Подробнее</span>
                    </div>
                </article>
            </a>
        </div>

        <div class="product-col">
            <a href="/blp/catalog#texture" class="product-card-link">
                <article class="product-card">
                    <?php echo render_image(
                        '/blp/images-convert/blocks/products/series-texture.png',
                        'Текстурированные плиты серия TEXTURE',
                        ['class' => 'product-image', 'lazy' => true]
                    ); ?>
                    <div class="product-content">
                        <div class="product-label text-label">Серия</div>
                        <h3 class="product-title">TEXTURE</h3>
                        <h4 class="product-text">Текстурированные плиты</h4>
                        <span class="card-link">Подробнее</span>
                    </div>
                </article>
            </a>
        </div>

        <div class="product-col">
            <a href="/blp/catalog#walypan" class="product-card-link">
                <article class="product-card">
                    <?php echo render_image(
                        '/blp/images-convert/blocks/products/series-walypan.png',
                        'Линеарные плиты серия WALYPAN',
                        ['class' => 'product-image', 'lazy' => true]
                    ); ?>
                    <div class="product-content">
                        <div class="product-label text-label">Серия</div>
                        <h3 class="product-title">WALYPAN</h3>
                        <h4 class="product-text">Линеарные плиты</h4>
                        <span class="card-link">Подробнее</span>
                    </div>
                </article>
            </a>
        </div>
    </div>
</section>
