<div class="content-container verse">
  <div class="verse-text">
    <?= isset($verseText) ? nl2br(htmlspecialchars($verseText)) : '' ?>
  </div>
  <div class="verse-ref">
    <?= isset($verseRef) ? htmlspecialchars($verseRef) : '' ?>
  </div>
</div>
