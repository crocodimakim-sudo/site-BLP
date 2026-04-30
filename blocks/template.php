<?php
if (session_status() === PHP_SESSION_NONE) {
    // 2026-04-24: cookie security — httponly, samesite strict, strict mode
    ini_set('session.cookie_httponly', 1);
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
// 2026-04-20: placeholder ID — заменить на реальный GA4 Measurement ID перед go-live
$ga4_id        = 'G-PLACEHOLDER20260420';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images-convert/favicon.ico">
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

    <!-- GA4: Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($ga4_id, ENT_QUOTES, 'UTF-8'); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo htmlspecialchars($ga4_id, ENT_QUOTES, 'UTF-8'); ?>', {
        page_title: <?php echo json_encode($page_title); ?>,
        page_location: window.location.href
      });
    </script>

    <!-- 2026-04-24: LCP preload — должен быть ДО всех stylesheet, как можно раньше в head -->
    <?php if (!empty($extra_preload)) echo $extra_preload; ?>

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
