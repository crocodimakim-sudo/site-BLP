<?php
$page_title = isset($page_title) ? $page_title : 'BLP Board';
$page_desc  = isset($page_desc)  ? $page_desc  : '';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Base -->
    <link rel="stylesheet" href="/blp/css/main.css">
    <link rel="stylesheet" href="/blp/css/animations.css">
    <!-- Layout -->
    <link rel="stylesheet" href="/blp/css/header.css">
    <link rel="stylesheet" href="/blp/css/footer.css">
    <!-- Shared blocks -->
    <link rel="stylesheet" href="/blp/css/hero-section.css">
    <link rel="stylesheet" href="/blp/css/products-section.css">
    <link rel="stylesheet" href="/blp/css/audience-section.css">
    <link rel="stylesheet" href="/blp/css/benefits.css">
    <link rel="stylesheet" href="/blp/css/partners-section.css">
    <link rel="stylesheet" href="/blp/css/objects-section.css">
    <link rel="stylesheet" href="/blp/css/contact-form.css">
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
    <?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
