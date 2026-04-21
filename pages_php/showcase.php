<?php
// 2026-04-20: Stage 3 Group 3.B — Project showcase / case studies page
$page_title    = 'Реализованные проекты с фиброцементными панелями BLP Board';
$page_canonical = 'https://building-port.ru/blp/showcase';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Кейсы применения фиброцементных панелей BLP Board: жилые комплексы, школы, административные здания, частные дома. Серия, объём, регион, результат.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/showcase.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',          'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Наши проекты',     'url' => 'https://building-port.ru/blp/showcase'],
];

// 2026-04-20: проекты — данные для schema и рендера
$projects = [
    [
        'id'      => 'sapronova',
        'name'    => 'ЖК «Сапронова»',
        'location'=> 'Москва, Московская область',
        'type'    => 'Жилой комплекс',
        'series'  => 'NATURE',
        'area'    => '3 200 м²',
        'year'    => '2024',
        'desc'    => 'Монолитный жилой комплекс бизнес-класса. Фасад выполнен панелями серии NATURE в цвете «Графитовый» — рельефная поверхность под архитектурный бетон усиливает брутальную эстетику здания. Применено скрытое крепление кляммерами на алюминиевой подсистеме. Класс НГ (К0) обеспечил прохождение пожарной экспертизы без доработок.',
        'result'  => 'Принят в эксплуатацию без замечаний по фасаду. Госэкспертиза пройдена с первого предъявления.',
        'image_dir' => 'sapronova',
    ],
    [
        'id'      => 'school',
        'name'    => 'Школа на 1 100 учеников',
        'location'=> 'г. Видное, Московская область',
        'type'    => 'Образовательный объект',
        'series'  => 'POLISHED',
        'area'    => '1 850 м²',
        'year'    => '2023',
        'desc'    => 'Государственный объект — новая школа на 1 100 учеников по программе Московской области. Для фасада использованы панели серии POLISHED: гладкая матовая поверхность в нейтральном белом цвете. Критическое требование заказчика — класс К0 для объекта с пребыванием детей. Все документы для госэкспертизы предоставлены в комплекте с поставкой.',
        'result'  => 'Объект сдан в срок. Фасад выбран по результатам сравнения с 3 альтернативными материалами.',
        'image_dir' => 'school',
    ],
    [
        'id'      => 'sud',
        'name'    => 'Административное здание',
        'location'=> 'Московская область',
        'type'    => 'Административный объект',
        'series'  => 'POLISHED',
        'area'    => '920 м²',
        'year'    => '2023',
        'desc'    => 'Реконструкция фасада административного здания. Задача — обновить внешний вид без изменения несущих конструкций, соответствовать требованиям к пожарной безопасности госучреждений. Выбрана серия POLISHED в тёмно-сером тоне. Лёгкий вес панелей (14 кг/м²) позволил смонтировать НВФ без усиления существующих перекрытий.',
        'result'  => 'Срок монтажа — 3 недели. Без остановки работы здания.',
        'image_dir' => 'sud',
    ],
    [
        'id'      => 'intl',
        'name'    => 'Международный логистический центр',
        'location'=> 'Московская область',
        'type'    => 'Промышленный / коммерческий объект',
        'series'  => 'NATURE',
        'area'    => '4 400 м²',
        'year'    => '2024',
        'desc'    => 'Крупный логистический центр площадью 4 400 м² фасада. Применены панели NATURE в двух цветах для зонирования фасадных плоскостей. Особенность объекта — высокая ветровая нагрузка (III ветровой район). Использованы панели толщиной 12 мм с усиленной подсистемой и расчётом на нагрузку. Поставка организована в 4 очереди по графику строительства.',
        'result'  => 'Поставки без сбоев по графику. Фасад смонтирован за 6 недель.',
        'image_dir' => 'intl',
    ],
];

ob_start();
?>
<!-- ============================================
     SHOWCASE HERO
     ============================================ -->
<section class="blp-hero-section showcase-hero">
    <div class="blp-container">
        <div class="blp-grid-12">
            <div class="blp-hero-content">
                <h1 class="blp-hero-title">Реализованные проекты<br>с панелями BLP Board</h1>
                <p class="blp-hero-subtitle">Жилые комплексы, школы, административные и коммерческие объекты — фиброцементный фасад в реальных условиях</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Серии NATURE и POLISHED — в реальных объектах</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Госэкспертиза — пройдена на всех объектах</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>От 920 до 4 400 м² — опыт разного масштаба</span>
                    </li>
                </ul>
                <a href="/blp/contacts" class="blp-hero-button">Обсудить ваш объект</a>
            </div>
            <div class="blp-hero-image showcase-hero-stats">
                <div class="showcase-stats-grid">
                    <div class="showcase-stat">
                        <span class="showcase-stat-num">10+</span>
                        <span class="showcase-stat-label">реализованных объектов</span>
                    </div>
                    <div class="showcase-stat">
                        <span class="showcase-stat-num">15 000+</span>
                        <span class="showcase-stat-label">м² установлено</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     PROJECT CARDS
     ============================================ -->
<section class="showcase-projects-section">
    <div class="blp-container">

        <?php foreach ($projects as $index => $project): ?>
        <article class="showcase-project" id="project-<?php echo htmlspecialchars($project['id']); ?>"
                 itemscope itemtype="https://schema.org/CreativeWork">
            <meta itemprop="name" content="<?php echo htmlspecialchars($project['name']); ?>">
            <meta itemprop="description" content="<?php echo htmlspecialchars($project['desc']); ?>">
            <meta itemprop="dateCreated" content="<?php echo htmlspecialchars($project['year']); ?>">

            <div class="showcase-project-inner <?php echo ($index % 2 === 1) ? 'showcase-project-reverse' : ''; ?>">

                <!-- Image gallery -->
                <div class="showcase-project-images">
                    <?php
                    $img_dir = "D:/Claude Code/site-blp/site-kimi/images-convert/pages/projects/" . $project['image_dir'] . "/";
                    $web_dir = "/blp/images-convert/pages/projects/" . $project['image_dir'] . "/";
                    $images = glob($img_dir . "*.{jpg,jpeg,png,webp}", GLOB_BRACE);
                    if ($images && count($images) > 0):
                        $main_img = basename($images[0]);
                    ?>
                    <div class="showcase-project-gallery">
                        <img src="<?php echo $web_dir . $main_img; ?>"
                             alt="<?php echo htmlspecialchars($project['name'] . ' — фасад ' . $project['series']); ?>"
                             class="showcase-project-main-img"
                             loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                             width="720" height="480">
                        <?php if (count($images) > 1): ?>
                        <div class="showcase-project-thumbs">
                            <?php foreach (array_slice($images, 1, 3) as $thumb): ?>
                            <img src="<?php echo $web_dir . basename($thumb); ?>"
                                 alt="<?php echo htmlspecialchars($project['name']); ?>"
                                 class="showcase-project-thumb" loading="lazy" width="220" height="148">
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="showcase-project-placeholder">
                        <div class="showcase-placeholder-inner">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span>Фото объекта</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Project info -->
                <div class="showcase-project-info">
                    <div class="showcase-project-meta">
                        <span class="showcase-meta-tag showcase-meta-type"><?php echo htmlspecialchars($project['type']); ?></span>
                        <span class="showcase-meta-tag showcase-meta-series"><?php echo htmlspecialchars($project['series']); ?></span>
                        <span class="showcase-meta-year"><?php echo htmlspecialchars($project['year']); ?></span>
                    </div>
                    <h2 class="showcase-project-name"><?php echo htmlspecialchars($project['name']); ?></h2>
                    <p class="showcase-project-location">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo htmlspecialchars($project['location']); ?>
                    </p>

                    <div class="showcase-project-specs">
                        <div class="showcase-spec">
                            <span class="showcase-spec-label">Серия панелей</span>
                            <span class="showcase-spec-value"><?php echo htmlspecialchars($project['series']); ?></span>
                        </div>
                        <div class="showcase-spec">
                            <span class="showcase-spec-label">Площадь фасада</span>
                            <span class="showcase-spec-value"><?php echo htmlspecialchars($project['area']); ?></span>
                        </div>
                        <div class="showcase-spec">
                            <span class="showcase-spec-label">Год</span>
                            <span class="showcase-spec-value"><?php echo htmlspecialchars($project['year']); ?></span>
                        </div>
                    </div>

                    <p class="showcase-project-desc"><?php echo htmlspecialchars($project['desc']); ?></p>

                    <div class="showcase-project-result">
                        <strong>Результат:</strong> <?php echo htmlspecialchars($project['result']); ?>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>

    </div>
</section>

<!-- ============================================
     USE CASES BY OBJECT TYPE
     ============================================ -->
<section class="showcase-usecases-section">
    <div class="blp-container">
        <h2 class="showcase-section-title">Области применения фиброцементных панелей BLP Board</h2>

        <div class="showcase-usecases-grid">
            <div class="showcase-usecase-card">
                <div class="showcase-usecase-icon">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h3>Жилые объекты</h3>
                <p>Жилые комплексы эконом, стандарт, бизнес-класса. Многоквартирные дома от 3 до 25+ этажей. Таунхаусы и частные дома (серия WALYPAN).</p>
                <p class="showcase-usecase-series">Серии: NATURE, POLISHED, WALYPAN</p>
            </div>
            <div class="showcase-usecase-card">
                <div class="showcase-usecase-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 20V7l-2-4H4L2 7v13a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/><line x1="12" y1="2" x2="12" y2="7"/><path d="M2 7h20"/></svg>
                </div>
                <h3>Коммерческие объекты</h3>
                <p>Торговые центры, офисные здания, бизнес-парки. Гостиницы, рестораны, фитнес-клубы. Логистические и производственные комплексы.</p>
                <p class="showcase-usecase-series">Серии: NATURE, TEXTURE, POLISHED</p>
            </div>
            <div class="showcase-usecase-card">
                <div class="showcase-usecase-icon">
                    <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <h3>Социальные объекты</h3>
                <p>Школы, детские сады, университеты. Больницы, поликлиники, медицинские центры. Государственные учреждения и административные здания. Требование К0 закрыто по умолчанию.</p>
                <p class="showcase-usecase-series">Серии: POLISHED (рекомендуется)</p>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org для проектов -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Реализованные проекты BLP Board",
  "description": "Кейсы применения фиброцементных панелей BLP Board на реальных объектах",
  "numberOfItems": <?php echo count($projects); ?>,
  "itemListElement": [
    <?php foreach ($projects as $i => $p): ?>
    {
      "@type": "ListItem",
      "position": <?php echo $i + 1; ?>,
      "item": {
        "@type": "CreativeWork",
        "name": "<?php echo addslashes($p['name']); ?>",
        "description": "<?php echo addslashes($p['desc']); ?>",
        "dateCreated": "<?php echo $p['year']; ?>",
        "locationCreated": {
          "@type": "Place",
          "name": "<?php echo addslashes($p['location']); ?>"
        }
      }
    }<?php echo ($i < count($projects) - 1) ? ',' : ''; ?>
    <?php endforeach; ?>
  ]
}
</script>

<?php $form_title = 'Хотите такой же результат?'; $form_desc = 'Расскажите о вашем объекте — подберём серию, рассчитаем объём, предоставим документы.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
