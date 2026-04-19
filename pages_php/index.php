<?php
$page_title = 'BLP Board — Фиброцементные панели';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/index.css">';
$extra_js = '<script src="/blp/js/pages/index.js" defer></script>';

ob_start();
?>

<section class="hero-main">
    <div class="hero-container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="badge">BLP Board</div>
                <h1 style="margin-bottom: 20px;">Фиброцементные плиты&nbsp;для вентилируемых фасадов</h1>
                <p class="hero-subtitle">Архитектурные панели окрашенные&nbsp;в массе</p>

                <div class="hero-tags">
                    <span class="tag">НГ (негорючие)</span>
                    <span class="tag">0% асбеста</span>
                    <span class="tag">Крупноформатные</span>
                </div>

                <a href="/blp/contacts" class="btn btn-primary">Оставить заявку</a>
            </div>

            <div class="hero-image-wrapper">
                <img src="/blp/images-convert/pages/index/index_hero.jpg"
                     alt="Фиброцементные плиты BLP Board"
                     class="hero-image">
            </div>
        </div>
    </div>
</section>

<?php include '../blocks/products-section.php'; ?>

<?php include '../blocks/audience-section.php'; ?>

<?php include '../blocks/benefits.php'; ?>

<?php include '../blocks/objects-section.php'; ?>

<?php include '../blocks/partners-section.php'; ?>

<?php include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
