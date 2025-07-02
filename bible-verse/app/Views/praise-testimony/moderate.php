<?php if (empty($pending)): ?>
    <p>Aucune publication en attente de validation.</p>
<?php else: ?>
    <ul>
        <?php foreach ($pending as $pub): ?>
            <li>
                <strong><?= htmlspecialchars($pub->author_name) ?> (<?= htmlspecialchars($pub->type) ?>)</strong> :<br>
                <?= nl2br(htmlspecialchars($pub->content)) ?><br>
                <em>Soumis le <?= htmlspecialchars($pub->created_at) ?></em><br>
                <a href="?route=validate-praise-testimony&id=<?= $pub->id ?>">Valider</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
