<?php
// 2026-09-12: «Сколько панелей входит в контейнер» + калькулятор партии.
// Стоит на /catalog: страница /logistika отключена в админке и отдаёт 404.
// Цифры — практическая загрузка с учётом тары, база знаний
// 07-ХРАНЕНИЕ-И-ТРАНСПОРТИРОВКА/03-логистика-импорта/контейнерная-загрузка.md.
// Опора — фактическая отгрузка: 1800 м² панелей 8 мм в один 40HQ.
?>
    <?php
    $blp_containers = [
        ['code' => '40HQ', 'note' => 'основной', 'pay' => '26,5 т', 'main' => true,
         'rows' => ['8' => '1800', '9' => '1570', '10' => '1420', '12' => '1180', '15' => '940']],
        ['code' => '40DC', 'note' => '', 'pay' => '26,8 т', 'main' => false,
         'rows' => ['8' => '1820', '9' => '1590', '10' => '1430', '12' => '1190', '15' => '950']],
        ['code' => '20DC', 'note' => '', 'pay' => '28,2 т', 'main' => false,
         'rows' => ['8' => '1910', '9' => '1670', '10' => '1510', '12' => '1260', '15' => '1000']],
    ];
    ?>
    <div class="blp-cont" id="konteyner">
        <h2>Сколько панелей входит в контейнер</h2>
        <p class="blp-cont-sub">Площадь панелей формата 3050&nbsp;×&nbsp;1220 при полной загрузке контейнера, с учётом упаковки.</p>

        <div class="blp-cont-cards">
            <?php foreach ($blp_containers as $c): ?>
            <div class="blp-cont-card<?= $c['main'] ? ' is-main' : '' ?>">
                <h3><?= $c['code'] ?><?php if ($c['note']): ?> <em><?= $c['note'] ?></em><?php endif; ?></h3>
                <p class="blp-cont-pay">грузоподъёмность <?= $c['pay'] ?></p>
                <dl>
                    <?php foreach ($c['rows'] as $t => $m2): ?>
                    <dt><?= $t ?> мм</dt><dd><?= $m2 ?> <small>м²</small></dd>
                    <?php endforeach; ?>
                </dl>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="blp-cont-foot">
            Количество для конкретной партии подтверждается при бронировании перевозки.
            <a class="blp-cont-more" href="#ves">Вес панелей по толщинам →</a>
        </p>
    </div>

    <div class="blp-calc" id="kalkulyator">
        <h2>Расчёт партии</h2>
        <div class="blp-calc-controls">
            <label for="blp-calc-t">Толщина
                <select id="blp-calc-t">
                    <option value="8">8 мм</option>
                    <option value="9">9 мм</option>
                    <option value="10">10 мм</option>
                    <option value="12">12 мм</option>
                    <option value="15">15 мм</option>
                </select>
            </label>
            <label for="blp-calc-m">Площадь объекта, м²
                <input id="blp-calc-m" type="number" min="1" step="50" value="2100" inputmode="numeric">
            </label>
        </div>

        <div class="blp-calc-ship">
            <span>Как поедет</span>
            <strong id="blp-calc-ship">—</strong>
        </div>

        <div class="blp-calc-out">
            <div><span>Вес панелей</span><strong id="blp-calc-w">—</strong></div>
            <div><span>Листов 3050 × 1220</span><strong id="blp-calc-l">—</strong></div>
        </div>

        <p class="blp-cont-foot">Расчёт справочный. Вес и количество мест по конкретной партии подтверждаются в спецификации к договору.</p>
    </div>


<script>
// 2026-09-12: калькулятор партии. Веса — канон базы знаний, вместимость 40HQ — практическая
// (с тарой). Считаем полные контейнеры и остаток: заказ 2100 м² 8 мм реально ехал одним 40HQ
// плюс сборный груз, округление вверх до двух контейнеров показывало бы неправду.
(function () {
    var WEIGHT = { 8: 13.0, 9: 14.9, 10: 16.5, 12: 19.8, 15: 24.8 };
    var CAP_40HQ = { 8: 1800, 9: 1570, 10: 1420, 12: 1180, 15: 940 };
    var SHEET_M2 = 3.721;

    var thickness = document.getElementById('blp-calc-t');
    var area = document.getElementById('blp-calc-m');
    var outShip = document.getElementById('blp-calc-ship');
    var outWeight = document.getElementById('blp-calc-w');
    var outSheets = document.getElementById('blp-calc-l');
    if (!thickness || !area || !outShip) return;

    function ru(n) { return n.toLocaleString('ru-RU'); }

    function plural(n, one, few, many) {
        var n10 = n % 10, n100 = n % 100;
        if (n10 === 1 && n100 !== 11) return one;
        if (n10 >= 2 && n10 <= 4 && (n100 < 12 || n100 > 14)) return few;
        return many;
    }

    function calc() {
        var t = thickness.value;
        var m2 = parseFloat(area.value);

        if (!m2 || m2 <= 0) {
            outShip.textContent = '—';
            outWeight.textContent = '—';
            outSheets.textContent = '—';
            return;
        }

        var cap = CAP_40HQ[t];
        var full = Math.floor(m2 / cap);
        var rest = Math.round(m2 - full * cap);

        if (full === 0) {
            outShip.textContent = 'Сборный груз, ' + ru(rest) + ' м²';
        } else {
            var text = ru(full) + ' ' + plural(full, 'контейнер', 'контейнера', 'контейнеров') + ' 40HQ';
            if (rest > 0) text += ' + ' + ru(rest) + ' м² сборным грузом';
            outShip.textContent = text;
        }

        var kg = m2 * WEIGHT[t];
        outWeight.textContent = kg >= 1000
            ? ru(Math.round(kg / 100) / 10) + ' т'
            : ru(Math.round(kg)) + ' кг';
        outSheets.textContent = ru(Math.ceil(m2 / SHEET_M2));
    }

    thickness.addEventListener('change', calc);
    area.addEventListener('input', calc);
    calc();
})();
</script>
