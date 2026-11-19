<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AppraisalController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\LegacyServiceRedirectController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Public pages. Content comes from the database via App\Support\SiteData (cached).
Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services.index');
Route::view('/contact', 'pages.contact')->name('contact');

Route::get('/appraisals', [AppraisalController::class, 'show'])->name('appraisals.index');
Route::get('/appraisals/{slug}', [AppraisalController::class, 'show'])
    ->where('slug', '(?!appraisals$)[a-z0-9-]+')
    ->name('appraisals.show');

// Unknown or inactive slugs return a real 404.
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('services.show');

// Legacy Core PHP URLs (temporary redirects). index.php is served by the front controller as "/".
Route::redirect('/about.php', '/about');
Route::redirect('/services.php', '/services');
Route::redirect('/contact.php', '/contact');
Route::redirect('/antique-appraisals.php', '/appraisals');
Route::redirect('/appraisal-terms.php', '/appraisals/terms');
Route::redirect('/appraisal-procedure.php', '/appraisals/procedure');
Route::redirect('/appraisal-fees.php', '/appraisals/fees');
Route::get('/service-detail.php', LegacyServiceRedirectController::class);

// Admin panel (login URL: /ktgadmin). All pages except login sit behind AdminAuth.
Route::prefix('ktgadmin')->name('admin.')->group(function () {
    Route::get('/', [Admin\AuthController::class, 'show'])->name('login');
    Route::post('/', [Admin\AuthController::class, 'login'])->name('login.submit');

    Route::middleware(AdminAuth::class)->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('settings', [Admin\SettingsController::class, 'edit'])->name('settings');
        Route::put('settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('account', [Admin\AccountController::class, 'edit'])->name('account');
        Route::put('account', [Admin\AccountController::class, 'update'])->name('account.update');

        $resources = [
            'banners' => Admin\BannerController::class,
            'services' => Admin\ServiceController::class,
            'appraisals' => Admin\AppraisalController::class,
            'team' => Admin\TeamMemberController::class,
        ];
        foreach ($resources as $key => $controller) {
            Route::patch("$key/{id}/toggle", [$controller, 'toggle'])->whereNumber('id')->name("$key.toggle");
            Route::resource($key, $controller)->except('show')->parameters([$key => 'id']);
        }
    });
});
