<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Private Laravel app lives in ./main (blocked from the web by main/.htaccess).
$base = __DIR__.'/main';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $base.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $base.'/bootstrap/app.php';

// This folder is the public path, not main/public.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
