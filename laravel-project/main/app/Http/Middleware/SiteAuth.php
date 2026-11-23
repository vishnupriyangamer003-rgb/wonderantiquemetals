<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Keeps every public page behind the OTP login until the session is verified. */
class SiteAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('site_login')) {
            return redirect()->route('login');
        }

        $response = $next($request);

        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
