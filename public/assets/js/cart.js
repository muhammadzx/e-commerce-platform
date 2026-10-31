// Add to cart, bag icon number and the checkout steps.
(function () {
    "use strict";

    var base = (window.NABTA_PUBLIC_URL || "").replace(/\/$/, "");

    function apiUrl(name) {
        return base + "/index.php?api=" + name;
    }

    // ---------- Bag icon ----------

    function setCount(count) {
        document.querySelectorAll("[data-cart-count]").forEach(function (el) {
            el.textContent = count;
            el.style.display = count > 0 ? "" : "none";
        });
    }

    var toastTimer;

    function toast(message, linkText) {
        var el = document.getElementById("cx-toast");

        if (!el) {
            return;
        }

        el.textContent = message;

        if (linkText) {
            var link = document.createElement("a");
            link.href = base + "/index.php?page=cart";
            link.textContent = linkText;
            el.appendChild(link);
        }

        el.classList.add("is-visible");
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () {
            el.classList.remove("is-visible");
        }, 3500);
    }

    // ---------- Add to cart (product page) ----------

    // Product page button (data-product-id) and collection cards on the home page (data-collection-id)
    document.querySelectorAll(".nd-cart[data-product-id], [data-collection-id]").forEach(function (addButton) {
        addButton.addEventListener("click", function () {
            if (addButton.disabled) {
                return;
            }

            var csrfMeta = document.querySelector('meta[name="cart-csrf"]');
            var body = new FormData();

            if (addButton.dataset.collectionId) {
                body.append("collection_id", addButton.dataset.collectionId);
            } else {
                body.append("pro_id", addButton.dataset.productId);
            }

            body.append("csrf_token", csrfMeta ? csrfMeta.content : "");

            addButton.disabled = true;

            fetch(apiUrl("cart-add"), {
                method: "POST",
                body: body,
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (data.login) {
                        window.location.href = base + "/login.php";
                        return;
                    }

                    if (typeof data.count === "number") {
                        setCount(data.count);
                    }

                    toast(data.message || "Something went wrong.", data.success ? "View basket" : "");
                })
                .catch(function () {
                    toast("We could not reach the shop. Please try again.");
                })
                .then(function () {
                    addButton.disabled = false;
                });
        });
    });

    // ---------- Checkout ----------

    var form = document.getElementById("delivery-form");

    if (!form) {
        return;
    }

    var modal = document.getElementById("review-modal");
    var details = document.getElementById("review-details");
    var formError = document.getElementById("form-error");
    var orderError = document.getElementById("order-error");
    var confirmButton = document.getElementById("review-confirm");

    function setStep(step) {
        document.querySelectorAll(".cx-steps [data-step]").forEach(function (el) {
            el.classList.toggle("is-current", Number(el.dataset.step) === step);
        });
    }

    function value(name) {
        return form.elements[name].value.trim();
    }

    function addDetail(label, text) {
        var row = document.createElement("div");
        var dt = document.createElement("dt");
        var dd = document.createElement("dd");

        dt.textContent = label;
        dd.textContent = text || "Not provided";
        row.appendChild(dt);
        row.appendChild(dd);
        details.appendChild(row);
    }

    function openModal() {
        details.textContent = "";
        addDetail("Name", value("full_name"));
        addDetail("Email", value("email"));
        addDetail("Phone", value("phone"));
        addDetail("Address", [value("street"), value("city"), value("postal_code")].filter(Boolean).join(", "));

        orderError.textContent = "";
        modal.classList.add("is-open");
        setStep(2);
    }

    function closeModal() {
        modal.classList.remove("is-open");
        setStep(1);
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        formError.textContent = "";

        var phone = value("phone");

        if (phone !== "" && !/^[0-9+()\-\s.]{6,30}$/.test(phone)) {
            formError.textContent = "Enter a valid phone number, or leave the field empty.";
            return;
        }

        openModal();
    });

    document.getElementById("review-edit").addEventListener("click", closeModal);

    modal.addEventListener("click", function (event) {
        if (event.target === modal && !confirmButton.disabled) {
            closeModal();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.classList.contains("is-open") && !confirmButton.disabled) {
            closeModal();
        }
    });

    confirmButton.addEventListener("click", function () {
        var body = new FormData(form);
        body.set("csrf_token", window.NABTA_CSRF || "");

        confirmButton.disabled = true;
        orderError.textContent = "";

        fetch(apiUrl("place-order"), {
            method: "POST",
            body: body,
            credentials: "same-origin"
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.login) {
                    window.location.href = base + "/login.php";
                    return;
                }

                if (!data.success) {
                    orderError.textContent = data.message || "We could not place your order.";
                    confirmButton.disabled = false;
                    return;
                }

                document.getElementById("review-content").hidden = true;
                document.getElementById("review-success").hidden = false;
                document.getElementById("success-text").textContent =
                    "Your order #" + data.order_id + " has been placed. We will confirm delivery details with you soon.";
                setStep(3);
                setCount(0);
            })
            .catch(function () {
                orderError.textContent = "We could not reach the shop. Please try again.";
                confirmButton.disabled = false;
            });
    });
})();
