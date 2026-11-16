# AGENTS.md

## What this is

Small static Core PHP multi-page site (root-level `*.php`, served directly by XAMPP) with a **parallel Laravel 12 app in `../laravel-project/`** (outside this repo). The legacy site has no database; the Laravel app uses MySQL (see "Dynamic site and admin panel"). No CI workflows (`.github/` holds only agent instructions and skills). The legacy site is the fallback until cutover is approved.

## Commands

- PHP is **not on PATH**. Use the XAMPP CLI directly: `D:\xampp\php\php.exe` (**PHP 8.2.12**).
- Composer is not installed globally. Download `https://getcomposer.org/composer-stable.phar` to a temp folder (never into the project) and run `D:\xampp\php\php.exe <phar> <args>`.
- Laravel commands run from `../laravel-project/main/`: `php artisan about`, `route:list`, `test`.

## Page structure (Core PHP)

- Each page sets optional `$pageTitle` / `$pageDescription`, then `require_once __DIR__ . '/includes/header.php';` … `require_once __DIR__ . '/includes/footer.php';`. Never duplicate shared header/footer markup.
- `includes/header.php` also outputs `<title>`/meta, the stylesheet, and deferred `assets/js/main.js`. Styles/scripts/images live only in `assets/css/`, `assets/js/`, `assets/images/`.
- `service-detail.php?service={slug}` renders from a `$services` array; allowed slugs: `regulatory`, `assaying`, `acquisition`, `auction`, `monetization`. Unknown slugs set `http_response_code(404)` and show an inline not-found section. Keep that validation when editing.
- Nav links are page-relative (`services.php`, `service-detail.php?service=…`). After touching any page, verify every nav link resolves from each page.

## Laravel migration (reset and restarted; Phases 1–4 done, Phase 5 not started)

Layout (outside this repo, `D:\xampp\htdocs\vichu\wonderantiquemetals\laravel-project\`):

- `laravel-project/` is the **public web root**: `index.php`, `.htaccess`, `assets/`, `favicon.ico`, `robots.txt`. `index.php` loads the app from `./main` and sets the public path to its own folder.
- `laravel-project/main/` is the **private Laravel 12.72 app** (`php ^8.2`). `main/.htaccess` is `Require all denied` so `/main/.env` and `/main/vendor/` are blocked. `.env` and `vendor/` are gitignored; `APP_URL=http://wonderantiquemetals.test`.

Phases:

1. **Done**: fresh Laravel 12 scaffold; the previous unrelated app in `laravel-project/main` was wiped (no backup, by the user's choice) and `project/laravel-app/` was removed. Site `assets/` copied to the public root.
2. **Done**: `resources/views/layout.blade.php` (from `includes/*.php`), `routes/web.php` (8 page routes, `/services/{slug}` constrained to the keys of `config/site.php`, 7 legacy `.php` redirects plus `service-detail.php?service=` — all 302, no closures so `route:cache` works), `ServiceController`, `LegacyServiceRedirectController`, `errors/404.blade.php`. `index.php` has no redirect: the front controller serves it as `/`.
3. **Done**: the 8 page views in `resources/views/pages/` were converted from the legacy `<main>` blocks; visible text was verified identical to the legacy pages. Links use `route()`, images use `asset()`.
4. **Done**: `tests/Feature/SiteTest.php` (29 tests with the scaffold's example tests) pass on PHP 8.2.12.
5. **Not started — needs separate user approval**: Apache vhost with DocumentRoot `laravel-project`, hosts entry `127.0.0.1 wonderantiquemetals.test`, production `.env` (`APP_ENV=production`, `APP_DEBUG=false`). Not yet verified in a browser or through Apache: CSS/JS/images loading, `main.js` behaviour, `/main/.env` being blocked.

### Dynamic site and admin panel (added after Phases 1–4; supersedes "no database / no admin")

The user asked for an editable site, so the Laravel app now has a database and an admin area:

- **Database**: MySQL `wonderantiquemetals` (XAMPP, root without password for local dev; set in `main/.env`). Tables: `admins`, `settings`, `banners`, `services`, `appraisals`, `testimonials`. `config/site.php` was replaced by the `services` table. Seed data lives in `database/seeders/data/site.php` (extracted from the static pages) and `DatabaseSeeder` also creates the first admin from `ADMIN_USERNAME` / `ADMIN_PASSWORD` in `.env`.
- **Public content**: read through `App\Support\SiteData` (cached with `Cache::rememberForever`, flushed on every admin save). `AppServiceProvider` shares `$site`, `$siteServices`, `$siteAppraisals`, `$siteBanners`, `$siteTestimonials` with the layout and page views. Appraisal pages share one view `pages/appraisal.blade.php` (`/appraisals` plus `/appraisals/{slug}`). In `@section('x', $value)` never pass a value that can be `null`: Blade then opens a section buffer instead of setting it.
- **Admin**: login at `/ktgadmin`, then Company info (`/ktgadmin/settings`), Banners, Services, Appraisals, Testimonials, Login details. Controllers in `app/Http/Controllers/Admin/` (shared base `ResourceController`), guarded by `App\Http\Middleware\AdminAuth` (session `admin_id`, no-store headers). Login is rate limited (5 tries/min per user+IP). UI assets: `laravel-project/assets/admin/admin.css` and `admin.js`; views in `resources/views/admin/`.
- **Admin password is stored in plain text by the owner's explicit choice** (so it can be shown with a show/hide eye). Do not "fix" this silently; if asked, switch to `Crypt` (still viewable) or hashing (not viewable).
- **Uploads**: `App\Support\ImageUploader` allows only JPG/PNG/WEBP, max 2 MB, max 6000 px, verifies the real MIME, re-encodes with GD, stores under `laravel-project/assets/uploads/` with a random name; `assets/uploads/.htaccess` blocks script execution. It never deletes files outside `assets/uploads/`.
- **Tests**: 51 tests (`SiteTest`, `AdminTest`) run on an in-memory SQLite database seeded by `TestCase`; they never touch MySQL.

Notes:

- Laravel 12 security fixes end 2027-02-24. Laravel 13 needs PHP 8.3, which is not installed.
- The scaffold ships its own `AGENTS.md`/`CLAUDE.md` guidance in some versions; ignore suggestions to install other PHP versions or `laravel/boost`.
- `git status` in this repo still shows the deleted `laravel-app/` tree. Do not commit, switch branches, or push without the user's direction.
- Keep the root Core PHP site working and unchanged until cutover is explicitly approved.

## Git

- Default branch is `main`. Current checkout is `feature/core-php-to-laravel`; confirm with the user before switching branches or merging.
- Commit only completed, validated changes; never force-push or amend; if the remote has advanced or a conflict blocks a safe push, stop and explain. Source: `.github/instructions/git-workflow.instructions.md`.

## Content rules (from `.github/instructions/`)

- No photo-credit links, captions, or overlays on images — use meaningful `alt` text instead (`images.instructions.md`).
- Service content is paraphrased from https://www.irishmetal.eu — never copy verbatim, never repeat unverifiable claims (licences, office locations, prices/fees). Contact details are sample data and testimonials are illustrative; don't present either as verified, and don't add a contact form or email handling without user requirements.

## Misc

- `project.zip` / `live.zip` in the root are gitignored artifacts; don't commit them or extract them over the tree.
