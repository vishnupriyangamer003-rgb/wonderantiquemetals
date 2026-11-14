# AGENTS.md

## What this is

Small static Core PHP multi-page site: no framework, no database, no Composer, no `package.json`, no tests, no lint/format config, and **no CI workflows** (`.github/` contains only agent instructions and skills — see below). Root-level `*.php` pages are served directly by XAMPP from this directory.

## Commands

- PHP is **not on PATH**. Use the XAMPP CLI directly: `C:\xampp\php\php.exe -l <file>` — syntax checking is the only automated verification available.
- There is no test runner, linter, or build step. Verify changes with `php -l` plus browser checks (navigation links, asset paths, desktop/mobile).
- Verified 2026-11: local XAMPP PHP CLI is **8.0.30**. `.github/instructions/laravel-migration.instructions.md` claims 8.2.12 — re-verify at runtime before trusting either number; Laravel 12 requires PHP ≥ 8.2, so the local runtime may be insufficient.

## Page structure (Core PHP)

- Each page sets optional `$pageTitle` / `$pageDescription`, then `require_once __DIR__ . '/includes/header.php';` … `require_once __DIR__ . '/includes/footer.php';`. Never duplicate shared header/footer markup.
- `includes/header.php` also outputs `<title>`/meta, the stylesheet, and deferred `assets/js/main.js`. Styles/scripts/images live only in `assets/css/`, `assets/js/`, `assets/images/`.
- `service-detail.php?service={slug}` renders from a `$services` array; allowed slugs: `regulatory`, `assaying`, `acquisition`, `auction`, `monetization`. Unknown slugs set `http_response_code(404)` and show an inline not-found section. Keep that validation when editing.
- Nav links are page-relative (`services.php`, `service-detail.php?service=…`). After touching any page, verify every nav link resolves from each page.

## Laravel migration (paused)

- A parallel Laravel app is planned at `laravel-app/`; it does not exist yet. Full spec: `.github/skills/core-php-to-laravel/SKILL.md` and `.github/instructions/laravel-migration.instructions.md`.
- **Stop gate:** do not scaffold Laravel, install Composer, or change any PHP runtime until the user confirms the target hosting PHP version. Composer is not installed.
- Keep the root Core PHP site working and unchanged until cutover is explicitly approved.

## Git

- Default branch is `main`. Current checkout is `feature/core-php-to-laravel` (only the agent-guidance files ahead of `main`); the migration skill says to work there — confirm with the user before switching branches.
- Commit only completed, validated changes; never force-push or amend; if the remote has advanced or a conflict blocks a safe push, stop and explain. Source: `.github/instructions/git-workflow.instructions.md`.

## Content rules (from `.github/instructions/`)

- No photo-credit links, captions, or overlays on images — use meaningful `alt` text instead (`images.instructions.md`).
- Service content is paraphrased from https://www.irishmetal.eu — never copy verbatim, never repeat unverifiable claims (licences, office locations, prices/fees). Contact details are sample data and testimonials are illustrative; don't present either as verified, and don't add a contact form or email handling without user requirements.

## Misc

- `project.zip` / `live.zip` in the root are gitignored artifacts; don't commit them or extract them over the tree.
