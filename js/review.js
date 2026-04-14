document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.querySelector("#testimonialCarousel");
  const items = carousel.children;
  const total = items.length;
  let index = 0;

  const prevBtn = document.getElementById("prevTestimonial");
  const nextBtn = document.getElementById("nextTestimonial");

  function updateCarousel() {
    const shift = -(index * 100 / total);
    carousel.style.transform = `translateX(${shift}%)`;
  }
              
  prevBtn.addEventListener("click", () => {
    index = (index - 1 + total) % total;
    updateCarousel();
  });

  nextBtn.addEventListener("click", () => {
    index = (index + 1) % total;
    updateCarousel();
  });

});