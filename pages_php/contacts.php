<?php
// 2026-04-20: added canonical, OG image
// 2026-04-20: SEO — title geo-enriched, meta desc 155-160 chars
$page_title    = 'Контакты BLP Board — Одинцово, Московская область';
$page_canonical = 'https://building-port.ru/blp/contacts';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Контакты BLP Board: +7 (495) 984-96-89, Одинцово, ул. Неделина 6А. Работаем с архитекторами, застройщиками и дилерами. Заявка онлайн — ответим в течение рабочего дня.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/contacts.css">';
$extra_js = '<script src="/blp/js/pages/contacts.js" defer></script>';

// 2026-04-23: session_start() до ob_start() — иначе CSRF-токен в форме будет пустым
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',  'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Контакты', 'url' => 'https://building-port.ru/blp/contacts'],
];

ob_start();
?>

<!-- 2026-04-24: CSS scroll-margin-top вместо JS — smooth-scroll браузера затирал JS-скролл -->
<style>
@media (max-width: 768px) {
    #form { scroll-margin-top: 65px !important; }
}
</style>

<!-- Контакты -->
<section class="contacts-section">
    <div class="contacts-container">
        <div class="contacts-header">
            <!-- 2026-04-20: H1 расширен для локального SEO (было: «Контакты») -->
            <h1 class="contacts-title">Контакты BLP Board</h1>
            <p class="contacts-subtitle">Работаем с архитекторами, застройщиками и дилерами. Доставка по всей России.</p>
        </div>

        <div class="contacts-grid">
            <div class="contacts-card">
                <div class="contacts-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <span class="contacts-label">Телефон</span>
                <a href="tel:+74959849689" class="contacts-value">+7 (495) 984-96-89</a>
            </div>

            <div class="contacts-card">
                <div class="contacts-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <span class="contacts-label">E-mail</span>
                <a href="mailto:info@building-port.ru" class="contacts-value">info@building-port.ru</a>
            </div>

            <div class="contacts-card">
                <div class="contacts-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <span class="contacts-label">Адрес</span>
                <p class="contacts-value">Одинцово, ул. Неделина, 6А</p>
            </div>
        </div>

    </div>
</section>

<!-- Форма обратной связи -->
<section class="contacts-form-section" id="form">
    <div class="contacts-form-wrapper">
        <!-- 2026-04-23: добавлены action/method для fallback без JS -->
        <form class="contact-form" id="contactsPageForm" action="/blp/blocks/send-form.php" method="POST" novalidate>
            <h2 class="contact-form-title">Написать нам</h2>
            <p class="contact-form-desc">Заполните форму — мы ответим&nbsp;в течение рабочего дня</p>
            <div class="contact-form-grid contact-form-grid--3col">

                <!-- Имя -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        Имя
                        <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        placeholder="Иван"
                        required
                    />
                    <span class="field-error" data-field="name"></span>
                </div>

                <!-- Телефон -->
                <div class="form-group">
                    <label for="phone" class="form-label">
                        Телефон
                        <span class="required">*</span>
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="form-input"
                        placeholder="+7 (999) 123-45-67"
                        required
                    />
                    <span class="field-error" data-field="phone"></span>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        Email
                        <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="example@company.com"
                        required
                    />
                    <span class="field-error" data-field="email"></span>
                </div>

                <!-- Сообщение -->
                <div class="form-group form-group--full">
                    <label for="message" class="form-label">Сообщение</label>
                    <textarea
                        id="message"
                        name="message"
                        class="form-input form-textarea"
                        rows="4"
                        placeholder="Опишите ваш вопрос или задачу..."
                    ></textarea>
                    <span class="field-error" data-field="message"></span>
                </div>

                <!-- Согласие -->
                <div class="form-checkbox-group form-checkbox-group--full">
                    <input
                        type="checkbox"
                        id="consent"
                        name="consent"
                        class="form-checkbox"
                        required
                    />
                    <label for="consent" class="form-checkbox-label">Я даю согласие&nbsp;на <a href="/blp/consent" target="_blank" rel="noopener noreferrer">обработку персональных данных</a>&nbsp;и принимаю условия <a href="/blp/policy" target="_blank" rel="noopener noreferrer">Политики конфиденциальности</a></label>
                    <span class="field-error" data-field="consent"></span>
                </div>

                <!-- Submit -->
                <div class="form-submit-wrapper">
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <span class="btn-text">Отправить сообщение</span>
                    </button>
                </div>

                <!-- Messages -->
                <div class="form-message success" id="successMessage">
                    ✓ Спасибо! Ваше сообщение отправлено. Мы свяжемся&nbsp;с вами&nbsp;в ближайшее время.
                </div>
                <div class="form-message error" id="errorMessage"></div>

                <!-- 2026-04-22: CSRF token protection -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
            </div>
        </form>
    </div>
</section>

<!-- Яндекс Карта -->
<section class="map-section">
    <div class="map-container">
        <div id="yandex-map" class="yandex-map"></div>
    </div>
</section>

<!-- 2026-04-24: реквизиты ООО «Билдингпорт» -->
<section class="contacts-requisites-section">
    <div class="contacts-container">
        <div class="contacts-requisites">
            <h2 class="contacts-requisites-title">Реквизиты организации</h2>
            <div class="contacts-requisites-grid">
                <div class="contacts-requisites-col">
                    <p><strong>Полное наименование:</strong><br>Общество с ограниченной ответственностью «Билдингпорт»</p>
                    <p><strong>Краткое наименование:</strong> ООО «Билдингпорт»</p>
                    <p><strong>ИНН:</strong> 7708427307</p>
                    <p><strong>КПП:</strong> 770801001</p>
                    <p><strong>ОГРН:</strong> 1237700843390</p>
                </div>
                <div class="contacts-requisites-col">
                    <p><strong>Юридический и почтовый адрес:</strong><br>107140, г. Москва, ул. Краснопрудная, д. 15, помещ. 3А/2</p>
                    <p><strong>Фактический адрес:</strong><br>143003, Московская область, г. Одинцово, ул. Неделина, д. 6А</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2026-04-20: LocalBusiness schema for contacts page -->
<?php include __DIR__ . '/schema_localbusiness.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
