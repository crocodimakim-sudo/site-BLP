<?php
$page_title = 'Фиброцементные панели для застройщиков — BLP Board';
$page_desc  = 'Фасадные решения для застройщиков: фиброцементные панели BLP Board. Совместимость с подсистемами, юридическая чистота, поставки точно в срок.';
$extra_css = '<link rel="stylesheet" href="/blp/css/pages/devops.css">';

ob_start();
?>
<!-- ========================================

     HERO SECTION — ПЕРВЫЙ ЭКРАН

     ======================================== -->

<section class="hero-section">

    <div class="hero-card">

        <!-- Фоновое изображение -->

        <div class="hero-bg"></div>

        

        <!-- Оверлей -->

        <div class="hero-overlay"></div>

        

        <!-- Контент -->

        <div class="hero-content">

            <div class="hero-label">BLP Board</div>

            <h1 class="hero-title">Фиброцементные панели&nbsp;для застройщиков</h1>

            <p class="hero-subtitle">Берём фасадное решение&nbsp;на себя: от подбора&nbsp;до поставки — чтобы вы уложились&nbsp;в бюджет&nbsp;и сроки проекта</p>

            <a href="/contacts" class="hero-cta">Задать вопрос</a>

        </div>

    </div>

</section>

<!-- ========================================

     БЛОК ТЕХНИЧЕСКИХ ПРЕИМУЩЕСТВ

     ======================================== -->

<section class="tech-section">

    <div class="section-header">

        <h2 class="section-title">Почему работают&nbsp;с нами</h2>

    </div>

    <div class="tech-grid">

        <!-- Карточка 1: Совместимость -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">01</div>

                <div class="tech-content">

                    <div class="tech-label">Технология</div>

                    <h3 class="tech-title">Совместимость<br>с подсистемами</h3>

                    <p class="tech-text">Панели работают&nbsp;со всеми типами фасадных подсистем без ограничений.</p>

                    <ul class="tech-list">

                        <li>Алюминиевые подсистемы</li>

                        <li>Оцинкованная сталь</li>

                        <li>Нержавеющая сталь</li>

                    </ul>

                </div>

            </article>

        </div>

        <!-- Карточка 2: Юридическая чистота -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">02</div>

                <div class="tech-content">

                    <div class="tech-label">Безопасность</div>

                    <h3 class="tech-title">Юридическая&nbsp;и техническая надежность</h3>

                    <p class="tech-text">Полный пакет документов&nbsp;для госэкспертизы.</p>

                    <ul class="tech-list">

                        <li>Соответствие ГОСТ</li>

                        <li>Пожарная сертификация НГ (К0)</li>

                        <li>Морозостойкость ≥150 циклов</li>

                    </ul>

                </div>

            </article>

        </div>

        <!-- Карточка 3: Поставки -->

        <div class="tech-col">

            <article class="tech-card">

                <div class="tech-number">03</div>

                <div class="tech-content">

                    <div class="tech-label">Логистика</div>

                    <h3 class="tech-title">Поставки точно&nbsp;в срок</h3>

                    <p class="tech-text">Согласовываем график отгрузок<br>под ваш проект. Фиксируем даты<br>в договоре.</p>

                    <ul class="tech-list">

                        <li>Гибкий график&nbsp;под проект</li>

                        <li>Гарантия отгрузки&nbsp;в срок</li>

                    </ul>

                </div>

            </article>

        </div>

    </div>

</section>

<!-- ========================================
     БЛОК ПРОЕКТОВ
     ======================================== -->
<?php include '../blocks/objects-section.php'; ?>

<!-- ========================================
     БЛОК ПРЕИМУЩЕСТВ (общий)
     ======================================== -->
<?php include '../blocks/benefits.php'; ?>

<!-- ========================================
     ФОРМА ОБРАТНОЙ СВЯЗИ
     ======================================== -->
<?php include '../blocks/contact-form.php'; ?>
<?php
$page_content = ob_get_clean();
include 'template.php';