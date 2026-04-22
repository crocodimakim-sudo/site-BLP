<?php
// 2026-04-22: image-helper for WebP + lazy-loading support
require_once __DIR__ . '/../blocks/image-helper.php';

$page_title = 'Сертификаты фиброцементных панелей — НГ, соответствие требованиям';
$page_desc = 'Полный комплект технической документации, соответствующий требованиям органов строительного надзора и подтверждающий пригодность для применения в строительстве на территории РФ.';
// 2026-04-20: canonical URL added (Task #14 — critical SEO fix)
$page_canonical = 'https://building-port.ru/blp/sertificate/';
// 2026-04-20: og_image added (Stage 2 SEO)
$page_og_image  = 'https://building-port.ru/blp/images-convert/pages/sertificate/cert_fire_safety.png';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/sertificate.css">';
$extra_js = '<script src="/blp/js/pages/sertificate.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',      'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Сертификаты',  'url' => 'https://building-port.ru/blp/sertificate'],
];
ob_start();
?>

<!-- ============================================
     БЛОК СЕРТИФИКАТОВ - С ВОТЕРМАРКОЙ И ЗАЩИТОЙ
     ============================================ -->
<section class="certificates-section">
    <div class="cert-container">
        <!-- Шапка слева с h1 и h2 -->
        <div class="cert-header">
            <div class="cert-header-top">
                <div class="cert-header-left">
                    <div class="cert-header-accent"></div>
                    <h1 class="cert-title">Сертификаты фиброцементных панелей — НГ, соответствие требованиям</h1>
                    <p class="cert-subtitle">Полный комплект технической документации, соответствующий требованиям органов строительного надзора&nbsp;и подтверждающий<br> пригодность для применения в строительстве на территории РФ.</p>
                </div>
                <div class="cert-button-wrapper">
                    <a href="/blp/contacts#form" class="cert-button">
                        <span>Запросить документы</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Горизонтальная карусель с защитой -->
        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-btn-prev" onclick="scrollCarousel(-1)" aria-label="Назад">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="carousel-track-container">
                <div class="carousel-track" id="carouselTrack">
                    <!-- СЛАЙД 1 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/blp/images-convert/pages/sertificate/cert_declaration_trts.png', 'Декларация ТР ТС'); ?>
                            </div>
                            <div class="slide-number">01</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 2 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/blp/images-convert/pages/sertificate/cert_technical_passport.png', 'Технический паспорт'); ?>
                            </div>
                            <div class="slide-number">02</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 3 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/blp/images-convert/pages/sertificate/cert_mchs_conclusion.png', 'Заключение МЧС'); ?>
                            </div>
                            <div class="slide-number">03</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 4 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/blp/images-convert/pages/sertificate/cert_registration.png', 'Свидетельство о регистрации'); ?>
                            </div>
                            <div class="slide-number">04</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 5 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/blp/images-convert/pages/sertificate/cert_test_protocol.png', 'Протокол испытаний'); ?>
                            </div>
                            <div class="slide-number">05</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 6 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <img src="/blp/images-convert/pages/sertificate/cert_fire_safety.png" alt="Сертификат пожарной безопасности" loading="lazy">
                            </div>
                            <div class="slide-number">06</div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-btn carousel-btn-next" onclick="scrollCarousel(1)" aria-label="Вперед">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

    </div>
</section>

<?php include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
?>