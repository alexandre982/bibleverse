<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($pageTitle ?? 'Bible Verse+') ?></title>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Barlow&family=Abibas&display=swap" rel="stylesheet" />
</head>
<body>
<div class="frame-container">
  <div class="stripe"></div>
  <img src="assets/images/logo.png" class="logo" alt="Bible Verse+" />
  <button class="menu-btn" aria-label="Ouvrir le menu">
    <img src="assets/images/canne.png" alt="Menu" />
  </button>

  <?php if (($pageTitle ?? '') !== 'Dashboard Admin'): ?>
    <img src="assets/images/cadre.png" class="cadre" alt="Cadre doré" />
  <?php endif; ?>

  <h1 class="page-label"><?= htmlspecialchars($pageTitle ?? '') ?></h1>

  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash-message">
      <?= htmlspecialchars($_SESSION['flash']) ?>
      <?php unset($_SESSION['flash']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($verseText)): ?>
    <div class="verse">
      <div class="verse-text">
        <?= nl2br(htmlspecialchars($verseText)) ?><br />
        <small><?= htmlspecialchars($verseRef) ?></small>
      </div>
    </div>
  <?php elseif (isset($view) && !empty($view)): ?>
    <section class="form-section">
      <?php require __DIR__ . '/' . $view; ?>
    </section>
  <?php endif; ?>

  <div class="icons">
    <button id="share-btn" aria-label="Partager"><i class="fa-solid fa-share-nodes"></i></button>
    <button id="copy-btn" aria-label="Copier"><i class="fa-solid fa-copy"></i></button>
    <form method="POST" action="?route=ajouter-favori" class="fav-form">
      <input type="hidden" name="verse_id" value="<?= isset($verseId) ? $verseId : '' ?>">
      <button type="submit" aria-label="Ajouter aux favoris">
        <i class="fa-solid fa-star"></i>
      </button>
    </form>
  </div>

  <nav class="dropdown" id="menu" aria-label="Menu principal">
    <ul>
      <li><a href="?route=verset-du-jour"><i class="fa-solid fa-book"></i> Verset du jour</a></li>
      <li><a href="?route=loue-temoigne"><i class="fa-solid fa-bell"></i> Loue & Témoigne</a></li>
      <li><a href="?route=fil-actualite"><i class="fa-solid fa-rss"></i> Fil d’actu</a></li>
      <li><a href="?route=favoris"><i class="fa-solid fa-star"></i> Favoris</a></li>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <li><a href="?route=dashboard"><i class="fa-solid fa-gauge"></i> Dashboard Admin</a></li>
      <?php endif; ?>
      <?php if (!isset($_SESSION['user'])): ?>
        <li><a href="?route=inscription"><i class="fa-solid fa-user-plus"></i> Inscription</a></li>
        <li><a href="?route=connexion"><i class="fa-solid fa-arrow-right-to-bracket"></i> Connexion</a></li>
      <?php else: ?>
        <li><a href="?route=deconnexion"><i class="fa-solid fa-arrow-right-from-bracket"></i> Déconnexion</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>
<script src="js/dom.js"></script>
</body>
</html>
