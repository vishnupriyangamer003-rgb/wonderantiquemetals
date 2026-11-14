---
applyTo: "laravel-app/**"
---

# Core PHP to Laravel migration

- This is a parallel migration in `laravel-app/`; keep the current Core PHP site at the project root working and unchanged until cutover is approved.
- Work on the user-created `feature/core-php-to-laravel` branch. Do not switch to `main`, merge, or push without the user's direction.
- Migration is on hold until the user confirms the target hosting PHP version. The local XAMPP CLI is PHP 8.2.12, Composer is not installed, and no Laravel app or Composer manifest exists yet. Do not scaffold Laravel, install Composer/dependencies, or change the host runtime before that confirmation.
- Select a Laravel major supported by the confirmed runtime and deployment support window. Laravel 13 requires PHP 8.3 or newer; Laravel 12 supports PHP 8.2 but its security-fix window ends February 24, 2027. Explain this tradeoff and ask before choosing Laravel 12 for a new production deployment.
- Keep the implementation lightweight: use Laravel's built-in routing, controllers where useful, Blade, validation, and CSRF protection. Do not add Livewire, Inertia, an admin panel, authentication, a database, or other packages unless requirements change and the user approves.
- Keep the existing site's page content and visual design. Copy the existing `assets/` into `laravel-app/public/assets/`; do not redesign, relocate, or remove the Core PHP originals during migration.
- Use a shared Blade layout for header, navigation, footer, and metadata. Keep page-specific content in Blade views and stable service definitions in a small config file or similarly simple data structure. No database is currently needed.
- Preserve the current URL behavior with Laravel routes and compatibility redirects:
  - `index.php` -> `/`
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
- Keep `.env`, secrets, generated keys, and `vendor/` out of version control. Commit `composer.json` and `composer.lock` when dependencies are introduced; do not add packages that are not needed.
- Configure and verify the eventual web document root as `laravel-app/public`; do not change the existing XAMPP vhost or production document root without approval.
- Validate the migrated app with the available Composer checks, Laravel test runner, PHP syntax checks, route and 404 tests, asset checks, old-URL compatibility checks, and desktop/mobile browser checks. Run only tools provided by the scaffold or already approved; do not add tooling just for coverage.
