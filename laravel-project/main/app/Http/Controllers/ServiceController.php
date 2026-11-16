<?php

namespace App\Http\Controllers;

use App\Support\SiteData;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function show(string $slug): View
    {
        $service = SiteData::services()->firstWhere('slug', $slug);
        abort_unless($service, 404);

        return view('service-detail', ['service' => $service]);
    }
}
