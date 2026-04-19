# -*- coding: utf-8 -*-
import os
import re

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

def cleanup_css(content):
    # Remove excessive blank lines (more than 1 consecutive)
    content = re.sub(r'\n{3,}', '\n\n', content)
    # Remove leading/trailing whitespace per line but keep indentation structure
    lines = content.split('\n')
    cleaned = []
    for line in lines:
        stripped = line.strip()
        if stripped:
            cleaned.append(stripped)
        elif cleaned and cleaned[-1] != '':
            cleaned.append('')
    # Remove trailing blank lines
    while cleaned and cleaned[-1] == '':
        cleaned.pop()
    return '\n'.join(cleaned)

def dedup_keyframes(content):
    # Find all @keyframes definitions
    keyframes = list(re.finditer(r'@keyframes\s+(\w+)\s*\{[^}]+\}', content))
    seen = set()
    to_remove = []
    for m in keyframes:
        name = m.group(1)
        if name in seen:
            to_remove.append((m.start(), m.end()))
        else:
            seen.add(name)
    # Remove duplicates from end to start
    for start, end in reversed(to_remove):
        # Also remove preceding blank lines/comments if any
        before = content[:start]
        after = content[end:]
        content = before.rstrip() + '\n\n' + after.lstrip()
    return content

def main():
    css_path = os.path.join(BASE_DIR, 'css', 'pages', 'devops.css')
    with open(css_path, 'r', encoding='utf-8') as f:
        css = f.read()

    css = cleanup_css(css)
    css = dedup_keyframes(css)

    with open(css_path, 'w', encoding='utf-8') as f:
        f.write(css)

    print('Cleaned CSS: %d lines' % len(css.split('\n')))
    print('Saved to: %s' % css_path)

if __name__ == '__main__':
    main()
