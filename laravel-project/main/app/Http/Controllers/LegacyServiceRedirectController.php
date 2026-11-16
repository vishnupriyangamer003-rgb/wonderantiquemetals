<?php

namespace App\Http\Controllers;

use App\Support\SiteData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Redirects legacy service-detail.php?service={slug} to /services/{slug}. */
class LegacyServiceRedirectController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $slug = $request->query('service');
        abort_unless(is_string($slug) && SiteData::services()->contains('slug', $slug), 404);

        return redirect()->route('services.show', $slug);
    }
}
