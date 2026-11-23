<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Contracts\View\View;
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
}
