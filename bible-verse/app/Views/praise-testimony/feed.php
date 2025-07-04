<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<div class="feed-wrapper">
  <div class="feed-scrollable scrollbar-visible">
    <?php foreach ($publications as $index => $pub): ?>
      <?php
        $colorClass = ($index === 0 && !empty($highlightColor)) ? $highlightColor : '';
      ?>
      <div class="publication-box <?= htmlspecialchars($colorClass) ?>">
        <strong><?= ucfirst($pub->type) ?> :</strong>
        <?= nl2br(htmlspecialchars($pub->content)) ?>
        <em>Par <?= htmlspecialchars($pub->user_name) ?> - <?= $pub->created_at ?></em>
      </div>
    <?php endforeach; ?>
  </div>
</div>
