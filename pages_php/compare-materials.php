<?php
// 2026-04-27: Сравнение BLP Board с конкурентами
$page_title     = 'BLP Board vs конкуренты: сравнение фасадных материалов';
$page_canonical = 'https://building-port.ru/compare-materials';
$page_og_image  = 'https://building-port.ru/images-convert/og-default.jpg';
$page_desc      = 'Сравнение BLP Board с HPL-панелями, керамогранитом, АКП, металлокассетами, клинкером, хризотилцементом, СФБ, терракотой и натуральным камнем по 22 параметрам.';
$extra_css      = '<link rel="stylesheet" href="/css/pages/compare-materials.css">';
$breadcrumbs    = [
    ['name' => 'Главная',              'url' => 'https://building-port.ru/'],
    ['name' => 'Сравнение материалов', 'url' => 'https://building-port.ru/compare-materials'],
];

require_once __DIR__ . '/../blocks/session_init.php';
ob_start();
?>

<!-- ============================================
     PAGE HEADER
     ============================================ -->
<div class="cmp-page-header">
    <div class="blp-container">
        <div class="cmp-header-grid">

            <div class="cmp-header-left">
                <p class="cmp-page-header-eyebrow">Анализ рынка фасадных материалов</p>
                <h1 class="cmp-page-header-title">
                    BLP Board <span class="cmp-vs">vs</span> конкуренты
                </h1>
                <p class="cmp-page-header-sub">Выберите материал — таблица покажет сравнение по 22 техническим параметрам</p>
            </div>

            <div class="cmp-header-right">
                <div class="cmp-stats-row">
                    <div class="cmp-stat">
                        <span class="cmp-stat-num">9</span>
                        <span class="cmp-stat-label">материалов</span>
                    </div>
                    <div class="cmp-stat">
                        <span class="cmp-stat-num">22</span>
                        <span class="cmp-stat-label">параметра</span>
                    </div>
                    <div class="cmp-stat">
                        <span class="cmp-stat-num">6</span>
                        <span class="cmp-stat-label">категорий</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================
     SELECTOR BAR
     ============================================ -->
<div class="cmp-selector-bar" id="cmpSelectorBar">
    <div class="blp-container">
        <div class="cmp-selector-inner">
            <span class="cmp-selector-label">Сравнить с:</span>
            <div class="cmp-pills" id="cmpPills">
                <button class="cmp-pill active" data-mat="chrysotile">Хризотилцемент</button>
                <button class="cmp-pill" data-mat="gfrc">СФБ</button>
                <button class="cmp-pill" data-mat="clinker">Клинкер</button>
                <button class="cmp-pill" data-mat="ceramics">Керамогранит</button>
                <button class="cmp-pill" data-mat="acp">АКП</button>
                <button class="cmp-pill" data-mat="metal">Металлокассеты</button>
                <button class="cmp-pill" data-mat="hpl">HPL-панели</button>
                <button class="cmp-pill" data-mat="terracotta">Терракота</button>
                <button class="cmp-pill" data-mat="stone">Натур. камень</button>
            </div>
            <select class="cmp-select-mobile" id="cmpSelectMobile">
                <option value="chrysotile">Хризотилцемент</option>
                <option value="gfrc">СФБ</option>
                <option value="clinker">Клинкер</option>
                <option value="ceramics">Керамогранит</option>
                <option value="acp">АКП</option>
                <option value="metal">Металлокассеты</option>
                <option value="hpl">HPL-панели</option>
                <option value="terracotta">Терракота</option>
                <option value="stone">Натур. камень</option>
            </select>
        </div>
    </div>
</div>

<!-- ============================================
     WIN COUNTER
     ============================================ -->
<section class="cmp-counter-section">
    <div class="blp-container">
        <div class="cmp-counter-row">
            <div class="cmp-counter-item blp" data-filter="blp" title="Показать только параметры где BLP выигрывает">
                <span class="cmp-counter-num" id="cntBlp">0</span>
                <span>BLP выигрывает</span>
            </div>
            <div class="cmp-counter-item equal" data-filter="equal" title="Показать только паритет">
                <span class="cmp-counter-num" id="cntEqual">0</span>
                <span>Паритет</span>
            </div>
            <div class="cmp-counter-item comp" data-filter="competitor" title="Показать только параметры где конкурент выигрывает">
                <span class="cmp-counter-num" id="cntComp">0</span>
                <span id="cntCompLabel">Конкурент</span> выигрывает
            </div>
            <div class="cmp-counter-item reset" id="cntReset" style="display:none">
                <span>× Все параметры</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     COMPARISON TABLE
     ============================================ -->
<section class="cmp-table-section">
    <div class="blp-container">
        <div class="cmp-table-wrap">
            <table class="cmp-table" id="cmpTable">
                <thead>
                    <tr>
                        <th class="cmp-th-param">Характеристика</th>
                        <th class="cmp-th-blp">BLP Board</th>
                        <th class="cmp-th-comp" id="thComp">HPL-панели</th>
                    </tr>
                </thead>
                <tbody id="cmpTbody">
                    <!-- 2026-04-27: Строки генерируются динамически через JS -->
                </tbody>
            </table>
        </div>

        <!-- Легенда -->
        <div class="cmp-legend">
            <span class="cmp-legend-item"><span class="cmp-legend-dot blp"></span> BLP Board выигрывает</span>
            <span class="cmp-legend-item"><span class="cmp-legend-dot equal"></span> Паритет</span>
            <span class="cmp-legend-item"><span class="cmp-legend-dot comp"></span> Конкурент выигрывает</span>
        </div>
    </div>
</section>

<!-- ============================================
     CTA ФОРМА
     ============================================ -->
<?php $form_title = 'Получить консультацию по материалу'; $form_desc = 'Ответим на вопросы по выбору фасадного материала для вашего объекта.'; include '../blocks/contact-form.php'; ?>

<!-- ============================================
     JS — данные и логика сравнения
     ============================================ -->
<script>
// 2026-04-27: BLP Board — данные для сравнения с конкурентами

const BLP = {
    thickness:       '8–15 мм',
    weight:          '16–20 кг/м²',
    formats:         'до 3050 × 1220 мм',
    frost:           '≥150 циклов (ГОСТ)',
    temp:            '−50...+80 °C',
    water:           '≤16% (прессованные ≤10%)',
    uv:              'Высокая',
    bio:             'Высокая',
    fire:            'НГ (К0) — негорючий',
    asbestos:        'Нет',
    hazardous:       'Нет',
    recyclable:      'Ограниченно',
    mounting:        'Вентфасад',
    complexity:      'Средняя',
    onsite_cut:      'Да',
    special_tools:   'Не требуется',
    colors:          '50–200+ цветов RAL',
    imitations:      'Дерево, камень, бетон, кирпич',
    repaintable:     'Не требуется (цвет в массе)',
    color_stability: 'Очень высокая',
    service_life:    '50+ лет',
    warranty:        '10–15 лет',
    install_cost:    'Средняя',
    maintenance:     'Не требуется',
};

const MATERIALS = {
    hpl: {
        name: 'HPL-панели',
        desc: 'Компакт-плиты высокого давления',
        rows: {
            thickness:      { val: '6–12 мм',                      result: 'equal' },
            weight:         { val: '8,5–18,5 кг/м²',               result: 'equal' },
            formats:        { val: 'до 3050 × 1570 мм',            result: 'equal' },
            frost:          { val: 'Н/д (до −40 °C)',              result: 'blp' },
            temp:           { val: '−40...+130 °C',                result: 'equal' },
            water:          { val: '< 3%',                         result: 'competitor' },
            uv:             { val: 'Высокая',                       result: 'equal' },
            bio:            { val: 'Высокая',                      result: 'equal' },
            fire:           { val: 'Г1 (ГОСТ 30244)',              result: 'blp' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет (формальдегид E1)',        result: 'equal' },
            recyclable:     { val: 'Ограниченно',                  result: 'equal' },
            mounting:       { val: 'Вентфасад, механика',          result: 'equal' },
            complexity:     { val: 'Средняя',                      result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Циркулярная пила, фрезер',    result: 'equal' },
            colors:         { val: '170+ цветов',                  result: 'equal' },
            imitations:     { val: 'Дерево, бетон, камень',        result: 'equal' },
            repaintable:    { val: 'Нет',                          result: 'equal' },
            color_stability:{ val: 'Высокая',                      result: 'blp' },
            service_life:   { val: '30–50 лет',                    result: 'blp' },
            warranty:       { val: '10–15 лет',                    result: 'equal' },
            install_cost:   { val: 'Средняя',                      result: 'equal' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    ceramics: {
        name: 'Керамогранит',
        desc: 'Фасадный керамогранит',
        rows: {
            thickness:      { val: '8–20 мм (вентфасад 13–14)',    result: 'equal' },
            weight:         { val: '20–35 кг/м²',                  result: 'blp' },
            formats:        { val: '300×300 — 1200×2400 мм',       result: 'equal' },
            frost:          { val: '≥150 циклов',                   result: 'equal' },
            temp:           { val: '−60...+1200 °C',               result: 'equal' },
            water:          { val: '≤ 0,05%',                      result: 'competitor' },
            uv:             { val: 'Очень высокая',                result: 'equal' },
            bio:            { val: 'Очень высокая',                result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Кляммеры или клей',            result: 'equal' },
            complexity:     { val: 'Высокая',                      result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Плиткорез, кляммеры',         result: 'equal' },
            colors:         { val: 'Тысячи вариантов',             result: 'competitor' },
            imitations:     { val: 'Камень, дерево, бетон, металл',result: 'equal' },
            repaintable:    { val: 'Нет',                          result: 'equal' },
            color_stability:{ val: 'Очень высокая',                result: 'equal' },
            service_life:   { val: '50–100+ лет',                  result: 'competitor' },
            warranty:       { val: 'Нет (на партию)',              result: 'blp' },
            install_cost:   { val: 'Высокая',                      result: 'blp' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    acp: {
        name: 'АКП',
        desc: 'Алюминиевые композитные панели',
        rows: {
            thickness:      { val: '3–4 мм (фасад)',               result: 'blp' },
            weight:         { val: '5,5–7,8 кг/м²',               result: 'competitor' },
            formats:        { val: 'до 1500 × 6000 мм',            result: 'equal' },
            frost:          { val: 'Без ограничений (металл)',      result: 'equal' },
            temp:           { val: '−50...+80 °C',                 result: 'equal' },
            water:          { val: '0% (металл)',                   result: 'competitor' },
            uv:             { val: 'Высокая (PVDF)',                result: 'equal' },
            bio:            { val: 'Очень высокая',                result: 'equal' },
            fire:           { val: 'Стандарт Г3–Г4 / FR: НГ',     result: 'blp' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Да (алюминий 100%)',           result: 'equal' },
            mounting:       { val: 'Кассетный вентфасад',          result: 'equal' },
            complexity:     { val: 'Средняя',                      result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Фрезер, гильотина',           result: 'equal' },
            colors:         { val: '200+ RAL + metallic',          result: 'equal' },
            imitations:     { val: 'Металл, зеркало',              result: 'blp' },
            repaintable:    { val: 'Только заводская',             result: 'equal' },
            color_stability:{ val: 'Высокая (PVDF)',               result: 'blp' },
            service_life:   { val: '25–40 лет',                    result: 'blp' },
            warranty:       { val: '10 лет (PVDF до 20)',          result: 'equal' },
            install_cost:   { val: 'Средняя',                      result: 'equal' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    metal: {
        name: 'Металлокассеты',
        desc: 'Стальные и алюминиевые кассеты',
        rows: {
            thickness:      { val: 'Al 1,5–3 мм / Сталь 0,7–1,5 мм', result: 'blp' },
            weight:         { val: '5–15 кг/м²',                   result: 'competitor' },
            formats:        { val: 'до 1400 × 5000 мм (под заказ)',result: 'equal' },
            frost:          { val: 'Без ограничений (металл)',      result: 'equal' },
            temp:           { val: '−60...+120 °C',                result: 'equal' },
            water:          { val: '0% (металл)',                   result: 'competitor' },
            uv:             { val: 'Высокая (покрытие)',            result: 'equal' },
            bio:            { val: 'Очень высокая',                result: 'equal' },
            fire:           { val: 'НГ (металл)',                   result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Да (металл 100%)',             result: 'equal' },
            mounting:       { val: 'Вентфасад, скрытое крепление', result: 'equal' },
            complexity:     { val: 'Средняя',                      result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Гильотина, листогиб',         result: 'equal' },
            colors:         { val: 'RAL 200+, Corten',             result: 'equal' },
            imitations:     { val: 'Металл (Corten, нерж.)',        result: 'blp' },
            repaintable:    { val: 'Только на производстве',       result: 'equal' },
            color_stability:{ val: 'Высокая',                      result: 'blp' },
            service_life:   { val: '25–50 лет',                    result: 'equal' },
            warranty:       { val: '5–10 лет',                     result: 'blp' },
            install_cost:   { val: 'Средняя',                      result: 'equal' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    clinker: {
        name: 'Клинкерная плитка',
        desc: 'Фасадная клинкерная плитка',
        rows: {
            thickness:      { val: '10–19 мм',                     result: 'equal' },
            weight:         { val: '14–35 кг/м²',                  result: 'equal' },
            formats:        { val: '60×240 — 240×660 мм',          result: 'blp' },
            frost:          { val: '≥150 циклов',                   result: 'equal' },
            temp:           { val: '−50...+1000 °C',               result: 'competitor' },
            water:          { val: '1–3%',                         result: 'competitor' },
            uv:             { val: 'Очень высокая (цвет в массе)', result: 'equal' },
            bio:            { val: 'Очень высокая',                result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Клей или вентфасад (панельный)', result: 'equal' },
            complexity:     { val: 'Высокая',                      result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Плиткорез, затирки',          result: 'equal' },
            colors:         { val: 'Сотни (цвет в массе)',         result: 'equal' },
            imitations:     { val: 'Кирпич, ручная кладка',        result: 'blp' },
            repaintable:    { val: 'Нет',                          result: 'equal' },
            color_stability:{ val: 'Очень высокая',                result: 'equal' },
            service_life:   { val: '50–100 лет',                   result: 'competitor' },
            warranty:       { val: 'Нет',                          result: 'blp' },
            install_cost:   { val: 'Высокая',                      result: 'blp' },
            maintenance:    { val: 'Низкое (швы)',                  result: 'blp' },
        }
    },
    chrysotile: {
        name: 'Хризотилцемент',
        desc: 'Асбестоцементные плиты',
        rows: {
            thickness:      { val: '4–10 мм',                      result: 'equal' },
            weight:         { val: '10–20 кг/м²',                  result: 'equal' },
            formats:        { val: 'до 3600 × 1500 мм',            result: 'equal' },
            frost:          { val: '25–50 циклов',                  result: 'blp' },
            temp:           { val: '−70...+70 °C',                 result: 'equal' },
            water:          { val: '≤18%',                         result: 'blp' },
            uv:             { val: 'Средняя (требует окраски)',     result: 'blp' },
            bio:            { val: 'Высокая',                      result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: '⚠ Содержит хризотиловый асбест', result: 'blp' },
            hazardous:      { val: '⚠ Опасная пыль при резке',    result: 'blp' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Вентфасад или обрешётка',      result: 'equal' },
            complexity:     { val: 'Низкая',                       result: 'equal' },
            onsite_cut:     { val: 'Да (защита обязательна)',       result: 'equal' },
            special_tools:  { val: 'Болгарка + респиратор',        result: 'equal' },
            colors:         { val: 'Под покраску (серый)',          result: 'blp' },
            imitations:     { val: 'Нет (требует отделочного слоя)', result: 'blp' },
            repaintable:    { val: 'Да (требуется регулярно)',      result: 'blp' },
            color_stability:{ val: 'Зависит от краски',            result: 'blp' },
            service_life:   { val: '25–40 лет',                    result: 'blp' },
            warranty:       { val: 'Нет',                          result: 'blp' },
            install_cost:   { val: 'Низкая',                       result: 'competitor' },
            maintenance:    { val: 'Среднее (регулярная окраска)',  result: 'blp' },
        }
    },
    gfrc: {
        name: 'СФБ',
        desc: 'Стеклофибробетон (GFRC)',
        rows: {
            thickness:      { val: '10–25 мм',                     result: 'equal' },
            weight:         { val: '20–25 кг/м²',                  result: 'blp' },
            formats:        { val: 'Индивидуальное литьё до 3×2 м', result: 'competitor' },
            frost:          { val: '≥500 циклов',                  result: 'equal' },
            temp:           { val: '−50...+70 °C',                 result: 'equal' },
            water:          { val: 'Н/д',                          result: 'equal' },
            uv:             { val: 'Средняя (зависит от финиша)',   result: 'blp' },
            bio:            { val: 'Высокая',                      result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Вентфасад, анкеры',            result: 'equal' },
            complexity:     { val: 'Высокая (нужен кран)',          result: 'equal' },
            onsite_cut:     { val: 'Ограниченно',                  result: 'equal' },
            special_tools:  { val: 'Кран, алмазный диск',          result: 'equal' },
            colors:         { val: 'Любой (пигментация)',           result: 'equal' },
            imitations:     { val: 'Бетон, камень, лепнина',       result: 'equal' },
            repaintable:    { val: 'Да',                           result: 'equal' },
            color_stability:{ val: 'Средняя',                      result: 'blp' },
            service_life:   { val: '50+ лет',                      result: 'equal' },
            warranty:       { val: 'Нет',                          result: 'blp' },
            install_cost:   { val: 'Высокая',                      result: 'blp' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    terracotta: {
        name: 'Терракота',
        desc: 'Обожжённые терракотовые панели',
        rows: {
            thickness:      { val: '12–40 мм',                     result: 'equal' },
            weight:         { val: '30–50 кг/м²',                  result: 'blp' },
            formats:        { val: 'ш. 200–600 мм, д. до 1600 мм', result: 'blp' },
            frost:          { val: '≤150 циклов',                   result: 'equal' },
            temp:           { val: '−50...+1000 °C',               result: 'competitor' },
            water:          { val: '3–6%',                         result: 'competitor' },
            uv:             { val: 'Очень высокая (цвет в массе)', result: 'equal' },
            bio:            { val: 'Очень высокая',                result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Нет',                          result: 'equal' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Исключительно вентфасад',      result: 'equal' },
            complexity:     { val: 'Средняя–высокая',              result: 'equal' },
            onsite_cut:     { val: 'Да',                           result: 'equal' },
            special_tools:  { val: 'Клипсы производителя',         result: 'equal' },
            colors:         { val: '50–100+ (терракотовые тона)',  result: 'blp' },
            imitations:     { val: 'Керамика, кирпич, камень',     result: 'blp' },
            repaintable:    { val: 'Нет',                          result: 'equal' },
            color_stability:{ val: 'Очень высокая',                result: 'equal' },
            service_life:   { val: '50–100+ лет',                  result: 'competitor' },
            warranty:       { val: '25 лет',                       result: 'competitor' },
            install_cost:   { val: 'Средняя–высокая',              result: 'blp' },
            maintenance:    { val: 'Низкое',                       result: 'blp' },
        }
    },
    stone: {
        name: 'Натуральный камень',
        desc: 'Гранит, известняк, песчаник',
        rows: {
            thickness:      { val: '18–40 мм',                     result: 'blp' },
            weight:         { val: '50–60 кг/м² (гранит)',         result: 'blp' },
            formats:        { val: '300–1200 мм (индивидуально)',   result: 'equal' },
            frost:          { val: '≥150 циклов',                   result: 'equal' },
            temp:           { val: '−60...+1000 °C',               result: 'competitor' },
            water:          { val: 'Гранит 0,1–0,5%',              result: 'competitor' },
            uv:             { val: 'Очень высокая (гранит)',        result: 'equal' },
            bio:            { val: 'Очень высокая (гранит)',        result: 'equal' },
            fire:           { val: 'НГ',                           result: 'equal' },
            asbestos:       { val: 'Нет',                          result: 'equal' },
            hazardous:      { val: 'Слабая радиоактивность (гранит)', result: 'blp' },
            recyclable:     { val: 'Нет',                          result: 'equal' },
            mounting:       { val: 'Кляммеры, скрытые анкеры',     result: 'equal' },
            complexity:     { val: 'Очень высокая',                result: 'equal' },
            onsite_cut:     { val: 'Да (водяное охлаждение)',       result: 'equal' },
            special_tools:  { val: 'Кран, водяное охлаждение',     result: 'equal' },
            colors:         { val: 'Ограничен природными вариантами', result: 'blp' },
            imitations:     { val: 'Сам является эталоном',        result: 'equal' },
            repaintable:    { val: 'Нет',                          result: 'equal' },
            color_stability:{ val: 'Очень высокая (гранит)',        result: 'equal' },
            service_life:   { val: '100–500+ лет',                 result: 'competitor' },
            warranty:       { val: 'Нет',                          result: 'blp' },
            install_cost:   { val: 'Очень высокая',                result: 'blp' },
            maintenance:    { val: 'Среднее (чистка, пропитка)',    result: 'blp' },
        }
    }
};

// 2026-04-27: Структура строк таблицы
const TABLE_STRUCTURE = [
    { type: 'cat', label: 'Физические параметры' },
    { type: 'row', key: 'thickness',       label: 'Толщина' },
    { type: 'row', key: 'weight',          label: 'Масса, кг/м²' },
    { type: 'row', key: 'formats',         label: 'Максимальный формат' },
    { type: 'cat', label: 'Климатика и эксплуатация' },
    { type: 'row', key: 'frost',           label: 'Морозостойкость' },
    { type: 'row', key: 'temp',            label: 'Температурный диапазон' },
    { type: 'row', key: 'water',           label: 'Водопоглощение' },
    { type: 'row', key: 'uv',             label: 'УФ-стойкость' },
    { type: 'row', key: 'bio',            label: 'Биостойкость' },
    { type: 'cat', label: 'Пожарная безопасность' },
    { type: 'row', key: 'fire',           label: 'Класс горючести' },
    { type: 'cat', label: 'Экология' },
    { type: 'row', key: 'asbestos',       label: 'Содержание асбеста' },
    { type: 'row', key: 'hazardous',      label: 'Вредные вещества' },
    { type: 'row', key: 'recyclable',     label: 'Вторичная переработка' },
    { type: 'cat', label: 'Монтаж' },
    { type: 'row', key: 'mounting',       label: 'Система крепления' },
    { type: 'row', key: 'complexity',     label: 'Сложность монтажа' },
    { type: 'row', key: 'onsite_cut',     label: 'Резка на объекте' },
    { type: 'row', key: 'special_tools',  label: 'Спецоборудование/техника' },
    { type: 'cat', label: 'Эстетика' },
    { type: 'row', key: 'imitations',     label: 'Имитируемые материалы' },
    { type: 'row', key: 'repaintable',    label: 'Перекраска' },
    { type: 'row', key: 'color_stability',label: 'Стабильность цвета' },
    { type: 'cat', label: 'Долговечность и экономика' },
    { type: 'row', key: 'service_life',   label: 'Срок службы' },
    { type: 'row', key: 'install_cost',   label: 'Стоимость монтажа' },
    { type: 'row', key: 'maintenance',    label: 'Обслуживание' },
];

// 2026-04-27: Рендер таблицы при смене материала
function renderTable(matKey) {
    const mat = MATERIALS[matKey];
    if (!mat) return;

    // Обновить заголовок конкурента
    document.getElementById('thComp').textContent = mat.name;

    // Обновить счётчик в легенде
    document.getElementById('cntCompLabel').textContent = mat.name;

    let blpWins = 0, equalWins = 0, compWins = 0;
    const tbody = document.getElementById('cmpTbody');
    let html = '';

    TABLE_STRUCTURE.forEach(function(item) {
        if (item.type === 'cat') {
            html += '<tr class="cmp-row-cat"><td colspan="3">' + item.label + '</td></tr>';
        } else {
            const row = mat.rows[item.key];
            const blpVal = BLP[item.key] || '—';
            const compVal = row ? row.val : '—';
            const result = row ? row.result : 'equal';

            let blpClass = '', compClass = '', blpIcon = '', compIcon = '';
            if (result === 'blp') {
                blpClass = 'cell-win-blp';
                blpIcon = '<span class="cmp-cell-icon">✓</span>';
                blpWins++;
            } else if (result === 'competitor') {
                compClass = 'cell-win-comp';
                compIcon = '<span class="cmp-cell-icon">★</span>';
                compWins++;
            } else {
                equalWins++;
            }

            html += '<tr data-result="' + result + '">'
                + '<td class="cmp-td-param">' + item.label + '</td>'
                + '<td class="' + blpClass + '">' + blpVal + blpIcon + '</td>'
                + '<td class="' + compClass + '">' + compVal + compIcon + '</td>'
                + '</tr>';
        }
    });

    tbody.innerHTML = html;

    // Обновить счётчики
    document.getElementById('cntBlp').textContent = blpWins;
    document.getElementById('cntEqual').textContent = equalWins;
    document.getElementById('cntComp').textContent = compWins;
}

// 2026-04-27: Переключение пилл
function setActiveMaterial(matKey) {
    // Пиллы
    document.querySelectorAll('.cmp-pill').forEach(function(btn) {
        btn.classList.toggle('active', btn.dataset.mat === matKey);
    });
    // Мобильный select
    var sel = document.getElementById('cmpSelectMobile');
    if (sel) sel.value = matKey;

    renderTable(matKey);
}

// 2026-04-27: Фильтрация таблицы по результату
var activeFilter = null;

function applyFilter(filter) {
    activeFilter = (activeFilter === filter) ? null : filter;

    // Состояние кнопок счётчика
    document.querySelectorAll('.cmp-counter-item[data-filter]').forEach(function(el) {
        el.classList.toggle('filter-active', el.dataset.filter === activeFilter);
    });

    // Кнопка сброса
    document.getElementById('cntReset').style.display = activeFilter ? '' : 'none';

    // Фильтр строк
    var rows = document.querySelectorAll('#cmpTbody tr');
    rows.forEach(function(row) {
        if (row.classList.contains('cmp-row-cat')) return;
        row.style.display = (!activeFilter || row.dataset.result === activeFilter) ? '' : 'none';
    });

    // Скрыть пустые категории
    document.querySelectorAll('#cmpTbody .cmp-row-cat').forEach(function(cat) {
        if (!activeFilter) { cat.style.display = ''; return; }
        var next = cat.nextElementSibling;
        var hasVisible = false;
        while (next && !next.classList.contains('cmp-row-cat')) {
            if (next.style.display !== 'none') { hasVisible = true; break; }
            next = next.nextElementSibling;
        }
        cat.style.display = hasVisible ? '' : 'none';
    });
}

// Клик по счётчику — фильтр
document.querySelector('.cmp-counter-row').addEventListener('click', function(e) {
    var item = e.target.closest('.cmp-counter-item[data-filter]');
    var reset = e.target.closest('#cntReset');
    if (item) applyFilter(item.dataset.filter);
    if (reset) applyFilter(null);
});

// Пиллы — клик
document.getElementById('cmpPills').addEventListener('click', function(e) {
    var btn = e.target.closest('.cmp-pill');
    if (!btn) return;
    activeFilter = null; // сброс фильтра при смене материала
    setActiveMaterial(btn.dataset.mat);
});

// Мобильный select — change
document.getElementById('cmpSelectMobile').addEventListener('change', function() {
    activeFilter = null;
    setActiveMaterial(this.value);
});

// Инициализация с Хризотилцемент по умолчанию
setActiveMaterial('chrysotile');
</script>

<?php
$page_content = ob_get_clean();
include 'template.php';
?>
