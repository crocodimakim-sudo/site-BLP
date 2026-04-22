<?php
// 2026-04-22: Image rendering helper with WebP, lazy-loading, srcset
function render_image($path, $alt = '', $options = []) {
    $lazy          = $options['lazy']          ?? true;
    $sizes         = $options['sizes']         ?? '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 100vw';
    $width         = $options['width']         ?? null;
    $height        = $options['height']        ?? null;
    $class         = $options['class']         ?? '';
    $fetchpriority = $options['fetchpriority'] ?? 'auto';

    $basename = pathinfo($path, PATHINFO_FILENAME);
    $dir      = rtrim(dirname($path), '/');
    $webp_url = $dir . '/' . $basename . '.webp';

    $loading_attr = $lazy ? 'loading="lazy"' : '';

    $html = '<picture>';

    // 2026-04-22: WebP source if file exists on disk
    $webp_disk = $_SERVER['DOCUMENT_ROOT'] . $webp_url;
    if (file_exists($webp_disk)) {
        $html .= '<source type="image/webp" srcset="' . htmlspecialchars($webp_url) . '" sizes="' . htmlspecialchars($sizes) . '">';
    }

    // 2026-04-22: Original format fallback (JPEG/PNG)
    $html .= '<img ';
    if ($width)  $html .= 'width="'  . htmlspecialchars($width)  . '" ';
    if ($height) $html .= 'height="' . htmlspecialchars($height) . '" ';
    $html .= 'src="'  . htmlspecialchars($path) . '" ';
    $html .= 'sizes="' . htmlspecialchars($sizes) . '" ';
    $html .= 'alt="'  . htmlspecialchars($alt)  . '" ';
    if ($class) $html .= 'class="' . htmlspecialchars($class) . '" ';
    if ($loading_attr) $html .= $loading_attr . ' ';
    $html .= 'fetchpriority="' . htmlspecialchars($fetchpriority) . '">';

    $html .= '</picture>';

    return $html;
}
?>
