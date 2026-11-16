<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LegacyServiceRedirectController extends Controller
{
    /**
     * Redirect legacy service-detail.php?service={slug} links to /services/{slug}.
     *
     * Mirrors the legacy page's behaviour: a missing, malformed, or unknown
     * slug is a real 404 rather than a redirect to the services overview.
     */
    public function __invoke(): RedirectResponse
    {
        $slug = request()->query('service', '');
        $slug = is_string($slug) ? $slug : '';

        abort_unless(array_key_exists($slug, config('site.services')), 404);

        return redirect()->route('services.show', ['slug' => $slug]);
    }
}
