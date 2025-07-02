<div class="admin-dashboard">
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

    <p class="admin-welcome">
        Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)
    </p>

    <h3>Gestion des Favoris</h3>
    <?php if (!empty($favorites)): ?>
        <ul>
            <?php foreach ($favorites as $fav): ?>
                <li>
                    <strong><?= htmlspecialchars($fav->book) ?> <?= $fav->chapter ?>:<?= $fav->verse_number ?></strong> - 
                    <?= nl2br(htmlspecialchars($fav->text)) ?> - Utilisateur: <?= htmlspecialchars($fav->user_name) ?>
                    <a href="?route=supprimer-favori&id=<?= $fav->id ?>" onclick="return confirm('Supprimer ce favori ?');">Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun favori enregistré.</p>
    <?php endif; ?>

    <h3>Publications en attente</h3>
    <?php if (!empty($pending)): ?>
        <ul>
            <?php foreach ($pending as $pub): ?>
                <li>
                    <strong><?= htmlspecialchars($pub['type'] === 'praise' ? 'Louange' : 'Témoignage') ?></strong> :
                    <?= nl2br(htmlspecialchars($pub['content'])) ?><br>
                    <em>Soumis par <?= htmlspecialchars($pub['user_id']) ?> le <?= htmlspecialchars($pub['created_at']) ?></em><br>
                    <a href="?route=valider-publication&id=<?= $pub['id'] ?>">Valider</a> | 
                    <a href="?route=supprimer-publication&id=<?= $pub['id'] ?>" onclick="return confirm('Supprimer cette publication ?');">Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune publication en attente de validation.</p>
    <?php endif; ?>
</div>
