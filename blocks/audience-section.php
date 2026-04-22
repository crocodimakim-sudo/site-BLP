<?php
// 2026-04-22: require image-helper (may already be loaded by parent page)
if (!function_exists('render_image')) {
    require_once __DIR__ . '/image-helper.php';
}
?>
<section class="audience-section" aria-labelledby="audience-heading">
    <div class="section-header">
        <h2 id="audience-heading">Кому подойдут наши решения</h2>
    </div>

    <div class="audience-grid">
        <div class="audience-col">
            <a href="/blp/architect" class="audience-card-link">
                <article class="audience-card">
                    <div class="audience-image-wrapper">
                        <?php echo render_image(
                            '/blp/images-convert/pages/index/audience/audience_architect.png',
                            'Архитекторы работают над проектом',
                            ['class' => 'audience-image', 'sizes' => '(max-width: 768px) 100vw, 400px']
                        ); ?>
                    </div>
                    <div class="audience-content">
                        <h3 class="audience-title">Архитекторам&nbsp;и проектировщикам</h3>
                        <h4 class="audience-text">Документация, узлы, комплексная поддержка</h4>
                        <span class="btn btn-secondary">подробнее</span>
                    </div>
                </article>
            </a>
        </div>

        <div class="audience-col">
            <a href="/blp/devops" class="audience-card-link">
                <article class="audience-card">
                    <div class="audience-image-wrapper">
                        <?php echo render_image(
                            '/blp/images-convert/pages/index/audience/audience_developer.png',
                            'Застройщики обсуждают проект',
                            ['class' => 'audience-image', 'sizes' => '(max-width: 768px) 100vw, 400px']
                        ); ?>
                    </div>
                    <div class="audience-content">
                        <h3 class="audience-title">Застройщикам&nbsp;и подрядчикам</h3>
                        <h4 class="audience-text">Прямые поставки, фиксация цены&nbsp;и сопровождение&nbsp;на всех этапах</h4>
                        <span class="btn btn-secondary">подробнее</span>
                    </div>
                </article>
            </a>
        </div>

        <div class="audience-col">
            <a href="/blp/dealer" class="audience-card-link">
                <article class="audience-card">
                    <div class="audience-image-wrapper">
                        <?php echo render_image(
                            '/blp/images-convert/pages/index/audience/audience_dealer.png',
                            'Дилеры на встрече',
                            ['class' => 'audience-image', 'sizes' => '(max-width: 768px) 100vw, 400px']
                        ); ?>
                    </div>
                    <div class="audience-content">
                        <h3 class="audience-title">Дилерам</h3>
                        <h4 class="audience-text">Стабильные поставки, тех.поддержка&nbsp;и полная вовлеченность&nbsp;в каждый объект</h4>
                        <span class="btn btn-secondary">подробнее</span>
                    </div>
                </article>
            </a>
        </div>
    </div>
</section>
