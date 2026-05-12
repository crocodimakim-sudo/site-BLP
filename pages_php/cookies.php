<?php
// 2026-04-22: Cookies policy page
// 2026-05-07: redesign — hero + sticky TOC + card layout
require_once __DIR__ . '/../blocks/image-helper.php';

$page_title    = 'Политика в отношении файлов cookies — BLP Board';
$page_canonical = 'https://building-port.ru/cookies';
$page_og_image  = 'https://building-port.ru/images/og-default.jpg';
$page_desc = 'Политика BLP Board по использованию файлов cookies. Как мы используем cookies, как вы можете управлять ими, и как отключить ненужные файлы.';
// 2026-05-11: noindex для юридических страниц (тонкий контент)
$page_robots = 'noindex, follow';
$extra_css = '<link rel="stylesheet" href="/css/pages/legal.css?v=20260507">';
$extra_js  = '<script src="/js/legal-toc.js?v=20260507" defer></script>';

$breadcrumbs = [
    ['name' => 'Главная',          'url' => 'https://building-port.ru/'],
    ['name' => 'Политика cookies', 'url' => 'https://building-port.ru/cookies'],
];

ob_start();
?>

<section class="legal-hero">
    <div class="legal-hero-container">
        <span class="legal-hero-eyebrow">Юридический документ</span>
        <h1 class="legal-hero-title">Политика в отношении файлов cookies</h1>
        <p class="legal-hero-subtitle">Какие файлы cookies мы используем, для каких целей и как Вы можете ими управлять.</p>
        <div class="legal-hero-meta">
            <span class="legal-hero-meta-item">Обновлено: <strong>07.05.2026</strong></span>
            <span class="legal-hero-meta-item">Оператор: <strong>ООО «Билдингпорт»</strong></span>
        </div>
    </div>
</section>

<section class="legal-body">
    <div class="legal-body-container">
        <aside class="legal-toc">
            <button class="legal-toc-mobile-toggle" type="button">Содержание</button>
            <div class="legal-toc-title">Содержание</div>
            <nav class="legal-toc-nav" aria-label="Содержание документа"></nav>
        </aside>

        <article class="legal-content">
            <h2>1. Общие положения</h2>
            <p>Веб-сайт «building-port.ru» (далее — «<strong>Сайт</strong>») использует технологию файлов cookies и аналогичные механизмы отслеживания для улучшения опыта пользователя и сбора статистической информации.</p>
            <p>Настоящая Политика описывает, какие файлы cookies мы используем, для каких целей, и как Вы можете их контролировать.</p>

            <h2>2. Что такое файлы cookies</h2>
            <p><strong>Файлы cookies</strong> — это небольшие текстовые файлы, которые сохраняются на жёстком диске Вашего компьютера, мобильного телефона, планшета или иного устройства при посещении веб-сайтов.</p>

            <h3>2.1. Как работают cookies</h3>
            <ul>
                <li>При посещении Сайта сервер отправляет файл cookies на Ваше устройство</li>
                <li>Браузер сохраняет этот файл локально</li>
                <li>При следующих посещениях браузер отправляет файл обратно серверу</li>
                <li>Это позволяет серверу узнать Вас и восстановить Вашу историю и предпочтения</li>
            </ul>

            <h3>2.2. Размер и содержимое</h3>
            <ul>
                <li>Типичный файл cookies занимает 4–5 килобайт</li>
                <li>Содержит идентификатор сессии, дату создания и срок действия</li>
                <li>Не содержит исполняемый код или вирусы — это просто текстовый файл</li>
            </ul>

            <h2>3. Типы используемых cookies</h2>

            <h3>3.1. Технические (обязательные)</h3>
            <p>Эти файлы cookies необходимы для функционирования Сайта и <strong>не могут быть отключены</strong> без нарушения функциональности.</p>

            <h4>Назначение</h4>
            <ul>
                <li>Запоминание статуса авторизации (вход в личный кабинет)</li>
                <li>Поддержание активной сессии пользователя</li>
                <li>Обеспечение безопасности и защиты от мошенничества</li>
                <li>Защита от CSRF-атак (Cross-Site Request Forgery)</li>
                <li>Отслеживание согласия пользователя с политиками конфиденциальности</li>
                <li>Запоминание языка интерфейса и региональных настроек</li>
                <li>Обеспечение корректной работы форм</li>
            </ul>

            <h4>Сроки хранения</h4>
            <ul>
                <li>Сессионные cookies: удаляются при закрытии браузера</li>
                <li>Постоянные cookies: 1 год</li>
            </ul>

            <h3>3.2. Аналитические cookies</h3>
            <p>Эти файлы cookies используются для анализа поведения пользователей и сбора статистической информации. Собранные данные передаются <strong>в анонимном виде</strong> на серверы аналитических сервисов.</p>

            <div class="legal-highlight legal-highlight--info">
                <svg class="legal-highlight-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                <div class="legal-highlight-body">
                    <p><strong>Загружаются только после Вашего согласия.</strong> На Сайте действует cookie-баннер: до нажатия «Принять всё» аналитические cookies не устанавливаются и аналитические скрипты не загружаются.</p>
                </div>
            </div>

            <h4>Назначение</h4>
            <ul>
                <li>Подсчёт количества посещений Сайта</li>
                <li>Определение популярности страниц</li>
                <li>Анализ траектории движения пользователя</li>
                <li>Анализ времени, проведённого на Сайте</li>
                <li>Определение источников переходов</li>
                <li>Выявление технических проблем</li>
                <li>Оптимизация интерфейса и содержимого</li>
            </ul>

            <h4>Используемые сервисы</h4>
            <h5>Яндекс.Метрика</h5>
            <ul>
                <li><strong>Оператор:</strong> ООО «Яндекс» (Россия)</li>
                <li><strong>Политика:</strong> <a href="https://yandex.com/privacy" target="_blank" rel="noopener noreferrer">yandex.com/privacy</a></li>
                <li><strong>Cookies:</strong> <code>_ym_uid</code>, <code>_ym_d</code> и др.</li>
                <li><strong>Данные:</strong> анонимные статистические данные</li>
            </ul>

            <!-- 2026-05-07: функциональные cookies — Яндекс.Карты для отображения адреса -->
            <h3>3.3. Функциональные cookies</h3>
            <p>Эти файлы cookies необходимы для корректного отображения функционального контента, запрошенного пользователем. Загружаются <strong>при просмотре соответствующей страницы</strong> и не используются для отслеживания пользователя в маркетинговых целях.</p>

            <h4>Используемые сервисы</h4>
            <h5>Яндекс.Карты</h5>
            <ul>
                <li><strong>Оператор:</strong> ООО «Яндекс» (Россия)</li>
                <li><strong>Где используется:</strong> страница <a href="/contacts">/contacts</a> — отображение карты с адресом офиса</li>
                <li><strong>Назначение:</strong> функциональное (отображение запрошенного пользователем контента — карты)</li>
                <li><strong>Политика:</strong> <a href="https://yandex.ru/legal/maps_termsofuse/" target="_blank" rel="noopener noreferrer">yandex.ru/legal/maps_termsofuse</a></li>
                <li><strong>Альтернатива:</strong> на этой же странице адрес доступен текстом, не зависит от загрузки карты</li>
            </ul>

            <h2>4. Локальное хранилище и похожие технологии</h2>
            <h3>4.1. Local Storage</h3>
            <ul>
                <li><strong>Что это:</strong> хранилище на клиентской стороне, подобное cookies, но с большим объёмом (5–10 МБ)</li>
                <li><strong>Назначение:</strong> сохранение предпочтений, кэширование данных</li>
                <li><strong>Удаление:</strong> вручную через браузер или программно</li>
            </ul>

            <h3>4.2. Session Storage</h3>
            <ul>
                <li><strong>Что это:</strong> временное хранилище, существует только во время сессии</li>
                <li><strong>Назначение:</strong> хранение временных данных</li>
                <li><strong>Удаление:</strong> автоматически при закрытии браузера</li>
            </ul>

            <h2>5. Согласие на использование cookies</h2>
            <h3>5.1. Требования закона</h3>
            <p>В соответствии с требованиями Федерального закона от 27 июля 2006 г. № 152-ФЗ:</p>
            <ul>
                <li>Компания получает Ваше согласие <strong>перед установкой необязательных cookies</strong></li>
                <li>Технические cookies могут быть установлены без согласия</li>
                <li>Согласие даётся <strong>отдельно</strong> от других документов</li>
            </ul>

            <h3>5.2. Как мы получаем согласие</h3>
            <p>Компания использует <strong>cookie-баннер</strong>, который появляется при первом посещении Сайта:</p>
            <ul>
                <li><strong>Принять всё</strong> — согласие на все типы cookies, включая аналитические</li>
                <li><strong>Отклонить</strong> — отказ от необязательных cookies, аналитика не загружается</li>
            </ul>

            <h3>5.3. Сохранение выбора</h3>
            <p>Ваш выбор сохраняется в <code>localStorage</code> и cookie-файле сроком на 1 год. Баннер не показывается повторно, пока запись не будет удалена.</p>

            <h3>5.4. Отзыв согласия</h3>
            <p>Вы можете в любой момент:</p>
            <ul>
                <li>Удалить cookie-запись и localStorage через настройки браузера — баннер появится снова</li>
                <li>Связаться с нами: <a href="mailto:info@building-port.ru">info@building-port.ru</a></li>
            </ul>

            <h2>6. Управление cookies в браузере</h2>
            <h3>6.1. Google Chrome</h3>
            <ol>
                <li>Откройте Chrome → <strong>Параметры</strong> (⋮)</li>
                <li><strong>Конфиденциальность и безопасность</strong> → <strong>Cookies и другие данные сайтов</strong></li>
                <li>Выберите опцию управления cookies</li>
            </ol>

            <h3>6.2. Mozilla Firefox</h3>
            <ol>
                <li>Откройте Firefox → <strong>Параметры</strong></li>
                <li><strong>Приватность и защита</strong></li>
                <li>Раздел <strong>Куки и данные сайтов</strong></li>
            </ol>

            <h3>6.3. Safari (macOS / iOS)</h3>
            <ol>
                <li><strong>Safari</strong> → <strong>Настройки</strong></li>
                <li><strong>Конфиденциальность</strong></li>
                <li>Отметьте опции для управления cookies</li>
            </ol>

            <h2>7. Безопасность cookies</h2>
            <h3>7.1. Защита от атак</h3>
            <ul>
                <li>Технические cookies используют флаги <strong>HttpOnly</strong>, <strong>Secure</strong> и <strong>SameSite=Strict</strong></li>
                <li>Это предотвращает доступ через JavaScript, передачу по незащищённым каналам и защищает от CSRF</li>
                <li>Мы используем шифрование SSL/TLS для защиты передачи данных</li>
            </ul>

            <h3>7.2. Что cookies не могут</h3>
            <ul>
                <li>Запускать вирусы или вредоносное ПО</li>
                <li>Получать доступ к Вашему компьютеру</li>
                <li>Воровать персональные данные напрямую</li>
                <li>Видеть файлы на Вашем жёстком диске</li>
            </ul>

            <h2>8. Регулирование и соответствие</h2>
            <p>Использование cookies регулируется:</p>
            <ul>
                <li><strong>Федеральный закон № 152-ФЗ</strong> «О персональных данных»</li>
                <li>Требования <strong>Роскомнадзора</strong> в соответствии с законодательством РФ</li>
            </ul>

            <h2>9. Контактная информация</h2>
            <div class="legal-meta-card">
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Email</span>
                    <span class="legal-meta-value"><a href="mailto:info@building-port.ru">info@building-port.ru</a></span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Телефон</span>
                    <span class="legal-meta-value"><a href="tel:+74959849689">+7 (495) 984-96-89</a></span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Адрес</span>
                    <span class="legal-meta-value">143003, Московская область, г. Одинцово, ул. Неделина, 6А</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Форма обратной связи</span>
                    <span class="legal-meta-value"><a href="/contacts">building-port.ru/contacts</a></span>
                </div>
            </div>
            <p>Мы рассмотрим Ваш вопрос в течение 3 рабочих дней.</p>

            <div class="legal-related">
                <div class="legal-related-title">Связанные документы</div>
                <div class="legal-related-grid">
                    <a href="/policy" class="legal-related-link">Политика конфиденциальности</a>
                    <a href="/consent" class="legal-related-link">Согласие на обработку ПД</a>
                </div>
            </div>
        </article>
    </div>
</section>

<?php $page_content = ob_get_clean(); include 'template.php'; ?>
