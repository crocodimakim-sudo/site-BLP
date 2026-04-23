<?php
// 2026-04-23: визуальные breadcrumbs — рендерит nav из $breadcrumbs если задан и содержит >1 элемента
if (empty($breadcrumbs) || count($breadcrumbs) <= 1) return;
?>
<nav class="blp-breadcrumbs" aria-label="Навигация по разделам">
  <ol class="blp-breadcrumbs__list">
    <?php foreach ($breadcrumbs as $i => $crumb):
          $isLast = ($i === count($breadcrumbs) - 1); ?>
      <li class="blp-breadcrumbs__item<?= $isLast ? ' blp-breadcrumbs__item--current' : '' ?>">
        <?php if (!$isLast): ?>
          <a href="<?= htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8') ?>" class="blp-breadcrumbs__link"><?= htmlspecialchars($crumb['name'], ENT_QUOTES, 'UTF-8') ?></a>
          <span class="blp-breadcrumbs__sep" aria-hidden="true">›</span>
        <?php else: ?>
          <span aria-current="page"><?= htmlspecialchars($crumb['name'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
