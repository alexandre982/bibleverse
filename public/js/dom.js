document.addEventListener("DOMContentLoaded", function () {
  const copyBtn = document.getElementById("copy-btn");
  const shareBtn = document.getElementById("share-btn");
  const verseTextElem = document.querySelector(".verse-text");

  if (copyBtn && verseTextElem) {
    copyBtn.addEventListener("click", function (e) {
      e.preventDefault();
      const textToCopy = verseTextElem.innerText.trim();
      navigator.clipboard
        .writeText(textToCopy)
        .then(() => {
          alert("Verset copié dans le presse-papier !");
        })
        .catch(() => {
          alert("Impossible de copier le verset.");
        });
    });
  }

  if (shareBtn && verseTextElem) {
    shareBtn.addEventListener("click", function (e) {
      e.preventDefault();
      if (navigator.share) {
        navigator
          .share({
            title: document.title,
            text: verseTextElem.innerText.trim(),
            url: window.location.href,
          })
          .catch(() => {
            alert("Partage annulé ou non supporté.");
          });
      } else {
        alert("Le partage n’est pas supporté par votre navigateur.");
      }
    });
  }
});
