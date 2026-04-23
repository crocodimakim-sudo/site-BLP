<?php
// 2026-04-22: image-helper for WebP + lazy-loading support
require_once __DIR__ . '/../blocks/image-helper.php';

// 2026-04-20: Stage 3 Group 3.B — Dealer/partner benefits page with LocalBusiness schema
$page_title    = 'Дилерская программа BLP Board — фиброцементные панели для партнёров';
$page_canonical = 'https://building-port.ru/blp/dealer';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Дилерская программа BLP Board: условия сотрудничества, ценовые уровни, маркетинговая поддержка, техническое сопровождение, обучение. Стать дилером фиброцементных панелей.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/dealer.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',             'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Дилерская программа', 'url' => 'https://building-port.ru/blp/dealer'],
];

ob_start();
?>
<!-- ============================================
     DEALER HERO — matching Tilda reference
     ============================================ -->
<section class="blp-hero-section dealer-hero">
    <div class="blp-container">
        <div class="blp-grid-12">
            <div class="blp-hero-content">
                <h1 class="blp-hero-title">Дилерская программа по&nbsp;фиброцементным плитам</h1>
                <p class="blp-hero-subtitle">Долгосрочная работа через проектные продажи</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>востребованный продукт для жилых, коммерческих и&nbsp;социальных объектов</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>сопровождение сделки до&nbsp;реализации</span>
                    </li>
                </ul>
                <a href="/blp/contacts#form" class="blp-hero-button">Обсудить сотрудничество</a>
            </div>
            <div class="blp-hero-image dealer-hero-visual">
                <?php echo render_image('/blp/images-convert/pages/diler/diler_hero.jpg', 'Объект с фиброцементными панелями BLP Board', ['fetchpriority' => 'high']); ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     WHY BLP — основные преимущества
     ============================================ -->
<section class="dealer-why-section">
    <div class="blp-container">
        <h2 class="dealer-section-title">Почему дилеры выбирают<br>BLP Board</h2>
        <div class="dealer-why-grid">
            <div class="dealer-why-card">
                <div class="dealer-why-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Технический специалист в каждой сделке</h3>
                <p>Наш технолог подключается к работе с вашим клиентом: помогает с выбором серии, толщины, расчётом нагрузок, подбором подсистемы. Это повышает конверсию в заказ.</p>
            </div>
            <div class="dealer-why-card">
                <div class="dealer-why-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <h3>Полный пакет документов</h3>
                <p>Технический паспорт, пожарный сертификат, расчёт ветровых нагрузок — всё для экспертизы. Предоставляем по запросу бесплатно.</p>
            </div>
            <div class="dealer-why-card">
                <div class="dealer-why-icon">
                    <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3>Маркетинговые материалы</h3>
                <p>Предоставляем образцы, буклеты, каталоги, шаблоны коммерческих предложений. Совместное участие в отраслевых выставках — по согласованию.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     HOW TO BECOME A DEALER — 2026-04-22: Timeline redesign
     ============================================ -->
<section class="dealer-steps-section">
    <div class="blp-container">
        <h2 class="dealer-section-title">Всё просто:</h2>

        <div class="dealer-steps-grid">

            <!-- Шаг 1: Подайте заявку — иконка: форма/конверт -->
            <div class="dealer-step-card">
                <div class="dealer-step-icon-wrap">
                    <span class="dealer-step-num">1</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <polyline points="2,4 12,13 22,4"/>
                    </svg>
                </div>
                <div class="dealer-step-text">
                    <h3>Подайте заявку</h3>
                    <p>Позвоните или заполните форму.</p>
                </div>
            </div>

            <!-- Шаг 2: Встреча с менеджером — иконка: рукопожатие/люди -->
            <div class="dealer-step-card">
                <div class="dealer-step-icon-wrap">
                    <span class="dealer-step-num">2</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="dealer-step-text">
                    <h3>Встреча с менеджером</h3>
                    <p>Обсудим условия: в офисе или онлайн.</p>
                </div>
            </div>

            <!-- Шаг 3: Подписание договора — иконка: документ с подписью -->
            <div class="dealer-step-card">
                <div class="dealer-step-icon-wrap">
                    <span class="dealer-step-num">3</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <path d="M8 17c.5-1 1.5-1 2 0s1.5 1 2 0"/>
                    </svg>
                </div>
                <div class="dealer-step-text">
                    <h3>Подписание договора</h3>
                    <p>Фиксируем цены и сроки в договоре.</p>
                </div>
            </div>

            <!-- Шаг 4: Старт продаж — акцентная карточка, иконка: ракета/старт -->
            <div class="dealer-step-card dealer-step-card--final">
                <div class="dealer-step-icon-wrap">
                    <span class="dealer-step-num">4</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 3l14 9-14 9V3z"/>
                    </svg>
                </div>
                <div class="dealer-step-text">
                    <h3>Старт продаж</h3>
                    <p>Получаете образцы и документацию. Продаём вместе.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Schema.org LocalBusiness JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "BLP Board — дилерская программа",
  "description": "Дилерская программа по фиброцементным панелям BLP Board. Серии NATURE, POLISHED, TEXTURE, WALYPAN. Класс НГ (К0), без асбеста, ГОСТ 8747-88.",
  "url": "https://building-port.ru/blp/dealer",
  "telephone": "+74959849689",
  "email": "info@building-port.ru",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "ул. Неделина, 6А",
    "addressLocality": "Одинцово",
    "addressRegion": "Московская область",
    "postalCode": "143003",
    "addressCountry": "RU"
  },
  "areaServed": {
    "@type": "Country",
    "name": "Russia"
  },
}
</script>

<?php $form_title = 'Стать дилером BLP Board'; $form_desc = 'Оставьте заявку — свяжемся в течение рабочего дня для обсуждения условий.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
