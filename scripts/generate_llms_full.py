# 2026-09-07: сборка /llms-full.txt — полные тексты страниц одним файлом для AI-ассистентов.
# llms.txt даёт карту сайта и факты, llms-full.txt — сам текст, чтобы модель цитировала нас, а не пересказ.
# Запуск: cd "D:\Claude Code\01-sites-buildingport\01-site-blpboard" && python scripts/generate_llms_full.py
# Затем deploy.bat. Повторять после правок текста на страницах.
import re
import sys
import urllib.request
from datetime import date

BASE = 'https://building-port.ru'
PAGES = [
    ('/', 'Главная — фиброцементные панели для вентилируемых фасадов'),
    ('/catalog', 'Каталог: серии NATURE, POLISHED, TEXTURE, WALYPAN'),
    ('/kreplenie', 'Крепление панелей к подсистеме'),
    ('/sertificate', 'Сертификаты и техническая документация'),
    ('/compare-materials', 'Сравнение с другими фасадными материалами'),
    ('/projects', 'Реализованные объекты'),
    ('/architect', 'Архитекторам и проектировщикам'),
    ('/devops', 'Застройщикам и подрядчикам'),
    ('/dealer', 'Дилерская программа'),
    ('/contacts', 'Контакты, склад, реквизиты'),
]
UA = 'Mozilla/5.0 (compatible; BLPBoard-llms-builder/1.0)'

DROP_BLOCKS = re.compile(
    r'<(script|style|nav|header|footer|noscript|svg|form)\b.*?</\1>', re.S | re.I)
TAG = re.compile(r'<[^>]+>')
SPACES = re.compile(r'[ \t\u00a0]+')
BLANKS = re.compile(r'\n{3,}')


def fetch(path):
    req = urllib.request.Request(BASE + path, headers={'User-Agent': UA})
    with urllib.request.urlopen(req, timeout=30) as r:
        return r.read().decode('utf-8', 'replace')


def to_text(html):
    body = re.search(r'<main\b.*?</main>', html, re.S | re.I)
    chunk = body.group(0) if body else html
    chunk = DROP_BLOCKS.sub(' ', chunk)
    # заголовки и пункты списков разделяем переносами, чтобы структура читалась
    chunk = re.sub(r'</(h[1-6]|p|li|tr|div|section)>', '\n', chunk, flags=re.I)
    chunk = re.sub(r'<li\b[^>]*>', '- ', chunk, flags=re.I)
    chunk = re.sub(r'<h([1-6])\b[^>]*>', lambda m: '\n' + '#' * int(m.group(1)) + ' ', chunk, flags=re.I)
    chunk = re.sub(r'</t[dh]>', ' | ', chunk, flags=re.I)
    text = TAG.sub(' ', chunk)
    for a, b in [('&nbsp;', ' '), ('&mdash;', '—'), ('&ndash;', '–'), ('&laquo;', '«'),
                 ('&raquo;', '»'), ('&amp;', '&'), ('&quot;', '"'), ('&#039;', "'"),
                 ('&lt;', '<'), ('&gt;', '>'), ('&times;', '×'), ('&deg;', '°')]:
        text = text.replace(a, b)
    text = SPACES.sub(' ', text)
    text = '\n'.join(line.strip() for line in text.split('\n'))
    text = BLANKS.sub('\n\n', text)
    return text.strip()


def main():
    out = [
        '# BLP Board — полные тексты страниц (llms-full.txt)',
        '',
        f'Обновлено: {date.today().isoformat()}. Источник: {BASE}. Краткая карта и ключевые факты — в /llms.txt.',
        'Файл собран автоматически из опубликованных страниц: scripts/generate_llms_full.py.',
        'Цены и номера документов действительны на дату сборки, актуальные — на самих страницах.',
        '',
    ]
    for path, title in PAGES:
        try:
            text = to_text(fetch(path))
        except Exception as e:
            print(f'  пропуск {path}: {e}', file=sys.stderr)
            continue
        if len(text) < 200:
            print(f'  пропуск {path}: слишком мало текста ({len(text)})', file=sys.stderr)
            continue
        out += [f'## {title}', f'Источник: {BASE}{path}', '', text, '', '---', '']
        print(f'  {path}: {len(text)} символов')
    body = '\n'.join(out).rstrip() + '\n'
    with open('llms-full.txt', 'w', encoding='utf-8', newline='\n') as f:
        f.write(body)
    print(f'llms-full.txt: {len(body)} символов, {body.count(chr(10))} строк')


if __name__ == '__main__':
    main()
