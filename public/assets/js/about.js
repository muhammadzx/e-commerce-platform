
document.addEventListener("DOMContentLoaded", () => {

    // 1. Reveal sections on scroll
    const revealElements =
        document.querySelectorAll(".reveal");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.12,
            rootMargin: "0px 0px -30px 0px"
        }
    );

    revealElements.forEach((element) => {
        observer.observe(element);
    });

    // 2. Parallax backgrounds
    const layers =
        document.querySelectorAll(".parallax-layer");

    const reducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    );

    let ticking = false;

    function updateParallax() {
        if (reducedMotion.matches) {
            layers.forEach((layer) => {
                layer.style.transform = "";
            });
            ticking = false;
            return;
        }

        const viewportHeight = window.innerHeight;

        layers.forEach((layer) => {
            const section = layer.parentElement;
            const rect = section.getBoundingClientRect();

            // Only animate sections near the viewport
            if (
                rect.bottom < 0 ||
                rect.top > viewportHeight
            ) {
                return;
            }

            const speed =
                parseFloat(layer.dataset.speed) || 0.2;

            const distance =
                (viewportHeight / 2 -
                 (rect.top + rect.height / 2)) * speed;

            layer.style.transform =
                `translate3d(0, ${distance}px, 0)`;
        });

        ticking = false;
    }

    function requestParallaxUpdate() {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(updateParallax);
        }
    }

    window.addEventListener(
        "scroll",
        requestParallaxUpdate,
        { passive: true }
    );

    window.addEventListener(
        "resize",
        requestParallaxUpdate
    );

    reducedMotion.addEventListener(
        "change",
        requestParallaxUpdate
    );

    requestParallaxUpdate();

    // 3. Smooth anchor navigation
    document.querySelectorAll('a[href^="#"]')
        .forEach((link) => {
            link.addEventListener("click", (event) => {
                const target = document.querySelector(
                    link.getAttribute("href")
                );

                if (!target) return;

                event.preventDefault();

                target.scrollIntoView({
                    behavior: reducedMotion.matches
                        ? "instant"
                        : "smooth",
                    block: "start"
                });
            });
        });
});
