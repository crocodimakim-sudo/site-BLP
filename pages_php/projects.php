<?php
// 2026-04-24: SEO — fixed branding typo (BLPboard→BLP Board), added og_image
$page_title = 'Объекты с фасадом из фиброцементных панелей BLP Board — портфолио';
// 2026-05-04: description расширен с 133 до 160 симв., добавлен E-E-A-T сигнал и точка (Phase 3)
$page_desc  = 'Портфолио реализованных объектов BLP Board: поликлиники, школы, здания судов, международные проекты. Фиброцементные фасадные панели в реальных условиях эксплуатации.';
$page_og_image  = 'https://building-port.ru/images-convert/pages/index/index_hero.jpg';
// 2026-04-20: canonical URL added (Task #14 — critical SEO fix)
$page_canonical = 'https://building-port.ru/projects';
$extra_css  = '<link rel="stylesheet" href="/css/pages/projects.css">';
$extra_js   = '<script src="/js/pages/projects.js" defer></script>';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/'],
    ['name' => 'Объекты', 'url' => 'https://building-port.ru/projects'],
];

require_once __DIR__ . '/../blocks/session_init.php';
ob_start();
?>

<section class="projects-modern">
    <div class="section-header">
        <h1 class="section-title">Объекты&nbsp;с фасадом&nbsp;из фиброцементных панелей BLPboard</h1>
    </div>

    <div class="projects-grid" id="projectsGrid"><?php
        // 2026-09-05: SSR-фолбэк — те же карточки, что рисует js/pages/projects.js; JS очищает сетку и перерисовывает
        ob_start(); include __DIR__ . '/../blocks/get_projects.php'; $_ssr = json_decode(ob_get_clean(), true) ?: [];
        foreach ($_ssr as $_i => $_p):
            $_imgs = $_p['images'] ?? []; $_first = $_imgs[0] ?? '';
            $_sm = preg_replace('/\.(jpg|jpeg|png)$/i', '-sm.webp', $_first); ?>
        <div class="project-card" onclick="openModal(<?= (int)$_i ?>)">
            <div class="mini-slider<?= $_first ? '' : ' mini-slider--empty' ?>" id="miniSlider-<?= (int)$_i ?>">
                <?php if ($_first): ?><div class="mini-slide active" data-index="0"><picture><source type="image/webp" srcset="<?= htmlspecialchars($_sm) ?>" sizes="(max-width: 480px) calc(100vw - 32px), (max-width: 900px) calc(50vw - 24px), 380px"><img src="<?= htmlspecialchars($_first) ?>" alt="<?= htmlspecialchars($_p['name'] . ' - фото 1') ?>" loading="<?= $_i < 2 ? 'eager' : 'lazy' ?>"></picture></div><?php endif; ?>
                <span class="project-tag"><?= htmlspecialchars($_p['tag'] ?? '') ?></span>
                <?php if (!empty($_p['category'])): ?><span class="project-category"><?= htmlspecialchars($_p['category']) ?></span><?php endif; ?>
                <?php if ($_first): ?><span class="slide-counter">1 / <?= count($_imgs) ?></span><?php endif; ?>
            </div>
            <div class="project-info"><h3 class="project-name"><?= htmlspecialchars($_p['name'] ?? '') ?></h3><div class="project-location"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><?= htmlspecialchars($_p['location'] ?? '') ?></div></div>
        </div>
        <?php endforeach; ?></div>
</section>

<div class="modal-overlay" id="projectModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        <div class="fullscreen-slider" id="modalSlider"></div>

        <button class="modal-nav prev" onclick="changeModalSlide(-1)">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
        <button class="modal-nav next" onclick="changeModalSlide(1)">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </button>

        <div class="modal-info" id="modalInfo">
            <div class="modal-title" id="modalTitle"></div>
            <div class="modal-location" id="modalLocation">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span id="modalLocationText"></span>
            </div>
        </div>

        <div class="modal-thumbs" id="modalThumbs"></div>
    </div>
</div>

<!-- ========================================
     BLOCK PREIMUSHHESTVA (shared)
     ======================================== -->
<?php include '../blocks/benefits.php'; ?>

<!-- ========================================
     CONTACT FORM
     ======================================== -->
<?php
$form_title = 'Узнать подробнее об объектах';
$form_desc  = 'Оставьте заявку — мы расскажем о реализованных проектах и подберём решение для вашего объекта';
include '../blocks/contact-form.php';
?>

<?php
$page_content = ob_get_clean();
include 'template.php';
