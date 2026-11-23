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
use Symfony\Component\HttpFoundation\Response;

/**
 * Public site login: one field, the user's fixed 4-digit PIN. New people register with
 * name, phone and email; their PIN is emailed to the admin only, who passes it on.
 */
class SiteLoginController extends Controller
{
    /** Hours a signed-in visitor stays logged in (absolute, counted from login). */
    public const SESSION_HOURS = 12;

    /** Wrong PINs allowed per IP per window. */
    private const IP_ATTEMPTS = 5;

    /** Wrong PINs allowed across all visitors per window (a PIN only has 10,000 values). */
    private const GLOBAL_ATTEMPTS = 30;

    /** Lockout window in seconds. */
    private const WINDOW_SECONDS = 900;

    /** Registrations allowed per IP per window. */
    private const REGISTER_LIMIT = 3;

    /** Login page: just the PIN field. */
    public function show(Request $request): Response
    {
        if ($request->session()->get('site_login')) {
            return redirect()->route('home');
        }

        return $this->noStore(response()->view('login'));
    }

    /** Checks the PIN and opens the site. */
    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pin' => ['required', 'string', 'regex:/^[0-9]{4}$/'],
        ], [
            'pin.required' => 'Please enter your pincode.',
            'pin.regex' => 'The pincode is 4 digits.',
        ]);

        $ipKey = 'site-pin-ip:'.$request->ip();
        $globalKey = 'site-pin-all';

        if (RateLimiter::tooManyAttempts($ipKey, self::IP_ATTEMPTS)) {
            $minutes = (int) ceil(RateLimiter::availableIn($ipKey) / 60);

            return back()->withErrors(['pin' => "Too many wrong attempts. Try again in {$minutes} minute(s)."]);
        }
        if (RateLimiter::tooManyAttempts($globalKey, self::GLOBAL_ATTEMPTS)) {
            return back()->withErrors(['pin' => 'Too many wrong attempts. Please try again later.']);
        }

        $user = SiteUser::where('pin_hash', SiteUser::hashPin($data['pin']))->first();

        if (! $user) {
            RateLimiter::hit($ipKey, self::WINDOW_SECONDS);
            RateLimiter::hit($globalKey, self::WINDOW_SECONDS);

            return back()->withErrors(['pin' => 'Incorrect pincode. New here? Register and ask the admin for your pincode.']);
        }

        RateLimiter::clear($ipKey);

        return $this->signIn($request, $user->name, $user->phone, $user->email);
    }

    public function showRegister(Request $request): Response
    {
        if ($request->session()->get('site_login')) {
            return redirect()->route('home');
        }

        return $this->noStore(response()->view('register'));
    }

    /** Saves the user and emails their PIN to the admin only; the user is told to ask the admin. */
    public function register(Request $request): RedirectResponse
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

        $key = 'site-register:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, self::REGISTER_LIMIT)) {
            $wait = RateLimiter::availableIn($key);

            return back()->withInput()->withErrors(['email' => "Too many requests. Try again in {$wait} seconds."]);
        }

        // One user, one PIN: a known email keeps its PIN (the admin gets it again).
        $user = SiteUser::where('email', $data['email'])->first();
        if ($user) {
            $user->update(['name' => $data['name'], 'phone' => $data['phone']]);
        } else {
            $user = SiteUser::register($data['name'], $data['phone'], $data['email']);
        }

        try {
            Mail::to(config('mail.from.address'))->send(new LoginOtp($user->name, $user->phone, $user->email, $user->pin));
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->withErrors(['email' => 'We could not complete the registration right now. Please try again later.']);
        }

        RateLimiter::hit($key, 300);

        return redirect()->route('login')->with('status', 'Thank you for registering. Kindly contact the admin and get your pincode.');
    }

    /** Opens the site for this session and records the login. */
    private function signIn(Request $request, string $name, string $phone, string $email): RedirectResponse
    {
        $session = $request->session();
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

    /** Same protections the admin panel uses: never cache login responses. */
    private function noStore(Response $response): Response
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
