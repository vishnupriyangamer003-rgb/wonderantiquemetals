<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtp;
use App\Models\Setting;
use App\Models\SiteUser;
use App\Models\UserLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public site login: name + phone + email → the user's one fixed 4-digit PIN is emailed to the
 * admin inbox (the admin passes it to the client) → PIN verified → site unlocked.
 */
class SiteLoginController extends Controller
{
    /** Minutes the PIN step stays open. */
    private const TTL_MINUTES = 5;

    /** Hours a signed-in visitor stays logged in (absolute, counted from login). */
    public const SESSION_HOURS = 12;

    /** Wrong-PIN attempts allowed per PIN step. */
    private const MAX_ATTEMPTS = 5;

    /** Wrong PINs allowed per user (email) per lockout window, across all sessions. */
    private const LOCKOUT_ATTEMPTS = 10;

    /** Seconds a user stays locked out after too many wrong PINs. */
    private const LOCKOUT_SECONDS = 900;

    /** PIN requests allowed per user and IP per window. */
    private const SEND_LIMIT = 3;

    private const SESSION_KEYS = ['otp_user_id', 'otp_name', 'otp_expires', 'otp_attempts'];

    /** Login page (details step, or PIN step when one is pending). */
    public function show(Request $request): Response
    {
        if ($request->session()->get('site_login')) {
            return redirect()->route('home');
        }

        if ($request->boolean('change')) {
            $request->session()->forget(self::SESSION_KEYS);
        }

        return $this->noStore(response()->view('login', [
            'step' => $request->session()->has('otp_user_id') ? 'otp' : 'details',
            'username' => $request->session()->get('otp_name', ''),
            'expiresIn' => $this->secondsLeft($request),
        ]));
    }

    /** Step 1: validate the details and email the user's PIN to the admin inbox. */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim((string) $request->input('name'))),
            'phone' => preg_replace('/[\s().-]/', '', (string) $request->input('phone')),
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', "regex:/^\\p{L}[\\p{L} .'-]*$/u"],
            'phone' => ['required', 'regex:/^\\+?[0-9]{10,15}$/'],
            'email' => ['required', 'email:rfc', 'max:150'],
        ], [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Your name must be at least 2 characters.',
            'name.regex' => 'Your name can only contain letters, spaces and . \' -',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Enter a valid phone number (10 to 15 digits, optional + country code).',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Enter a valid email address.',
        ]);

        // The owner's name signs in directly, without a PIN.
        $bypass = $this->normalizeName((string) config('site.login_bypass_username', ''));
        if ($bypass !== '' && $this->normalizeName($data['name']) === $bypass) {
            return $this->signIn($request, $data['name'], $data['phone'], $data['email']);
        }

        $key = 'site-otp-send:'.$data['email'].'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, self::SEND_LIMIT)) {
            $wait = RateLimiter::availableIn($key);

            return back()->withInput()->withErrors([
                'email' => "Too many requests. Try again in {$wait} seconds.",
            ]);
        }

        // One user, one PIN: created once for a new email, reused on every later login.
        $user = SiteUser::where('email', $data['email'])->first();
        if ($user) {
            $user->update(['name' => $data['name'], 'phone' => $data['phone']]);
        } else {
            $user = SiteUser::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'pin' => Str::padLeft((string) random_int(0, 9999), 4, '0'),
            ]);
        }

        $request->session()->put([
            'otp_user_id' => $user->id,
            'otp_name' => $user->name,
            'otp_expires' => now()->addMinutes(self::TTL_MINUTES)->getTimestamp(),
            'otp_attempts' => 0,
        ]);

        try {
            Mail::to(config('mail.from.address'))->send(
                new LoginOtp($user->name, $user->phone, $user->email, $user->pin, self::TTL_MINUTES)
            );
        } catch (\Throwable $e) {
            $request->session()->forget(self::SESSION_KEYS);

            report($e);

            return back()->withInput()->withErrors([
                'email' => 'We could not send the PIN right now. Please try again later.',
            ]);
        }

        RateLimiter::hit($key, 300);

        return redirect()->route('login')->with('status', 'The PIN was sent to the admin email. Please check the inbox.');
    }

    /** Step 2: check the PIN the admin passed on, then open the site. */
    public function verify(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ], [
            'code.regex' => 'Enter the 4-digit PIN.',
            'code.size' => 'Enter the 4-digit PIN.',
        ]);

        $session = $request->session();
        $user = $session->has('otp_user_id') ? SiteUser::find($session->get('otp_user_id')) : null;

        if (! $user || $this->secondsLeft($request) <= 0) {
            $session->forget(self::SESSION_KEYS);

            return redirect()->route('login')->withErrors(['code' => 'This step has expired. Please enter your details again.']);
        }

        $lockKey = 'site-pin:'.$user->email;
        if (RateLimiter::tooManyAttempts($lockKey, self::LOCKOUT_ATTEMPTS)) {
            $wait = (int) ceil(RateLimiter::availableIn($lockKey) / 60);
            $session->forget(self::SESSION_KEYS);

            return redirect()->route('login')->withErrors(['code' => "Too many wrong PINs. Try again in {$wait} minute(s)."]);
        }

        $attempts = (int) $session->get('otp_attempts', 0);
        if ($attempts >= self::MAX_ATTEMPTS) {
            $session->forget(self::SESSION_KEYS);

            return redirect()->route('login')->withErrors(['code' => 'Too many wrong PINs. Please enter your details again.']);
        }

        // Constant-time comparison.
        if (! hash_equals((string) $user->pin, $data['code'])) {
            $session->put('otp_attempts', $attempts + 1);
            RateLimiter::hit($lockKey, self::LOCKOUT_SECONDS);

            return back()->withErrors(['code' => 'Incorrect PIN. '.(self::MAX_ATTEMPTS - $attempts - 1).' attempt(s) left.']);
        }

        RateLimiter::clear($lockKey);

        return $this->signIn($request, $user->name, $user->phone, $user->email);
    }

    /** Opens the site for this session and records the login. */
    private function signIn(Request $request, string $name, string $phone, string $email): RedirectResponse
    {
        $session = $request->session();
        $session->forget(self::SESSION_KEYS);
        $session->regenerate();

        UserLogin::create([
            'username' => $name,
            'phone' => $phone,
            'email' => $email,
            'login_at' => now(),
        ]);

        $session->put('site_login', true);
        $session->put('site_login_at', now()->getTimestamp());
        $session->put('site_login_epoch', self::sessionEpoch());
        $session->put('site_login_name', $name);

        return redirect()->route('home')->with('status', 'Signed in. Welcome, '.$name.'.');
    }

    /** Send the same PIN to the admin again (same rate limit as the first send). */
    public function resend(Request $request): RedirectResponse
    {
        $user = $request->session()->has('otp_user_id') ? SiteUser::find($request->session()->get('otp_user_id')) : null;

        if (! $user) {
            return redirect()->route('login');
        }

        return $this->sendOtp($request->merge([
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]));
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

    /** Seconds until the pending PIN step expires (0 when none). */
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
