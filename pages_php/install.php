<?php
// 2026-04-20: Stage 3 Group 3.B — Installation guide with HowTo schema
$page_title    = 'Монтаж фиброцементных панелей BLP Board: пошаговое руководство';
$page_canonical = 'https://building-port.ru/blp/install';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Пошаговое руководство по монтажу фиброцементных панелей BLP Board на навесной вентилируемый фасад (НВФ): инструменты, подготовка основания, крепление, типичные ошибки.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/install.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',          'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Руководство по монтажу', 'url' => 'https://building-port.ru/blp/install'],
];

// 2026-04-20: HowTo schema.org markup
$howto_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'HowTo',
    'name' => 'Монтаж фиброцементных панелей BLP Board на НВФ',
    'description' => 'Пошаговое руководство по монтажу фиброцементных панелей серий NATURE, POLISHED, TEXTURE на навесной вентилируемый фасад.',
    'totalTime' => 'P2D',
    'tool' => [
        ['@type' => 'HowToTool', 'name' => 'Циркулярная пила с твёрдосплавным диском'],
        ['@type' => 'HowToTool', 'name' => 'Шуруповёрт'],
        ['@type' => 'HowToTool', 'name' => 'Перфоратор'],
        ['@type' => 'HowToTool', 'name' => 'Уровень строительный (2 м)'],
        ['@type' => 'HowToTool', 'name' => 'Рулетка, маркер, отвес'],
        ['@type' => 'HowToTool', 'name' => 'Защитные очки и маска (класс FFP2)'],
    ],
    'supply' => [
        ['@type' => 'HowToSupply', 'name' => 'Фиброцементные панели BLP Board'],
        ['@type' => 'HowToSupply', 'name' => 'Алюминиевая или стальная подсистема НВФ'],
        ['@type' => 'HowToSupply', 'name' => 'Анкерные болты для крепления кронштейнов'],
        ['@type' => 'HowToSupply', 'name' => 'Паропроницаемая ветрозащитная мембрана'],
        ['@type' => 'HowToSupply', 'name' => 'Утеплитель (минеральная вата)'],
        ['@type' => 'HowToSupply', 'name' => 'Кляммеры или шурупы с потайной головкой'],
    ],
    'step' => [
        [
            '@type' => 'HowToStep',
            'position' => 1,
            'name' => 'Подготовка основания',
            'text' => 'Проверьте несущую способность стены (кирпич, монолит, ж/б панель). Устраните сколы и трещины глубиной более 5 мм. Вынесите разметку фасада — оси кронштейнов с шагом согласно проекту (обычно 600–900 мм по горизонтали).'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 2,
            'name' => 'Монтаж кронштейнов подсистемы',
            'text' => 'Просверлите отверстия в стене по разметке. Установите анкерные болты и кронштейны с термовставками (для предотвращения мостиков холода). Выровняйте кронштейны по вертикали с допуском ±1 мм на 1 м высоты.'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 3,
            'name' => 'Укладка утеплителя и ветрозащиты',
            'text' => 'Закрепите плиты минеральной ваты (рекомендуемая плотность ≥80 кг/м³) тарельчатыми дюбелями из расчёта 5–6 шт/м². Поверх утеплителя — паропроницаемая ветрозащитная мембрана с нахлёстом 100 мм. Вентиляционный зазор между мембраной и панелями — не менее 40 мм.'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 4,
            'name' => 'Монтаж несущих и направляющих профилей',
            'text' => 'Закрепите вертикальные (или горизонтальные) направляющие на кронштейнах. Соблюдайте шаг профилей в соответствии с расчётом для выбранной толщины панели. Проверьте плоскость подсистемы нивелиром.'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 5,
            'name' => 'Раскрой панелей',
            'text' => 'Выполняйте раскрой циркулярной пилой с твёрдосплавным диском или болгаркой. Работайте в защитной маске (FFP2) и очках. Кромки после реза обработайте водоотталкивающим составом на акриловой основе для предотвращения впитывания влаги в торец.'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 6,
            'name' => 'Монтаж панелей',
            'text' => 'Начинайте монтаж снизу вверх. При видимом креплении: предварительно просверлите отверстие диаметром на 1 мм больше шурупа (компенсация теплового расширения). Затяжка — до плотного прилегания, без деформации панели. При скрытом креплении (кляммеры): вставьте кляммер в паз панели и закрепите к профилю шурупом.'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 7,
            'name' => 'Оформление примыканий и откосов',
            'text' => 'Оконные и дверные откосы закройте фасонными алюминиевыми элементами или нарезанными полосами из панелей. На углах используйте алюминиевый угловой профиль или выполните стыковку панелей под 45°. Зазор между панелями в швах — 8–12 мм (без заполнения герметиком для обеспечения вентиляции).'
        ],
    ]
];

ob_start();
?>
<!-- ============================================
     INSTALL HERO
     ============================================ -->
<section class="blp-hero-section install-hero">
    <div class="blp-container">
        <div class="blp-grid-12">
            <div class="blp-hero-content">
                <h1 class="blp-hero-title">Монтаж фиброцементных<br>панелей BLP Board</h1>
                <p class="blp-hero-subtitle">Пошаговое руководство для НВФ (навесного вентилируемого фасада)</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>7 шагов от подготовки до финального оформления</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Совместимость со всеми алюминиевыми и стальными подсистемами</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Типичные ошибки и как их избежать</span>
                    </li>
                </ul>
                <a href="/blp/contacts" class="blp-hero-button">Получить техническую документацию</a>
            </div>
            <div class="blp-hero-image install-hero-steps">
                <div class="install-steps-counter">
                    <span class="install-steps-num">7</span>
                    <span class="install-steps-label">шагов<br>монтажа</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     TOOLS & MATERIALS
     ============================================ -->
<section class="install-tools-section">
    <div class="blp-container">
        <h2 class="install-section-title">Инструменты и материалы</h2>

        <div class="install-tools-grid">
            <div class="install-tools-col">
                <h3 class="install-tools-subtitle">Инструменты</h3>
                <ul class="install-tools-list">
                    <li>Циркулярная пила с твёрдосплавным диском</li>
                    <li>Шуруповёрт (крутящий момент ≥25 Нм)</li>
                    <li>Перфоратор с буром по бетону/кирпичу</li>
                    <li>Уровень строительный (2 м) и лазерный нивелир</li>
                    <li>Рулетка (10 м), маркер, угольник</li>
                    <li>Отвес для проверки вертикали</li>
                    <li>Защитные очки и маска FFP2 (при резке)</li>
                </ul>
            </div>
            <div class="install-tools-col">
                <h3 class="install-tools-subtitle">Материалы</h3>
                <ul class="install-tools-list">
                    <li>Фиброцементные панели BLP Board</li>
                    <li>Алюминиевая или оцинкованная стальная подсистема НВФ</li>
                    <li>Анкерные болты (по типу основания)</li>
                    <li>Минеральная вата (плотность ≥80 кг/м³)</li>
                    <li>Паропроницаемая ветрозащитная мембрана</li>
                    <li>Кляммеры или шурупы с потайной головкой (нержавеющая сталь)</li>
                    <li>Акриловый состав для обработки кромок</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     STEP-BY-STEP GUIDE
     ============================================ -->
<section class="install-steps-section" itemscope itemtype="https://schema.org/HowTo">
    <meta itemprop="name" content="Монтаж фиброцементных панелей BLP Board на НВФ">
    <div class="blp-container">
        <h2 class="install-section-title" itemprop="description">Пошаговый монтаж фиброцементных панелей на НВФ</h2>

        <div class="install-steps-list">

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">1</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Подготовка основания</h3>
                    <p itemprop="text">Проверьте несущую способность стены (кирпич, монолит, ж/б панель). Устраните сколы и трещины глубиной более 5 мм. Вынесите разметку фасада — оси кронштейнов с шагом согласно проекту (обычно 600–900 мм по горизонтали).</p>
                    <div class="install-step-tip">
                        <strong>Важно:</strong> при работе с газобетоном используйте анкеры для ячеистых бетонов с расчётом вырывной нагрузки. Стандартные анкеры для монолита здесь не подходят.
                    </div>
                    <!-- Video placeholder -->
                    <div class="install-video-placeholder" aria-label="Видео: подготовка основания (доступно по запросу)">
                        <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        <span>Видео: Подготовка основания</span>
                    </div>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">2</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Монтаж кронштейнов подсистемы</h3>
                    <p itemprop="text">Просверлите отверстия в стене по разметке. Установите анкерные болты и кронштейны с термовставками — они предотвращают мостики холода через металлические элементы. Выровняйте кронштейны по вертикали с допуском <strong>±1 мм на 1 м высоты</strong>.</p>
                    <div class="install-step-tip">
                        <strong>Совет:</strong> используйте лазерный нивелир для разметки рядов кронштейнов — это сэкономит время и обеспечит ровную плоскость подсистемы.
                    </div>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">3</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Укладка утеплителя и ветрозащиты</h3>
                    <p itemprop="text">Закрепите плиты минеральной ваты тарельчатыми дюбелями из расчёта <strong>5–6 штук на м²</strong>. Поверх утеплителя — паропроницаемая ветрозащитная мембрана с нахлёстом 100 мм. Вентиляционный зазор между мембраной и панелями — не менее 40 мм.</p>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">4</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Монтаж несущих профилей</h3>
                    <p itemprop="text">Закрепите вертикальные (или горизонтальные, в зависимости от системы) направляющие на кронштейнах. Соблюдайте шаг профилей в соответствии с расчётом для выбранной толщины панели. Проверьте плоскость подсистемы нивелиром — допуск ±2 мм на 2 м.</p>
                    <!-- Video placeholder -->
                    <div class="install-video-placeholder" aria-label="Видео: монтаж направляющих (доступно по запросу)">
                        <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        <span>Видео: Монтаж несущих профилей</span>
                    </div>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">5</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Раскрой панелей</h3>
                    <p itemprop="text">Выполняйте раскрой циркулярной пилой с твёрдосплавным диском или болгаркой. Работайте в защитной маске FFP2 и очках. <strong>Обязательно:</strong> кромки после реза обработайте водоотталкивающим составом на акриловой основе для предотвращения впитывания влаги в торец панели.</p>
                    <div class="install-step-tip">
                        <strong>Типичная ошибка:</strong> не оставлять торцы необработанными. Необработанный торец поглощает воду при намокании, что со временем может привести к расслоению кромки.
                    </div>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">6</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Монтаж панелей</h3>
                    <p itemprop="text">Начинайте монтаж снизу вверх. При <strong>видимом креплении</strong>: предварительно просверлите отверстие диаметром на 1 мм больше шурупа — это компенсирует тепловое расширение панели. Затяжка — до плотного прилегания, без деформации. При <strong>скрытом креплении (кляммеры)</strong>: вставьте кляммер в паз панели и закрепите к профилю шурупом.</p>
                    <div class="install-step-tip">
                        <strong>Типичная ошибка:</strong> перетяжка крепёжных элементов. Шуруп, вкрученный «до предела», создаёт точечное напряжение и может стать причиной растрескивания панели при температурных деформациях.
                    </div>
                    <!-- Video placeholder -->
                    <div class="install-video-placeholder" aria-label="Видео: крепление панелей (доступно по запросу)">
                        <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        <span>Видео: Крепление панелей</span>
                    </div>
                </div>
            </div>

            <div class="install-step" itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <div class="install-step-num"><span itemprop="position">7</span></div>
                <div class="install-step-content">
                    <h3 class="install-step-title" itemprop="name">Оформление примыканий и откосов</h3>
                    <p itemprop="text">Оконные и дверные откосы закройте фасонными алюминиевыми элементами или нарезанными полосами из панелей. На углах используйте алюминиевый угловой профиль или выполните стыковку панелей под 45°. <strong>Зазор между панелями в швах — 8–12 мм</strong> (без герметика — для обеспечения вентиляции фасада).</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================
     COMMON MISTAKES
     ============================================ -->
<section class="install-mistakes-section">
    <div class="blp-container">
        <h2 class="install-section-title">Типичные ошибки при монтаже</h2>

        <div class="install-mistakes-grid">
            <div class="install-mistake-card">
                <div class="install-mistake-icon">✗</div>
                <h3>Не обработаны торцы</h3>
                <p>Торцы после раскроя впитывают влагу. Обязательно покрывайте акриловым гидрофобным составом сразу после резки.</p>
            </div>
            <div class="install-mistake-card">
                <div class="install-mistake-icon">✗</div>
                <h3>Перетяжка крепёжных элементов</h3>
                <p>Шуруп, вкрученный «насухо», создаёт точечное напряжение. Оставляйте зазор 1 мм под шляпкой шурупа.</p>
            </div>
            <div class="install-mistake-card">
                <div class="install-mistake-icon">✗</div>
                <h3>Герметик в швах</h3>
                <p>Швы между панелями НВФ должны быть открытыми для вентиляции. Герметик нарушает работу вентилируемого зазора.</p>
            </div>
            <div class="install-mistake-card">
                <div class="install-mistake-icon">✗</div>
                <h3>Монтаж без термовставок</h3>
                <p>Металлический кронштейн без термовставки — мостик холода. Это ведёт к конденсату и потерям тепла через фасад.</p>
            </div>
        </div>

        <div class="install-doc-cta">
            <p>Нужна техническая документация по монтажу? Предоставим спецификации и таблицу совместимости с подсистемами — бесплатно.</p>
            <a href="/blp/contacts" class="blp-hero-button">Получить документацию</a>
        </div>
    </div>
</section>

<!-- Schema.org HowTo JSON-LD -->
<script type="application/ld+json">
<?php echo json_encode($howto_schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>

<?php $form_title = 'Вопрос по монтажу'; $form_desc = 'Задайте вопрос нашему технологу — ответим в течение рабочего дня.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
