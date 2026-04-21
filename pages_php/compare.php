<?php
// 2026-04-20: Stage 3 Group 3.B — Product comparison page (NATURE vs POLISHED vs TEXTURE vs WALYPAN)
$page_title    = 'Сравнение серий фиброцементных панелей BLP Board: NATURE, POLISHED, TEXTURE, WALYPAN';
$page_canonical = 'https://building-port.ru/blp/compare';
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$page_desc = 'Сравнение 4 серий фиброцементных панелей BLP Board: характеристики, фактуры, области применения, толщина, размеры. Выберите подходящую серию для вашего объекта.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/compare.css">';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная',  'url' => 'https://building-port.ru/blp/'],
    ['name' => 'Каталог',  'url' => 'https://building-port.ru/blp/catalog'],
    ['name' => 'Сравнение серий', 'url' => 'https://building-port.ru/blp/compare'],
];

ob_start();
?>
<!-- ============================================
     COMPARE HERO
     ============================================ -->
<section class="blp-hero-section compare-hero">
    <div class="blp-container">
        <div class="blp-grid-12">
            <div class="blp-hero-content">
                <h1 class="blp-hero-title">Сравнение серий<br>фиброцементных панелей</h1>
                <p class="blp-hero-subtitle">NATURE · POLISHED · TEXTURE · WALYPAN — выберите подходящую серию для вашего объекта</p>
                <ul class="blp-hero-list">
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Все серии: НГ (К0), без асбеста, ГОСТ 8747-88</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Цвет окрашен в массе — не выгорает и не скалывается</span>
                    </li>
                    <li class="blp-hero-list-item">
                        <span class="blp-hero-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                        <span>Крупный формат до 3050 мм — меньше стыков на фасаде</span>
                    </li>
                </ul>
                <a href="/blp/contacts" class="blp-hero-button">Запросить образцы серий</a>
            </div>
            <div class="blp-hero-image">
                <div class="compare-hero-series">
                    <span class="compare-series-pill">NATURE</span>
                    <span class="compare-series-pill">POLISHED</span>
                    <span class="compare-series-pill">TEXTURE</span>
                    <span class="compare-series-pill">WALYPAN</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SERIES CARDS — краткий обзор
     ============================================ -->
<section class="compare-cards-section">
    <div class="blp-container">
        <h2 class="compare-section-title">Обзор серий BLP Board</h2>
        <p class="compare-section-desc">Все четыре серии изготовлены из фиброцемента (цемент + целлюлозное волокно + песок) и прошли пожарную сертификацию НГ / К0. Различие — в фактуре поверхности, размерном ряду и рекомендуемых областях применения.</p>

        <div class="compare-cards-grid">

            <div class="compare-card" id="series-nature">
                <div class="compare-card-header compare-card-nature">
                    <h3 class="compare-card-name">NATURE</h3>
                    <p class="compare-card-tagline">Фактура под натуральный бетон</p>
                </div>
                <div class="compare-card-body">
                    <ul class="compare-card-list">
                        <li><strong>Поверхность:</strong> рельефная, имитация архитектурного бетона</li>
                        <li><strong>Толщина:</strong> 8, 10, 12 мм</li>
                        <li><strong>Формат:</strong> до 3050 × 1220 мм</li>
                        <li><strong>Цвета:</strong> Жемчужный, Бежевый, Графитовый, Антрацит</li>
                        <li><strong>Применение:</strong> ЖК бизнес-класса, бизнес-центры, частные дома</li>
                    </ul>
                    <div class="compare-card-badge">Популярная серия</div>
                </div>
                <div class="compare-card-footer">
                    <a href="/blp/catalog#nature" class="compare-card-link">Подробнее о NATURE →</a>
                </div>
            </div>

            <div class="compare-card" id="series-polished">
                <div class="compare-card-header compare-card-polished">
                    <h3 class="compare-card-name">POLISHED</h3>
                    <p class="compare-card-tagline">Гладкая матовая поверхность</p>
                </div>
                <div class="compare-card-body">
                    <ul class="compare-card-list">
                        <li><strong>Поверхность:</strong> гладкая, равномерный матовый тон</li>
                        <li><strong>Толщина:</strong> 8, 10, 12, 15 мм</li>
                        <li><strong>Формат:</strong> до 3050 × 1220 мм</li>
                        <li><strong>Цвета:</strong> Белый, Серый, Бежевый светлый, Терракота</li>
                        <li><strong>Применение:</strong> медицинские, образовательные учреждения, офисы</li>
                    </ul>
                    <div class="compare-card-badge compare-card-badge-alt">Для соцобъектов</div>
                </div>
                <div class="compare-card-footer">
                    <a href="/blp/catalog#polished" class="compare-card-link">Подробнее о POLISHED →</a>
                </div>
            </div>

            <div class="compare-card" id="series-texture">
                <div class="compare-card-header compare-card-texture">
                    <h3 class="compare-card-name">TEXTURE</h3>
                    <p class="compare-card-tagline">Структурная поверхность под камень</p>
                </div>
                <div class="compare-card-body">
                    <ul class="compare-card-list">
                        <li><strong>Поверхность:</strong> тиснёная, имитация натурального камня</li>
                        <li><strong>Толщина:</strong> 10, 12 мм</li>
                        <li><strong>Формат:</strong> до 2440 × 1220 мм</li>
                        <li><strong>Цвета:</strong> Графитовый, Бежевый, Серо-коричневый</li>
                        <li><strong>Применение:</strong> торговые центры, гостиницы, смешанная застройка</li>
                    </ul>
                    <div class="compare-card-badge compare-card-badge-alt2">Выразительный фасад</div>
                </div>
                <div class="compare-card-footer">
                    <a href="/blp/catalog#texture" class="compare-card-link">Подробнее о TEXTURE →</a>
                </div>
            </div>

            <div class="compare-card" id="series-walypan">
                <div class="compare-card-header compare-card-walypan">
                    <h3 class="compare-card-name">WALYPAN</h3>
                    <p class="compare-card-tagline">Линеарные панели — горизонталь или вертикаль</p>
                </div>
                <div class="compare-card-body">
                    <ul class="compare-card-list">
                        <li><strong>Поверхность:</strong> линеарная (ламельная), направленный ритм</li>
                        <li><strong>Толщина:</strong> 18 мм (профилированная)</li>
                        <li><strong>Формат:</strong> длина до 3600 мм, ширина 195 мм</li>
                        <li><strong>Цвета:</strong> Антрацит, Тёмный графит, Натуральный</li>
                        <li><strong>Применение:</strong> акцентные фасадные зоны, частные дома, студии</li>
                    </ul>
                    <div class="compare-card-badge compare-card-badge-premium">Архитектурный акцент</div>
                </div>
                <div class="compare-card-footer">
                    <a href="/blp/catalog#walypan" class="compare-card-link">Подробнее о WALYPAN →</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================
     FEATURE MATRIX TABLE
     ============================================ -->
<section class="compare-matrix-section">
    <div class="blp-container">
        <h2 class="compare-section-title">Таблица характеристик по сериям</h2>
        <p class="compare-section-desc">Технические параметры для подбора оптимальной серии под требования проекта. Все серии производятся из фиброцемента класса НГ (К0) без асбеста.</p>

        <div class="compare-table-wrap">
            <table class="compare-matrix-table">
                <thead>
                    <tr>
                        <th class="compare-th-param">Параметр</th>
                        <th class="compare-th-nature">NATURE</th>
                        <th class="compare-th-polished">POLISHED</th>
                        <th class="compare-th-texture">TEXTURE</th>
                        <th class="compare-th-walypan">WALYPAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="compare-param">Тип поверхности</td>
                        <td>Рельефная / бетон</td>
                        <td>Гладкая / матовая</td>
                        <td>Тиснёная / камень</td>
                        <td>Линеарная / ламель</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">Толщина, мм</td>
                        <td>8 / 10 / 12</td>
                        <td>8 / 10 / 12 / 15</td>
                        <td>10 / 12</td>
                        <td>18 (профиль)</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Макс. длина, мм</td>
                        <td>3050</td>
                        <td>3050</td>
                        <td>2440</td>
                        <td>3600</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">Ширина, мм</td>
                        <td>1220</td>
                        <td>1220</td>
                        <td>1220</td>
                        <td>195</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Масса, кг/м²</td>
                        <td>14–17</td>
                        <td>14–20</td>
                        <td>15–18</td>
                        <td>18–22</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">Пожарный класс</td>
                        <td class="compare-check">НГ (К0) ✓</td>
                        <td class="compare-check">НГ (К0) ✓</td>
                        <td class="compare-check">НГ (К0) ✓</td>
                        <td class="compare-check">НГ (К0) ✓</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Без асбеста</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">Цвет в массе</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Морозостойкость, циклов</td>
                        <td>100+</td>
                        <td>100+</td>
                        <td>100+</td>
                        <td>100+</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">ГОСТ</td>
                        <td>8747-88 / 31251-2008</td>
                        <td>8747-88 / 31251-2008</td>
                        <td>8747-88 / 31251-2008</td>
                        <td>8747-88 / 31251-2008</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Срок службы</td>
                        <td>50+ лет</td>
                        <td>50+ лет</td>
                        <td>50+ лет</td>
                        <td>50+ лет</td>
                    </tr>
                    <tr class="compare-row-alt">
                        <td class="compare-param">Видимое крепление</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td>—</td>
                    </tr>
                    <tr>
                        <td class="compare-param">Скрытое крепление (кляммер)</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                        <td class="compare-check">✓</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ============================================
     USE CASE RECOMMENDATIONS
     ============================================ -->
<section class="compare-usecase-section">
    <div class="blp-container">
        <h2 class="compare-section-title">Рекомендации по выбору серии</h2>

        <div class="compare-usecase-grid">
            <div class="compare-usecase-card">
                <h3 class="compare-usecase-title">Жилой комплекс бизнес-класса</h3>
                <p>Выберите <strong>NATURE</strong> — рельефная поверхность под бетон подчёркивает архитектурный замысел. Крупный формат 3050 мм создаёт монолитный вид фасада с минимальным количеством швов.</p>
                <a href="/blp/catalog#nature" class="compare-usecase-link">Смотреть NATURE →</a>
            </div>
            <div class="compare-usecase-card">
                <h3 class="compare-usecase-title">Школа, больница, поликлиника</h3>
                <p>Выберите <strong>POLISHED</strong> — гладкая поверхность легко моется, нейтральные тона вписываются в требования госзаказа. Толщина 12–15 мм обеспечивает требуемую несущую способность для социальных объектов.</p>
                <a href="/blp/catalog#polished" class="compare-usecase-link">Смотреть POLISHED →</a>
            </div>
            <div class="compare-usecase-card">
                <h3 class="compare-usecase-title">Торговый центр, гостиница</h3>
                <p>Выберите <strong>TEXTURE</strong> — выразительная фактура под природный камень создаёт эффектный фасад. Серия хорошо работает на больших плоскостях и акцентных входных группах.</p>
                <a href="/blp/catalog#texture" class="compare-usecase-link">Смотреть TEXTURE →</a>
            </div>
            <div class="compare-usecase-card">
                <h3 class="compare-usecase-title">Частный дом, акцентная зона</h3>
                <p>Выберите <strong>WALYPAN</strong> — линеарные ламели создают ритмичный рисунок горизонтальных или вертикальных линий. Идеальный выбор для архитектурных акцентов на фасаде или облицовки интерьерных поверхностей.</p>
                <a href="/blp/catalog#walypan" class="compare-usecase-link">Смотреть WALYPAN →</a>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org для страницы сравнения -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Серии фиброцементных панелей BLP Board",
  "description": "Сравнение 4 серий фиброцементных панелей BLP Board: NATURE, POLISHED, TEXTURE, WALYPAN",
  "numberOfItems": 4,
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "BLP Board NATURE",
      "description": "Фиброцементные панели с рельефной поверхностью под архитектурный бетон. Толщина 8–12 мм, формат до 3050×1220 мм, класс НГ (К0).",
      "url": "https://building-port.ru/blp/catalog#nature"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "BLP Board POLISHED",
      "description": "Фиброцементные панели с гладкой матовой поверхностью. Толщина 8–15 мм, формат до 3050×1220 мм, класс НГ (К0).",
      "url": "https://building-port.ru/blp/catalog#polished"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "BLP Board TEXTURE",
      "description": "Фиброцементные панели с тиснёной поверхностью под натуральный камень. Толщина 10–12 мм, формат до 2440×1220 мм, класс НГ (К0).",
      "url": "https://building-port.ru/blp/catalog#texture"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "BLP Board WALYPAN",
      "description": "Линеарные фиброцементные ламели для горизонтального и вертикального монтажа. Толщина 18 мм, длина до 3600 мм, класс НГ (К0).",
      "url": "https://building-port.ru/blp/catalog#walypan"
    }
  ]
}
</script>

<?php $form_title = 'Помочь с выбором серии'; $form_desc = 'Опишите ваш объект — подберём подходящую серию и предоставим образцы бесплатно.'; include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
