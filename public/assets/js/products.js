const publicBasePath = window.NABTA_PUBLIC_URL || "";


document.addEventListener("DOMContentLoaded", async () => {

    // ==========================================
    // SHOP ALL PAGE
    // ==========================================

    const container = document.getElementById("products-container");
    const countEl = document.getElementById("product-count");
    const searchInput = document.getElementById("product-search");
    const categorySelect = document.getElementById("category-filter");
    const sortSelect = document.getElementById("sort-filter");

    // Only run Shop All functionality on the Shop All page
    if (
        container &&
        searchInput &&
        categorySelect &&
        sortSelect
    ) {

        let pagination = document.getElementById("pagination");

        if (!pagination) {
            pagination = document.createElement("nav");
            pagination.id = "pagination";
            pagination.className = "pagination";
            pagination.setAttribute("aria-label", "Pagination");
            container.after(pagination);
        }

        let currentPage = 1;
        let totalPages = 0;
        let requestController = null;
        let searchTimer = null;

        // ==========================================
        // SHOW MESSAGE
        // ==========================================

        function showMessage(text) {
            container.innerHTML = "";

            const msg = document.createElement("p");
            msg.textContent = text;
            msg.style.gridColumn = "1 / -1";
            msg.style.textAlign = "center";

            container.appendChild(msg);
        }

        // ==========================================
        // PRODUCT CARD
        // ==========================================

        function buildCard(product) {
            const card = document.createElement("article");
            card.className = "product-card";

            const imageWrap = document.createElement("a");
            imageWrap.className = "product-image";
            imageWrap.href =
                `index.php?page=product&id=${encodeURIComponent(product.pro_id)}`;

            const image = document.createElement("img");

            if (product.image_url) {
                image.src = product.image_url.startsWith("http")
                    ? product.image_url
                    : "assets/img/" + product.image_url;
            }

            image.alt = product.name;
            image.loading = "lazy";

            imageWrap.appendChild(image);

            // Stock badge
            if (product.quantity !== undefined) {
                const badge = document.createElement("span");
                badge.className = "stock-badge";

                badge.textContent = Number(product.quantity) > 0
                    ? "In stock"
                    : "Out of stock";

                imageWrap.appendChild(badge);
            }




            
 // ==========================================
 // WISHLIST HEART BUTTON
 // ==========================================

const wishlistButton = document.createElement("button");

wishlistButton.type = "button";
wishlistButton.className = "wishlist-heart";
wishlistButton.dataset.productId = product.pro_id;

wishlistButton.setAttribute(
    "aria-label",
    `Add ${product.name} to wishlist`
);

wishlistButton.setAttribute("aria-pressed", "false");

wishlistButton.innerHTML = `
    <svg viewBox="0 0 24 24"
         width="22"
         height="22"
         fill="none"
         stroke="currentColor"
         stroke-width="1.8"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/>
    </svg>
`;

card.appendChild(wishlistButton);






            const info = document.createElement("div");
            info.className = "product-info";

            const name = document.createElement("h3");
            const nameLink = document.createElement("a");

            nameLink.href =
                `index.php?page=product&id=${encodeURIComponent(product.pro_id)}`;

            nameLink.textContent = product.name;
            name.appendChild(nameLink);

            const price = document.createElement("p");
            price.className = "product-price";
            price.textContent =
                `${Number(product.price).toFixed(2)} JOD`;

            const description = document.createElement("p");
            description.className = "product-category";
            description.textContent = product.description || "";

            info.append(name, price, description);
            card.append(imageWrap, info);

            return card;
        }

        // ==========================================
        // PAGINATION BUTTON
        // ==========================================

        function pageButton(
            label,
            page,
            { active = false, disabled = false, aria = "" } = {}
        ) {
            const btn = document.createElement("button");

            btn.type = "button";
            btn.className = "page-btn" + (active ? " active" : "");
            btn.textContent = label;
            btn.disabled = disabled;

            if (active) {
                btn.setAttribute("aria-current", "page");
            }

            if (aria) {
                btn.setAttribute("aria-label", aria);
            }

            btn.addEventListener("click", () => goToPage(page));

            return btn;
        }

        // ==========================================
        // RENDER PAGINATION
        // ==========================================

        function renderPagination() {
            pagination.innerHTML = "";

            if (totalPages <= 1) return;

            pagination.appendChild(
                pageButton("‹ Prev", currentPage - 1, {
                    disabled: currentPage === 1,
                    aria: "Previous page"
                })
            );

            const pages = new Set([
                1,
                totalPages,
                currentPage - 1,
                currentPage,
                currentPage + 1
            ]);

            let last = 0;

            [...pages]
                .filter(n => n >= 1 && n <= totalPages)
                .sort((a, b) => a - b)
                .forEach(n => {

                    if (n - last > 1) {
                        const dots = document.createElement("span");
                        dots.className = "page-dots";
                        dots.textContent = "…";
                        pagination.appendChild(dots);
                    }

                    pagination.appendChild(
                        pageButton(String(n), n, {
                            active: n === currentPage
                        })
                    );

                    last = n;
                });

            pagination.appendChild(
                pageButton("Next ›", currentPage + 1, {
                    disabled: currentPage === totalPages,
                    aria: "Next page"
                })
            );
        }

        // ==========================================
        // FETCH PRODUCTS FROM API
        // ==========================================

        async function loadProducts(page = 1) {

            // Cancel previous request
            if (requestController) {
                requestController.abort();
            }

            const controller = new AbortController();
            requestController = controller;

            const params = new URLSearchParams({
                api: "products",
                page: String(page),
                search: searchInput.value.trim(),
                category: categorySelect.value,
                sort: sortSelect.value
            });

            try {
                const response = await fetch(
                    `${publicBasePath}/index.php?${params.toString()}`,
                    { signal: controller.signal }
                );

                if (!response.ok) {
                    throw new Error("Failed to load products");
                }

                const data = await response.json();

                if (controller.signal.aborted) return;

                if (!Array.isArray(data.products)) {
                    throw new Error("Invalid products API response");
                }

                currentPage = Number(data.currentPage);
                totalPages = Number(data.totalPages);

                if (countEl) {
                    countEl.textContent =
                        `${data.totalProducts} ${
                            Number(data.totalProducts) === 1
                                ? "product"
                                : "products"
                        }`;
                }

                container.innerHTML = "";

                if (data.products.length === 0) {
                    showMessage("No products match your search.");
                    pagination.innerHTML = "";
                    return;
                }

                const fragment = document.createDocumentFragment();

                data.products.forEach(product => {
                    fragment.appendChild(buildCard(product));
                });

                container.appendChild(fragment);

                renderPagination();

            } catch (error) {

                if (error.name === "AbortError") return;

                console.error(error);
                showMessage("Unable to load products.");
                pagination.innerHTML = "";

                if (countEl) {
                    countEl.textContent = "";
                }

            } finally {

                if (requestController === controller) {
                    requestController = null;
                }
            }
        }

        // ==========================================
        // PAGE NAVIGATION
        // ==========================================

        async function goToPage(page) {

            if (
                page < 1 ||
                page > totalPages ||
                page === currentPage
            ) {
                return;
            }

            await loadProducts(page);

            const top = document.getElementById("shop-area");

            if (top) {
                top.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        }

        // ==========================================
        // FILTERS
        // ==========================================

        function applyFilters() {
            currentPage = 1;
            loadProducts(1);
        }

        // Search
        searchInput.addEventListener("input", () => {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                applyFilters();
            }, 300);
        });

        // Category
        categorySelect.addEventListener("change", applyFilters);

        // Sorting
        sortSelect.addEventListener("change", applyFilters);

        // ==========================================
        // LOAD CATEGORIES
        // ==========================================

        async function populateCategories() {

            try {
                const response = await fetch(
                    `${publicBasePath}/index.php?api=product-categories`
                );

                if (!response.ok) {
                    throw new Error("Failed to load categories");
                }

                const categories = await response.json();

                if (!Array.isArray(categories)) {
                    throw new Error("Invalid categories response");
                }

                categorySelect.innerHTML = "";

                const allOption = document.createElement("option");
                allOption.value = "all";
                allOption.textContent = "All Categories";

                categorySelect.appendChild(allOption);

                categories.forEach(category => {

                    const option = document.createElement("option");

                    option.value = category.name;
                    option.textContent = category.name;

                    categorySelect.appendChild(option);
                });

            } catch (error) {
                console.error("Categories error:", error);
            }
        }

        // ==========================================
        // INITIALIZE SHOP
        // ==========================================

        await populateCategories();
        await loadProducts(1);
    }

    // ==========================================
    // PRODUCT DETAILS IMAGE GALLERY
    // ==========================================

    const mainImage = document.getElementById("main-product-image");
    const thumbnails = document.querySelectorAll(".nd-thumbnail");
    const counter = document.getElementById("image-counter");

    // Only run gallery functionality on Product Details
    if (mainImage && thumbnails.length > 0) {

        thumbnails.forEach((thumbnail) => {

            thumbnail.addEventListener("click", () => {

                // Change the large product image
                mainImage.src = thumbnail.dataset.image;

                // Update active thumbnail
                thumbnails.forEach((item) => {
                    item.classList.remove("active");
                    item.setAttribute("aria-pressed", "false");
                });

                thumbnail.classList.add("active");
                thumbnail.setAttribute("aria-pressed", "true");

                // Update the image counter
                if (counter) {

                    const current = String(
                        thumbnail.dataset.index
                    ).padStart(2, "0");

                    const total = String(
                        thumbnails.length
                    ).padStart(2, "0");

                    counter.textContent = `${current} / ${total}`;
                }
            });
        });
    }

});



// ==========================================
// CUSTOMER REVIEW SUBMISSION
// ==========================================

document.addEventListener("DOMContentLoaded", () => {

    const reviewForm = document.getElementById("review-form");

    // Only run on pages with a review form
    if (!reviewForm) return;

    const message = document.getElementById("review-message");
    const submitButton = reviewForm.querySelector('button[type="submit"]');

    reviewForm.addEventListener("submit", async (event) => {

        event.preventDefault();

        submitButton.disabled = true;
        message.textContent = "Submitting your review...";

        try {
            const response = await fetch(
                `${publicBasePath}/index.php?api=submit-review`,
                {
                    method: "POST",
                    body: new FormData(reviewForm),
                    credentials: "same-origin"
                }
            );

            const data = await response.json();

            if (response.ok && data.success) {

                message.textContent = "Review submitted successfully!";

                const productId = reviewForm.elements["pro_id"].value;

                window.location.href =
                    `${publicBasePath}/index.php?page=product&id=` +
                    encodeURIComponent(productId) +
                    "#reviews";

                window.location.reload();

            } else {

                message.textContent =
                    data.message || "Unable to submit review.";

            }

        } catch (error) {

            console.error("Review submission error:", error);

            message.textContent =
                "Something went wrong. Please try again.";

        } finally {

            submitButton.disabled = false;

        }
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("reviews-modal");
    const openButton = document.getElementById("open-reviews-modal");
    const closeButton = document.getElementById("close-reviews-modal");
    const loadMoreButton = document.getElementById("load-more-reviews");

    if (!modal || !openButton || !closeButton) return;

    const panel = modal.querySelector(".nd-modal-panel");
    const reviews = Array.from(
        modal.querySelectorAll(".nd-modal-review-list .nd-review")
    );

    let visibleCount = 5;
    let previousFocus = null;

    function updateReviews() {
        reviews.forEach((review, index) => {
            review.hidden = index >= visibleCount;
        });

        loadMoreButton.hidden = visibleCount >= reviews.length;
    }

    function openModal() {
        previousFocus = document.activeElement;
        visibleCount = 5;
        updateReviews();

        modal.hidden = false;
        document.body.style.overflow = "hidden";
        panel.focus();
    }

    function closeModal() {
        modal.hidden = true;
        document.body.style.overflow = "";

        if (previousFocus) {
            previousFocus.focus();
        }
    }

    openButton.addEventListener("click", openModal);
    closeButton.addEventListener("click", closeModal);

    modal.querySelector("[data-close-reviews]")
        .addEventListener("click", closeModal);

    loadMoreButton.addEventListener("click", function () {
        visibleCount += 5;
        updateReviews();
    });

    document.addEventListener("keydown", function (event) {
        if (modal.hidden) return;

        if (event.key === "Escape") {
            closeModal();
        }

        if (event.key === "Tab") {
            const focusable = Array.from(
                modal.querySelectorAll(
                    'button:not([hidden]):not([disabled]), a[href], input:not([disabled]), select:not([disabled])'
                )
            ).filter(el => el.getClientRects().length > 0);

            if (!focusable.length) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
});










 // ==========================================
 // ADD TO CART BUTTON
 // ==========================================

document.addEventListener("click", (event) => {

    const button = event.target.closest(".nd-cart[data-product-id]");

    if (!button || button.disabled) return;

    const productId = Number(button.dataset.productId);

    if (!Number.isSafeInteger(productId) || productId <= 0) return;

    document.dispatchEvent(
        new CustomEvent("nabta:add-to-cart", {
            detail: {
                productId,
                quantity: 1
            }
        })
    );

    // Temporary visual feedback
    const originalText = button.innerHTML;

    button.innerHTML = `
        <span>✓ Added to cart </span>
        <span aria-hidden="true">↗</span>
    `;

    button.classList.add("cart-feedback");

    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove("cart-feedback");
        button.disabled = false;
    }, 2000);

    console.log("Add to cart requested:", productId);

});










 // ==========================================
 // WISHLIST HEART - INTEGRATION EVENT
 // ==========================================

document.addEventListener("click", (event) => {

    const button = event.target.closest(".wishlist-heart");

    if (!button) return;

    const productId = Number(button.dataset.productId);

    if (!Number.isSafeInteger(productId) || productId <= 0) {
        console.error("Invalid wishlist product ID");
        return;
    }

    const isActive = button.classList.toggle("active");

    button.setAttribute(
        "aria-pressed",
        String(isActive)
    );

    button.setAttribute(
        "aria-label",
        isActive ? "Remove from wishlist" : "Add to wishlist"
    );

    document.dispatchEvent(
        new CustomEvent("nabta:wishlist-toggle", {
            detail: {
                productId,
                action: isActive ? "add" : "remove"
            }
        })
    );

    console.log("Wishlist request:", {
        productId,
        action: isActive ? "add" : "remove"
    });

});
