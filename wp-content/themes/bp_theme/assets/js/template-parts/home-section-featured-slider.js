jQuery(document).ready(function ($) {
  if (typeof wp !== "undefined" && wp.domReady) {
    wp.domReady(function () {
      setTimeout(function () {
        initializeFeaturedSlider();
      }, 500);
    });
  } else {
    initializeFeaturedSlider();
  }

  function initializeFeaturedSlider() {
    document.querySelectorAll(".splide.featured-slider").forEach(function (el) {
      new Splide(el, {
        perPage: 2,
        arrows: true,
        pagination: false,
        gap: "1rem",
        breakpoints: {
          768: {
            perPage: 1,
            gap: "0.5rem",
          },
          500: {
            perPage: 1,
            gap: "8px",
          },
        },
      }).mount();
    });
  }
});
