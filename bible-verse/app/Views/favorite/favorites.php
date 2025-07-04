<section class="favorites-wrapper">
  <h2>Mes Favoris</h2>
  <?php if(empty($favorites)): ?>
    <p>Aucun favori pour le moment.</p>
  <?php else: ?>
    <ul class="favorites-list">
      <?php foreach($favorites as $fav): ?>
        <li class="favorites-item">
          <strong><?= htmlspecialchars($fav['book_name']) ?> <?= $fav['chapter'] ?>:<?= $fav['verse_number'] ?></strong>
          <p><?= nl2br(htmlspecialchars($fav['text'])) ?></p>
          <form method="POST" action="?route=supprimer-favori" class="fav-actions">
            <input type="hidden" name="favorite_id" value="<?= (int)$fav['favorite_id'] ?>">
            <button type="submit" aria-label="Supprimer"><i class="fa-solid fa-trash"></i></button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>
