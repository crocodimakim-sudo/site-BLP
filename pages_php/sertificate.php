<?php
// 2026-04-22: image-helper for WebP + lazy-loading support
require_once __DIR__ . '/../blocks/image-helper.php';

// 2026-05-04: title сокращён с 77 до 56 симв. (Phase 3, формулировка от пользователя)
$page_title = 'Сертификаты фиброцементных панелей - полная документация';
// 2026-05-04: description переписан с 177 до 152 симв., добавлены ключи НГ/К0/ФАУ ФЦС/госконтракты (Phase 3)
$page_desc = 'Сертификаты BLP Board: пожарная безопасность НГ (К0), техническое свидетельство ФАУ ФЦС. Документы для органов строительного надзора и госконтрактов.';
// 2026-04-24: SEO — canonical trailing slash removed (consistent with breadcrumb)
$page_canonical = 'https://building-port.ru/sertificate';
// 2026-04-20: og_image added (Stage 2 SEO)
$page_og_image  = 'https://building-port.ru/images-convert/pages/sertificate/cert_fire_safety.png';
$extra_css = '<link rel="stylesheet" href="/css/pages/sertificate.css">';
$extra_js = '<script src="/js/pages/sertificate.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',      'url' => 'https://building-port.ru/'],
    ['name' => 'Сертификаты',  'url' => 'https://building-port.ru/sertificate'],
];
require_once __DIR__ . '/../blocks/session_init.php';
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
                    <h1 class="cert-title">Сертификаты фиброцементных панелей — НГ, техническое свидетельство от ФАУ ФЦС</h1>
                    <!-- 2026-08-18: сверка с эталоном — добавлено упоминание нового ТС Минстроя № 7515-26, ТС 7292-25 не удалено -->
                    <p class="cert-subtitle">Полный комплект технической документации — включая техническое свидетельство ФАУ ФЦС № 7292-25 и техническое свидетельство Минстроя России № 7515-26, — соответствующий требованиям органов строительного надзора&nbsp;и подтверждающий<br> пригодность для применения в строительстве на территории РФ.</p>
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
                                <?php echo render_image('/images-convert/pages/sertificate/cert_technical_passport.png', 'Технический паспорт (Техническое свидетельство ФАУ ФЦС)'); ?>
                            </div>
                            <div class="slide-number">01</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 2 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/images-convert/pages/sertificate/cert_declaration_trts.png', 'Декларация ТР ТС'); ?>
                            </div>
                            <div class="slide-number">02</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 3 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/images-convert/pages/sertificate/cert_mchs_conclusion.png', 'Заключение МЧС'); ?>
                            </div>
                            <div class="slide-number">03</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 4 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/images-convert/pages/sertificate/cert_registration.png', 'Свидетельство о регистрации'); ?>
                            </div>
                            <div class="slide-number">04</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 5 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <?php echo render_image('/images-convert/pages/sertificate/cert_test_protocol.png', 'Протокол испытаний'); ?>
                            </div>
                            <div class="slide-number">05</div>
                        </div>
                    </div>

                    <!-- СЛАЙД 6 -->
                    <div class="carousel-slide">
                        <div class="slide-inner" oncontextmenu="return false;" ondragstart="return false;">
                            <div class="image-wrapper">
                                <img src="/images-convert/pages/sertificate/cert_fire_safety.png" alt="Сертификат пожарной безопасности" loading="lazy">
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

        <div class="cert-button-wrapper">
            <a href="/contacts#form" class="cert-button">
                <span>Запросить документы</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
        </div>

    </div>
</section>

<?php include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
?>
