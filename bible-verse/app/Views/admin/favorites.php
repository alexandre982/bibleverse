<section class="admin-favoris">
    <h2>Favoris enregistrés</h2>

    <?php if (!empty($favorites)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Verset</th>
                    <th>Référence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($favorites as $fav): ?>
                    <tr>
                        <td><?= $fav['id'] ?></td>
                        <td><?= htmlspecialchars($fav['user_name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($fav['text'])) ?></td>
                        <td><?= htmlspecialchars($fav['book_name']) ?> <?= $fav['chapter'] ?>:<?= $fav['verse_number'] ?></td>
                        <td>
                            <form method="POST" action="?route=supprimer-favori" onsubmit="return confirm('Supprimer ce favori ?');">
                                <input type="hidden" name="favorite_id" value="<?= $fav['id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun favori trouvé.</p>
    <?php endif; ?>
</section>
