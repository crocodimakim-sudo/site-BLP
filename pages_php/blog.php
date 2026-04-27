<?php
// 2026-04-24: страница листинга блога — hero + фильтры + сетка карточек
$page_title    = 'Блог BLP Board — статьи о фиброцементе и вентилируемых фасадах';
$page_desc     = 'Экспертные материалы о монтаже фиброцементных панелей, сравнении материалов, типовых ошибках вентилируемых фасадов и реализованных проектах BLP Board.';
$page_canonical = 'https://building-port.ru/blp/blog';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$extra_css     = '<link rel="stylesheet" href="/blp/css/pages/blog.css">';
// 2026-04-27: блог скрыт до доработки — не индексировать
$page_robots   = 'noindex, nofollow';

$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Блог',    'url' => 'https://building-port.ru/blp/blog'],
];

// 2026-04-24: подключаем БД блога
$dbFile = dirname(__DIR__) . '/database/blog.db';
$dbReady = is_file($dbFile);

$articles   = [];
$categories = [];
$hero       = null;
$currentCat = isset($_GET['cat']) ? trim($_GET['cat']) : '';

if ($dbReady) {
    try {
        $pdo = new PDO('sqlite:' . $dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // 2026-04-24: список всех категорий для фильтров
        $catStmt = $pdo->query("SELECT DISTINCT category FROM articles WHERE is_published = 1 ORDER BY category ASC");
        $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

        if ($currentCat !== '') {
            $stmt = $pdo->prepare("SELECT * FROM articles WHERE is_published = 1 AND category = ? ORDER BY published_at DESC");
            $stmt->execute([$currentCat]);
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM articles WHERE is_published = 1 ORDER BY published_at DESC");
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($articles)) {
                $hero = array_shift($articles);
            }
        }
    } catch (Exception $e) {
        $dbReady = false;
    }
}

// 2026-04-24: форматирование русской даты
function blog_format_date(string $dt): string {
    $months = [
        '01' => 'января', '02' => 'февраля', '03' => 'марта',    '04' => 'апреля',
        '05' => 'мая',    '06' => 'июня',    '07' => 'июля',     '08' => 'августа',
        '09' => 'сентября','10' => 'октября','11' => 'ноября',   '12' => 'декабря',
    ];
    $ts = strtotime($dt);
    if ($ts === false) return '';
    $d = date('j', $ts);
    $m = $months[date('m', $ts)] ?? '';
    $y = date('Y', $ts);
    return $d . ' ' . $m . ' ' . $y;
}

ob_start();
?>

<?php if (!$dbReady): ?>
<section class="blog-main">
    <div style="max-width:720px;margin:80px auto;padding:32px;border:1px solid #e8e8e8;border-radius:12px;background:#fff8f0;">
        <h1 style="font-size:24px;margin:0 0 16px;color:#1a1a1a;">База блога не инициализирована</h1>
        <p style="color:#5a5a5a;line-height:1.6;margin:0 0 12px;">Запустите CLI-команду для создания <code>database/blog.db</code>:</p>
        <pre style="background:#1a1a1a;color:#f4f4f4;padding:16px;border-radius:8px;overflow:auto;">php "D:\Claude Code\site-blp\site-kimi\database\init_blog.php"</pre>
    </div>
</section>
<?php else: ?>

<?php if ($hero): ?>
<section class="blog-hero">
    <div class="blog-hero-inner">
        <div class="blog-hero-content">
            <span class="blog-tag"><?php echo htmlspecialchars($hero['category'], ENT_QUOTES, 'UTF-8'); ?></span>
            <h1><?php echo htmlspecialchars($hero['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p><?php echo htmlspecialchars($hero['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <div class="blog-hero-meta">
                <span><?php echo htmlspecialchars(blog_format_date($hero['published_at']), ENT_QUOTES, 'UTF-8'); ?></span>
                <span>&bull;</span>
                <span><?php echo (int)$hero['read_time']; ?> мин чтения</span>
                <span>&bull;</span>
                <span><?php echo (int)$hero['views']; ?> просмотров</span>
            </div>
            <a href="/blp/blog/<?php echo htmlspecialchars($hero['slug'], ENT_QUOTES, 'UTF-8'); ?>" class="blog-hero-btn">Читать статью &rarr;</a>
        </div>
        <div class="blog-hero-image">
            <img src="<?php echo htmlspecialchars($hero['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                 alt="<?php echo htmlspecialchars($hero['title'], ENT_QUOTES, 'UTF-8'); ?>"
                 onerror="this.style.background='#1a4d47';this.style.minHeight='320px';this.removeAttribute('src');">
        </div>
    </div>
</section>
<?php endif; ?>

<section class="blog-main">
    <div class="blog-filters">
        <a href="/blp/blog" class="blog-filter-btn<?php echo $currentCat === '' ? ' active' : ''; ?>">Все</a>
        <?php foreach ($categories as $cat): ?>
            <a href="/blp/blog?cat=<?php echo urlencode($cat); ?>"
               class="blog-filter-btn<?php echo $currentCat === $cat ? ' active' : ''; ?>">
                <?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($articles) && !$hero): ?>
        <p style="color:#5a5a5a;font-size:16px;padding:40px 0;">
            В категории «<?php echo htmlspecialchars($currentCat, ENT_QUOTES, 'UTF-8'); ?>» пока нет статей.
        </p>
    <?php else: ?>
    <div class="blog-grid">
        <?php foreach ($articles as $a): ?>
        <article class="blog-card">
            <a href="/blp/blog/<?php echo htmlspecialchars($a['slug'], ENT_QUOTES, 'UTF-8'); ?>" class="blog-card-img-wrap">
                <img src="<?php echo htmlspecialchars($a['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($a['title'], ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"
                     onerror="this.style.background='#e8e8e8';this.removeAttribute('src');">
                <span class="blog-tag blog-card-tag"><?php echo htmlspecialchars($a['category'], ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
            <div class="blog-card-body">
                <h2 class="blog-card-title">
                    <a href="/blp/blog/<?php echo htmlspecialchars($a['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($a['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h2>
                <p class="blog-card-excerpt"><?php echo htmlspecialchars($a['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="blog-card-meta">
                    <span><?php echo htmlspecialchars(blog_format_date($a['published_at']), ENT_QUOTES, 'UTF-8'); ?></span>
                    <span><?php echo (int)$a['read_time']; ?> мин</span>
                    <span>&#128065; <?php echo (int)$a['views']; ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<?php // 2026-04-24: Blog schema — только когда БД готова и есть статьи ?>
<?php include __DIR__ . '/schema_blog.php'; ?>

<?php endif; ?>

<?php
$page_content = ob_get_clean();
include __DIR__ . '/template.php';
