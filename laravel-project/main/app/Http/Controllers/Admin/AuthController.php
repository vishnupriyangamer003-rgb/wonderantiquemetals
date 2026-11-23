<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuth;
use App\Models\Admin;
use App\Support\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function show(Request $request): Response
    {
        $id = $request->session()->get('admin_id');
        if ($id && Admin::whereKey($id)->exists()) {
            return redirect()->route('admin.settings');
        }

        return AdminAuth::noStore(response()->view('admin.login'));
    }

    public function login(Request $request): Response
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:200'],
        ]);
        $key = 'admin-login:'.strtolower($data['username']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $wait = RateLimiter::availableIn($key);

            return AdminAuth::noStore(back()->withInput($request->only('username'))
                ->withErrors(['username' => "Too many attempts. Try again in {$wait} seconds."]));
        }

        $admin = Admin::where('username', $data['username'])->first();
        // Constant-time comparison; same message whether the username or password is wrong.
        $valid = $admin && hash_equals((string) $admin->password, $data['password']);

        if (! $valid) {
            RateLimiter::hit($key, 60);

            return AdminAuth::noStore(back()->withInput($request->only('username'))
                ->withErrors(['username' => 'Invalid username or password.']));
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $request->session()->put('admin_id', $admin->id);
        ActivityLog::record('login', 'Signed in', $admin);

        return AdminAuth::noStore(redirect()->route('admin.settings'));
    }

    public function logout(Request $request): RedirectResponse
    {
        ActivityLog::record('logout', 'Signed out');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
