<?php
// 2026-04-23: правильная 404-страница — возвращает HTTP 404, не 200 (fix soft 404)
$page_title    = '404 — Страница не найдена | BLP Board';
$page_desc     = 'Запрошенная страница не найдена. Вернитесь на главную или перейдите в каталог.';
$page_canonical = '';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

http_response_code(404);

ob_start();
?>
<section style="min-height:60vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;">
    <div style="text-align:center;max-width:480px;">
        <div style="font-size:80px;font-weight:800;color:#00352F;line-height:1;margin-bottom:16px;">404</div>
        <h1 style="font-size:24px;font-weight:700;margin:0 0 12px;color:#1a1a1a;">Страница не найдена</h1>
        <p style="color:#5a5a5a;margin:0 0 32px;line-height:1.6;">Возможно, страница была удалена или адрес введён неверно.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="/blp/" style="background:#00352F;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:600;font-size:15px;">На главную</a>
            <a href="/blp/catalog" style="background:#f8f9fa;color:#1a1a1a;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:600;font-size:15px;border:1px solid #e5e7eb;">Каталог</a>
            <a href="/blp/contacts" style="background:#f8f9fa;color:#1a1a1a;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:600;font-size:15px;border:1px solid #e5e7eb;">Контакты</a>
        </div>
    </div>
</section>
<?php
$page_content = ob_get_clean();
include 'template.php';
