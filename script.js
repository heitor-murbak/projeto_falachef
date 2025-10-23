document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.dot');
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.add('hidden');
      if (i === index) {
        slide.classList.remove('hidden');
      }
    });

    dots.forEach((dot, i) => {
      dot.classList.remove('active');
      if (i === index) {
        dot.classList.add('active');
      }
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      currentIndex = index;
      showSlide(currentIndex);
    });
  });

  setInterval(nextSlide, 5000);
  showSlide(currentIndex);
});

document.addEventListener('DOMContentLoaded', () => {
  // Carousel já existente
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

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      currentIndex = index;
      showSlide(currentIndex);
    });
  });

  setInterval(nextSlide, 5000);
  showSlide(currentIndex);

  // ===== DROPDOWN REGIÕES =====
  const regionBtn = document.querySelector('.region-btn');
  const regionDropdown = document.querySelector('.region-dropdown-container .dropdown');

  regionBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // evita fechamento imediato
    regionDropdown.classList.toggle('show');
  });

  // Fecha se clicar fora
  document.addEventListener('click', () => {
    regionDropdown.classList.remove('show');
  });
});
