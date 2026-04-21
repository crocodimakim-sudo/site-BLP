<?php
// 2026-04-20: added canonical, OG image
// 2026-04-20: SEO — title keyword-first, meta desc 155-160 chars
$page_title    = "Фиброцементные панели для архитекторов и проектировщиков — BLP Board";
$page_canonical = 'https://building-port.ru/blp/architect';
// 2026-04-20: og_image → real hero instead of missing og-default
$page_og_image  = 'https://building-port.ru/blp/images-convert/pages/architect/architect_hero.jpg';
$page_desc  = "Техническая поддержка архитекторов: документация, образцы, консультации по фиброцементным фасадным панелям BLP Board.";
$extra_css  = '<link rel="stylesheet" href="/blp/css/pages/architect.css">';
// 2026-04-20: fix — подключаем корректный JS страницы architect (был index.js)
$extra_js   = '<script src="/blp/js/pages/architect.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',                      'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Архитекторам и проектировщикам', 'url' => 'https://building-port.ru/blp/architect'],
];

ob_start();
?>

<div class="blp-audience-block">
    <h1 class="blp-section-title">Кому можем помочь</h1>

    <div class="blp-cards-grid">
        <div class="blp-card">
            <h2 class="blp-card-title">Архитекторам</h2>
            <p class="blp-card-text">Помогаем реализовать фасадную концепцию&nbsp;по внешнему виду&nbsp;и узлам</p>
        </div>

        <div class="blp-card">
            <h2 class="blp-card-title">Проектировщикам</h2>
            <p class="blp-card-text">Закрываем техническую часть: узлы, документация, корректная интеграция&nbsp;в проект</p>
        </div>

        <div class="blp-card">
            <h2 class="blp-card-title">Дизайнерам</h2>
            <p class="blp-card-text">Даем инструменты&nbsp;для работы&nbsp;с фактурами, цветами&nbsp;и ритмом фасада</p>
        </div>
    </div>

    <div class="blp-support-block">
        <div class="blp-support-content">
            <!-- 2026-04-20: список расширен реальными инструментами архитектора + ключевые слова -->
            <ul class="blp-support-list">
                <li>Техническая документация (сертификаты, паспорта плит)</li>
                <li>Техническое свидетельство от ФАУ ФЦС</li>
                <li>Образцы фиброцементных панелей по запросу</li>
                <li>Помощь в выборе подсистемы НВФ (навесного вентилируемого фасада)</li>
                <li>Консультации по интеграции фиброцементных панелей в проект</li>
            </ul>
        </div>
        <div class="blp-support-badge">
            <p class="blp-support-badge-text">Поддержка&nbsp;от концепции&nbsp;до реализации</p>
        </div>
    </div>
</div>

<?php include '../blocks/objects-section.php'; ?>

<?php include '../blocks/products-section.php'; ?>

<?php include '../blocks/benefits.php'; ?>

<div class="architect-specs">
<?php include '../blocks/specs-section.php'; ?>
</div>

<div class="blp-partner-card-wrap">
    <div class="blp-partner-card">
        <div class="blp-partner-card__content">
            <h2 class="blp-partner-card__title">Партнерская модель взаимодействия</h2>
            <p class="blp-partner-card__text">Мы выстраиваем долгосрочное сотрудничество&nbsp;с авторскими коллективами. Фиксация условий&nbsp;на этапе согласования.</p>
            <p class="blp-partner-card__note"><strong>Важно:</strong> Сотрудничество&nbsp;не влияет&nbsp;на архитектурные решения&nbsp;и не ограничивает ваш выбор — мы подключаемся&nbsp;как технический партнер.</p>
            <!-- 2026-04-20: CTA конкретизирован для аудитории архитекторов -->
            <a class="blp-partner-card__btn" href="/blp/contacts#form">Запросить техническую документацию</a>
        </div>
        <div class="blp-partner-card__image">
            <img src="/blp/images-convert/pages/architect/architect_hero.jpg" alt="Партнерская модель взаимодействия" width="600" height="450" fetchpriority="high" decoding="async">
        </div>
    </div>
</div>

<?php include '../blocks/partners-section.php'; ?>

<?php include '../blocks/contact-form.php'; ?>
<?php
$page_content = ob_get_clean();
include "../blocks/template.php";
