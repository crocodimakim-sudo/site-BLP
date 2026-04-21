<?php
// 2026-04-20: added canonical, OG image
// 2026-04-20: SEO — title keyword-first, meta desc 155-160 chars
$page_title    = 'Дилерская программа BLP Board — фиброцементные панели';
$page_canonical = 'https://building-port.ru/blp/diler';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Дилерская программа по фиброцементным панелям BLP Board. Проектные продажи, техподдержка, прозрачные условия сотрудничества. Востребованный продукт для жилых и коммерческих объектов.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/diler.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Дилерам', 'url' => 'https://building-port.ru/blp/diler'],
];

ob_start();
?>
<!-- ============================================
     HERO БЛОК - ПЕРВЫЙ ЭКРАН
     ============================================ -->
<section class="blp-hero-section">
    <div class="blp-container">
        <div class="blp-grid-12">
            <!-- Контент - левая часть -->
            <div class="blp-hero-content">
                <!-- 2026-04-20: H1 обновлён — добавлен бренд -->
                <h1 class="blp-hero-title">Дилерская программа BLP Board&nbsp;<br>по фиброцементным панелям</h1>
                <p class="blp-hero-subtitle">Продавайте фиброцементные панели для жилых, коммерческих и социальных объектов — мы обеспечиваем техподдержку и сопровождение сделки</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check">
                            <svg viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>сопровождение сделки&nbsp;до реализации</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check">
                            <svg viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>востребованный продукт для жилых, коммерческих и социальных объектов</span>
                    </li>
                </ul>
                <!-- 2026-04-20: href="#" исправлен на форму контактов -->
                <a href="/blp/contacts#form" class="blp-hero-button">Стать дилером BLP Board</a>
            </div>
            <!-- Изображение - правая часть -->
            <div class="blp-hero-image">
                <img src="/blp/images-convert/pages/diler/diler_hero.jpg" alt="Объект с фиброцементными панелями" class="blp-hero-img" width="600" height="450" fetchpriority="high" decoding="async">
            </div>
        </div>
    </div>
</section>







    <!-- ============================================
         БЛОК ПРЕИМУЩЕСТВ ДЛЯ ДИЛЕРОВ
         ============================================ -->
    <section class="blp-benefits-section">
        <div class="blp-container">
            <div class="blp-grid-12">
                
                <!-- Заголовок блока -->
                <h2 class="blp-benefits-title">Почему дилеры работают&nbsp;с нами</h2>
                
                <!-- Карточка 1: Работа с проектом -->
                <div class="blp-benefit-card">
                    <div class="blp-benefit-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="blp-benefit-content">
                        <div class="blp-benefit-heading-box">
                            <h3>Работа&nbsp;с проектом, а&nbsp;не просто поставка</h3>
                        </div>
                        <div class="blp-benefit-description-box">
                            <h4>Подключаемся&nbsp;к задаче клиента&nbsp;и помогаем довести решение&nbsp;до реализации</h4>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка 2: Поддержка в продаже -->
                <div class="blp-benefit-card">
                    <div class="blp-benefit-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="blp-benefit-content">
                        <div class="blp-benefit-heading-box">
                            <h3>Поддержка&nbsp;в продаже</h3>
                        </div>
                        <div class="blp-benefit-description-box">
                            <h4>Помогаем&nbsp;с подбором, аргументацией&nbsp;и проработкой объекта</h4>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка 3: Гибкое подключение -->
                <div class="blp-benefit-card">
                    <div class="blp-benefit-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </div>
                    <div class="blp-benefit-content">
                        <div class="blp-benefit-heading-box">
                            <h3>Гибкое подключение</h3>
                        </div>
                        <div class="blp-benefit-description-box">
                            <h4>Включаемся&nbsp;на любой стадии — от концепции&nbsp;до стройки</h4>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка 4: Понятное взаимодействие -->
                <div class="blp-benefit-card">
                    <div class="blp-benefit-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="blp-benefit-content">
                        <div class="blp-benefit-heading-box">
                            <h3>Понятное взаимодействие</h3>
                        </div>
                        <div class="blp-benefit-description-box">
                            <h4>Работаем прозрачно: от запроса&nbsp;до поставки</h4>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>



<!--БЛОК "ПОЧЕМУ ЭТО ИНТЕРЕСНО-->




    <!-- ============================================
         БЛОК "ПОЧЕМУ ЭТО ИНТЕРЕСНО"
         ============================================ -->
    <section class="blp-interesting-section">
        <div class="blp-container">
            <div class="blp-grid-12">
                
                <!-- Заголовок блока -->
                <h2 class="blp-interesting-title">Почему&nbsp;это интересно?</h2>
                
                <!-- Контент - левая часть -->
                <div class="blp-interesting-content">
                    <p class="blp-interesting-text">
                        Решение&nbsp;по фасаду принимается&nbsp;не только&nbsp;по цене, но&nbsp;и по внешнему виду, требованиям объекта&nbsp;и удобству реализации.
                    </p>
                    
                    <div class="blp-interesting-highlight">
                        Это позволяет работать&nbsp;с проектами, где важна&nbsp;не только минимальная стоимость, а комплексное решение&nbsp;для объекта.
                    </div>
                </div>
                
                <!-- Декоративная иконка - правая часть (скрывается на планшете и мобильном) -->
                <div class="blp-interesting-visual">
                    <div class="blp-interesting-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-9a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v9"/>
                            <path d="M9 21v-6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6"/>
                        </svg>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

<?php include '../blocks/benefits.php'; ?>

<?php include '../blocks/objects-section.php'; ?>

<?php $form_title = 'Стать дилером'; $form_desc = 'Оставьте заявку и мы свяжемся с вами для обсуждения условий сотрудничества.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
