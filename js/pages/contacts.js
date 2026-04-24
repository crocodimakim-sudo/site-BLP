/* contacts.js — Яндекс Карта + валидация формы */

// ===================================================
// Яндекс Карта
// ===================================================
function initYandexMap() {
    const mapContainer = document.getElementById('yandex-map');
    if (!mapContainer) return;

    // Координаты: Одинцово, ул. Неделина, 6А
    const coords = [55.6789, 37.2725];

    const map = new ymaps.Map('yandex-map', {
        center: coords,
        zoom: 16,
        controls: ['zoomControl', 'fullscreenControl']
    });

    // Плейсмарк
    const placemark = new ymaps.Placemark(coords, {
        balloonContentHeader: 'BLP Board',
        balloonContentBody: 'Одинцово, ул. Неделина, 6А<br>Тел: +7 (495) 984-96-89',
        balloonContentFooter: '<a href="mailto:info@building-port.ru">info@building-port.ru</a>',
        hintContent: 'BLP Board — Одинцово, Неделина 6А'
    }, {
        preset: 'islands#greenDotIconWithCaption',
        iconCaption: 'BLP Board'
    });

    map.geoObjects.add(placemark);

    // Открыть балун сразу
    placemark.balloon.open();
}

// Загрузка API Яндекс.Карт
function loadYandexMaps() {
    if (window.ymaps) {
        ymaps.ready(initYandexMap);
        return;
    }

    const script = document.createElement('script');
    script.src = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=';
    script.onload = function () {
        ymaps.ready(initYandexMap);
    };
    script.onerror = function () {
        const mapContainer = document.getElementById('yandex-map');
        if (mapContainer) {
            mapContainer.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#666;font-size:14px;">Карта временно недоступна. Адрес: Одинцово, ул. Неделина, 6А</div>';
        }
    };
    document.head.appendChild(script);
}

// ===================================================
// Валидация и отправка формы
// ===================================================
function initContactForm() {
    const form = document.getElementById('contactsPageForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    const successMsg = document.getElementById('successMessage');
    const errorMsg = document.getElementById('errorMessage');
    const phoneInput = document.getElementById('phone');

    // Маска телефона через IMask (если доступен)
    if (window.IMask && phoneInput) {
        IMask(phoneInput, {
            mask: '+{7} (000) 000-00-00',
            lazy: false
        });
    }

    function showError(field, message) {
        const group = field.closest('.form-group') || field.closest('.form-checkbox-group');
        if (group) group.classList.add('error');
        const errorEl = document.querySelector('.field-error[data-field="' + field.name + '"]');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }

    function clearErrors() {
        form.querySelectorAll('.error').forEach(function (el) {
            el.classList.remove('error');
        });
        form.querySelectorAll('.field-error').forEach(function (el) {
            el.textContent = '';
            el.style.display = 'none';
        });
        errorMsg.textContent = '';
        errorMsg.classList.remove('show');
    }

    function validate() {
        let valid = true;
        clearErrors();

        // Имя
        const name = form.querySelector('[name="name"]');
        if (!name.value.trim()) {
            showError(name, 'Введите имя');
            valid = false;
        }

        // Телефон
        const phone = form.querySelector('[name="phone"]');
        const phoneVal = phone.value.replace(/\D/g, '');
        if (phoneVal.length < 10) {
            showError(phone, 'Введите корректный телефон');
            valid = false;
        }

        // Email
        const email = form.querySelector('[name="email"]');
        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRe.test(email.value.trim())) {
            showError(email, 'Введите корректный email');
            valid = false;
        }

        // Согласие
        const consent = form.querySelector('[name="consent"]');
        if (!consent.checked) {
            showError(consent, 'Необходимо согласие');
            valid = false;
        }

        return valid;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validate()) return;

        // Показать загрузку
        const originalText = submitBtn.querySelector('.btn-text').textContent;
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').textContent = 'Отправка...';

        // Сбор данных
        const data = {
            name: form.querySelector('[name="name"]').value.trim(),
            phone: form.querySelector('[name="phone"]').value.trim(),
            email: form.querySelector('[name="email"]').value.trim(),
            message: form.querySelector('[name="message"]') ? form.querySelector('[name="message"]').value.trim() : '',
            consent: true,
            marketing: form.querySelector('[name="marketing"]') ? form.querySelector('[name="marketing"]').checked : false,
            // 2026-04-22: добавлен csrf_token для защиты формы
            csrf_token: (document.querySelector('input[name="csrf_token"]') || {}).value || ''
        };

        // Отправка на сервер
        fetch('/blp/blocks/send-form.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(function (r) { return r.json(); })
        .then(function (result) {
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').textContent = originalText;
            if (result.ok) {
                successMsg.classList.add('show');
                form.reset();
                setTimeout(function () {
                    successMsg.classList.remove('show');
                }, 5000);
            } else {
                errorMsg.textContent = result.error || 'Ошибка отправки. Попробуйте позже.';
                errorMsg.classList.add('show');
            }
        })
        .catch(function (err) {
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').textContent = originalText;
            errorMsg.textContent = 'Ошибка сети. Проверьте подключение и попробуйте снова.';
            errorMsg.classList.add('show');
        });
    });
}

// ===================================================
// Инициализация
// ===================================================
document.addEventListener('DOMContentLoaded', function () {
    loadYandexMaps();
    initContactForm();
});
