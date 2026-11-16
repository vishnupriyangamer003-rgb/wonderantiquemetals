<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Guards /ktgadmin pages and stops browsers caching them (back button after logout shows nothing). */
class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->session()->get('admin_id');
        $admin = $id ? Admin::find($id) : null;
        if (! $admin) {
            $request->session()->forget('admin_id');

            return self::noStore(redirect()->route('admin.login'));
        }
        $request->attributes->set('admin', $admin);

        return self::noStore($next($request));
    }

    public static function noStore(Response $response): Response
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
