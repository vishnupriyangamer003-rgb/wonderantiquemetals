---
name: core-php-to-laravel
description: Safely migrate Wonder Antique Metals from its existing Core PHP pages to a lightweight parallel Laravel app.
---

# Core PHP to Laravel migration skill

## Current state and stop gate

- Work is requested on branch `feature/core-php-to-laravel`, based on the current `main`.
- The existing site is a small, static Core PHP site: root-level page scripts, shared `includes/header.php` and `includes/footer.php`, CSS/JS/images under `assets/`, and no database or contact form.
- The requested layout is a parallel app at `laravel-app/`; leave the current Core PHP site and assets intact as the fallback.
- Migration is currently paused until the user confirms the target hosting PHP version. Local CLI PHP is 8.2.12; Composer is not installed; no Laravel app, `composer.json`, or `composer.lock` has been created.
- Before scaffolding or installing anything, check both the local web-server PHP runtime and the target host PHP version. If either is unknown, stop and ask.
- Laravel 13 requires PHP 8.3+. Laravel 12 supports PHP 8.2, but security fixes end February 24, 2027. Prefer a supported Laravel version with a compatible confirmed runtime; ask before using Laravel 12 for a new production deployment or changing/upgrading any PHP runtime.

## Goals and constraints

1. Preserve existing page content, shared chrome, responsive design, accessibility, and supplied CSS/JS/images.
2. Use Laravel's built-in route system and Blade. Keep dependencies minimal; do not add Livewire, Inertia, admin/auth packages, a database, or a frontend build stack unless the user asks.
3. Keep service content in a simple config/data structure. There is no current need for persistence or Eloquent models.
4. Preserve old URLs with redirects or equivalent compatibility routes after the Laravel pages are ready.
5. Do not cut over the site's document root, delete legacy files, merge, or push without user approval.
6. Do not invent company contact details or treat illustrative testimonials as verified.

## Migration sequence

### 1. Preflight

- Confirm target PHP and extensions on both XAMPP/Apache and the deployment host.
- Confirm Composer availability/version and the intended deployment document root.
- Select the Laravel major only after confirming runtime compatibility and support lifetime.
- Do not install Composer globally or upgrade PHP without approval. Use an approved Composer installation method after the Laravel manifest/scaffold is in scope.

### 2. Scaffold in parallel

- Create a standard Laravel app under `laravel-app/`, never over the current project root.
- Use the Laravel native starter structure only. Do not install optional starter kits or third-party packages.
- Keep `.env`, generated keys, secrets, and `vendor/` untracked; commit the dependency manifest and lock file.
- Copy the existing `assets/` to `laravel-app/public/assets/` without editing the legacy originals.

### 3. Map pages, routes, and shared layout

Create a shared Blade layout for document metadata, preloader, announcement, header/navigation, footer, styles, and scripts. Migrate each page's existing content into focused views:

| Existing Core PHP URL | Laravel URL |
| --- | --- |
| `index.php` | `/` |
| `about.php` | `/about` |
| `services.php` | `/services` |
| `service-detail.php?service={slug}` | `/services/{slug}` |
| `contact.php` | `/contact` |
| `antique-appraisals.php` | `/appraisals` |
| `appraisal-terms.php` | `/appraisals/terms` |
| `appraisal-procedure.php` | `/appraisals/procedure` |
| `appraisal-fees.php` | `/appraisals/fees` |

The allowed service slugs are `regulatory`, `assaying`, `acquisition`, `auction`, and `monetization`. Unknown slugs must return 404. Retain redirects for old `.php` URLs and the `service-detail.php?service=...` query format so existing bookmarks continue to work.

### 4. Handle content and data safely

- Preserve titles, descriptions, text, alt text, image dimensions, links, and semantic structure while converting PHP templates to Blade.
- Let Blade escape dynamic output. Keep route input constrained to the known service keys.
- No database, migrations, authentication, or form handling are needed for the current site.
- Contact details on the existing page are explicitly sample information. Do not publish them as verified business details.
- Testimonials are explicitly illustrative; retain their disclaimer or wait for approved client quotes.
- Do not create contact form processing, mail delivery, or upload handling until the user defines the required behavior.

### 5. Verify, then plan cutover separately

- Run `composer validate`, dependency installation from the committed lock file, PHP lint, and the scaffold's Laravel test runner.
- Add focused tests for every route, service slug and unknown-slug 404, metadata/content essentials, legacy URL redirects, and any request validation actually introduced.
- Check asset requests, desktop/mobile layout, keyboard navigation, reduced-motion behavior, and no horizontal overflow in a browser.
- Confirm Apache/rewrite support and set the target document root to `laravel-app/public` only in an approved deployment change.
- Stage the new app beside the working Core PHP site. Do not remove legacy pages or cut over until route/browser checks pass and the user approves. Keep a rollback path to the legacy site.

## Completion report

Report the Laravel/PHP versions selected, Composer packages added, route compatibility results, tests run, unresolved placeholder content, and whether the app remains parallel or has an explicitly approved cutover. Do not claim production deployment unless it is confirmed.
