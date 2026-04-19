<?php
$page_title = "Архитекторам и проектировщикам — BLP Board";
$page_desc  = "Партнерская программа для архитекторов и проектировщиков. Техническая документация, образцы, консультации по интеграции фиброцементных панелей в проект.";
$extra_css  = '<link rel="stylesheet" href="/blp/css/pages/architect.css">';
$extra_js   = '<script src="/blp/js/pages/index.js" defer></script>';

ob_start();
?>

<div class="blp-audience-block">
    <h1 class="blp-section-title">Кому это принесёт пользу</h1>

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
            <h2 class="blp-support-title">Все, чтобы заложить материал&nbsp;в проект</h2>
            <ul class="blp-support-list">
                <li>Техническая документация (сертификаты, паспорта)</li>
                <li>Образцы</li>
                <li>Помощь&nbsp;в выборе подсистемы (Узлы крепления&nbsp;и типовые решения)</li>
                <li>Консультации&nbsp;по интеграции&nbsp;в проект</li>
            </ul>
        </div>
        <div class="blp-support-badge">
            <p class="blp-support-badge-text">Поддержка&nbsp;от концепции&nbsp;до реализации</p>
        </div>
    </div>
</div>

<div class="architect-specs">
<?php include '../blocks/specs-section.php'; ?>
</div>
<?php include '../blocks/products-section.php'; ?>
<?php include '../blocks/benefits.php'; ?>

<div class="blp-partner-card-wrap">
    <div class="blp-partner-card">
        <div class="blp-partner-card__content">
            <h2 class="blp-partner-card__title">Партнерская модель взаимодействия</h2>
            <p class="blp-partner-card__text">Мы выстраиваем долгосрочное сотрудничество&nbsp;с авторскими коллективами. Фиксация условий&nbsp;на этапе согласования.</p>
            <p class="blp-partner-card__note"><strong>Важно:</strong> Сотрудничество&nbsp;не влияет&nbsp;на архитектурные решения&nbsp;и не ограничивает ваш выбор — мы подключаемся&nbsp;как технический партнер.</p>
            <a class="blp-partner-card__btn" href="/blp/contacts#form">Оставить заявку</a>
        </div>
        <div class="blp-partner-card__image">
            <img src="/blp/images-convert/pages/architect/architect_hero.jpg" alt="Партнерская модель взаимодействия">
        </div>
    </div>
</div>

<?php include '../blocks/objects-section.php'; ?>

<?php include '../blocks/partners-section.php'; ?>

<?php include '../blocks/contact-form.php'; ?>
<?php
$page_content = ob_get_clean();
include "../blocks/template.php";
