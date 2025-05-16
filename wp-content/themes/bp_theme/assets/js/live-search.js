const setups = [
  {
    input: document.getElementById("live-search"),
    resultsBox: document.getElementById("live-search-results"),
  },
  {
    input: document.getElementById("mobile-search"),
    resultsBox: document.getElementById("mobile-search-results"),
  },
];

setups.forEach(({ input, resultsBox }) => {
  if (!input || !resultsBox) return;

  input.addEventListener("input", function () {
    const keyword = this.value.trim();

    if (keyword.length < 2) {
      resultsBox.innerHTML = "";
      return;
    }

    fetch(
      `/wp-admin/admin-ajax.php?action=live_search&q=${encodeURIComponent(
        keyword
      )}`
    )
      .then((res) => res.json())
      .then((data) => {
        if (!data) return;

        let html = "";
        let totalResults = data.products.length + data.categories.length;

        if (totalResults > 0) {
          html += `<div class="search-summary">${resultsBox.dataset.foundText.replace(
            "%s",
            data.total_found
          )}</div>`;
        }

        if (data.products.length > 0) {
          html += "<div class='search-group'>";
          data.products.forEach((p) => {
            html += `<a href="${p.link}" class="search-item">
                        <img src="${p.image}" alt="">
                        <div class="search-item__wrapper">
                          <span class="product-title">${p.title}</span>
                          <span class="price">${p.price}</span>
                        </div>
                      </a>`;
          });
          html += "</div>";
        }

        if (data.categories.length > 0) {
          html += "<div class='search-group__category'>";
          data.categories.forEach((c) => {
            html += `<a href="${c.link}" class="search-item category">${c.name}<span class="pr-category-name">Produkto kategorija</span></a>`;
          });
          html += "</div>";
        }

        if (totalResults > 0 && data.has_more) {
          html += `<div class="search-all"><a href="/?s=${encodeURIComponent(
            keyword
          )}">${resultsBox.dataset.viewAllText}</a></div>`;
        } else if (totalResults === 0) {
          html += `<div class="search-empty">${resultsBox.dataset.noResultsText}</div>`;
        }

        resultsBox.innerHTML = html;
      });
  });

  input.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      const keyword = this.value.trim();
      if (keyword.length >= 2) {
        window.location.href = `/?s=${encodeURIComponent(keyword)}`;
      }
    }
  });

  document.addEventListener("click", (e) => {
    if (!resultsBox.contains(e.target) && e.target !== input) {
      resultsBox.innerHTML = "";
    }
  });
});
