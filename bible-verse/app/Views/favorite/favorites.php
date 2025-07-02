<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="favorites-wrapper">
  <?php if (!empty($favorites)): ?>
    <div class="favorites-scrollable scrollbar-visible">
      <?php foreach ($favorites as $fav): ?>
        <div class="favorites-item">
          <strong><?= htmlspecialchars($fav->book_name ?? $fav->book) ?> <?= $fav->chapter ?>:<?= $fav->verse_number ?></strong>
          <p><?= htmlspecialchars($fav->text) ?></p>
          <em>Utilisateur: <?= htmlspecialchars($fav->user_name) ?></em>
          <div class="fav-actions">
            <a class="fav-delete" href="?route=supprimer-favori&id=<?= $fav->id ?>">Supprimer</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="no-fav">Aucun verset favori pour le moment.</p>
  <?php endif; ?>
</div>
