const slides = document.querySelectorAll('.slider-img');
const textos = document.querySelectorAll('.brigadeiro-detalhes');

slides.forEach(slide => {
  slide.addEventListener('click', () => {
    // Remove "active" de todos
    slides.forEach(s => s.classList.remove('active'));
    textos.forEach(t => t.classList.remove('active'));

    // Ativa o clicado
    slide.classList.add('active');
    const id = slide.getAttribute('data-id');
    const textoMostrar = document.getElementById(id);
    if (textoMostrar) {
      textoMostrar.classList.add('active');
    }
  });
});
