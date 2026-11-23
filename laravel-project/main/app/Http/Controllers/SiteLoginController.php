<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtp;
use App\Models\Setting;
use App\Models\UserLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public site login: any username → one-time code emailed to the admin inbox
 * (the admin passes the code to the client) → code verified → site unlocked.
 */
class SiteLoginController extends Controller
{
    /** Minutes a code stays valid. */
    private const TTL_MINUTES = 5;

    /** Hours a signed-in visitor stays logged in (absolute, counted from login). */
    public const SESSION_HOURS = 12;

    /** Wrong-code attempts allowed before the code is invalidated. */
    private const MAX_ATTEMPTS = 5;

    /** Successful OTP sends allowed per IP per window. */
    private const SEND_LIMIT = 3;

    /** Login page (username step, or code step when a code is pending). */
    public function show(Request $request): Response
    {
        if ($request->session()->get('site_login')) {
            return redirect()->route('home');
        }

        return $this->noStore(response()->view('login', [
            'step' => $request->session()->has('otp_hash') ? 'otp' : 'username',
            'username' => $request->session()->get('otp_username', ''),
            'expiresIn' => $this->secondsLeft($request),
        ]));
    }

    /** Step 1: accept the username and email the code to the admin inbox. */
    public function sendOtp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:100'],
        ], [
            'username.required' => 'Please enter your username.',
        ]);

        // The owner's username signs in directly, without an emailed code.
        $bypass = $this->normalizeName((string) config('site.login_bypass_username', ''));
        if ($bypass !== '' && $this->normalizeName($data['username']) === $bypass) {
            return $this->signIn($request, trim(preg_replace('/\s+/', ' ', $data['username'])));
        }

        $key = 'site-otp-send:'.strtolower(trim($data['username'])).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, self::SEND_LIMIT)) {
            $wait = RateLimiter::availableIn($key);

            return back()->withInput()->withErrors([
                'username' => "Too many code requests. Try again in {$wait} seconds.",
            ]);
        }

        $code = Str::padLeft((string) random_int(0, 9999), 4, '0');
        $username = trim($data['username']);

        $request->session()->put([
            'otp_hash' => hash('sha256', $code),
            'otp_expires' => now()->addMinutes(self::TTL_MINUTES)->getTimestamp(),
            'otp_username' => $username,
            'otp_attempts' => 0,
        ]);

        try {
            Mail::to(config('mail.from.address'))->send(new LoginOtp($username, $code, self::TTL_MINUTES));
        } catch (\Throwable $e) {
            $request->session()->forget(['otp_hash', 'otp_expires', 'otp_username', 'otp_attempts']);

            report($e);

            return back()->withInput()->withErrors([
                'username' => 'We could not send the login code right now. Please try again later.',
            ]);
        }

        RateLimiter::hit($key, 300);

        return redirect()->route('login')->with('status', 'A login code was sent to the admin email. Please check the inbox.');
    }

    /** Step 2: check the code the admin passed on, then open the site. */
    public function verify(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ], [
            'code.regex' => 'Enter the 4-digit login code.',
            'code.size' => 'Enter the 4-digit login code.',
        ]);

        $session = $request->session();

        if (! $session->has('otp_hash') || $this->secondsLeft($request) <= 0) {
            $session->forget(['otp_hash', 'otp_expires', 'otp_username', 'otp_attempts']);

            return redirect()->route('login')->withErrors(['code' => 'That code has expired. Request a new one.']);
        }

        $attempts = (int) $session->get('otp_attempts', 0);
        if ($attempts >= self::MAX_ATTEMPTS) {
            $session->forget(['otp_hash', 'otp_expires', 'otp_username', 'otp_attempts']);

            return redirect()->route('login')->withErrors(['code' => 'Too many wrong codes. Request a new one.']);
        }

        // Constant-time comparison of the hashed code.
        $valid = hash_equals((string) $session->get('otp_hash'), hash('sha256', $data['code']));

        if (! $valid) {
            $session->put('otp_attempts', $attempts + 1);

            return back()->withErrors(['code' => 'Incorrect code. '.(self::MAX_ATTEMPTS - $attempts - 1).' attempt(s) left.']);
        }

        return $this->signIn($request, (string) $session->get('otp_username', ''));
    }

    /** Opens the site for this session and records the login. */
    private function signIn(Request $request, string $username): RedirectResponse
    {
        $session = $request->session();
        $session->forget(['otp_hash', 'otp_expires', 'otp_username', 'otp_attempts']);
        $session->regenerate();

        UserLogin::create([
            'username' => $username,
            'login_at' => now(),
            'ip' => $request->ip(),
        ]);

        $session->put('site_login', true);
        $session->put('site_login_at', now()->getTimestamp());
        $session->put('site_login_epoch', self::sessionEpoch());
        $session->put('site_login_name', $username);

        return redirect()->route('home')->with('status', 'Signed in. Welcome, '.$username.'.');
    }

    /** Ask for a fresh code (same rate limit as the first send). */
    public function resend(Request $request): RedirectResponse
    {
        $username = (string) $request->session()->get('otp_username', '');

        if ($username === '') {
            return redirect()->route('login');
        }

        return $this->sendOtp($request->merge(['username' => $username]));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /** Current session epoch; the admin's reset button changes it to sign everyone out. */
    public static function sessionEpoch(): string
    {
        return (string) (Setting::where('key', 'site_session_epoch')->value('value') ?? '0');
    }

    /** Lower-case, trimmed, single-spaced name for comparisons. */
    private function normalizeName(string $name): string
    {
        return mb_strtolower(trim(preg_replace('/\s+/', ' ', $name)));
    }

    /** Seconds until the pending code expires (0 when none). */
    private function secondsLeft(Request $request): int
    {
        $expires = (int) $request->session()->get('otp_expires', 0);

        return max(0, $expires - time());
    }

    /** Same protections the admin panel uses: never cache login responses. */
    private function noStore(Response $response): Response
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
