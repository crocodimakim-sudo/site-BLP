<?php
// 2026-04-22: image-helper for WebP + lazy-loading support
require_once __DIR__ . '/../blocks/image-helper.php';

// 2026-04-24: SEO — title keyword-first, canonical trailing slash removed (consistent with breadcrumb)
// 2026-05-04: title сокращён с 68 до 52 симв., детали в description (Phase 3)
$page_title = "Крепление фиброцементных панелей BLP Board: 2 способа";
$page_desc = "Варианты крепления фиброцементных панелей BLP Board к подсистеме: видимый и скрытый способы. Совместимость с алюминиевыми, оцинкованными и нержавеющими подсистемами.";
$page_canonical = 'https://building-port.ru/kreplenie';
$page_og_image  = 'https://building-port.ru/images-convert/pages/kreplenie/vidimoe/mount_visible_facade.png';
$extra_css = '<link rel="stylesheet" href="/css/pages/kreplenie.css">';
$extra_js = "";
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',           'url' => 'https://building-port.ru/'],
    ['name' => 'Способы крепления', 'url' => 'https://building-port.ru/kreplenie'],
];

require_once __DIR__ . '/../blocks/session_init.php';
ob_start();
?>

<!-- Блок MOUNTING -->
<div class="blp-mounting-block">
    <h1 class="blp-mounting-title">Варианты крепления панелей&nbsp;к подсистеме</h1><!-- 2026-09-05: h2→h1, страница была без H1; класс и стили те же -->
    <div class="blp-mounting-divider"></div>

    <!-- Видимый способ -->
    <div class="blp-method-section">
        <h2 class="blp-method-header">Видимый</h2>
        <div class="blp-method-content">
            <div class="blp-method-images">
                <div class="blp-img-large">
                    <?php echo render_image('/images-convert/pages/kreplenie/vidimoe/mount_visible_facade.png', 'Фасад с видимыми заклёпками', ['lazy' => false]) /* 2026-09-05: первый экран — eager */; ?>
                </div>
                <div class="blp-img-small">
                    <?php echo render_image('/images-convert/pages/kreplenie/vidimoe/mount_visible_rivets.png', 'Заклёпки'); ?>
                </div>
            </div>
            <div class="blp-method-info">
                <!-- 2026-08-18: уточнено — видимое крепление предусматривает 2 официальных способа по АТР АТРБИЛДП230626 -->
                <p class="blp-method-description">Вытяжные заклёпки или самосверлящие винты, выкрашенные&nbsp;в тон панели, становятся деталью дизайна.</p>
            </div>
        </div>
    </div>

    <!-- Скрытый способ -->
    <div class="blp-method-section">
        <h2 class="blp-method-header">Скрытый способ</h2>
        <div class="blp-method-content">
            <div class="blp-method-images">
                <div class="blp-img-large">
                    <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_hidden_scheme.png', 'Скрытый способ крепления'); ?>
                </div>
            </div>
            <div class="blp-method-info">
                <!-- 2026-08-18: перечень скрытого крепежа приведён к 3 официальным способам по АТР АТРБИЛДП230626 (убраны KEIL и «Аграфы NORDFox» — таких вариантов нет в АТР/ТС) -->
                <p class="blp-method-description">Невидимый крепёж - сохраняет чистоту фасадной поверхности. Ничего лишнего, только идеальные линии. Три официальных способа скрытого крепления по Альбому технических решений АТРБИЛДП230626: кляммеры КЛ8 «КРАБ» (ГК «ДИАТ», ТС № 7205-24), анкеры KS цангового типа (ООО «ТПК «Новая Грань», ТС № 7204-24), винты ФИКСАР типа ИНСЕРТ РТ (ТС № 7457-26).</p>
                <div class="blp-hardware-grid">
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">Кляммер КЛ8 «КРАБ»</p>
                        <div class="blp-hardware-images">
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_krab_1.png', 'Кляммер КЛ8 КРАБ'); ?>
                            </div>
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_krab_2.png', 'Кляммер КЛ8 КРАБ вид 2'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">Анкер KS цангового типа</p>
                    </div>
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">Винт ФИКСАР типа ИНСЕРТ РТ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Блок COMPAT -->
<div class="blp-compatibility-block">
    <h2 class="blp-compatibility-title">Совместимость&nbsp;с подсистемами</h2>
    <div class="blp-compatibility-divider"></div>

    <div class="blp-materials-grid">
        <div class="blp-material-card">
            <p class="blp-material-name">Алюминий</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">Оцинкованная сталь</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">Нержавеющая сталь</p>
        </div>
    </div>
</div>

<!-- 2026-08-18: блок совместимых фасадных систем (класс К0) добавлен по решению владельца -->
<div class="blp-compatibility-block">
    <h2 class="blp-compatibility-title">Совместимые фасадные системы (класс К0 по ГОСТ 31251-2008)</h2>
    <div class="blp-compatibility-divider"></div>

    <p class="blp-method-description">Подтверждено экспертным заключением АНО «ПОЖ-АУДИТ» № З-1/06-2026 от 23.06.2026: класс пожарной опасности К0 (ГОСТ 31251-2008) распространён на 10 навесных фасадных систем (НФС) с облицовкой BLPboard:</p>

    <div class="blp-materials-grid">
        <div class="blp-material-card">
            <p class="blp-material-name">АЛЬТ-ФАСАД-А/ФБ</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">АЛЬТ-ФАСАД-03</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">NORDFOX MTA-v-100</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">NORDFOX MLK-v-300 DECO</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">U-kon (АТС-114, LT-147р, АТС-414, LT-447, СИАЛ ПЛМ, КАФТ 03-В/С)</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">EnWall-PANELS</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">UTECH VFH Fibrocement</p>
        </div>
        <div class="blp-material-card">
            <p class="blp-material-name">ФАРОС-001</p>
        </div>
    </div>
</div>

<?php include "../blocks/partners-section.php"; ?>
<?php include "../blocks/contact-form.php"; ?>

<!-- 2026-05-11: HowTo schema — 2 способа крепления (видимое/скрытое) для SERP rich results -->
<?php
$howto_data = [
    'name'        => 'Крепление фиброцементных панелей BLP Board к подсистеме',
    'description' => 'Видимое и скрытое крепление фиброцементных панелей BLP Board к алюминиевой, оцинкованной или нержавеющей подсистеме навесного вентилируемого фасада.',
    'totalTime'   => 'PT1D',
    'tool'        => [
        ['name' => 'Заклёпочник'],
        ['name' => 'Шуруповёрт'],
        ['name' => 'Дрель'],
        ['name' => 'Уровень'],
    ],
    // 2026-08-18: перечень крепежа приведён к 5 официальным способам по АТР АТРБИЛДП230626 (убраны KEIL и Nordfox)
    'supply'      => [
        ['name' => 'Заклёпки вытяжные или самосверлящие винты (для видимого крепления)'],
        ['name' => 'Кляммеры КЛ8 «КРАБ», анкеры KS цангового типа или винты ФИКСАР типа ИНСЕРТ РТ (для скрытого крепления)'],
        ['name' => 'Направляющие профили подсистемы'],
        ['name' => 'Фиброцементные панели BLP Board'],
    ],
    'step'        => [
        [
            'name' => 'Монтаж подсистемы',
            'text' => 'Установите кронштейны на несущую стену с шагом 600 мм, закрепите вертикальные направляющие. Используйте алюминиевую, оцинкованную или нержавеющую подсистему — все варианты совместимы с BLP Board.',
        ],
        [
            'name' => 'Видимое крепление заклёпками',
            'text' => 'Просверлите отверстие в панели и направляющей. Установите вытяжную заклёпку из нержавеющей стали или окрашенную в цвет панели. Заклёпки видны на фасаде — допустимо для большинства архитектурных решений.',
        ],
        [
            'name' => 'Скрытое крепление',
            'text' => 'Закрепите кляммеры КЛ8 «КРАБ», анкеры KS цангового типа или винты ФИКСАР типа ИНСЕРТ РТ к направляющим по Альбому технических решений АТРБИЛДП230626. Крепёж не виден на фасаде — выбор для премиум-проектов.',
        ],
        [
            'name' => 'Контроль зазоров',
            'text' => 'Соблюдайте температурный зазор 8–10 мм между панелями. Это компенсирует тепловое расширение фиброцемента при диапазоне эксплуатации −60 … +80 °C.',
        ],
    ],
];
include __DIR__ . '/schema_howto.php';
?>

<?php
$page_content = ob_get_clean();
include "../blocks/template.php";
