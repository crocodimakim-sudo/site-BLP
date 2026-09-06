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
    // 2026-09-06: responsive srcset — к полноразмерному webp добавляется -sm.webp (800px),
    // который уже генерирует scripts/convert_images.php. Мобильные грузят ~2x меньше (hero 91 КБ -> 39 КБ).
    // Вид страницы не меняется: браузер выбирает файл по ширине контейнера из того же sizes.
    $webp_disk = $_SERVER['DOCUMENT_ROOT'] . $webp_url;
    if (file_exists($webp_disk)) {
        $srcset_parts = [];
        $sm_url  = $dir . '/' . $basename . '-sm.webp';
        $sm_disk = $_SERVER['DOCUMENT_ROOT'] . $sm_url;
        if (file_exists($sm_disk)) {
            $sm_size = @getimagesize($sm_disk);
            if ($sm_size && $sm_size[0] > 0) $srcset_parts[] = $sm_url . ' ' . (int)$sm_size[0] . 'w';
        }
        $full_size = @getimagesize($webp_disk);
        if ($srcset_parts && $full_size && $full_size[0] > 0) {
            $srcset_parts[] = $webp_url . ' ' . (int)$full_size[0] . 'w';
            $srcset_value = implode(', ', $srcset_parts);
        } else {
            $srcset_value = $webp_url;
        }
        $html .= '<source type="image/webp" srcset="' . htmlspecialchars($srcset_value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" sizes="' . htmlspecialchars($sizes, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">';
    }

    // 2026-04-22: Original format fallback (JPEG/PNG)
    $html .= '<img ';
    if ($width)  $html .= 'width="'  . htmlspecialchars($width,  ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    if ($height) $html .= 'height="' . htmlspecialchars($height, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    $html .= 'src="'  . htmlspecialchars($path,         ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    $html .= 'sizes="' . htmlspecialchars($sizes,       ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    $html .= 'alt="'  . htmlspecialchars($alt,          ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    if ($class) $html .= 'class="' . htmlspecialchars($class, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" ';
    if ($loading_attr) $html .= $loading_attr . ' ';
    $html .= 'fetchpriority="' . htmlspecialchars($fetchpriority, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">';

    $html .= '</picture>';

    return $html;
}
?>
