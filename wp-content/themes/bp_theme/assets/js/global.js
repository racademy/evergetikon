document.addEventListener("DOMContentLoaded", function () {
  /* Sticky nav */
  jQuery(function ($) {
    $(window).on("scroll", function () {
      var scrollPos = $(window).scrollTop();
      $("header").toggleClass("active", scrollPos > 1);
    });
  });
  /* end */

  jQuery(document).ready(function ($) {
    if (typeof wp !== "undefined" && wp.domReady) {
      wp.domReady(function () {
        setTimeout(function () {
          initializeGlobal();
        }, 600);
      });
    } else {
      initializeGlobal();
    }

    function initializeGlobal() {
      /* Testimonials slider */
      if (document.querySelector(".testimonial-splide")) {
        new Splide(".testimonial-splide", {
          type: "loop",
          perPage: 1,
          pagination: true,
          arrows: true,
          gap: "24px",
          breakpoints: {
            500: {
              pagination: false,
            },
          },
        }).mount();
      }
      /* end */

      /* Single post slider */
      if (document.querySelector(".posts-slider-second")) {
        new Splide(".splide.posts-slider-second", {
          type: "loop",
          perPage: 4,
          pagination: true,
          arrows: true,
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
      }
      /* end */

      /* Related product slider */
      if (document.querySelector(".product-slider-related")) {
        new Splide(".splide.product-slider-related", {
          type: "loop",
          perPage: 4,
          pagination: true,
          arrows: true,
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
      }
      /* end */

      /* Single post product slider */
      if (document.querySelector(".slider-container-second-shop")) {
        new Splide(".splide.slider-container-second-shop", {
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
      }
      /* end */
    }
  });

  /* Scroll to top */
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");

  window.addEventListener("scroll", function () {
    scrollToTopBtn.style.display = window.scrollY > 200 ? "flex" : "none";
  });

  scrollToTopBtn.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
  /* end */

  /* Frenquali asked questions */
  const faqItems = document.querySelectorAll(".faq-item");

  faqItems.forEach((item) => {
    const question = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");
    const toggleBtn = question.querySelector(".toggle-btn");

    question.addEventListener("click", () => {
      faqItems.forEach((otherItem) => {
        if (otherItem !== item) {
          otherItem.querySelector(".faq-answer").style.display = "none";
          otherItem.querySelector(".toggle-btn").textContent = "+";
        }
      });

      if (answer.style.display === "none") {
        answer.style.display = "block";
        toggleBtn.textContent = "-";
      } else {
        answer.style.display = "none";
        toggleBtn.textContent = "+";
      }
    });
  });
  /* end */

  /* Single product gallery */
  var thumbnail = new Splide("#thumbnail-slider", {
    fixedWidth: 84,
    fixedHeight: 84,
    height: 376,
    isNavigation: true,
    gap: 10,
    direction: "ttb",
    pagination: false,
    arrows: false,
    breakpoints: {
      500: {
        direction: "ltr",
        height: null,
        fixedWidth: 84,
        fixedHeight: 84,
      },
    },
  }).mount();

  // Main Splide
  var main = new Splide("#main-slider", {
    type: "fade",
    height: 376,
    heightRatio: 1,
    pagination: true,
    arrows: true,
    cover: true,
  });

  main.sync(thumbnail).mount();

  // Lightbox button trigger (simulate click on first main image anchor)
  document
    .querySelector(".open-gallery-lightbox")
    .addEventListener("click", function (e) {
      e.preventDefault();
      const firstImage = document.querySelector(
        "#main-slider a[data-lightbox]"
      );
      if (firstImage) {
        firstImage.click();
      }
    });
  /* end */

  /* Read more in product page */
  const containers = document.querySelectorAll("[data-readmore]");
  const charLimit = 200;

  containers.forEach((container) => {
    const readMoreLabel = container.dataset.readmoreLabel || "Read more";
    const readLessLabel = container.dataset.readlessLabel || "Read less";

    const originalText = container.textContent.trim();

    if (originalText.length <= charLimit) return;

    let cutoffIndex = originalText.lastIndexOf(" ", charLimit);
    if (cutoffIndex === -1) cutoffIndex = charLimit;

    const visibleText = originalText.slice(0, cutoffIndex);
    const hiddenText = originalText.slice(cutoffIndex);

    const visibleSpan = `<span class="readmore-visible">${visibleText}</span>`;
    const hiddenSpan = `<span class="readmore-hidden" style="display:none;">${hiddenText}</span>`;
    const toggleBtn = `<span class="readmore-toggle" style="cursor:pointer; color:#0073aa; text-decoration:underline;">${readMoreLabel}</span>`;

    container.innerHTML = `${visibleSpan}${hiddenSpan}${toggleBtn}`;

    const toggle = container.querySelector(".readmore-toggle");
    const hidden = container.querySelector(".readmore-hidden");

    toggle.addEventListener("click", function () {
      const isHidden = hidden.style.display === "none";

      hidden.style.display = isHidden ? "inline" : "none";
      toggle.textContent = isHidden ? ` ${readLessLabel}` : ` ${readMoreLabel}`;
    });
  });
  /* end */

  /* Single post scroll bar */
  document.addEventListener("scroll", function () {
    const scrollBar = document.getElementById("scrollProgressBar");
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;
    const scrolled = (scrollTop / docHeight) * 100;
    scrollBar.style.width = scrolled + "%";
  });
  /* end */
});

/* Wishlist button name changing */
if (document.documentElement.lang === "lt-LT") {
  document.querySelectorAll(".add_to_cart_button").forEach(function (button) {
    button.textContent = "Dėti į krepšelį";
  });
}
/* end */

/* Mobile header */
const toggles = document.querySelectorAll(".mobile-toggle");

toggles.forEach(function (toggle) {
  toggle.addEventListener("click", function () {
    const target = document.querySelector(toggle.getAttribute("data-target"));
    if (target) {
      const isActive = target.classList.contains("active");

      document.querySelectorAll(".mobile-menu__dropdown").forEach((menu) => {
        menu.classList.remove("active");
      });

      document.body.classList.remove("menu-open");

      if (!isActive) {
        target.classList.add("active");
        document.body.classList.add("menu-open");
      }

      toggle.classList.toggle("open", !isActive);
    }
  });
});

document
  .querySelectorAll(".mobile-nav-menu li.menu-item-has-children")
  .forEach((item) => {
    const link = item.querySelector("a");
    const subMenu = item.querySelector(".sub-menu");

    if (link && subMenu) {
      const toggleBtn = document.createElement("button");
      toggleBtn.setAttribute("aria-expanded", "false");
      toggleBtn.setAttribute("aria-label", "Toggle submenu");
      toggleBtn.classList.add("submenu-toggle");
      toggleBtn.innerHTML =
        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 8.98332L3.5 5.48332L4.31667 4.66666L7 7.34999L9.68333 4.66666L10.5 5.48332L7 8.98332Z" fill="black"></path></svg>';

      link.after(toggleBtn);

      toggleBtn.addEventListener("click", function (e) {
        e.preventDefault();
        item.classList.toggle("submenu-open");

        const isExpanded = toggleBtn.getAttribute("aria-expanded") === "true";
        toggleBtn.setAttribute("aria-expanded", String(!isExpanded));
      });
    }
  });

const searchInput = document.getElementById("mobile-search");
const clearBtn = document.querySelector(".clear-input");

if (searchInput && clearBtn) {
  searchInput.addEventListener("input", () => {
    clearBtn.style.display = searchInput.value.trim() ? "block" : "none";
  });

  clearBtn.addEventListener("click", () => {
    searchInput.value = "";
    clearBtn.style.display = "none";

    const resultsBox = document.getElementById("mobile-search-results");
    if (resultsBox) resultsBox.innerHTML = "";

    searchInput.focus();
  });

  clearBtn.style.display = searchInput.value.trim() ? "block" : "none";
}
/* end  */

/* Subscribe form */
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get("nm") === "confirmed") {
  const fullLang = document.documentElement.lang || "en";
  const lang = fullLang.split("-")[0];

  const messages = {
    en: "Your subscription has been confirmed.",
    lt: "Jūsų prenumerata buvo patvirtinta.",
  };

  const translatedText = messages[lang] || messages.en;

  const wrapper = document.createElement("div");
  wrapper.className = "custom-success-msg";
  wrapper.innerHTML = `
            <span class="close-btn" aria-label="Close message">&times;</span>
            <p>${translatedText}</p>
        `;
  document.body.appendChild(wrapper);

  const timer = setTimeout(() => {
    wrapper.classList.add("hide");
  }, 300000);

  wrapper.querySelector(".close-btn").addEventListener("click", () => {
    clearTimeout(timer);
    wrapper.classList.add("hide");
  });

  const cleanUrl = window.location.origin + window.location.pathname;
  window.history.replaceState({}, document.title, cleanUrl);
}
/* end */
