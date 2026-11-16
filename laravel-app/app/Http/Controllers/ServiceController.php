<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Show a single service page (legacy service-detail.php?service={slug}).
     *
     * The slug is already constrained to config('site.services') keys by the
     * route's whereIn() requirement; the abort is a defensive backstop.
     */
    public function show(string $slug): View
    {
        $services = config('site.services');

        abort_unless(array_key_exists($slug, $services), 404);

        $service = $services[$slug];

        return view('service-detail', [
            'services' => $services,
            'service' => $service,
            'slug' => $slug,
            'pageTitle' => $service['title'].' | Wonder Antique Metals',
            'pageDescription' => $service['summary'],
        ]);
    }
}
