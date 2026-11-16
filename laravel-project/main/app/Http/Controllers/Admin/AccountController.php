<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.account', ['admin' => $request->attributes->get('admin')]);
    }

    /** One simple form: username and password, no confirmation field. */
    public function update(Request $request): RedirectResponse
    {
        $admin = $request->attributes->get('admin');
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:60', 'regex:~^[A-Za-z0-9._-]+$~', Rule::unique('admins', 'username')->ignore($admin->id)],
            'password' => ['required', 'string', 'min:6', 'max:100'],
        ]);
        $admin->update($data);
        $request->session()->regenerate();

        return back()->with('status', 'Login details saved.');
    }
}
