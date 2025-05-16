jQuery(document).ready(function ($) {
  if (typeof wp !== "undefined" && wp.domReady) {
    wp.domReady(function () {
      InitializeCategorySli();
    });
  } else {
    InitializeCategorySli();
  }

  function InitializeCategorySli() {
    setTimeout(function () {
      new Splide("#category-slider", {
        type: "loop",
        perPage: 4,
        gap: "24px",
        arrows: true,
        pagination: true,
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
    }, 500);
  }
});
