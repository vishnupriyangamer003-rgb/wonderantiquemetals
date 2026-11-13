const siteHeader = document.querySelector(".site-header");
const menuToggle = document.querySelector(".menu-toggle");
const primaryNavigation = document.querySelector("#primary-navigation");

if (siteHeader && menuToggle && primaryNavigation) {
    const closeMenu = () => {
        siteHeader.classList.remove("is-open");
        menuToggle.setAttribute("aria-expanded", "false");
    };

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
    const toggleButton = carousel.querySelector("[data-carousel-toggle]");
    const toggleIcon = toggleButton && toggleButton.querySelector("[aria-hidden='true']");
    const status = carousel.querySelector(".home-carousel__status");
    let activeIndex = slides.findIndex((slide) => !slide.hidden);

    if (slides.length > 1 && previousButton && nextButton && toggleButton && toggleIcon && status) {
        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
        let autoplayTimer = null;

        const updateControls = () => {
            const isPlaying = autoplayTimer !== null;
            toggleButton.setAttribute("aria-label", isPlaying ? "Pause slideshow" : "Play slideshow");
            toggleIcon.textContent = isPlaying ? "Ⅱ" : "▶";
            status.setAttribute("aria-live", isPlaying ? "off" : "polite");
        };

        const showSlide = (index) => {
            activeIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.hidden = slideIndex !== activeIndex;
            });
            status.textContent = `${String(activeIndex + 1).padStart(2, "0")} / ${String(slides.length).padStart(2, "0")}`;
        };

        const stopAutoplay = () => {
            if (autoplayTimer !== null) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
            updateControls();
        };

        const startAutoplay = (userInitiated = false) => {
            if (autoplayTimer !== null || (prefersReducedMotion.matches && !userInitiated)) {
                return;
            }
            autoplayTimer = window.setInterval(() => showSlide(activeIndex + 1), 6500);
            updateControls();
        };

        previousButton.addEventListener("click", () => {
            stopAutoplay();
            showSlide(activeIndex - 1);
        });
        nextButton.addEventListener("click", () => {
            stopAutoplay();
            showSlide(activeIndex + 1);
        });
        toggleButton.addEventListener("click", () => {
            if (autoplayTimer === null) {
                startAutoplay(true);
            } else {
                stopAutoplay();
            }
        });
        carousel.addEventListener("pointerenter", stopAutoplay);
        carousel.addEventListener("focusin", (event) => {
            if (event.target !== toggleButton) {
                stopAutoplay();
            }
        });
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                stopAutoplay();
            }
        });

        if (typeof prefersReducedMotion.addEventListener === "function") {
            prefersReducedMotion.addEventListener("change", (event) => {
                if (event.matches) {
                    stopAutoplay();
                }
            });
        }

        updateControls();
        startAutoplay();
    }
}
