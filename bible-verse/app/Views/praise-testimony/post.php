<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<section class="form-section">
  <form method="post" action="?route=envoyer-loue-temoigne" class="form-auth" novalidate>
    
    <?php if (!empty($errors)): ?>
      <ul class="form-errors">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- Type de publication -->
    <select name="type" required>
      <option value="">Choisir : Louange ou Témoignage</option>
      <option value="praise" <?= (isset($old['type']) && $old['type'] === 'praise') ? 'selected' : '' ?>>Louange</option>
      <option value="testimony" <?= (isset($old['type']) && $old['type'] === 'testimony') ? 'selected' : '' ?>>Témoignage</option>
    </select>

    <!-- Contenu -->
    <textarea name="content" placeholder="Exprime ta louange ou ton témoignage ici..." required><?= htmlspecialchars($old['content'] ?? '') ?></textarea>

    <!-- Couleur (utilisée pour affichage seulement) -->
    <select name="color" required>
      <option value="">Choisis une couleur</option>
      <option value="red" <?= (isset($old['color']) && $old['color'] === 'red') ? 'selected' : '' ?>>Rouge</option>
      <option value="green" <?= (isset($old['color']) && $old['color'] === 'green') ? 'selected' : '' ?>>Vert</option>
      <option value="blue" <?= (isset($old['color']) && $old['color'] === 'blue') ? 'selected' : '' ?>>Bleu</option>
      <option value="violet" <?= (isset($old['color']) && $old['color'] === 'violet') ? 'selected' : '' ?>>Violet</option>
      <option value="indigo" <?= (isset($old['color']) && $old['color'] === 'indigo') ? 'selected' : '' ?>>Indigo</option>
      <option value="darkbrown" <?= (isset($old['color']) && $old['color'] === 'darkbrown') ? 'selected' : '' ?>>Marron foncé</option>
    </select>

    <!-- Bouton d'envoi -->
    <button type="submit">Envoyer</button>
  </form>
</section>
