# -*- coding: utf-8 -*-
import os
import re

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

def main():
    # Read HTML source
    html_path = os.path.join(BASE_DIR, 'html', 'devops_fixed_final.html')
    with open(html_path, 'r', encoding='utf-8') as f:
        html = f.read()

    # Extract all style blocks
    styles = []
    for m in re.finditer(r'<style[^>]*>(.*?)</style>', html, re.DOTALL):
        styles.append(m.group(1).strip())

    print('Found %d style blocks' % len(styles))

    # Extract body contents
    body_starts = [m.end() for m in re.finditer(r'<body[^>]*>', html)]
    body_ends = [m.start() for m in re.finditer(r'</body>', html)]

    contents = []
    for start, end in zip(body_starts, body_ends):
        content = html[start:end].strip()
        # Remove header-spacer div
        content = re.sub(r'<div[^>]*style=["\'][^"\']*height:\s*80px[^"\']*["\'][^>]*>.*?</div>', '', content, flags=re.DOTALL)
        content = content.strip()
        if content:
            contents.append(content)

    full_content = '\n\n'.join(contents)
    # Remove excessive blank lines
    full_content = re.sub(r'\n{4,}', '\n\n', full_content)

    print('Content length: %d chars' % len(full_content))

    # Combine CSS (skip font import since template already has it)
    css_parts = []
    for s in styles:
        # Remove @import for fonts (already in template)
        s_clean = re.sub(r"@import\s+url\('https://fonts\.googleapis\.com[^']+'\);?\s*", '', s)
        # Remove :root, *, body resets (already in main.css)
        s_clean = re.sub(r':root\s*\{[^}]+\}\s*', '', s_clean, flags=re.DOTALL)
        s_clean = re.sub(r'\*\s*\{[^}]+\}\s*', '', s_clean, flags=re.DOTALL)
        s_clean = re.sub(r'body\s*\{[^}]+\}\s*', '', s_clean, flags=re.DOTALL)
        s_clean = s_clean.strip()
        if s_clean:
            css_parts.append(s_clean)

    css = '\n\n'.join(css_parts)
    css = re.sub(r'\n{4,}', '\n\n', css)

    print('CSS length: %d chars' % len(css))

    # Check for scripts
    scripts = re.findall(r'<script[^>]*>(.*?)</script>', html, re.DOTALL)
    has_js = len(scripts) > 0
    print('Found %d script blocks' % len(scripts))

    # Write CSS
    css_dir = os.path.join(BASE_DIR, 'css', 'pages')
    os.makedirs(css_dir, exist_ok=True)
    css_path = os.path.join(css_dir, 'devops.css')
    with open(css_path, 'w', encoding='utf-8') as f:
        f.write(css)
    print('Wrote CSS: %s' % css_path)

    # Write JS if any
    js_path = None
    if has_js:
        js_dir = os.path.join(BASE_DIR, 'js', 'pages')
        os.makedirs(js_dir, exist_ok=True)
        js_path = os.path.join(js_dir, 'devops.js')
        with open(js_path, 'w', encoding='utf-8') as f:
            f.write('\n\n'.join(scripts))
        print('Wrote JS: %s' % js_path)

    # Build PHP
    page_title = 'Фиброцементные панели для застройщиков — BLP Board'
    page_desc = 'Фасадные решения для застройщиков: фиброцементные панели BLP Board. Совместимость с подсистемами, юридическая чистота, поставки точно в срок.'
    extra_css = '<link rel="stylesheet" href="css/pages/devops.css">'
    extra_js = '<script src="js/pages/devops.js" defer></script>' if has_js else ''

    php_lines = [
        '<?php',
        "$page_title = '%s';" % page_title.replace("'", "\\'"),
        "$page_desc  = '%s';" % page_desc.replace("'", "\\'"),
        "$extra_css = '%s';" % extra_css,
    ]
    if extra_js:
        php_lines.append("$extra_js = '%s';" % extra_js)
    php_lines.extend([
        '',
        'ob_start();',
        '?>',
        full_content,
        '<?php',
        '$page_content = ob_get_clean();',
        "include 'template.php';",
    ])

    php = '\n'.join(php_lines)

    # Write PHP
    php_path = os.path.join(BASE_DIR, 'pages_php', 'devops.php')
    with open(php_path, 'w', encoding='utf-8') as f:
        f.write(php)
    print('Wrote PHP: %s' % php_path)

    # Build preview HTML
    # Read header and footer
    header_path = os.path.join(BASE_DIR, 'pages_php', 'header.php')
    footer_path = os.path.join(BASE_DIR, 'pages_php', 'footer.php')

    header_html = ''
    footer_html = ''

    if os.path.exists(header_path):
        with open(header_path, 'r', encoding='utf-8') as f:
            header_html = f.read()
    if os.path.exists(footer_path):
        with open(footer_path, 'r', encoding='utf-8') as f:
            footer_html = f.read()

    # Simple PHP echo replacement for preview
    preview_content = full_content

    preview_html = '''<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>%s</title>
    <meta name="description" content="%s">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/hero-section.css">
    <link rel="stylesheet" href="css/products-section.css">
    <link rel="stylesheet" href="css/audience-section.css">
    <link rel="stylesheet" href="css/benefits.css">
    <link rel="stylesheet" href="css/partners-section.css">
    <link rel="stylesheet" href="css/objects-section.css">
    <link rel="stylesheet" href="css/contact-form.css">
    <link rel="stylesheet" href="css/pages/devops.css">
</head>
<body>
%s
<div class="header-spacer"></div>
<main>
%s
</main>
%s
<script src="js/header.js" defer></script>
</body>
</html>''' % (page_title, page_desc, header_html, preview_content, footer_html)

    preview_path = os.path.join(BASE_DIR, '_preview_devops.html')
    with open(preview_path, 'w', encoding='utf-8') as f:
        f.write(preview_html)
    print('Wrote preview: %s' % preview_path)

    # Verify UTF-8
    for path in [css_path, php_path, preview_path]:
        with open(path, 'rb') as f:
            data = f.read()
        try:
            data.decode('utf-8')
            print('UTF-8 OK: %s' % os.path.basename(path))
        except UnicodeDecodeError as e:
            print('UTF-8 FAIL: %s - %s' % (path, e))

    print('Done!')

if __name__ == '__main__':
    main()
