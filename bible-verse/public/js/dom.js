document.addEventListener('DOMContentLoaded', function () {
  const menuBtn = document.querySelector('.menu-btn');
  const dropdown = document.querySelector('.dropdown');

  menuBtn.addEventListener('click', function () {
    dropdown.classList.toggle('open');
  });

  // Clic en dehors du menu pour fermer
  document.addEventListener('click', function (e) {
    if (!dropdown.contains(e.target) && !menuBtn.contains(e.target)) {
      dropdown.classList.remove('open');
    }
  });
});
