jQuery(document).ready(function ($) {
  if (typeof wp !== "undefined" && wp.domReady) {
    wp.domReady(function () {
      setTimeout(function () {
        initializeProductSide();
      }, 500);
    });
  } else {
    initializeProductSide();
  }
  function initializeProductSide() {
    document
      .querySelectorAll(".splide.slider-container")
      .forEach(function (el) {
        new Splide(el, {
          perPage: 3,
          arrows: true,
          pagination: true,
          type: "loop",
          gap: "34px",
          breakpoints: {
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
