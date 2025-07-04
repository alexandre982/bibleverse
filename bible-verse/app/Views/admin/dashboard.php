<div class="admin-dashboard">
  <!-- COLONNE GAUCHE -->
  <div class="left-panel">
    <h2>Statistiques du site</h2>

    <div class="dashboard-cards">
      <div class="card">
        <h3>Utilisateurs</h3>
        <p><?= htmlspecialchars($userCount) ?></p>
      </div>
      <div class="card">
        <h3>Favoris</h3>
        <p><?= htmlspecialchars($favoriCount) ?></p>
      </div>
      <div class="card">
        <h3>Publications</h3>
        <p><?= htmlspecialchars($publicationCount) ?></p>
      </div>
    </div>

    <p>
      <em>Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)</em>
    </p>

    <h3>Favoris des utilisateurs</h3>
    <?php if (!empty($favorites)): ?>
      <ul>
        <?php foreach ($favorites as $fav): ?>
          <li>
            <strong><?= htmlspecialchars($fav->book) ?> <?= $fav->chapter ?>:<?= $fav->verse_number ?></strong> -
            <?= nl2br(htmlspecialchars($fav->text)) ?> -
            <em>Utilisateur: <?= htmlspecialchars($fav->user_name) ?></em>
            <br>
            <a href="?route=supprimer-favori&id=<?= $fav->id ?>" onclick="return confirm('Supprimer ce favori ?');">Supprimer</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>Aucun favori enregistré.</p>
    <?php endif; ?>
  </div>

  <!-- COLONNE DROITE -->
  <div class="right-panel">
    <h3>Publications en attente</h3>

    <?php if (!empty($pending)): ?>
      <?php foreach ($pending as $pub): ?>
        <div class="publication-item">
          <p><strong><?= htmlspecialchars($pub->type === 'praise' ? 'Louange' : 'Témoignage') ?></strong> : <?= nl2br(htmlspecialchars($pub->content)) ?></p>
          <em>Soumis par utilisateur #<?= htmlspecialchars($pub->user_id) ?> le <?= htmlspecialchars($pub->created_at) ?></em>

          <div class="actions">
            <a href="?route=valider-publication&id=<?= $pub->id ?>">Valider</a>
            <a href="?route=supprimer-publication&id=<?= $pub->id ?>" onclick="return confirm('Supprimer cette publication ?');">Supprimer</a>
            <a href="#" class="edit-toggle" data-id="<?= $pub->id ?>">Modifier</a>
          </div>

          <form method="post" action="?route=modifier-publication" class="form-auth" id="edit-form-<?= $pub->id ?>" style="display: none;">
            <input type="hidden" name="id" value="<?= $pub->id ?>">
            <textarea name="content" required><?= htmlspecialchars($pub->content) ?></textarea>
            <button type="submit">Sauvegarder</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune publication en attente de validation.</p>
    <?php endif; ?>
  </div>
</div>