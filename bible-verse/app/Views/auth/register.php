<section class="form-section">
  <form method="post" class="form-auth">
    <?php if (!empty($errors)): ?>
      <ul class="form-errors">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <label for="name">Nom :</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>

    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit">S'inscrire</button>
  </form>
</section>
