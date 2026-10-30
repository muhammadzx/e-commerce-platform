// NABTA - a few leaves drifting down from the top-left
document.addEventListener("DOMContentLoaded", () => {
    const rand = (a, b) => Math.random() * (b - a) + a;
    const pick = arr => arr[Math.floor(Math.random() * arr.length)];

    /* ---------- A few leaves drifting down from just outside the top-left corner ---------- */
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    const wrap = document.getElementById("leaves");
    if (!wrap) return;

    const palettes = [["#8eb69b", "#235347"], ["#daf1de", "#8eb69b"], ["#8eb69b", "#163832"]];

    function leafImage([light, dark]) {
        const svg =
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 140">` +
            `<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">` +
            `<stop offset="0" stop-color="${light}"/><stop offset="1" stop-color="${dark}"/>` +
            `</linearGradient></defs>` +
            `<path d="M50 4C82 30 94 72 50 136C6 72 18 30 50 4Z" fill="url(#g)"/>` +
            `<path d="M50 10L50 136M50 50L30 34M50 50L70 34M50 80L26 60M50 80L74 60" ` +
            `stroke="rgba(5,31,32,0.35)" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>`;
        return `url("data:image/svg+xml;utf8,${encodeURIComponent(svg)}")`;
    }

    // Each time a leaf finishes falling it restarts from a new spot near the top-left
    function place(leaf) {
        leaf.style.setProperty("--x", rand(0, 40).toFixed(0) + "vw");
        leaf.style.setProperty("--y", rand(-14, 4).toFixed(0) + "vh");
        leaf.style.setProperty("--dx", rand(80, 280).toFixed(0) + "px"); // gentle breeze to the right
        leaf.style.setProperty("--fall", rand(18, 30).toFixed(1) + "s");
    }

    const count = window.innerWidth < 700 ? 5 : 8;

    for (let i = 0; i < count; i++) {
        const leaf = document.createElement("div");
        leaf.className = "leaf";
        leaf.style.setProperty("--s", rand(14, 26).toFixed(0) + "px");
        leaf.style.setProperty("--sway", rand(3, 5).toFixed(1) + "s");
        leaf.style.setProperty("--delay", (-rand(0, 20)).toFixed(1) + "s");
        place(leaf);

        const inner = document.createElement("i");
        inner.style.setProperty("--img", leafImage(pick(palettes)));
        leaf.appendChild(inner);

        leaf.addEventListener("animationiteration", e => {
            if (e.animationName === "leaf-fall") place(leaf);
        });

        wrap.appendChild(leaf);
    }
});