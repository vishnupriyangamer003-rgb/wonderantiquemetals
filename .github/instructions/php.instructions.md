---
applyTo: "**/*.php"
---

# PHP changes

- Read the surrounding code and identify the project's PHP version, framework, and conventions before editing.
- Keep changes focused and preserve existing behavior outside the requested change.
- Preserve the existing core PHP structure: keep the entry point at the project root, shared PHP templates in `includes/`, styles in `assets/css/`, scripts in `assets/js/`, and the brand logo and other images in `assets/images/` (not in the project root). Add or update files in the closest existing location; do not move, rename, or create a competing structure unless requested.
- Reuse existing framework and plugin APIs. Do not edit third-party or vendor plugin code unless explicitly requested.
- Do not add a package, plugin, or dependency unless the user asks for it or the change requires it.
- Validate and escape data at the appropriate boundaries, and use the project's established error handling.
- Run the smallest relevant test, lint, or syntax check available after changes.
