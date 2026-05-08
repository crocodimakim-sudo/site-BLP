<?php
/**
 * Блок: Форма обратной связи
 * Переменные: $form_title, $form_desc
 */
$form_title = isset($form_title) ? $form_title : 'Получить предложение';
$form_desc  = isset($form_desc)  ? $form_desc  : 'Специалисты нашей компании всегда на связи, готовы оперативно и подробно ответить на все ваши вопросы.';

// 2026-05-06: timing check — фиксируем время показа формы
$_SESSION['form_time'] = time();
?>

<section class="contact-form-section">
  <div class="contact-form-wrapper">
    <form class="contact-form" id="contactForm" action="/blocks/send-form.php" method="POST" novalidate>
      <h2 class="contact-form-title"><?php echo htmlspecialchars($form_title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2>
      <p class="contact-form-desc"><?php echo htmlspecialchars($form_desc, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
      <div class="contact-form-grid">

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

        <!-- Компания, ИНН -->
        <div class="form-group">
          <label for="company" class="form-label">Компания, ИНН</label>
          <input type="text" id="company" name="company" class="form-input" placeholder="Компания, 1234567890" />
          <span class="field-error" data-field="company"></span>
        </div>

        <!-- Согласие на обработку данных -->
        <div class="form-checkbox-group">
          <input
            type="checkbox"
            id="consent"
            name="consent"
            class="form-checkbox"
            required
          />
          <label for="consent" class="form-checkbox-label">
            <!-- 2026-05-07: расширенное согласие — ст. 9 ч. 4 152-ФЗ (оператор, ИНН, перечень ПД, цели) -->
            Я даю согласие ООО «Билдингпорт» (ИНН&nbsp;7708427307, ОГРН&nbsp;1237700843390, г.&nbsp;Москва, ул.&nbsp;Краснопрудная, д.&nbsp;15, помещ.&nbsp;3А/2) на обработку моих персональных данных (имя, телефон, email, наименование компании и ИНН) с целью обработки заявки, связи со мной и направления коммерческого предложения, на условиях <a href="/consent" target="_blank" rel="noopener noreferrer">Согласия на обработку персональных данных</a> и <a href="/policy" target="_blank" rel="noopener noreferrer">Политики конфиденциальности</a>
          </label>
          <span class="field-error" data-field="consent"></span>
        </div>

        <!-- 2026-04-24: согласие на маркетинговую рассылку -->
        <!-- 2026-05-07: расширено по приказу РКН №178 и ст.18 38-ФЗ — перечень материалов, канал, срок, способ отзыва -->
        <div class="form-checkbox-group form-checkbox-group--full">
            <label class="form-checkbox-label">
                <input type="checkbox" name="marketing" id="marketing" class="form-checkbox">
                <span class="form-checkbox-text">Согласен(на) получать от ООО «Билдингпорт» (ИНН&nbsp;7708427307) на указанный email информационные и рекламные материалы о продукции BLP Board: новинки каталога, технические бюллетени, специальные предложения и приглашения на отраслевые мероприятия. Не чаще 2 раз в месяц. Согласие действительно 3 года и может быть отозвано в любой момент через ссылку «отписаться» в письме или по адресу <a href="mailto:info@building-port.ru">info@building-port.ru</a></span>
            </label>
        </div>

        <!-- 2026-04-24: honeypot — ботозащита, не трогать. aria-hidden для accessibility (поле невидимо для AT) -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;">

        <!-- 2026-04-22: CSRF token -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">

        <!-- Submit Button -->
        <div class="form-submit-wrapper">
          <button type="submit" class="btn-primary" id="submitBtn">
            <span class="btn-text">Получить предложение</span>
          </button>
        </div>

        <!-- Messages -->
        <div class="form-message success" id="successMessage">
          ✓ Спасибо! Ваша заявка отправлена. Мы свяжемся&nbsp;с вами&nbsp;в течение 24 часов.
        </div>
        <div class="form-message error" id="errorMessage"></div>
      </div>
    </form>
  </div>
</section>

<!-- 2026-04-24: imask 7.2.0 → 7.6.1 (404 на CDN для 7.2.0) -->
<script src="https://cdn.jsdelivr.net/npm/imask@7.6.1/dist/imask.min.js" defer></script>
<script src="/js/contact-form.js" defer></script>
