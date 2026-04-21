<?php
// 2026-04-20: GA4, OG/Twitter meta, canonical support added
$page_title    = isset($page_title)    ? $page_title    : 'BLP Board';
$page_desc     = isset($page_desc)     ? $page_desc     : '';
$page_og_image = isset($page_og_image) ? $page_og_image : 'https://building-port.ru/blp/images/og-default.jpg';
$page_og_type  = isset($page_og_type)  ? $page_og_type  : 'website';
$page_canonical = isset($page_canonical) ? $page_canonical : '';
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
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <?php if ($page_desc): ?>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'); ?>">
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

    <!-- 2026-04-20: Google Fonts optimized — removed weight 300 (unused), added font-display=swap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"></noscript>

    <!-- 2026-04-20: Critical CSS — sync (above-fold) -->
    <link rel="stylesheet" href="/blp/css/main.css">
    <link rel="stylesheet" href="/blp/css/header.css">
    <link rel="stylesheet" href="/blp/css/hero-section.css">

    <!-- 2026-04-20: Non-critical CSS — deferred (below-fold) -->
    <link rel="preload" as="style" href="/blp/css/animations.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/footer.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/products-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/audience-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/benefits.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/partners-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/objects-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/contact-form.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="/blp/css/specs-section.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/blp/css/animations.css">
        <link rel="stylesheet" href="/blp/css/footer.css">
        <link rel="stylesheet" href="/blp/css/products-section.css">
        <link rel="stylesheet" href="/blp/css/audience-section.css">
        <link rel="stylesheet" href="/blp/css/benefits.css">
        <link rel="stylesheet" href="/blp/css/partners-section.css">
        <link rel="stylesheet" href="/blp/css/objects-section.css">
        <link rel="stylesheet" href="/blp/css/contact-form.css">
        <link rel="stylesheet" href="/blp/css/specs-section.css">
    </noscript>

    <!-- Page-specific -->
    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="header-spacer"></div>

    <main>
        <?php if (isset($page_content)) echo $page_content; ?>
    </main>

    <?php include 'footer.php'; ?>
    <script src="/blp/js/header.js" defer></script>
    <script src="/blp/js/analytics.js" defer></script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
