<?php

use App\Http\Controllers\LegacyServiceRedirectController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Page routes
|--------------------------------------------------------------------------
| Parallel equivalents of the legacy Core PHP pages (see the route table in
| .github/skills/core-php-to-laravel/SKILL.md). The /services/{slug} route
| constraint is derived from config('site.services') — the single source of
| truth for allowed slugs — so unknown slugs fall through to a real 404.
| All routes are controller/view based (no closures) so route:cache works.
*/

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services.index');
Route::view('/contact', 'contact')->name('contact');
Route::view('/appraisals', 'appraisals')->name('appraisals.index');
Route::view('/appraisals/terms', 'appraisal-terms')->name('appraisals.terms');
Route::view('/appraisals/procedure', 'appraisal-procedure')->name('appraisals.procedure');
Route::view('/appraisals/fees', 'appraisal-fees')->name('appraisals.fees');

Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->whereIn('slug', array_keys(config('site.services')))
    ->name('services.show');

/*
|--------------------------------------------------------------------------
| Legacy Core PHP compatibility redirects
|--------------------------------------------------------------------------
| Old .php URLs (and the service-detail.php?service={slug} query format)
| keep working for existing bookmarks. Temporary 302s while both sites run
| in parallel, so the mapping stays reversible until cutover is approved.
| The query-string route is handled by a controller because the legacy
| target depends on the value of ?service=.
*/

Route::redirect('index.php', '/')->name('legacy.index');
Route::redirect('about.php', '/about')->name('legacy.about');
Route::redirect('services.php', '/services')->name('legacy.services');
Route::redirect('contact.php', '/contact')->name('legacy.contact');
Route::redirect('antique-appraisals.php', '/appraisals')->name('legacy.antique-appraisals');
Route::redirect('appraisal-terms.php', '/appraisals/terms')->name('legacy.appraisal-terms');
Route::redirect('appraisal-procedure.php', '/appraisals/procedure')->name('legacy.appraisal-procedure');
Route::redirect('appraisal-fees.php', '/appraisals/fees')->name('legacy.appraisal-fees');

Route::get('service-detail.php', LegacyServiceRedirectController::class)
    ->name('legacy.service-detail');
