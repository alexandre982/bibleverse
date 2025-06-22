<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<h2>Mes Favoris</h2>

<?php if (!empty($favorites)): ?>
  <ul>
    <?php foreach ($favorites as $favorite): ?>
      <li>
        <?= htmlspecialchars($favorite->book_name, ENT_QUOTES, 'UTF-8') ?>
        <?= htmlspecialchars($favorite->chapter, ENT_QUOTES, 'UTF-8') ?>:
        <?= htmlspecialchars($favorite->verse_number, ENT_QUOTES, 'UTF-8') ?> - 
        <?= nl2br(htmlspecialchars($favorite->text, ENT_QUOTES, 'UTF-8')) ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Aucun favori enregistré.</p>
<?php endif; ?>
