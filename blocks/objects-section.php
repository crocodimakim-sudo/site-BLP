<section class="objects-section">
    <div class="section-header">
        <h2 class="section-title">Объекты&nbsp;с фасадом&nbsp;из фиброцементных плит</h2>
    </div>

    <div class="objects-grid">
        <!-- 2026-04-24: alt="" — декоративное изображение в ссылке, h3 уже описывает назначение (WCAG H67) -->
        <!-- 2026-09-06: alt заполнены — снимки показывают тип объекта, это контентные изображения; текст ссылки не дублируется -->
        <!-- 2026-05-04: <img> → render_image() для webp + lazy (Phase 5) — экономия ~1.6 МБ, LCP -3..-4s -->
        <?php require_once __DIR__ . '/image-helper.php'; ?>
        <a href="/projects" class="object-card">
            <?php echo render_image('/images-convert/blocks/objects/object_residential.png', 'Жилой комплекс с фасадом из фиброцементных панелей BLP Board', ['class' => 'object-image']); ?>
            <div class="object-info">
                <h3 class="object-title">Жилые комплексы</h3>
            </div>
        </a>

        <a href="/projects" class="object-card">
            <?php echo render_image('/images-convert/blocks/objects/object_admin.png', 'Административное здание, облицованное фиброцементными панелями', ['class' => 'object-image']); ?>
            <div class="object-info">
                <h3 class="object-title">Административные здания</h3>
            </div>
        </a>

        <a href="/projects" class="object-card">
            <?php echo render_image('/images-convert/blocks/objects/object_commercial.png', 'Коммерческое здание с вентилируемым фасадом из фиброцемента', ['class' => 'object-image']); ?>
            <div class="object-info">
                <h3 class="object-title">Коммерческая недвижимость</h3>
            </div>
        </a>

        <a href="/projects" class="object-card">
            <?php echo render_image('/images-convert/blocks/objects/object_healthcare.jpg', 'Объект здравоохранения с фасадом из фиброцементных плит', ['class' => 'object-image']); ?>
            <div class="object-info">
                <h3 class="object-title">Объекты здравоохранения</h3>
            </div>
        </a>

        <a href="/projects" class="object-card">
            <?php echo render_image('/images-convert/blocks/objects/object_education.jpg', 'Школа с навесным вентилируемым фасадом из фиброцементных панелей', ['class' => 'object-image']); ?>
            <div class="object-info">
                <h3 class="object-title">Образовательные учреждения</h3>
            </div>
        </a>

        <div class="cta-card">
            <h3 class="cta-text">Хотите увидеть больше реализованных проектов?</h3>
            <a href="/projects" class="btn-cta">Смотреть все объекты</a>
        </div>
    </div>
</section>