<?php
$page_title = 'Объекты - Проекты с фасадом из фиброцементных панелей BLPboard';
$page_desc  = 'Портфолио реализованных объектов с фасадом из фиброцементных панелей BLPboard: поликлиники, школы, здания судов, международные проекты';
$extra_css  = '<link rel="stylesheet" href="/blp/css/pages/projects.css">';
$extra_js   = '<script src="/blp/js/pages/projects.js" defer></script>';

ob_start();
?>

<section class="projects-modern">
    <div class="section-header">
        <h1 class="section-title">Объекты&nbsp;с фасадом&nbsp;из фиброцементных панелей BLPboard</h1>
    </div>

    <div class="projects-grid" id="projectsGrid"></div>
</section>

<div class="modal-overlay" id="projectModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="fullscreen-slider" id="modalSlider"></div>

        <button class="modal-nav prev" onclick="changeModalSlide(-1)">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
        <button class="modal-nav next" onclick="changeModalSlide(1)">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </button>

        <div class="modal-info" id="modalInfo">
            <div class="modal-title" id="modalTitle"></div>
            <div class="modal-location" id="modalLocation">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span id="modalLocationText"></span>
            </div>
        </div>

        <div class="modal-thumbs" id="modalThumbs"></div>
    </div>
</div>

<!-- ========================================
     BLOCK PREIMUSHHESTVA (shared)
     ======================================== -->
<?php include '../blocks/benefits.php'; ?>

<!-- ========================================
     CONTACT FORM
     ======================================== -->
<?php
$form_title = 'Узнать подробнее об объектах';
$form_desc  = 'Оставьте заявку — мы расскажем о реализованных проектах и подберём решение для вашего объекта';
include '../blocks/contact-form.php';
?>

<?php
$page_content = ob_get_clean();
include 'template.php';

