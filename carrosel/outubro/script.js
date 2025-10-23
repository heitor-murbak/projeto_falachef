document.addEventListener('DOMContentLoaded', () => {

  // ===== CAROUSEL =====
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.dot');
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.add('hidden');
      if (i === index) slide.classList.remove('hidden');
    });

    dots.forEach((dot, i) => {
      dot.classList.remove('active');
      if (i === index) dot.classList.add('active');
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  if (slides.length && dots.length) {
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        currentIndex = index;
        showSlide(currentIndex);
      });
    });

    setInterval(nextSlide, 5000);
    showSlide(currentIndex);
  }

  // ===== DROPDOWN REGIÕES =====
  const regionBtn = document.querySelector('.region-btn');
  const regionDropdown = document.querySelector('.region-dropdown-container .dropdown');

  if (regionBtn) {
    regionBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      regionDropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
      if (regionDropdown) regionDropdown.classList.remove('show');
    });
  }

});
