<?php

namespace App\Http\Controllers;

use App\Support\SiteData;
use Illuminate\Contracts\View\View;

class AppraisalController extends Controller
{
    public function show(string $slug = 'appraisals'): View
    {
        $appraisal = SiteData::appraisals()->firstWhere('slug', $slug);
        abort_unless($appraisal, 404);

        return view('pages.appraisal', ['appraisal' => $appraisal]);
    }
}
