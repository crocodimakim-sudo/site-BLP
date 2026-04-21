<?php
// 2026-04-20: added canonical, OG image
// 2026-04-20: SEO — title keyword-first, meta desc 155-160 chars
$page_title    = 'Фиброцементные фасадные панели для застройщиков — BLP Board';
$page_canonical = 'https://building-port.ru/blp/devops';
// 2026-04-20: og_image → real hero instead of missing og-default
$page_og_image  = 'https://building-port.ru/blp/images-convert/pages/devops/devops_hero.jpg';
$page_desc  = 'Фиброцементные фасадные панели для застройщиков. ГОСТ, НГ (К0), поставки в срок по договору. BLP Board — от подбора до монтажа. Документы для госэкспертизы включены.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/devops.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',      'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Застройщикам', 'url' => 'https://building-port.ru/blp/devops'],
];

ob_start();
?>
<!-- ========================================

     HERO SECTION — ПЕРВЫЙ ЭКРАН

     ======================================== -->

<section class="hero-section">

    <div class="hero-card">

        <!-- Фоновое изображение -->

        <div class="hero-bg"></div>

        

        <!-- Оверлей -->

        <div class="hero-overlay"></div>

        

        <!-- Контент -->

        <div class="hero-content">

            <div class="hero-label">BLP Board</div>

            <!-- 2026-04-20: H1 расширен, CTA конкретизирован, href исправлен (/contacts → /blp/contacts) -->
            <h1 class="hero-title">Фиброцементные панели BLP&nbsp;Board<br>для застройщиков и подрядчиков</h1>

            <p class="hero-subtitle">Берём фасадное решение&nbsp;на себя: от подбора&nbsp;до поставки — чтобы вы уложились&nbsp;в бюджет&nbsp;и сроки проекта</p>

            <a href="/blp/contacts#form" class="hero-cta">Запросить расчёт поставки</a>

        </div>

    </div>

</section>

<!-- ========================================

     БЛОК ТЕХНИЧЕСКИХ ПРЕИМУЩЕСТВ

     ======================================== -->

<section class="tech-section">

    <div class="section-header">

        <h2 class="section-title">Почему работают&nbsp;с нами</h2>

    </div>

    <div class="tech-grid">

        <!-- Карточка 1: Совместимость -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">01</div>

                <div class="tech-content">

                    <div class="tech-label">Технология</div>

                    <h3 class="tech-title">Совместимость<br>с подсистемами</h3>

                    <p class="tech-text">Панели работают&nbsp;со всеми типами фасадных подсистем без ограничений.</p>

                    <ul class="tech-list">

                        <li>Алюминиевые подсистемы</li>

                        <li>Оцинкованная сталь</li>

                        <li>Нержавеющая сталь</li>

                    </ul>

                </div>

            </article>

        </div>

        <!-- Карточка 2: Юридическая чистота -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">02</div>

                <div class="tech-content">

                    <div class="tech-label">Безопасность</div>

                    <h3 class="tech-title">Юридическая&nbsp;и техническая надежность</h3>

                    <p class="tech-text">Полный пакет документов&nbsp;для госэкспертизы.</p>

                    <ul class="tech-list">

                        <li>Соответствие ГОСТ</li>

                        <li>Пожарная сертификация НГ (К0)</li>

                        <li>Морозостойкость ≥150 циклов</li>

                    </ul>

                </div>

            </article>

        </div>

        <!-- Карточка 3: Поставки -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">03</div>

                <div class="tech-content">

                    <div class="tech-label">Логистика</div>

                    <h3 class="tech-title">Поставки точно&nbsp;в срок</h3>

                    <p class="tech-text">Согласовываем график отгрузок<br>под ваш проект. Фиксируем даты<br>в договоре.</p>

                    <ul class="tech-list">

                        <li>Гибкий график&nbsp;под проект</li>

                        <li>Гарантия отгрузки&nbsp;в срок</li>

                    </ul>

                </div>

            </article>

        </div>

    </div>

</section>

<!-- ========================================
     БЛОК ПРОЕКТОВ
     ======================================== -->
<?php include '../blocks/objects-section.php'; ?>

<!-- ========================================
     БЛОК ПРЕИМУЩЕСТВ (общий)
     ======================================== -->
<?php include '../blocks/benefits.php'; ?>

<!-- ========================================
     БЛОК ПАРТНЁРОВ
     ======================================== -->
<?php include '../blocks/partners-section.php'; ?>

<!-- ========================================
     ФОРМА ОБРАТНОЙ СВЯЗИ
     ======================================== -->
<?php include '../blocks/contact-form.php'; ?>
<?php
$page_content = ob_get_clean();
include 'template.php';