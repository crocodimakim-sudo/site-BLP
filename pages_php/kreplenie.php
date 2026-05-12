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
    <h2 class="blp-mounting-title">Варианты крепления панелей&nbsp;к подсистеме</h2>
    <div class="blp-mounting-divider"></div>

    <!-- Видимый способ -->
    <div class="blp-method-section">
        <h2 class="blp-method-header">Видимый</h2>
        <div class="blp-method-content">
            <div class="blp-method-images">
                <div class="blp-img-large">
                    <?php echo render_image('/images-convert/pages/kreplenie/vidimoe/mount_visible_facade.png', 'Фасад с видимыми заклёпками'); ?>
                </div>
                <div class="blp-img-small">
                    <?php echo render_image('/images-convert/pages/kreplenie/vidimoe/mount_visible_rivets.png', 'Заклёпки'); ?>
                </div>
            </div>
            <div class="blp-method-info">
                <p class="blp-method-description">Заклёпки, выкрашенные&nbsp;в тон панели, становятся деталью дизайна.</p>
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
                <p class="blp-method-description">Невидимый крепёж - сохраняет чистоту фасадной поверхности. Ничего лишнего, только идеальные линии.</p>
                <div class="blp-hardware-grid">
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">Кляммер «КРАБ»</p>
                        <div class="blp-hardware-images">
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_krab_1.png', 'Кляммер КРАБ'); ?>
                            </div>
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_krab_2.png', 'Кляммер КРАБ вид 2'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">KEIL</p>
                        <div class="blp-hardware-images">
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_keil_1.png', 'KEIL крепёж'); ?>
                            </div>
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_keil_2.png', 'KEIL крепёж вид 2'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="blp-hardware-item">
                        <p class="blp-hardware-title">Аграфы NORDFox</p>
                        <div class="blp-hardware-images">
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_nordfox_1.png', 'Аграфы NORDFox схема'); ?>
                            </div>
                            <div class="blp-hardware-img">
                                <?php echo render_image('/images-convert/pages/kreplenie/skritoe/mount_nordfox_2.png', 'Аграфы NORDFox'); ?>
                            </div>
                        </div>
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
    'supply'      => [
        ['name' => 'Заклёпки вытяжные (для видимого крепления)'],
        ['name' => 'Кляммеры скрытого крепления (KRAB, KEIL, Nordfox)'],
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
            'name' => 'Скрытое крепление кляммерами',
            'text' => 'Закрепите кляммеры (KRAB, KEIL, Nordfox) к направляющим. Заведите панель в кляммер сверху и зафиксируйте. Крепёж не виден на фасаде — выбор для премиум-проектов.',
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
