---
applyTo: "../laravel-project/**"
---

# Core PHP to Laravel migration

- This is a parallel migration in `../laravel-project/` (public root) with the private app in `../laravel-project/main/`. Keep the current Core PHP site at this repo's root working and unchanged until cutover is approved.
- Work on the user-created `feature/core-php-to-laravel` branch. Do not switch to `main`, merge, or push without the user's direction.
- Runtime: local XAMPP PHP is **8.2.12** (`D:\xampp\php\php.exe`), so the app is **Laravel 12** (`php ^8.2`). Laravel 13 needs PHP 8.3. Laravel 12 security fixes end 2027-02-24; raise this tradeoff before any production deployment. Composer is not installed globally; use a temporary `composer.phar` outside the project. Do not change the host PHP without approval.
- Status: Phases 1–4 done (scaffold, layout/routes/service data, page content, tests). Phase 5 (cutover) is not started and needs explicit user approval.
- Keep the implementation lightweight: Laravel routing, controllers where useful, Blade, validation, and CSRF protection. The user has since approved a MySQL database and a custom admin panel at `/ktgadmin` (see AGENTS.md, "Dynamic site and admin panel"). Do not add Livewire, Inertia, an admin/auth package, a frontend build stack, or other packages unless requirements change and the user approves.
- Keep the existing site's page content and visual design. Site assets live in `../laravel-project/assets/`; do not redesign or remove the Core PHP originals.
- Use the shared Blade layout (`resources/views/layout.blade.php`). Page content lives in `resources/views/pages/`; services, banners, appraisal pages, testimonials and company settings now live in MySQL and are read through `App\Support\SiteData` (the old `config/site.php` is gone).
- Preserve the current URL behavior with Laravel routes and compatibility redirects:
  - `index.php` -> `/` (served by the front controller)
  - `about.php` -> `/about`
  - `services.php` -> `/services`
  - `service-detail.php?service={slug}` -> `/services/{slug}` for `regulatory`, `assaying`, `acquisition`, `auction`, and `monetization`
  - `contact.php` -> `/contact`
  - `antique-appraisals.php` -> `/appraisals`
  - `appraisal-terms.php` -> `/appraisals/terms`
  - `appraisal-procedure.php` -> `/appraisals/procedure`
  - `appraisal-fees.php` -> `/appraisals/fees`
- Restrict service routes to known slugs and return a real 404 for unknown slugs. Let Blade escape output; validate any future request input at the boundary.
- The current contact page has no form, and its displayed address, phone, email, and map location are sample information. Do not invent real contact data or implement form submission/email without user requirements. About-page testimonials are illustrative and must not be presented as verified.
- Keep `.env`, secrets, generated keys, and `vendor/` out of version control. Commit `composer.json` and `composer.lock` when dependencies change; do not add packages that are not needed.
- The web document root is `laravel-project/` (not `main/`). `main/.htaccess` must keep `Require all denied`. Do not change the existing XAMPP vhost, hosts file, or production document root without approval.
- Validate with `php artisan test`, `route:list`, route and 404 tests, legacy-URL redirect checks, asset checks, and desktop/mobile browser checks (browser checks still pending). Run only tools provided by the scaffold or already approved.
