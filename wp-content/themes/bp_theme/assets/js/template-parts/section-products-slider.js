jQuery(document).ready(function ($) {
  if (typeof wp !== "undefined" && wp.domReady) {
    wp.domReady(function () {
      setTimeout(function () {
        initializeProductsSlider();
      }, 500);
    });
  } else {
    initializeProductsSlider();
  }

  function initializeProductsSlider() {
    document
      .querySelectorAll(".splide.slider-container-second")
      .forEach(function (el) {
        new Splide(el, {
          type: "loop",
          perPage: 4,
          arrows: true,
          pagination: true,
          gap: "34px",
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
  }
});
