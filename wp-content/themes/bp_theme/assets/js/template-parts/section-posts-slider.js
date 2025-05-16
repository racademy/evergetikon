document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".splide.posts-slider").forEach(function (el) {
    new Splide(el, {
      type: "loop",
      perPage: 4,
      arrows: true,
      pagination: true,
      gap: "24px",
      breakpoints: {
        1024: {
          perPage: 3,
          gap: "16px",
        },
        768: {
          perPage: 2,
          gap: "12px",
        },
        500: {
          perPage: 1,
          gap: "8px",
          pagination: false,
        },
      },
    }).mount();
  });
});
