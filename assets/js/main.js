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
    const status = carousel.querySelector(".home-carousel__status");
    let activeIndex = slides.findIndex((slide) => !slide.hidden);

    if (slides.length > 1 && previousButton && nextButton && status) {
        const showSlide = (index) => {
            activeIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.hidden = slideIndex !== activeIndex;
            });
            status.textContent = `${String(activeIndex + 1).padStart(2, "0")} / ${String(slides.length).padStart(2, "0")}`;
        };

        previousButton.addEventListener("click", () => showSlide(activeIndex - 1));
        nextButton.addEventListener("click", () => showSlide(activeIndex + 1));
    }
}
