<?php
// 2026-04-20: added meta description, OG image, canonical
// 2026-04-20: SEO — title keyword-first, meta desc 155-160 chars
$page_title    = 'Фиброцементные панели для вентилируемых фасадов — BLP Board';
$page_desc     = 'Фиброцементные плиты НГ для вентфасадов: серии NATURE, POLISHED, TEXTURE, WALYPAN. Без асбеста. Крупный формат до 3050 мм. Соответствие ГОСТ. Производитель BLP Board.';
$page_canonical = 'https://building-port.ru/blp/';
$page_og_image  = 'https://building-port.ru/blp/images-convert/pages/index/index_hero.jpg';
$extra_css  = '<link rel="stylesheet" href="/blp/css/pages/index.css">';
$extra_js   = '<script src="/blp/js/pages/index.js" defer></script>';
$lcp_image  = '/blp/images-convert/pages/index/index_hero.jpg';
// 2026-04-20: breadcrumbs for schema
$breadcrumbs = [
    ['name' => 'Главная', 'url' => 'https://building-port.ru/blp/'],
];

ob_start();
?>

<section class="hero-main">
    <div class="hero-container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="badge">BLP Board</div>
                <!-- 2026-04-20: H1 обновлён (+НВФ), subtitle переписан с ключевыми словами, CTA конкретизирован -->
                <h1 style="margin-bottom: 20px;">Фиброцементные плиты&nbsp;для навесных вентилируемых фасадов</h1>

                <div class="hero-tags">
                    <span class="tag">НГ (негорючие)</span>
                    <span class="tag">0% асбеста</span>
                    <span class="tag">Крупноформатные</span>
                    <span class="tag">Соответствуют ГОСТ</span>
                </div>


                <a href="/blp/contacts" class="btn btn-primary" style="margin-top: 20px;">Получить техническое предложение</a>
            </div>

            <div class="hero-image-wrapper">
                <img src="/blp/images-convert/pages/index/index_hero.jpg"
                     alt="Фиброцементные плиты BLP Board"
                     class="hero-image"
                     width="600" height="450"
                     fetchpriority="high"
                     decoding="async">
            </div>
        </div>
    </div>
</section>

<?php include '../blocks/products-section.php'; ?>

<?php include '../blocks/audience-section.php'; ?>

<?php include '../blocks/benefits.php'; ?>

<!-- 2026-04-20: Stage 3 Group 3.B — Product benefits section: material choice justification, env impact, ROI -->
<section class="index-material-benefits">
    <div class="blp-container">
        <h2 class="index-mb-title">Почему фиброцементные панели BLP Board — правильный выбор</h2>
        <p class="index-mb-desc">Фиброцемент выигрывает у альтернатив по трём ключевым критериям, которые определяют решение на долгосрочном горизонте.</p>

        <div class="index-mb-grid">
            <div class="index-mb-card">
                <div class="index-mb-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h3>Пожарная безопасность без компромисса</h3>
                <p class="index-mb-subtitle">НГ (негорючие)</p>
                <p>Класс НГ (негорючий, К0) в составе с подсистемой — высший уровень пожарной безопасности по ГОСТ 31251-2008. Не горит, не выделяет дыма, не образует горящих капель. Обязателен для зданий выше 28 м.</p>
            </div>
            <div class="index-mb-card">
                <div class="index-mb-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                        <line x1="9" y1="9" x2="9.01" y2="9"/>
                        <line x1="15" y1="9" x2="15.01" y2="9"/>
                    </svg>
                </div>
                <h3>Экологичность и безопасность состава</h3>
                <p class="index-mb-subtitle">0% асбеста</p>
                <p>Состав: цемент + целлюлозное волокно + кварцевый песок. Производство соответствует европейским стандартам качества. Безопасен для объектов с пребыванием детей и маломобильных групп населения.</p>
            </div>
            <div class="index-mb-card">
                <div class="index-mb-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <h3>Гарантия: 5 лет на материал</h3>
                <p class="index-mb-subtitle">Крупноформатные</p>
                <p>Гарантийное обслуживание — 5 лет при условии соблюдения технологии монтажа и эксплуатации. Цвет окрашен в массе: не выгорает. Морозостойкость — 150+ циклов замораживания/оттаивания. При правильном уходе фасад служит 50+ лет.</p>
            </div>
        </div>

        <div class="index-mb-compare">
            <h2 class="index-mb-compare-title">Фиброцемент vs альтернативы</h2>
            <div class="index-mb-table-wrap">
                <table class="index-mb-table">
                    <thead>
                        <tr>
                            <th>Критерий</th>
                            <th class="index-mb-th-blp" style="background-color: #00352F; color: #ffffff;">Фиброцемент BLP</th>
                            <th>HPL</th>
                            <th>Металлокассеты</th>
                            <th>Керамогранит</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Пожарный класс</td>
                            <td class="index-mb-td-blp" style="background-color: #f0f8f7; color: #1a1a1a;"><strong>НГ (К0)</strong></td>
                            <td>Г1–Г4</td>
                            <td>НГ</td>
                            <td>НГ</td>
                        </tr>
                        <tr>
                            <td>Масса, кг/м²</td>
                            <td class="index-mb-td-blp"><strong>14–20</strong></td>
                            <td>8–12</td>
                            <td>5–8</td>
                            <td>25–35</td>
                        </tr>
                        <tr>
                            <td>Гарантия</td>
                            <td class="index-mb-td-blp"><strong>5 лет</strong></td>
                            <td>2–5 лет</td>
                            <td>3–5 лет</td>
                            <td>5–10 лет</td>
                        </tr>
                        <tr>
                            <td>Без повторной окраски</td>
                            <td class="index-mb-td-blp"><strong>Да</strong></td>
                            <td>Нет</td>
                            <td>Нет</td>
                            <td>Да</td>
                        </tr>
                        <tr>
                            <td>Обработка на стройплощадке</td>
                            <td class="index-mb-td-blp"><strong>Простая</strong></td>
                            <td>Сложно</td>
                            <td>Средне</td>
                            <td>Сложно</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>

<?php include '../blocks/objects-section.php'; ?>

<?php include '../blocks/partners-section.php'; ?>

<?php include '../blocks/contact-form.php'; ?>

<?php
$page_content = ob_get_clean();
include 'template.php';
