# AGENTS.md

## What this is

Small static Core PHP multi-page site (root-level `*.php`, served directly by XAMPP) with a **parallel Laravel 13 app being built in `laravel-app/`** (Phase 1 scaffolded 2026-11). No database, no CI workflows (`.github/` holds only agent instructions and skills). The legacy site is the fallback until cutover is approved.

## Commands

- PHP is **not on PATH**. Use the XAMPP CLI directly: `C:\xampp\php\php.exe`.
- Composer is not installed globally; a working `composer.phar` lives at `%LOCALAPPDATA%\Temp\opencode\composer.phar` (re-download from `https://getcomposer.org/composer-stable.phar` if missing): `C:\xampp\php\php.exe <phar> <args>`.
- Local PHP is **8.0.30** (both CLI and Apache). This is below `laravel-app/`'s `php ^8.3` requirement, so **`artisan`, PHPUnit, and Laravel's test runner cannot run locally** — they run on the live host (PHP ≥ 8.3). Local verification = `php -l` + browser checks of the legacy site.
- Local Composer operations inside `laravel-app/` must pass `--ignore-platform-reqs` (platform check would otherwise fail on PHP 8.0.30). `composer validate` works without it.
- `.github/instructions/laravel-migration.instructions.md` claims local PHP is 8.2.12 — that is wrong; verified 8.0.30 at runtime.

## Page structure (Core PHP)

- Each page sets optional `$pageTitle` / `$pageDescription`, then `require_once __DIR__ . '/includes/header.php';` … `require_once __DIR__ . '/includes/footer.php';`. Never duplicate shared header/footer markup.
- `includes/header.php` also outputs `<title>`/meta, the stylesheet, and deferred `assets/js/main.js`. Styles/scripts/images live only in `assets/css/`, `assets/js/`, `assets/images/`.
- `service-detail.php?service={slug}` renders from a `$services` array; allowed slugs: `regulatory`, `assaying`, `acquisition`, `auction`, `monetization`. Unknown slugs set `http_response_code(404)` and show an inline not-found section. Keep that validation when editing.
- Nav links are page-relative (`services.php`, `service-detail.php?service=…`). After touching any page, verify every nav link resolves from each page.

## Laravel migration (Phase 1 done: scaffold)

- `laravel-app/` now holds a stock Laravel **13.11** scaffold (framework 13.42, `php ^8.3`), created with `--no-scripts` (artisan can't run locally), plus a copy of `assets/` in `public/assets/`. `.env` + `APP_KEY` were generated manually; `vendor/` and `.env` are gitignored. Full spec: `.github/skills/core-php-to-laravel/SKILL.md`.
- Remaining phases: shared Blade layout, routes + legacy `.php` redirects, page content migration, tests (on live-host PHP ≥ 8.3), then a separately approved cutover.
- The skeleton ships its own `laravel-app/AGENTS.md`/`CLAUDE.md` (Laravel Boost boilerplate) — they suggest installing PHP 8.5; **ignore that**, local runtime stays 8.0.30 unless the user approves a change.
- Keep the root Core PHP site working and unchanged until cutover is explicitly approved.

## Git

- Default branch is `main`. Current checkout is `feature/core-php-to-laravel` (migration work lives here, ahead of `main`); confirm with the user before switching branches or merging.
- Commit only completed, validated changes; never force-push or amend; if the remote has advanced or a conflict blocks a safe push, stop and explain. Source: `.github/instructions/git-workflow.instructions.md`.

## Content rules (from `.github/instructions/`)

- No photo-credit links, captions, or overlays on images — use meaningful `alt` text instead (`images.instructions.md`).
- Service content is paraphrased from https://www.irishmetal.eu — never copy verbatim, never repeat unverifiable claims (licences, office locations, prices/fees). Contact details are sample data and testimonials are illustrative; don't present either as verified, and don't add a contact form or email handling without user requirements.

## Misc

- `project.zip` / `live.zip` in the root are gitignored artifacts; don't commit them or extract them over the tree.
