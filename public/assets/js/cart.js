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
    var selectionsModal = document.getElementById("checkout-selections-details");
    if (selectionsModal) selectionsModal.addEventListener("click", async function (event) {
        var button = event.target.closest("[data-remove-checkout-item]");
        if (!button || button.disabled) return;
        var error = document.getElementById("checkout-remove-error");
        error.textContent = "";
        var buttons = [...selectionsModal.querySelectorAll("[data-remove-checkout-item]")];
        buttons.forEach(function (item) { item.disabled = true; });
        var nextIndex = buttons.indexOf(button);
        var body = new FormData();
        body.set("csrf_token", window.NABTA_CSRF || "");
        body.set("cart_item_id", button.dataset.removeCheckoutItem);
        try {
            var response = await fetch(apiUrl("cart-remove"), { method: "POST", body: body, credentials: "same-origin" });
            var data = await response.json();
            if (data.login) { window.location.href = base + "/login.php"; return; }
            if (!response.ok || !data.success) throw new Error(data.message || "Could not remove this item. Please try again.");
            if (!Array.isArray(data.item_ids) || !Number.isFinite(data.subtotal) || !Number.isFinite(data.count)) throw new Error("Please refresh to see your updated basket.");
            setCount(data.count);
            if (!data.item_ids.length) { window.location.href = base + "/index.php?page=cart"; return; }
            document.querySelectorAll("[data-checkout-item]").forEach(function (row) {
                if (!data.item_ids.includes(Number(row.dataset.checkoutItem))) row.remove();
            });
            var rows = [...selectionsModal.querySelectorAll(".cx-pick")];
            var preview = document.querySelector(".checkout-selections");
            preview.querySelectorAll(".cx-pick").forEach(function (row) { row.remove(); });
            var more = preview.querySelector(".checkout-selections-more");
            rows.slice(0, 3).forEach(function (row) {
                var clone = row.cloneNode(true);
                clone.querySelector(".checkout-remove-item")?.remove();
                preview.insertBefore(clone, more);
            });
            more.hidden = rows.length <= 3;
            more.textContent = "See more (+" + Math.max(0, rows.length - 3) + ")";
            document.getElementById("checkout-selections-title").textContent = "All your selections (" + rows.length + ")";
            document.querySelectorAll("[data-checkout-subtotal]").forEach(function (el) { el.textContent = data.subtotal.toFixed(2) + " JOD"; });
            document.querySelectorAll("[data-checkout-item-count]").forEach(function (el) { el.textContent = "Subtotal · " + data.count + " item" + (data.count === 1 ? "" : "s"); });
            var remainingButtons = [...selectionsModal.querySelectorAll("[data-remove-checkout-item]")];
            remainingButtons.forEach(function (el) { el.disabled = false; });
            (remainingButtons[Math.min(nextIndex, remainingButtons.length - 1)] || selectionsModal.querySelector(".checkout-selections-close")).focus();
        } catch (exception) {
            error.textContent = exception.message || "We could not update your basket. Please try again.";
        } finally {
            buttons.forEach(function (item) { item.disabled = false; });
        }
    });

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
        if (!form.reportValidity()) return;

        var phone = value("phone");

        if (phone !== "" && !/^[0-9+()\-\s.]{6,20}$/.test(phone)) {
            formError.textContent = "Enter a valid phone number, or leave the field empty.";
            form.elements.phone.setAttribute("aria-invalid", "true");
            form.elements.phone.focus();
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
                    orderError.textContent = data.message || "We could not save your request.";
                    confirmButton.disabled = false;
                    return;
                }

                document.getElementById("review-content").hidden = true;
                document.getElementById("review-success").hidden = false;
                document.getElementById("success-text").textContent =
                    "Your order #" + data.order_id + " is saved as a pending confirmation request. Delivery costs and payment arrangements still need your approval. No payment has been taken.";
                setStep(3);
                setCount(0);
            })
            .catch(function () {
                orderError.textContent = "We could not reach the shop. Please try again.";
                confirmButton.disabled = false;
            });
    });
})();
