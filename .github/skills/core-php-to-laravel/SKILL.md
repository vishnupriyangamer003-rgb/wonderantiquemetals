---
name: core-php-to-laravel
description: Safely migrate Wonder Antique Metals from its existing Core PHP pages to a lightweight parallel Laravel app.
---

# Core PHP to Laravel migration skill

## Current state

- Work is on branch `feature/core-php-to-laravel`, based on `main`.
- The existing site is a small, static Core PHP site: root-level page scripts, shared `includes/header.php` and `includes/footer.php`, CSS/JS/images under `assets/`, and no database or contact form. It stays intact as the fallback.
- The migration was **reset and restarted from Phase 1**. The parallel app now lives outside this repo at `../laravel-project/`: that folder is the public web root, and `../laravel-project/main/` is the private Laravel 12 app. The old `laravel-app/` was removed.
- Local PHP is 8.2.12 (`D:\xampp\php\php.exe`), so Laravel 12 was chosen (Laravel 13 needs PHP 8.3). Laravel 12 security fixes end 2027-02-24. Ask before changing any PHP runtime or using Laravel 12 for a new production deployment.
- **Phases 1–4 are done. Phase 5 (cutover) is not started and needs explicit user approval.** See the sequence below.

## Goals and constraints

1. Preserve existing page content, shared chrome, responsive design, accessibility, and supplied CSS/JS/images.
2. Use Laravel's built-in route system and Blade. Keep dependencies minimal; do not add Livewire, Inertia, admin/auth packages, a database, or a frontend build stack unless the user asks.
3. Keep service content in a simple config/data structure. There is no current need for persistence or Eloquent models.
4. Preserve old URLs with redirects or equivalent compatibility routes after the Laravel pages are ready.
5. Do not cut over the site's document root, delete legacy files, merge, or push without user approval.
6. Do not invent company contact details or treat illustrative testimonials as verified.

## Migration sequence

### Phase 1 — Fresh scaffold (done)

- Laravel 12.72 created in `../laravel-project/main/`; `../laravel-project/` holds `index.php` (loads `./main`, sets the public path), `.htaccess`, `favicon.ico`, `robots.txt`, and a copy of `assets/`.
- `main/.htaccess` is `Require all denied`. `.env` and `vendor/` stay untracked. `APP_URL=http://wonderantiquemetals.test`.
- Do not install optional starter kits or third-party packages. Do not install Composer globally; use a temporary `composer.phar`.

### Phases 2–3 — Layout, routes, data, content (done)

Shared layout `resources/views/layout.blade.php`, routes in `routes/web.php`, service data in `config/site.php`, the 8 pages in `resources/views/pages/` (text verified identical to the legacy pages), `errors/404.blade.php`, `ServiceController`, `LegacyServiceRedirectController`. Pages map as follows:

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
- Update: the user later approved a MySQL database and an admin panel at `/ktgadmin` (banners, services, appraisals, testimonials, company settings, login details). See AGENTS.md. Public contact form processing and email are still not built.
- Contact details on the existing page are explicitly sample information. Do not publish them as verified business details.
- Testimonials are explicitly illustrative; retain their disclaimer or wait for approved client quotes.
- Do not create contact form processing, mail delivery, or upload handling until the user defines the required behavior.

### Phase 4 — Tests (done)

- `tests/Feature/SiteTest.php` covers every page, service slug, unknown-slug 404, legacy redirects, titles, and internal links. 29 tests pass with `php artisan test` on PHP 8.2.12.

### Phase 5 — Cutover (not started, needs approval)

- Still to check in a browser: asset requests, `main.js` behaviour, desktop/mobile layout, keyboard navigation, reduced-motion behavior, no horizontal overflow, and that `/main/.env` is blocked by Apache.
- Confirm Apache/rewrite support, then set the vhost DocumentRoot to `laravel-project` (not `main`) only in an approved deployment change, with the hosts entry and production `.env` (`APP_DEBUG=false`).
- Stage the new app beside the working Core PHP site. Do not remove legacy pages or cut over until route/browser checks pass and the user approves. Keep a rollback path to the legacy site.

## Completion report

Report the Laravel/PHP versions selected, Composer packages added, route compatibility results, tests run, unresolved placeholder content, and whether the app remains parallel or has an explicitly approved cutover. Do not claim production deployment unless it is confirmed.
