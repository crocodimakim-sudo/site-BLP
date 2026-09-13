<?php
// 2026-09-12: блок «Вес панелей» — продолжение блока характеристик на /catalog.
// Цифры: канон базы знаний 02-фиброцемент-база, файл
// 07-ХРАНЕНИЕ-И-ТРАНСПОРТИРОВКА/03-логистика-импорта/контейнерная-загрузка.md, § 1.
// Вес 8 мм (13 кг/м²) подтверждён техническим свидетельством ТС 7515-26.
// Формат только 3050 × 1220 — решение владельца 2026-09-12.
// Панель 6 мм — интерьерная линейка MDBoard, отдельный сайт, строка приглушена.
$blp_weights = [
    ['t' => '8',  'kg' => '13,0', 'sheet' => '48,4', 'muted' => false],
    ['t' => '9',  'kg' => '14,9', 'sheet' => '55,4', 'muted' => false],
    ['t' => '10', 'kg' => '16,5', 'sheet' => '61,4', 'muted' => false],
    ['t' => '12', 'kg' => '19,8', 'sheet' => '73,7', 'muted' => false],
    ['t' => '15', 'kg' => '24,8', 'sheet' => '92,3', 'muted' => false],
    ['t' => '6',  'kg' => '9,9',  'sheet' => '36,8', 'muted' => true],
];
?>
<div class="blp-weight-block" id="ves">
    <h2 class="blp-weight-title">Вес панелей</h2>
    <p class="blp-weight-sub">Вес указан для сухой панели. При влагонасыщении масса увеличивается примерно на 10%.</p>

    <div class="blp-weight-wrap">
        <table class="blp-weight-table">
            <caption>Фиброцементные панели BLP Board, формат 3050&nbsp;×&nbsp;1220&nbsp;мм</caption>
            <thead>
                <tr>
                    <th scope="col">Толщина</th>
                    <th scope="col">Вес, кг/м²</th>
                    <th scope="col">Вес листа, кг</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blp_weights as $row): ?>
                <tr<?= $row['muted'] ? ' class="is-muted"' : '' ?>>
                    <th scope="row"><?= $row['t'] ?> <span class="blp-weight-unit">мм<?= $row['muted'] ? ' · интерьер' : '' ?></span></th>
                    <td class="blp-weight-key"><?= $row['kg'] ?></td>
                    <td class="blp-weight-dim"><?= $row['sheet'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p class="blp-weight-foot">
        Площадь листа 3050&nbsp;×&nbsp;1220&nbsp;— 3,72&nbsp;м². Плотность ≥&nbsp;1450&nbsp;кг/м³.
        Панель 6&nbsp;мм — интерьерная линейка MDBoard, <a href="https://blp.building-port.ru/" rel="noopener">смотреть на сайте интерьерных панелей</a>.
        <a class="blp-weight-more" href="#konteyner">Сколько панелей входит в контейнер →</a>
    </p>
</div>
