---
name: static-multipage-site
description: Build consistent, accessible static content pages using the project's Core PHP includes and shared assets.
---

# Static multi-page site skill

- Treat this as a content-focused multi-page website. Use Core PHP to assemble pages and shared templates; do not introduce a framework, database, or dynamic backend unless requested.
- Keep each page focused on one topic and follow the existing root-level PHP page structure.
- Reuse `includes/header.php` and `includes/footer.php`; do not duplicate shared page chrome.
- Keep shared styles, scripts, and images in `assets/css/`, `assets/js/`, and `assets/images/`.
- Use same-page anchors for sections on the current page and page-relative links for destinations on other pages. Verify that every navigation link resolves from each page.
- Keep page markup semantic, responsive, keyboard-accessible, and consistent with the shared visual system.
- Run PHP syntax checks and verify navigation and asset paths after adding or changing pages.
