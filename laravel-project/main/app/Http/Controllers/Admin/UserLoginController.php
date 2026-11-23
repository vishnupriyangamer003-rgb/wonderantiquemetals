<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\UserLogin;
use App\Support\ActivityLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Read-only audit list of successful OTP sign-ins to the public site. */
class UserLoginController extends Controller
{
    public function index(Request $request): View
    {
        $items = UserLogin::orderByDesc('login_at')
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        return view('admin.userlogins.index', compact('items'));
    }

    /** Signs every website visitor out: sessions issued before this moment stop working. */
    public function resetSessions(): RedirectResponse
    {
        Setting::updateOrCreate(
            ['key' => 'site_session_epoch'],
            ['value' => now()->getTimestamp().random_int(1000, 9999)],
        );

        ActivityLog::record('sessions', 'Reset all website sessions');

        return redirect()->route('admin.userlogins.index')
            ->with('status', 'All website sessions were reset. Every visitor must sign in again.');
    }
}
