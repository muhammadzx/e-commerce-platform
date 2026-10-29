document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById("products-container");
    const countEl = document.getElementById("product-count");
    const searchInput = document.getElementById("product-search");
    const categorySelect = document.getElementById("category-filter");
    const sortSelect = document.getElementById("sort-filter");

    let allProducts = [];

    // Adjust if your API names the field differently (e.g. category_name)
    const getCategory = p => p.category || p.category_name || "";

    function showMessage(text) {
        container.innerHTML = "";
        const msg = document.createElement("p");
        msg.textContent = text;
        msg.style.gridColumn = "1 / -1";
        msg.style.textAlign = "center";
        container.appendChild(msg);
    }

    function buildCard(product) {
        const card = document.createElement("article");
        card.className = "product-card";

        const imageWrap = document.createElement("a");
        imageWrap.className = "product-image";
        imageWrap.href = `index.php?page=product&id=${encodeURIComponent(product.pro_id)}`;

        const image = document.createElement("img");
        if (product.image_url) {
            image.src = product.image_url.startsWith("http")
                ? product.image_url
                : "assets/img/" + product.image_url; // adjust to your real folder
        }
        image.alt = product.name;
        image.loading = "lazy";
        imageWrap.appendChild(image);

      if (product.quantity !== undefined) {
    const badge = document.createElement("span");
    badge.className = "stock-badge";

    badge.textContent = Number(product.quantity) > 0
        ? "In stock"
        : "Out of stock";

    imageWrap.appendChild(badge);
}

        const info = document.createElement("div");
        info.className = "product-info";

       const name = document.createElement("h3");

const nameLink = document.createElement("a");
nameLink.href = `index.php?page=product&id=${encodeURIComponent(product.pro_id)}`;
nameLink.textContent = product.name;

name.appendChild(nameLink);

        const price = document.createElement("p");
        price.className = "product-price";
        price.textContent = `${Number(product.price).toFixed(2)} JOD`;

        const description = document.createElement("p");
        description.className = "product-category";
        description.textContent = product.description || "";

        info.append(name, price, description);
        card.append(imageWrap, info);
        return card;
    }

    function render() {
        const query = searchInput.value.trim().toLowerCase();
        const category = categorySelect.value;
        const sort = sortSelect.value;

        let list = allProducts.filter(p => {
            const matchesSearch =
                !query ||
                (p.name || "").toLowerCase().includes(query) ||
                (p.description || "").toLowerCase().includes(query);
            const matchesCategory =
                category === "all" || getCategory(p) === category;
            return matchesSearch && matchesCategory;
        });

        if (sort === "price-low") {
            list.sort((a, b) => Number(a.price) - Number(b.price));
        } else if (sort === "price-high") {
            list.sort((a, b) => Number(b.price) - Number(a.price));
        } else if (sort === "name") {
            list.sort((a, b) => (a.name || "").localeCompare(b.name || ""));
        }
        // "default" keeps the order returned by the API

        countEl.textContent = `${list.length} ${list.length === 1 ? "product" : "products"}`;

        if (list.length === 0) {
            showMessage("No products match your search.");
            return;
        }

        container.innerHTML = "";
        list.forEach(p => container.appendChild(buildCard(p)));
    }

    function populateCategories() {
        const categories = [...new Set(allProducts.map(getCategory).filter(Boolean))].sort();
        categories.forEach(cat => {
            const option = document.createElement("option");
            option.value = cat;
            option.textContent = cat;
            categorySelect.appendChild(option);
        });
    }

    try {
        const response = await fetch("index.php?api=products");
        if (!response.ok) throw new Error("Failed to load products");

        allProducts = await response.json();

        populateCategories();
        render();

        searchInput.addEventListener("input", render);
        categorySelect.addEventListener("change", render);
        sortSelect.addEventListener("change", render);
    } catch (error) {
        console.error(error);
        countEl.textContent = "";
        showMessage("Unable to load products.");
    }
});