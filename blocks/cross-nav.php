<?php
// 2026-09-12: строка направлений — постоянный переход между тремя сайтами BuildingPort.
// Заменила welcome-popup.php: попап показывался только на главной и возвращался раз в 2 часа,
// а с внутренних страниц уйти на соседний сайт было нельзя вообще.
// Текущий сайт (фасадные панели) — не ссылка. Название интерьерной линейки — MDBoard,
// декоративная серия внутри неё — BLP FCP decor (не FCB, см. паспорт изделия).
// Живёт внутри .header, поэтому высота .header-spacer увеличена в css/cross-nav.css.
?>
<nav class="cross-nav" aria-label="Направления BuildingPort">
    <div class="cross-nav__inner">
        <span class="cross-nav__item cross-nav__item--current" aria-current="page">Фасадные панели</span>
        <a class="cross-nav__item" href="https://blp.building-port.ru/" rel="noopener">
            Интерьерные панели MDBoard
            <svg class="cross-nav__arrow" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"></path><path d="M7 7h10v10"></path></svg>
        </a>
        <a class="cross-nav__item" href="https://blite-light.ru/" rel="noopener">
            Светильники BLP
            <svg class="cross-nav__arrow" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"></path><path d="M7 7h10v10"></path></svg>
        </a>
    </div>
</nav>
