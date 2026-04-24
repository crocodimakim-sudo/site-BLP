<?php
/**
 * Блок: Форма обратной связи
 * Переменные: $form_title, $form_desc
 */
$form_title = isset($form_title) ? $form_title : 'Получить предложение';
$form_desc  = isset($form_desc)  ? $form_desc  : 'Специалисты нашей компании всегда на связи, готовы оперативно и подробно ответить на все ваши вопросы.';
?>

<section class="contact-form-section">
  <div class="contact-form-wrapper">
    <form class="contact-form" id="contactForm" action="/blp/blocks/send-form.php" method="POST" novalidate>
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
            Я даю согласие&nbsp;на <a href="/blp/consent" target="_blank" rel="noopener noreferrer">обработку персональных данных</a>&nbsp;и принимаю условия <a href="/blp/policy" target="_blank" rel="noopener noreferrer">Политики конфиденциальности</a>
          </label>
          <span class="field-error" data-field="consent"></span>
        </div>

        <!-- 2026-04-24: honeypot — ботозащита, не трогать -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;">

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

<script src="https://cdn.jsdelivr.net/npm/imask@7.2.0/index.min.js" defer></script>
<script src="/blp/js/contact-form.js" defer></script>
