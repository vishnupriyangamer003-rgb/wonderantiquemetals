<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use Illuminate\Contracts\View\View;

/** Read-only list of what admins did in the panel. */
class ActivityController extends Controller
{
    public function index(): View
    {
        $items = AdminActivity::orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        return view('admin.activity.index', compact('items'));
    }
}
