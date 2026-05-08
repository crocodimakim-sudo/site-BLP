<?php
if (session_status() === PHP_SESSION_NONE) {
    // 2026-04-24: cookie security — httponly, secure, samesite strict, strict mode
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', 1);
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    // 2026-04-24: session_regenerate_id — защита от session fixation
    session_regenerate_id(true);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2026-04-20: GA4, OG/Twitter meta, canonical support added
$page_title    = isset($page_title)    ? $page_title    : 'BLP Board';
$page_desc     = isset($page_desc)     ? $page_desc     : '';
$page_og_image = isset($page_og_image) ? $page_og_image : 'https://building-port.ru/images-convert/og-default.jpg';
$page_og_type  = isset($page_og_type)  ? $page_og_type  : 'website';
$page_canonical = isset($page_canonical) ? $page_canonical : '';
// 2026-04-24: SEO — noindex support for error pages and non-indexed content
$page_robots   = isset($page_robots)   ? $page_robots   : '';

// 2026-04-27: читаем pages.json для управления видимостью страниц через админ-панель
$_pages_config_file = __DIR__ . '/../database/pages.json';
$_pg = null;
if (file_exists($_pages_config_file)) {
    $_pages_data = json_decode(file_get_contents($_pages_config_file), true);
    if (!empty($_pages_data['pages'])) {
        $_current_slug = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        $_current_slug = str_replace('blp/', '', $_current_slug);
        $_current_slug = explode('/', $_current_slug)[0] ?: 'index';
        foreach ($_pages_data['pages'] as $_p) {
            if (($_p['slug'] ?? '') === $_current_slug) {
                $_pg = $_p;
                if (empty($_p['is_live']) && $page_robots === '') {
                    $page_robots = 'noindex, nofollow';
                }
                break;
            }
        }
    }
}

// 2026-04-30: если страница скрыта (is_live=false) и это не страница ошибки — показать 404
if ($_pg && empty($_pg['is_live']) && !isset($error_code)) {
    http_response_code(404);
    require __DIR__ . '/../pages_php/404.php';
    exit;
}

$site_name     = 'BLP Board';
$site_url      = 'https://building-port.ru';

// 2026-05-01: счётчики загружаются из админки (database/site_config.json)
$_site_cfg = [];
$_site_cfg_file = __DIR__ . '/../database/site_config.json';
if (file_exists($_site_cfg_file)) {
    $_site_cfg = json_decode(file_get_contents($_site_cfg_file), true) ?: [];
}
$ga4_id           = !empty($_site_cfg['ga4_id'])           ? $_site_cfg['ga4_id']           : '';
$yandex_metrika_id = !empty($_site_cfg['yandex_metrika_id']) ? $_site_cfg['yandex_metrika_id'] : '';
// 2026-05-07: VK Pixel удалён (R-001/R-013). Если понадобится — раскомментировать эту строку и добавить блок с consent gate.
// $vk_pixel_id = !empty($_site_cfg['vk_pixel_id']) ? $_site_cfg['vk_pixel_id'] : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <script>(function(){function s(){document.documentElement.style.setProperty('--vh',window.innerHeight*.01+'px');}window.addEventListener('resize',s);s();})();</script>
    <link rel="icon" type="image/svg+xml" href="/images-convert/favicon.svg">
    <meta name="yandex-verification" content="5c0035a8d8486cab" />
    <!-- 2026-05-07: возрастная маркировка по 436-ФЗ (R-012) — контент общего назначения, без ограничений -->
    <meta name="rating" content="general">
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <?php if ($page_desc): ?>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <?php if ($page_robots): ?>
    <meta name="robots" content="<?php echo htmlspecialchars($page_robots, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <?php if ($page_canonical): ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($page_canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type" content="<?php echo htmlspecialchars($page_og_type, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>">
    <?php if ($page_desc): ?>
    <meta property="og:description" content="<?php echo htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($page_og_image, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php if ($page_canonical): ?>
    <meta property="og:url" content="<?php echo htmlspecialchars($page_canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>">
    <?php if ($page_desc): ?>
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <meta name="twitter:image" content="<?php echo htmlspecialchars($page_og_image, ENT_QUOTES, 'UTF-8'); ?>">

    <?php if ($yandex_metrika_id): ?>
    <!-- 2026-05-07: Yandex.Metrika с consent gate — грузится ТОЛЬКО после accept в cookie-баннере -->
    <script type="text/javascript">
       (function(){
         function getConsent(){try{return JSON.parse(localStorage.getItem('blp_cookie_consent'));}catch(e){return null;}}
         function loadMetrika(){
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
            ym(<?php echo json_encode($yandex_metrika_id); ?>, "init", {
                 clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true
            });
         }
         var c = getConsent();
         if (c && c.accepted === true) { loadMetrika(); }
         else { window.addEventListener('blp:cookie-consent-accepted', loadMetrika, {once:true}); }
       })();
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo htmlspecialchars($yandex_metrika_id, ENT_QUOTES, 'UTF-8'); ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <?php endif; ?>

    <?php /* 2026-05-07: VK Pixel удалён — не используется. Если понадобится — добавить с consent gate как у Метрики выше. */ ?>

    <!-- 2026-04-24: LCP preload — должен быть ДО всех stylesheet, как можно раньше в head -->
    <?php if (!empty($extra_preload)) echo $extra_preload; ?>

    <!-- 2026-05-04: preconnect к аналитике — экономит DNS+TLS handshake -->
    <!-- 2026-05-07: убран preconnect к flaticon (R-015) — иконки больше не используются -->
    <link rel="preconnect" href="https://mc.yandex.ru" crossorigin>

    <!-- 2026-04-20: Google Fonts optimized — removed weight 300 (unused), added font-display=swap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"></noscript>

    <!-- 2026-04-20: Critical CSS — sync (above-fold) -->
    <!-- 2026-04-27: ?v= версионирование — сбрасывает кэш браузера при обновлении CSS -->
    <?php $cv = '20260427b'; ?>
    <link rel="stylesheet" href="/css/main.css?v=<?php echo $cv; ?>">
    <link rel="stylesheet" href="/css/header.css?v=<?php echo $cv; ?>">
    <link rel="stylesheet" href="/css/hero-section.css?v=<?php echo $cv; ?>">

    <!-- 2026-04-20: Non-critical CSS — deferred (below-fold) -->
    <link rel="preload" as="style" href="/css/animations.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/footer.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/products-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/audience-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/benefits.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/partners-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/objects-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/contact-form.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/css/specs-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/css/animations.css">
        <link rel="stylesheet" href="/css/footer.css">
        <link rel="stylesheet" href="/css/products-section.css">
        <link rel="stylesheet" href="/css/audience-section.css">
        <link rel="stylesheet" href="/css/benefits.css">
        <link rel="stylesheet" href="/css/partners-section.css">
        <link rel="stylesheet" href="/css/objects-section.css">
        <link rel="stylesheet" href="/css/contact-form.css">
        <link rel="stylesheet" href="/css/specs-section.css">
    </noscript>

    <!-- Page-specific -->
    <?php if (isset($extra_css)) echo $extra_css; ?>

    <!-- 2026-04-23: skip-to-content — WCAG 2.4.1, keyboard navigation -->
    <style>
    .skip-to-content{position:absolute;top:-100%;left:1rem;z-index:99999;padding:10px 20px;background:#00352F;color:#fff;font-family:'Montserrat',sans-serif;font-size:14px;font-weight:600;border-radius:0 0 8px 8px;text-decoration:none;transition:top .15s ease;}
    .skip-to-content:focus{top:0;outline:3px solid #fff;outline-offset:2px;}
    </style>

    <?php
    // 2026-04-22: Schema.org markup for SEO
    $schema_dir = __DIR__ . '/../pages_php/';
    include $schema_dir . 'schema_organization.php';
    include $schema_dir . 'schema_webpage.php';
    if (isset($breadcrumbs)) include $schema_dir . 'schema_breadcrumbs.php';
    ?>
</head>
<body>
    <a href="#main-content" class="skip-to-content">Перейти к содержимому</a>

    <!-- 2026-04-22: Cookie consent banner -->
    <?php include 'cookie-consent-banner.php'; ?>

    <?php include 'header.php'; ?>
    <div class="header-spacer"></div>
    <?php include 'breadcrumbs.php'; ?>

    <main id="main-content">
        <?php if (isset($page_content)) echo $page_content; ?>
    </main>

    <?php include 'footer.php'; ?>
    <script src="/js/header.js" defer></script>
    <script src="/js/analytics.js" defer></script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
