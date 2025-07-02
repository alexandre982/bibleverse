document.addEventListener("DOMContentLoaded", function () {
  const menuBtn = document.querySelector(".menu-btn");
  const dropdown = document.querySelector(".dropdown");

  menuBtn.addEventListener("click", function () {
    dropdown.classList.toggle("open");
  });

  // Clic en dehors du menu pour fermer
  document.addEventListener("click", function (e) {
    if (!dropdown.contains(e.target) && !menuBtn.contains(e.target)) {
      dropdown.classList.remove("open");
    }
  });

  // COPIER LE TEXTE DU VERSET
  const copyBtn = document.getElementById("copy-btn");
  const verseTextElement = document.querySelector(".verse-text");

  if (copyBtn && verseTextElement) {
    copyBtn.addEventListener("click", function () {
      const text = verseTextElement.innerText;
      navigator.clipboard
        .writeText(text)
        .then(() => {
          alert("Verset copié dans le presse-papier !");
        })
        .catch((err) => {
          alert("Erreur lors de la copie : " + err);
        });
    });
  }

  // PARTAGER (API Web Share)
  const shareBtn = document.getElementById("share-btn");

  if (shareBtn && verseTextElement && navigator.share) {
    shareBtn.addEventListener("click", function () {
      const text = verseTextElement.innerText;
      navigator
        .share({
          title: "Bible Verse+",
          text: text,
          url: window.location.href,
        })
        .catch((error) => {
          console.error("Erreur lors du partage :", error);
        });
    });
  } else if (shareBtn) {
    shareBtn.addEventListener("click", function () {
      alert("La fonction de partage n’est pas supportée par votre navigateur.");
    });
  }
});
