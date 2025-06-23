<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php if (!empty($favorites)): ?>
  <ul class="favoris-zone">
    <?php foreach ($favorites as $favorite): ?>
      <li>
        <div class="verse-text"><?= nl2br(htmlspecialchars($favorite->text)) ?></div>
        <div class="verse-ref"><?= htmlspecialchars($favorite->book_name) ?> <?= $favorite->chapter ?>:<?= $favorite->verse_number ?></div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Aucun favori enregistré.</p>
<?php endif; ?>
