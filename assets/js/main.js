const siteHeader = document.querySelector(".site-header");
const menuToggle = document.querySelector(".menu-toggle");
const primaryNavigation = document.querySelector("#primary-navigation");

if (siteHeader && menuToggle && primaryNavigation) {
    const closeMenu = () => {
        siteHeader.classList.remove("is-open");
        menuToggle.setAttribute("aria-expanded", "false");
    };

    const acquisitionDropdown = primaryNavigation.querySelector(".nav-dropdown");
    if (acquisitionDropdown) {
        const supportsHover = window.matchMedia("(hover: hover) and (pointer: fine)");

        acquisitionDropdown.addEventListener("pointerenter", (event) => {
            if (supportsHover.matches && event.pointerType !== "touch") {
                acquisitionDropdown.open = true;
            }
        });

        acquisitionDropdown.addEventListener("pointerleave", () => {
            if (supportsHover.matches && !acquisitionDropdown.contains(document.activeElement)) {
                acquisitionDropdown.open = false;
            }
        });
    }

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

const carousels = document.querySelectorAll("[data-carousel]");

carousels.forEach((carousel) => {
    const slides = Array.from(carousel.querySelectorAll("[data-carousel-slide]"));
    const previousButton = carousel.querySelector("[data-carousel-prev]");
    const nextButton = carousel.querySelector("[data-carousel-next]");
    const toggleButton = carousel.querySelector("[data-carousel-toggle]");
    const status = carousel.querySelector("[data-carousel-status]");
    let activeIndex = slides.findIndex((slide) => !slide.hidden);

    if (slides.length > 1 && previousButton && nextButton && status) {
        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
        let autoplayTimer = null;
        let userPaused = false;

        const updateToggleButton = () => {
            if (!toggleButton) {
                return;
            }

            toggleButton.hidden = prefersReducedMotion.matches;
            toggleButton.textContent = userPaused ? "Play" : "Pause";
            toggleButton.setAttribute("aria-label", `${userPaused ? "Resume" : "Pause"} automatic slide rotation`);
        };

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
            updateToggleButton();
        };

        const startAutoplay = () => {
            if (autoplayTimer !== null || userPaused) {
                return;
            }
            if (prefersReducedMotion.matches || document.hidden) {
                status.setAttribute("aria-live", "polite");
                updateToggleButton();
                return;
            }
            autoplayTimer = window.setInterval(() => showSlide(activeIndex + 1), 6500);
            status.setAttribute("aria-live", "off");
            updateToggleButton();
        };

        previousButton.addEventListener("click", () => showSlide(activeIndex - 1, true));
        nextButton.addEventListener("click", () => showSlide(activeIndex + 1, true));
        if (toggleButton) {
            toggleButton.addEventListener("click", () => {
                userPaused = !userPaused;
                if (userPaused) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
                updateToggleButton();
            });
        }
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
});
