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

const testimonialCarousel = document.querySelector("[data-testimonial-carousel]");

if (testimonialCarousel) {
    const track = testimonialCarousel.querySelector(".about-testimonials__track");
    const slides = Array.from(testimonialCarousel.querySelectorAll(".about-testimonial"));

    if (track && slides.length > 1) {
        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
        let autoplayTimer = null;
        let pointerInside = false;
        let focusInside = false;

        const stopAutoplay = () => {
            if (autoplayTimer !== null) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        };

        const startAutoplay = () => {
            if (
                autoplayTimer !== null ||
                prefersReducedMotion.matches ||
                document.hidden ||
                pointerInside ||
                focusInside
            ) {
                return;
            }

            autoplayTimer = window.setInterval(advanceSlide, 6500);
        };

        const updateSlideLabels = () => {
            Array.from(track.children).forEach((slide, index) => {
                slide.setAttribute("aria-label", `Testimonial ${index + 1} of ${slides.length}`);
            });
        };

        const advanceSlide = () => {
            const firstSlide = track.firstElementChild;
            if (!firstSlide) {
                return;
            }

            const gap = Number.parseFloat(window.getComputedStyle(track).columnGap) || 0;
            const distance = firstSlide.getBoundingClientRect().width + gap;
            let completed = false;

            const finishTransition = () => {
                if (completed) {
                    return;
                }

                completed = true;
                window.clearTimeout(fallbackTimer);
                track.removeEventListener("transitionend", handleTransitionEnd);
                track.style.transition = "none";
                track.append(firstSlide);
                track.style.transform = "translateX(0)";
                track.getBoundingClientRect();
                track.style.transition = "";
                updateSlideLabels();
            };

            const handleTransitionEnd = (event) => {
                if (event.target === track && event.propertyName === "transform") {
                    finishTransition();
                }
            };

            track.addEventListener("transitionend", handleTransitionEnd);
            track.style.transform = `translateX(-${distance}px)`;
            const fallbackTimer = window.setTimeout(finishTransition, 750);
        };

        testimonialCarousel.addEventListener("pointerenter", () => {
            pointerInside = true;
            stopAutoplay();
        });

        testimonialCarousel.addEventListener("pointerleave", () => {
            pointerInside = false;
            startAutoplay();
        });

        testimonialCarousel.addEventListener("focusin", () => {
            focusInside = true;
            stopAutoplay();
        });

        testimonialCarousel.addEventListener("focusout", (event) => {
            if (!testimonialCarousel.contains(event.relatedTarget)) {
                focusInside = false;
                startAutoplay();
            }
        });

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
