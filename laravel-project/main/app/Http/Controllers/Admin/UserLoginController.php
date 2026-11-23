<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SiteUser;
use App\Models\UserLogin;
use App\Support\ActivityLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

/**
 * Audit and credentials list of registered site visitors and their sign-in history.
 */
class UserLoginController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Fetch all registered visitors
        $siteUsers = Schema::hasTable('site_users') ? SiteUser::all() : collect();

        // 2. Fetch all sign-ins, newest first
        $allLogins = Schema::hasTable('user_logins')
            ? UserLogin::orderByDesc('login_at')->orderByDesc('id')->get()
            : collect();

        // Group logins by lowercase email and username
        $loginsByEmail = $allLogins->filter(fn ($l) => !empty($l->email))
            ->groupBy(fn ($l) => mb_strtolower(trim((string) $l->email)));

        $loginsByName = $allLogins->filter(fn ($l) => !empty($l->username))
            ->groupBy(fn ($l) => mb_strtolower(trim((string) $l->username)));

        $claimedLoginIds = [];
        $userItems = collect();

        // Process registered users
        foreach ($siteUsers as $user) {
            $emailKey = mb_strtolower(trim((string) $user->email));
            $nameKey = mb_strtolower(trim((string) $user->name));

            $userLogins = $loginsByEmail->get($emailKey);
            if (! $userLogins) {
                $userLogins = $loginsByName->get($nameKey) ?? collect();
            }

            foreach ($userLogins as $l) {
                $claimedLoginIds[$l->id] = true;
            }

            $latestLogin = $userLogins->first();

            $history = $userLogins->map(function ($l) {
                return [
                    'date' => $l->login_at ? $l->login_at->format('d M Y') : '—',
                    'time' => $l->login_at ? $l->login_at->format('h:i:s A') . ' IST' : '—',
                    'timestamp' => $l->login_at ? $l->login_at->getTimestamp() : 0,
                ];
            })->values()->all();

            $userItems->push((object) [
                'id' => 'u-' . $user->id,
                'username' => $user->name,
                'phone' => $user->phone ?: $latestLogin?->phone,
                'email' => $user->email ?: $latestLogin?->email,
                'password' => $user->pin,
                'login_at' => $latestLogin?->login_at,
                'created_at' => $user->created_at,
                'sort_time' => $latestLogin?->login_at?->getTimestamp() ?? $user->created_at?->getTimestamp() ?? 0,
                'history' => $history,
            ]);
        }

        // Process any logins not claimed by a SiteUser (e.g. legacy test records)
        $orphanLogins = $allLogins->reject(fn ($l) => isset($claimedLoginIds[$l->id]));
        $orphanGroups = $orphanLogins->groupBy(function ($l) {
            return !empty($l->email)
                ? ('e:' . mb_strtolower(trim((string) $l->email)))
                : ('n:' . mb_strtolower(trim((string) $l->username)));
        });

        foreach ($orphanGroups as $group) {
            $first = $group->first();
            $history = $group->map(function ($l) {
                return [
                    'date' => $l->login_at ? $l->login_at->format('d M Y') : '—',
                    'time' => $l->login_at ? $l->login_at->format('h:i:s A') . ' IST' : '—',
                    'timestamp' => $l->login_at ? $l->login_at->getTimestamp() : 0,
                ];
            })->values()->all();

            $userItems->push((object) [
                'id' => 'l-' . $first->id,
                'username' => $first->username,
                'phone' => $first->phone,
                'email' => $first->email,
                'password' => null,
                'login_at' => $first->login_at,
                'created_at' => $first->login_at,
                'sort_time' => $first->login_at ? $first->login_at->getTimestamp() : 0,
                'history' => $history,
            ]);
        }

        // Order newest activity first
        $sorted = $userItems->sortByDesc('sort_time')->values();

        // Paginate (50 per page)
        $perPage = 50;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $slice = $sorted->slice(($page - 1) * $perPage, $perPage)->values();

        $items = new LengthAwarePaginator(
            $slice,
            $sorted->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

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
