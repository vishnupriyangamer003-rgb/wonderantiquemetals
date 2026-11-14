const sitePreloader = document.querySelector("[data-site-preloader]");
const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

if (sitePreloader && !prefersReducedMotion.matches) {
    const minimumDisplayTime = 600;
    const startedAt = performance.now();
    let dismissalScheduled = false;

    const dismissPreloader = () => {
        if (dismissalScheduled) {
            return;
        }

        dismissalScheduled = true;
        const remainingTime = Math.max(0, minimumDisplayTime - (performance.now() - startedAt));

        window.setTimeout(() => {
            document.documentElement.classList.remove("is-preloading");
            sitePreloader.classList.add("is-hiding");
            window.setTimeout(() => sitePreloader.remove(), 500);
        }, remainingTime);
    };

    document.documentElement.classList.add("is-preloading");
    if (document.readyState === "complete") {
        dismissPreloader();
    } else {
        window.addEventListener("load", dismissPreloader, { once: true });
    }
    window.setTimeout(dismissPreloader, 2500);
}

const siteHeader = document.querySelector(".site-header");
const menuToggle = document.querySelector(".menu-toggle");
const primaryNavigation = document.querySelector("#primary-navigation");

if (siteHeader && menuToggle && primaryNavigation) {
    const closeMenu = () => {
        siteHeader.classList.remove("is-open");
        menuToggle.setAttribute("aria-expanded", "false");
    };

    const navigationDropdowns = primaryNavigation.querySelectorAll(".nav-dropdown");
    const supportsHover = window.matchMedia("(hover: hover) and (pointer: fine)");

    navigationDropdowns.forEach((dropdown) => {
        dropdown.addEventListener("pointerenter", (event) => {
            if (supportsHover.matches && event.pointerType !== "touch") {
                dropdown.open = true;
            }
        });

        dropdown.addEventListener("pointerleave", () => {
            if (supportsHover.matches && !dropdown.contains(document.activeElement)) {
                dropdown.open = false;
            }
        });
    });

    menuToggle.addEventListener("click", () => {
        const isOpen = menuToggle.getAttribute("aria-expanded") === "true";
        siteHeader.classList.toggle("is-open", !isOpen);
        menuToggle.setAttribute("aria-expanded", String(!isOpen));
    });

    primaryNavigation.addEventListener("click", (event) => {
        if (event.target instanceof Element && event.target.closest("a")) {
            closeMenu();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeMenu();
        }
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 700) {
            closeMenu();
        }
    });
}

const carousel = document.querySelector("[data-carousel]");

if (carousel) {
    const slides = Array.from(carousel.querySelectorAll("[data-carousel-slide]"));
    const previousButton = carousel.querySelector("[data-carousel-prev]");
    const nextButton = carousel.querySelector("[data-carousel-next]");
    const status = carousel.querySelector(".home-carousel__status");
    let activeIndex = slides.findIndex((slide) => !slide.hidden);

    if (slides.length > 1 && previousButton && nextButton && status) {
        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
        let autoplayTimer = null;

        const showSlide = (index, announce = false) => {
            activeIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.hidden = slideIndex !== activeIndex;
            });
            status.setAttribute("aria-live", announce || autoplayTimer === null ? "polite" : "off");
            status.textContent = `${String(activeIndex + 1).padStart(2, "0")} / ${String(slides.length).padStart(2, "0")}`;
        };

        const stopAutoplay = () => {
            if (autoplayTimer !== null) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
            status.setAttribute("aria-live", "polite");
        };

        const startAutoplay = () => {
            if (autoplayTimer !== null) {
                return;
            }
            if (prefersReducedMotion.matches || document.hidden) {
                status.setAttribute("aria-live", "polite");
                return;
            }
            autoplayTimer = window.setInterval(() => showSlide(activeIndex + 1), 6500);
            status.setAttribute("aria-live", "off");
        };

        previousButton.addEventListener("click", () => showSlide(activeIndex - 1, true));
        nextButton.addEventListener("click", () => showSlide(activeIndex + 1, true));
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });

        if (typeof prefersReducedMotion.addEventListener === "function") {
            prefersReducedMotion.addEventListener("change", (event) => {
                if (event.matches) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
            });
        }

        startAutoplay();
    }
}
