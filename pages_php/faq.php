<?php
// 2026-04-20: Stage 3 Group 3.B — FAQ page targeting long-tail question keywords
$page_title    = 'Часто задаваемые вопросы о фиброцементных панелях — BLP Board';
$page_canonical = 'https://building-port.ru/blp/faq';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Ответы на частые вопросы о фиброцементных панелях BLP Board: характеристики, монтаж, совместимость с подсистемами, гарантия, заказ образцов, цены и доставка.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/faq.css">';
$extra_js  = '<script src="/blp/js/pages/faq.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
    ['name' => 'FAQ', 'url' => 'https://building-port.ru/blp/faq'],
];

// 2026-04-20: FAQPage schema.org markup
$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'name' => 'Часто задаваемые вопросы о фиброцементных панелях BLP Board',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => 'Чем фиброцемент отличается от HPL и фасадного кирпича?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Фиброцемент — негорючий материал класса НГ (К0), не поддерживает горение в отличие от HPL-панелей. Масса фиброцементной плиты 14–20 кг/м² — значительно меньше кирпича (80–120 кг/м²), что снижает нагрузку на фундамент. В отличие от HPL, фиброцемент не выгорает на солнце: цвет окрашен в массе по всей толщине. Срок службы — 50+ лет без окрашивания.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Что такое НГ и К0? Почему это важно для высотных зданий?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'НГ — негорючий материал (не воспламеняется при прямом воздействии огня). К0 — высший класс пожарной опасности строительных материалов по ГОСТ 31251-2008, означает отсутствие дыма и горящих капель при пожаре. Для зданий выше 28 м (III категория по ПБ) применение фасадных материалов класса К0 обязательно по требованиям МЧС и СП 2.13130. Панели BLP Board соответствуют НГ и К0 — это закрывает требование для жилых комплексов, школ, больниц и бизнес-центров.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Можно ли пилить, сверлить и фрезеровать фиброцементные панели?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Да. Фиброцементные плиты обрабатываются стандартным инструментом: циркулярная пила с твёрдосплавным диском, болгарка, дрель. Фрезерование кромки и подрезка по месту выполняются без специального оборудования. При резке рекомендуется работать в маске — пыль содержит кварцевые частицы. Инструмент следует использовать с пылесосом или увлажнением реза.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Какой толщины плиты выбрать для жилого дома, бизнес-центра и поликлиники?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Для жилых домов до 5 этажей — толщина 8 мм, пролёт между точками крепления до 600 мм. Для высотных ЖК, бизнес-центров и социальных объектов — 10–12 мм, пролёт до 900 мм. Для промышленных фасадов и объектов с повышенными ветровыми нагрузками — 15 мм. Точный подбор зависит от ветровой зоны и шага подсистемы — наш технический специалист выполнит расчёт бесплатно.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Как заказать образцы фиброцементных панелей BLP Board?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Образцы всех 4 серий (NATURE, POLISHED, TEXTURE, WALYPAN) предоставляются бесплатно. Отправьте заявку через форму на сайте или позвоните по телефону +7 (495) 984-96-89. Доставляем в офис или на объект в течение 3–5 рабочих дней по Москве и МО. В регионы — транспортной компанией.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Работаете ли вы по всей России?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Да. Склад расположен в Одинцово (Московская область). Доставка по Москве и МО — собственным транспортом. В регионы — транспортными компаниями (СДЭК, Деловые Линии, ПЭК) с нашего склада. Сроки поставки в регионы — от 5 до 14 рабочих дней в зависимости от направления и объёма заказа. Минимальный объём поставки уточняйте у менеджера.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Какие документы предоставляются для прохождения госэкспертизы?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Комплект документов для госэкспертизы включает: технический паспорт изделия, пожарный сертификат (класс НГ/К0), расчёт ветровых нагрузок. Все документы предоставляются бесплатно при наличии проекта.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Сколько стоят фиброцементные панели? Как получить цену?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Цена зависит от серии, толщины и объёма заказа. Ценообразование прозрачное: базовая ставка за м² + логистика. Оптовые условия доступны от 200 м². Для получения точного расчёта заполните форму на сайте с указанием серии, толщины, объёма (м²) и региона доставки — ответим в течение рабочего дня. Для дилеров — отдельные условия ценообразования.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Совместимы ли панели BLP Board с различными подсистемами НВФ?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Да. Панели BLP Board совместимы с алюминиевыми, стальными (оцинкованными) и нержавеющими подсистемами НВФ (навесных вентилируемых фасадов). Крепление — видимое (через отверстия) или скрытое (кляммеры). Шаг несущих профилей определяется расчётом в зависимости от толщины панели и ветровой зоны объекта. Мы предоставляем таблицу совместимости с основными системами на рынке.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Какой гарантийный срок на фиброцементные панели BLP Board?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Гарантийный срок — 10 лет. Расчётный срок службы фиброцемента — 50+ лет при соблюдении условий монтажа. Материал устойчив к морозному расклиниванию (выдерживает 100+ циклов замораживания/оттаивания), ультрафиолетовому излучению и атмосферным осадкам. Цвет сохраняется весь срок службы: краситель вводится в массу при производстве, а не наносится сверху.'
            ]
        ],
    ]
];

ob_start();
?>
<!-- ============================================
     FAQ HERO SECTION
     ============================================ -->
<section class="blp-hero-section faq-hero">
    <div class="blp-container">
        <div class="blp-grid-12">
            <div class="blp-hero-content faq-hero-content">
                <h1 class="blp-hero-title">Часто задаваемые вопросы<br>о фиброцементных панелях</h1>
                <p class="blp-hero-subtitle">Характеристики, монтаж, совместимость, гарантия, заказ и доставка</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span>Серии NATURE, POLISHED, TEXTURE, WALYPAN</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span>Документы для госэкспертизы — бесплатно</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span>Образцы панелей — доставим за 3–5 дней</span>
                    </li>
                </ul>
                <a href="/blp/contacts" class="blp-hero-button">Задать вопрос менеджеру</a>
            </div>
            <div class="blp-hero-image faq-hero-image">
                <div class="faq-hero-badge">
                    <span class="faq-hero-badge-num">10</span>
                    <span class="faq-hero-badge-label">ответов<br>на главные<br>вопросы</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     FAQ ACCORDION
     ============================================ -->
<section class="faq-section">
    <div class="blp-container">

        <h2 class="faq-section-title">Технические характеристики и сравнение</h2>

        <div class="faq-accordion">

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Чем фиброцемент отличается от HPL и фасадного кирпича?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Фиброцемент — <strong>негорючий материал класса НГ (К0)</strong>, не поддерживает горение в отличие от HPL-панелей. Масса фиброцементной плиты 14–20 кг/м² — значительно меньше кирпича (80–120 кг/м²), что снижает нагрузку на фундамент.</p>
                        <p>В отличие от HPL, фиброцемент <strong>не выгорает на солнце</strong>: цвет окрашен в массе по всей толщине. Срок службы — 50+ лет без повторного окрашивания.</p>
                        <table class="faq-compare-table">
                            <thead>
                                <tr><th>Параметр</th><th>Фиброцемент BLP</th><th>HPL</th><th>Кирпич</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Пожарный класс</td><td>НГ (К0)</td><td>Г1–Г4 (горючий)</td><td>НГ</td></tr>
                                <tr><td>Масса, кг/м²</td><td>14–20</td><td>8–12</td><td>80–120</td></tr>
                                <tr><td>Срок службы</td><td>50+ лет</td><td>15–25 лет</td><td>50+ лет</td></tr>
                                <tr><td>Цвет в массе</td><td>Да</td><td>Нет</td><td>Да</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Что такое НГ и К0? Почему это важно для высотных зданий?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p><strong>НГ</strong> — негорючий материал: не воспламеняется при прямом воздействии огня. <strong>К0</strong> — высший класс пожарной опасности строительных материалов по ГОСТ 31251-2008, означает отсутствие дыма и горящих капель при пожаре.</p>
                        <p>Для зданий выше 28 м применение фасадных материалов класса К0 <strong>обязательно по требованиям МЧС и СП 2.13130</strong>. Панели BLP Board соответствуют НГ и К0 — это закрывает требование для жилых комплексов, школ, больниц и бизнес-центров.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Какой гарантийный срок на фиброцементные панели BLP Board?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Гарантийный срок — <strong>10 лет</strong>. Расчётный срок службы фиброцемента — 50+ лет при соблюдении условий монтажа.</p>
                        <p>Материал устойчив к:</p>
                        <ul>
                            <li>Морозному расклиниванию: выдерживает <strong>100+ циклов</strong> замораживания/оттаивания</li>
                            <li>Ультрафиолетовому излучению: цвет не выгорает</li>
                            <li>Атмосферным осадкам: водопоглощение ≤16%</li>
                        </ul>
                        <p>Цвет сохраняется весь срок службы: краситель вводится в массу при производстве, а не наносится сверху.</p>
                    </div>
                </div>
            </div>

        </div><!-- /faq-accordion -->

        <h2 class="faq-section-title">Монтаж и совместимость</h2>

        <div class="faq-accordion">

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Можно ли пилить, сверлить и фрезеровать фиброцементные панели?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Да. Фиброцементные плиты обрабатываются <strong>стандартным инструментом</strong>: циркулярная пила с твёрдосплавным диском, болгарка, дрель. Фрезерование кромки и подрезка по месту выполняются без специального оборудования.</p>
                        <p>При резке рекомендуется работать в защитной маске — пыль содержит кварцевые частицы. Инструмент следует использовать с пылесосом или увлажнением линии реза.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Какой толщины плиты выбрать для жилого дома, бизнес-центра, поликлиники?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <table class="faq-compare-table">
                            <thead>
                                <tr><th>Тип объекта</th><th>Рекомендуемая толщина</th><th>Макс. пролёт</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Жилые дома до 5 этажей</td><td>8 мм</td><td>600 мм</td></tr>
                                <tr><td>Высотные ЖК, бизнес-центры</td><td>10–12 мм</td><td>900 мм</td></tr>
                                <tr><td>Школы, больницы, соцобъекты</td><td>10–12 мм</td><td>900 мм</td></tr>
                                <tr><td>Промышленные объекты, высокая ветровая нагрузка</td><td>15 мм</td><td>1200 мм</td></tr>
                            </tbody>
                        </table>
                        <p>Точный подбор зависит от ветровой зоны и шага подсистемы — технический специалист BLP Board выполнит расчёт бесплатно.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Совместимы ли панели BLP Board с различными подсистемами НВФ?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Да. Панели BLP Board совместимы с <strong>алюминиевыми, стальными (оцинкованными) и нержавеющими подсистемами НВФ</strong> (навесных вентилируемых фасадов).</p>
                        <p>Варианты крепления:</p>
                        <ul>
                            <li><strong>Видимое</strong> — через отверстия в панели (шурупы, заклёпки)</li>
                            <li><strong>Скрытое</strong> — кляммерами по краю панели</li>
                        </ul>
                        <p>Шаг несущих профилей определяется расчётом в зависимости от толщины панели и ветровой зоны объекта. Мы предоставляем таблицу совместимости с основными системами на рынке.</p>
                    </div>
                </div>
            </div>

        </div><!-- /faq-accordion -->

        <h2 class="faq-section-title">Заказ, доставка, документы</h2>

        <div class="faq-accordion">

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Как заказать образцы фиброцементных панелей BLP Board?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Образцы всех 4 серий (NATURE, POLISHED, TEXTURE, WALYPAN) предоставляются <strong>бесплатно</strong>. Отправьте заявку через форму на сайте или позвоните по телефону <a href="tel:+74959849689">+7 (495) 984-96-89</a>.</p>
                        <p>Образцы доставляем:</p>
                        <ul>
                            <li>Москва и МО — в течение 3–5 рабочих дней</li>
                            <li>Регионы — транспортной компанией (СДЭК, Деловые Линии)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Работаете ли вы по всей России?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Да. Склад расположен в <strong>Одинцово (Московская область)</strong>. Доставка по Москве и МО — собственным транспортом. В регионы — транспортными компаниями (СДЭК, Деловые Линии, ПЭК) с нашего склада.</p>
                        <p>Сроки поставки в регионы — от 5 до 14 рабочих дней в зависимости от направления и объёма заказа.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Какие документы предоставляются для прохождения госэкспертизы?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Комплект документов для госэкспертизы:</p>
                        <ul>
                            <li>Технический паспорт изделия</li>
                            <li>Пожарный сертификат (класс НГ / К0)</li>
                            <li>Расчёт ветровых нагрузок</li>
                        </ul>
                        <p>Все документы предоставляются <strong>бесплатно</strong> при наличии проекта.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false">
                    <span itemprop="name">Сколько стоят фиброцементные панели? Как получить цену?</span>
                    <svg class="faq-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Цена зависит от <strong>серии, толщины и объёма</strong> заказа. Ценообразование прозрачное: базовая ставка за м² + логистика. Оптовые условия доступны от 200 м².</p>
                        <p>Для получения точного расчёта заполните форму с указанием серии, толщины, объёма (м²) и региона доставки — ответим в течение рабочего дня. Для дилеров — отдельные условия.</p>
                        <a href="/blp/contacts" class="faq-cta-btn">Запросить расчёт стоимости</a>
                    </div>
                </div>
            </div>

        </div><!-- /faq-accordion -->

    </div>
</section>

<!-- Schema.org FAQPage JSON-LD -->
<script type="application/ld+json">
<?php echo json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>

<?php $form_title = 'Остались вопросы?'; $form_desc = 'Напишите нам — ответим в течение рабочего дня.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
