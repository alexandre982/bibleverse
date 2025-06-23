<section class="form-section">
  <form method="post" class="form-auth">
    <?php if (!empty($errors)): ?>
      <ul class="form-errors">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <input
      type="text"
      name="name"
      placeholder="Nom"
      value="<?= htmlspecialchars($old['name'] ?? '') ?>"
      required
    />

    <input
      type="email"
      name="email"
      placeholder="Email"
      value="<?= htmlspecialchars($old['email'] ?? '') ?>"
      required
    />

    <input
      type="password"
      name="password"
      placeholder="Mot de passe"
      required
    />

    <input
      type="password"
      name="confirm_password"
      placeholder="Confirmer le mot de passe"
      required
    />

    <button type="submit">S'inscrire</button>
  </form>
</section>
