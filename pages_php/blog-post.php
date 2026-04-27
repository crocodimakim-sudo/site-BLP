<?php
// 2026-04-24: страница отдельной статьи блога
$slug = isset($_GET['slug']) ? preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug'])) : '';

$dbFile = dirname(__DIR__) . '/database/blog.db';

if ($slug === '' || !is_file($dbFile)) {
    $error_code = 404;
    require __DIR__ . '/error.php';
    return;
}

try {
    $pdo = new PDO('sqlite:' . $dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ? AND is_published = 1 LIMIT 1");
    $stmt->execute([$slug]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $article = null;
}

if (!$article) {
    $error_code = 404;
    require __DIR__ . '/error.php';
    return;
}

// 2026-04-24: инкремент просмотров (не блокируем страницу при ошибке)
try {
    $pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = ?")->execute([$article['id']]);
    $article['views'] = ((int)$article['views']) + 1;
} catch (Exception $e) {}

// 2026-04-24: 3 related из той же категории, исключая текущую
$related = [];
try {
    $rs = $pdo->prepare("SELECT * FROM articles WHERE category = ? AND id != ? AND is_published = 1 ORDER BY published_at DESC LIMIT 3");
    $rs->execute([$article['category'], $article['id']]);
    $related = $rs->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// 2026-04-24: fallback — если в категории <3 статей, добрать последними из других категорий
if (count($related) < 3) {
    try {
        $excludeIds = array_map(fn($r) => (int)$r['id'], $related);
        $excludeIds[] = (int)$article['id'];
        $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
        $need = 3 - count($related);
        $rs = $pdo->prepare("SELECT * FROM articles WHERE id NOT IN ($placeholders) AND is_published = 1 ORDER BY published_at DESC LIMIT " . (int)$need);
        $rs->execute($excludeIds);
        $related = array_merge($related, $rs->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {}
}

$page_title    = $article['title'] . ' — Блог BLP Board';
$page_desc     = $article['subtitle'] ?? '';
$page_canonical = 'https://building-port.ru/blp/blog/' . $article['slug'];
$page_og_image  = 'https://building-port.ru' . ($article['image'] ?? '/blp/images/og-default.jpg');
$page_og_type   = 'article';
$extra_css     = '<link rel="stylesheet" href="/blp/css/pages/blog.css">';

$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Блог',    'url' => 'https://building-port.ru/blp/blog'],
    ['name' => $article['title'], 'url' => $page_canonical],
];

// 2026-04-24: форматирование русской даты
if (!function_exists('blog_format_date')) {
    function blog_format_date(string $dt): string {
        $months = [
            '01' => 'января', '02' => 'февраля', '03' => 'марта',    '04' => 'апреля',
            '05' => 'мая',    '06' => 'июня',    '07' => 'июля',     '08' => 'августа',
            '09' => 'сентября','10' => 'октября','11' => 'ноября',   '12' => 'декабря',
        ];
        $ts = strtotime($dt);
        if ($ts === false) return '';
        return date('j', $ts) . ' ' . ($months[date('m', $ts)] ?? '') . ' ' . date('Y', $ts);
    }
}

// 2026-04-24: BlogPosting schema — построить до ob_start()
$_image_url = !empty($article['image'])
    ? (strpos($article['image'], 'http') === 0 ? $article['image'] : 'https://building-port.ru' . $article['image'])
    : 'https://building-port.ru/blp/images/og-default.jpg';

$_datePublished = !empty($article['published_at']) ? date('c', strtotime($article['published_at'])) : '';
$_dateModified  = !empty($article['updated_at'])   ? date('c', strtotime($article['updated_at']))   : $_datePublished;

$_blogposting_schema = [
    '@context'       => 'https://schema.org',
    '@type'          => 'BlogPosting',
    '@id'            => $page_canonical . '#blogposting',
    'headline'       => $article['title'],
    'url'            => $page_canonical,
    'description'    => $article['subtitle'] ?? '',
    'image'          => [
        '@type'  => 'ImageObject',
        'url'    => $_image_url,
        'width'  => 1200,
        'height' => 630,
    ],
    'datePublished'  => $_datePublished,
    'dateModified'   => $_dateModified,
    'author'         => [
        '@type' => 'Organization',
        '@id'   => 'https://building-port.ru/blp/#organization',
        'name'  => 'BLP Board',
    ],
    'publisher'      => ['@id' => 'https://building-port.ru/blp/#organization'],
    'inLanguage'     => 'ru-RU',
    'isPartOf'       => ['@id' => 'https://building-port.ru/blp/blog#blog'],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id'   => $page_canonical . '#webpage',
    ],
];

if (!empty($article['read_time'])) {
    // ISO 8601 duration: PTxM
    $_blogposting_schema['timeRequired'] = 'PT' . (int)$article['read_time'] . 'M';
}

ob_start();
?>
<article class="blog-post">
    <div class="blog-post-container">
        <div class="blog-post-meta">
            <a href="/blp/blog?cat=<?php echo urlencode($article['category']); ?>" class="blog-tag">
                <?php echo htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <span><?php echo htmlspecialchars(blog_format_date($article['published_at']), ENT_QUOTES, 'UTF-8'); ?></span>
            <span><?php echo (int)$article['read_time']; ?> мин чтения</span>
            <span>&#128065; <?php echo (int)$article['views']; ?></span>
        </div>
        <h1><?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php if (!empty($article['subtitle'])): ?>
        <p class="blog-post-subtitle"><?php echo htmlspecialchars($article['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <div class="blog-post-content" id="blogPostContent">
            <?php echo $article['content']; // 2026-04-24: сырой HTML из БД — контент админом ?>
        </div>
        <script>
        // 2026-04-27: авто-обёртка таблиц для горизонтального скролла на мобиле
        document.querySelectorAll('#blogPostContent table').forEach(function(t) {
            var w = document.createElement('div');
            w.className = 'blog-table-wrap';
            t.parentNode.insertBefore(w, t);
            w.appendChild(t);
        });
        </script>
        <div class="blog-post-tags">
            Теги:
            <a href="/blp/blog?cat=<?php echo urlencode($article['category']); ?>">
                <?php echo htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </div>
    </div>
</article>

<?php if (!empty($related)): ?>
<section class="blog-related">
    <div class="blog-related-inner">
        <h2>Читайте также</h2>
        <div class="blog-related-grid">
            <?php foreach ($related as $a): ?>
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
    </div>
</section>
<?php endif; ?>

<?php // 2026-04-24: BlogPosting JSON-LD schema ?>
<script type="application/ld+json">
<?php echo json_encode($_blogposting_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>

<?php
$page_content = ob_get_clean();
include __DIR__ . '/template.php';
