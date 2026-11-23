<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SiteLoginController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Keeps every public page behind the OTP login; the login ends SESSION_HOURS after sign-in. */
class SiteAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $session = $request->session();

        if (! $session->get('site_login')) {
            return redirect()->route('login');
        }

        $loggedInAt = (int) $session->get('site_login_at', 0);
        if ($loggedInAt <= 0 || time() - $loggedInAt >= SiteLoginController::SESSION_HOURS * 3600) {
            $session->forget(['site_login', 'site_login_name', 'site_login_at']);

            return redirect()->route('login')
                ->with('status', 'Your session ended after '.SiteLoginController::SESSION_HOURS.' hours. Please sign in again.');
        }

        $response = $next($request);

        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
