<?php
// 2026-04-22: Personal data processing consent form page
// 2026-05-07: redesign — hero + sticky TOC + card layout
require_once __DIR__ . '/../blocks/image-helper.php';

$page_title    = 'Согласие на обработку персональных данных — BLP Board';
$page_canonical = 'https://building-port.ru/consent';
$page_og_image  = 'https://building-port.ru/images/og-default.jpg';
$page_desc = 'Форма согласия на обработку персональных данных. Подтвердите согласие на обработку ваших персональных данных в соответствии с Федеральным законом № 152-ФЗ.';
// 2026-05-11: noindex для юридических страниц (тонкий контент)
$page_robots = 'noindex, follow';
$extra_css = '<link rel="stylesheet" href="/css/pages/legal.css?v=20260507">';
$extra_js  = '<script src="/js/legal-toc.js?v=20260507" defer></script>';

$breadcrumbs = [
    ['name' => 'Главная',                                 'url' => 'https://building-port.ru/'],
    ['name' => 'Согласие на обработку персональных данных', 'url' => 'https://building-port.ru/consent'],
];

ob_start();
?>

<section class="legal-hero">
    <div class="legal-hero-container">
        <span class="legal-hero-eyebrow">Документ согласия · ФЗ-152</span>
        <h1 class="legal-hero-title">Согласие на обработку персональных данных</h1>
        <p class="legal-hero-subtitle">Текст согласия в соответствии со ст.&nbsp;9 Федерального закона № 152-ФЗ. Согласие фиксируется при заполнении любой формы на Сайте.</p>
        <div class="legal-hero-meta">
            <span class="legal-hero-meta-item">Версия: <strong>2026-05-07-v2</strong></span>
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
            <div class="legal-highlight legal-highlight--info">
                <svg class="legal-highlight-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                <div class="legal-highlight-body">
                    <p>Я, нижеподписавшийся(аяся), подтверждаю, что ознакомился(ась) с условиями обработки моих персональных данных и <strong>добровольно, сознательно и однозначно</strong> даю своё <strong>согласие</strong> на их обработку.</p>
                </div>
            </div>

            <h2>1. Сведения об операторе</h2>
            <div class="legal-meta-card">
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Наименование</span>
                    <span class="legal-meta-value">ООО «Билдингпорт»</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">ИНН / КПП</span>
                    <span class="legal-meta-value">7708427307 / 770801001</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">ОГРН</span>
                    <span class="legal-meta-value">1237700843390</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Юридический адрес</span>
                    <span class="legal-meta-value">107140, г. Москва, ул. Краснопрудная, д. 15, помещ. 3А/2</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Фактический адрес</span>
                    <span class="legal-meta-value">143003, Московская область, г. Одинцово, ул. Неделина, 6А</span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Email</span>
                    <span class="legal-meta-value"><a href="mailto:info@building-port.ru">info@building-port.ru</a></span>
                </div>
                <div class="legal-meta-item">
                    <span class="legal-meta-label">Телефон</span>
                    <span class="legal-meta-value"><a href="tel:+74959849689">+7 (495) 984-96-89</a></span>
                </div>
            </div>

            <h2>2. Категории персональных данных</h2>
            <p>Я согласен(на) на обработку следующих категорий моих персональных данных:</p>
            <ul>
                <li>Фамилия, имя, отчество</li>
                <li>Адрес электронной почты</li>
                <li>Номер телефона</li>
                <li>Почтовый адрес</li>
                <li>Информация о месте работы / компании, ИНН компании</li>
                <li>Текст сообщения (при заполнении формы обратной связи)</li>
                <li>IP-адрес, User-Agent, время отправки заявки</li>
                <li>Иные данные, предоставленные добровольно</li>
            </ul>

            <h2>3. Цели обработки</h2>
            <ul>
                <li>Оказание услуг и техническая поддержка</li>
                <li>Ответ на запросы и консультации</li>
                <li>Направление коммерческих предложений в ответ на заявку</li>
                <li>Отправка информационных и маркетинговых сообщений (при отдельном согласии)</li>
                <li>Анализ использования сайта и улучшение качества услуг</li>
                <li>Исполнение требований законодательства Российской Федерации</li>
                <li>Обеспечение безопасности и защиты от мошенничества</li>
            </ul>

            <h2>4. Правовое основание</h2>
            <p>Обработка моих персональных данных осуществляется на основании:</p>
            <ol>
                <li>Добровольного согласия субъекта персональных данных (Федеральный закон от 27 июля 2006 г. № 152-ФЗ, ст. 6 п. 1)</li>
                <li>Необходимости исполнения договора, стороной которого я являюсь (ст. 6 ФЗ-152)</li>
                <li>Требований законодательства Российской Федерации (ст. 8 ФЗ-152)</li>
            </ol>

            <h2>5. Сроки обработки</h2>
            <p>Я согласен(на) на обработку моих персональных данных в течение:</p>
            <ul>
                <li><strong>3 (трёх) лет</strong> с момента предоставления настоящего согласия либо до момента его отзыва — в зависимости от того, что наступит раньше</li>
                <li>Срока действия договора между мной и Оператором</li>
                <li>Срока, установленного законодательством Российской Федерации</li>
            </ul>

            <h2>6. Передача данных третьим лицам</h2>
            <h3>6.1. Категории получателей</h3>
            <ul>
                <li>Передача без необходимости — <strong>не осуществляется</strong></li>
                <li>Органы государственной власти и местного самоуправления — при требовании по закону</li>
            </ul>

            <h3>6.2. Аналитические сервисы</h3>
            <p>Я даю согласие на передачу обезличенных данных сервису веб-аналитики:</p>
            <ul>
                <li><strong>ООО «Яндекс»</strong> (Россия) — сервис Яндекс.Метрика. Политика: <a href="https://yandex.ru/legal/confidential/" target="_blank" rel="noopener noreferrer">yandex.ru/legal/confidential</a></li>
            </ul>
            <p>Передача осуществляется в анонимизированном виде (статистические данные без идентификации конкретного лица). Трансграничная передача персональных данных в иные государства <strong>не осуществляется</strong>.</p>

            <h2>7. Локализация баз данных</h2>
            <div class="legal-highlight legal-highlight--info">
                <svg class="legal-highlight-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                <div class="legal-highlight-body">
                    <p>В соответствии с ч.&nbsp;5 ст.&nbsp;18 ФЗ-152 запись, систематизация, накопление, хранение, уточнение и извлечение персональных данных граждан РФ осуществляется с использованием баз данных, расположенных <strong>на территории Российской Федерации</strong> — в охраняемом дата-центре с круглосуточным контролем доступа в г.&nbsp;Москве.</p>
                </div>
            </div>

            <h2>8. Права субъекта</h2>
            <h3>8.1. Мне известно, что я имею право</h3>
            <ul>
                <li>Получить подтверждение об обработке моих персональных данных</li>
                <li>Запросить доступ к своим персональным данным</li>
                <li>Требовать исправления неточных или неполных данных</li>
                <li>Требовать удаления моих персональных данных</li>
                <li>Требовать ограничения обработки моих данных</li>
                <li>Возразить против обработки данных</li>
                <li><strong>Отозвать настоящее согласие в любой момент</strong></li>
            </ul>

            <h3>8.2. Я понимаю, что</h3>
            <ul>
                <li>Отзыв согласия не влияет на законность обработки данных до момента отзыва</li>
                <li>Отзыв согласия может привести к невозможности исполнения договора</li>
                <li>Оператор имеет право хранить данные в соответствии с требованиями закона</li>
            </ul>

            <h2>9. Отзыв согласия</h2>
            <div class="legal-highlight legal-highlight--warn">
                <svg class="legal-highlight-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                <div class="legal-highlight-body">
                    <h4>Как отозвать согласие</h4>
                    <p>Я могу отозвать настоящее согласие в любой момент, направив письменное уведомление на адрес:</p>
                    <ul>
                        <li><strong>Email:</strong> <a href="mailto:info@building-port.ru">info@building-port.ru</a></li>
                        <li><strong>Почтовый адрес:</strong> 143003, Московская область, г. Одинцово, ул. Неделина, 6А</li>
                        <li><strong>Телефон:</strong> <a href="tel:+74959849689">+7 (495) 984-96-89</a></li>
                    </ul>
                    <p>Отзыв согласия вступает в силу с момента получения уведомления.</p>
                </div>
            </div>

            <h2>10. Подтверждение информированности</h2>
            <p>Подтверждая согласие, я подтверждаю, что:</p>
            <ul>
                <li>Ознакомился(ась) с <a href="/policy">Политикой конфиденциальности</a> BLP Board</li>
                <li>Ознакомился(ась) с <a href="/cookies">Политикой использования файлов cookies</a></li>
                <li>Понимаю цели и способы обработки моих персональных данных</li>
                <li>Информирован(а) о своих правах как субъекта персональных данных</li>
                <li>Даю согласие добровольно, без давления и влияния третьих лиц</li>
            </ul>

            <h2>11. Онлайн-форма согласия</h2>
            <p>При заполнении любой формы на Сайте (контакты, заявка) Вам предлагается дать согласие на обработку персональных данных <strong>отдельным флажком</strong>, в соответствии с требованиями Федерального закона № 152-ФЗ и приказа Роскомнадзора.</p>
            <p>Нажимая кнопку «Отправить», Вы подтверждаете ознакомление с настоящим Согласием и выражаете его в явном виде. Факт согласия фиксируется в базе данных Оператора с указанием времени, IP-адреса и версии текста согласия.</p>

            <div class="legal-related">
                <div class="legal-related-title">Связанные документы</div>
                <div class="legal-related-grid">
                    <a href="/policy" class="legal-related-link">Политика конфиденциальности</a>
                    <a href="/cookies" class="legal-related-link">Политика cookies</a>
                </div>
            </div>
        </article>
    </div>
</section>

<?php $page_content = ob_get_clean(); include 'template.php'; ?>
