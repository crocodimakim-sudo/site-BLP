/* ========================================
   Contact Form Validation & Submit
   ======================================== */

(function() {
  const form = document.getElementById('contactForm');
  if (!form) return;

  const submitBtn = document.getElementById('submitBtn');
  const successMsg = document.getElementById('successMessage');
  const errorMsg = document.getElementById('errorMessage');
  const phoneInput = document.getElementById('phone');

  // Phone mask
  let phoneMask = null;
  if (phoneInput && typeof IMask !== 'undefined') {
    phoneMask = IMask(phoneInput, {
      mask: '+7 (000) 000-00-00',
      placeholderChar: '_'
    });
  }

  // Validation rules
  const validators = {
    email: (val) => {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(val) ? null : 'Введите корректный email';
    },
    name: (val) => {
      if (val.trim().length < 2) return 'Имя должно быть не менее 2 символов';
      if (!/^[а-яА-ЯёЁa-zA-Z\s\-]+$/.test(val)) return 'Только буквы и дефисы';
      return null;
    },
    phone: (val) => {
      const digitsOnly = val.replace(/\D/g, '');
      if (digitsOnly.length !== 11) return 'Введите полный номер телефона';
      return null;
    },
    company: () => null,
    consent: (val) => {
      return !val ? 'Примите условия обработки данных' : null;
    }
  };

  // Track which fields the user has interacted with
  const touched = {};

  // Validate field (onSubmit=true forces error even for empty fields)
  function validateField(fieldName, onSubmit) {
    const field = form.elements[fieldName];
    const validator = validators[fieldName];
    if (!validator) return null;

    const isCheckbox = field.type === 'checkbox';
    const rawValue = isCheckbox ? field.checked : field.value;
    const isEmpty = isCheckbox ? !field.checked : field.value.trim() === '';

    const formGroup = field.closest('.form-group') || field.closest('.form-checkbox-group');
    const errorEl = formGroup.querySelector('.field-error');

    // On blur/input: if field is empty — clear error and do nothing
    if (!onSubmit && isEmpty) {
      formGroup.classList.remove('error');
      errorEl.textContent = '';
      return true; // treat as "no error yet" (not validated)
    }

    const error = validator(rawValue);

    if (error) {
      formGroup.classList.add('error');
      errorEl.textContent = error;
      return false;
    } else {
      formGroup.classList.remove('error');
      errorEl.textContent = '';
      return true;
    }
  }

  // Validate all fields (called on submit — forces errors on empty required fields)
  function validateForm() {
    let isValid = true;
    Object.keys(validators).forEach(fieldName => {
      const field = form.elements[fieldName];
      if (!field) return;
      const isCheckbox = field.type === 'checkbox';
      const isEmpty = isCheckbox ? !field.checked : field.value.trim() === '';
      // On submit, treat empty required fields as invalid
      if (isEmpty && fieldName !== 'company') {
        const formGroup = field.closest('.form-group') || field.closest('.form-checkbox-group');
        const errorEl = formGroup.querySelector('.field-error');
        formGroup.classList.add('error');
        errorEl.textContent = validators[fieldName](isCheckbox ? false : '') || 'Обязательное поле';
        isValid = false;
      } else if (!validateField(fieldName, true)) {
        isValid = false;
      }
    });
    return isValid;
  }

  // Real-time validation
  ['email', 'name', 'phone', 'company', 'consent'].forEach(fieldName => {
    const field = form.elements[fieldName];
    if (!field) return;

    field.addEventListener('blur', () => {
      touched[fieldName] = true;
      validateField(fieldName, false);
    });

    if (fieldName !== 'consent') {
      field.addEventListener('input', () => {
        // Only validate on input if user already left the field (touched)
        if (touched[fieldName]) {
          validateField(fieldName, false);
        }
      });
    }
  });

  // Submit handler
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!validateForm()) return;

    successMsg.classList.remove('show');
    errorMsg.classList.remove('show');
    submitBtn.disabled = true;

    const spinner = document.createElement('div');
    spinner.className = 'spinner';
    const btnText = submitBtn.querySelector('.btn-text');
    const originalText = btnText.textContent;
    btnText.textContent = '';
    submitBtn.insertBefore(spinner, btnText);

    const data = {
      email: form.email.value.trim(),
      name: form.name.value.trim(),
      phone: form.phone.value.trim(),
      company: form.company.value.trim(),
      consent: form.consent.checked
    };

    try {
      const response = await fetch('blocks/send-form.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (result.ok) {
        successMsg.classList.add('show');
        form.reset();
        if (phoneMask) phoneMask.updateValue();
        setTimeout(() => {
          submitBtn.disabled = false;
          spinner.remove();
          btnText.textContent = originalText;
        }, 1000);
      } else {
        throw new Error(result.error || 'Ошибка при отправке');
      }
    } catch (error) {
      errorMsg.textContent = '⚠ ' + (error.message || 'Ошибка при отправке формы. Попробуйте позже.');
      errorMsg.classList.add('show');
      submitBtn.disabled = false;
      spinner.remove();
      btnText.textContent = originalText;
    }
  });
})();
