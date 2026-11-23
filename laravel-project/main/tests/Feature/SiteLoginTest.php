<?php

namespace Tests\Feature;

use App\Mail\LoginOtp;
use App\Models\Admin;
use App\Models\SiteUser;
use App\Models\UserLogin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiteLoginTest extends TestCase
{
    /** A valid details payload; override single fields per test. */
    private function details(array $override = []): array
    {
        return array_merge([
            'name' => 'Ravi Kumar',
            'phone' => '+91 98765 43210',
            'email' => 'Ravi@Example.com',
        ], $override);
    }

    /** Submits the details form and returns the PIN that was mailed to the admin. */
    private function requestPin(array $override = []): string
    {
        $this->post('/login', $this->details($override))->assertRedirect('/login');

        $pin = null;
        Mail::assertSent(LoginOtp::class, function (LoginOtp $m) use (&$pin) {
            $pin = $m->code;

            return true;
        });

        return $pin;
    }

    // ---------- details form validation ----------

    public function test_form_requires_name_phone_and_email(): void
    {
        $this->flushSession();

        $this->post('/login', [])->assertSessionHasErrors(['name', 'phone', 'email']);
    }

    public function test_name_phone_and_email_are_validated(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', $this->details(['name' => 'R']))->assertSessionHasErrors('name');
        $this->post('/login', $this->details(['name' => 'Ravi 123 <b>']))->assertSessionHasErrors('name');
        $this->post('/login', $this->details(['phone' => '12345']))->assertSessionHasErrors('phone');
        $this->post('/login', $this->details(['phone' => 'abcdefghij']))->assertSessionHasErrors('phone');
        $this->post('/login', $this->details(['email' => 'not-an-email']))->assertSessionHasErrors('email');

        Mail::assertNothingSent();
        $this->assertSame(0, SiteUser::count());
    }

    public function test_phone_accepts_spaces_dashes_and_country_code(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', $this->details(['phone' => '(+91) 98765-43210']))->assertSessionHasNoErrors();

        $this->assertSame('+919876543210', SiteUser::first()->phone);
    }

    // ---------- one user, one PIN ----------

    public function test_new_user_gets_a_four_digit_pin_mailed_to_admin(): void
    {
        Mail::fake();
        $this->flushSession();

        $pin = $this->requestPin();

        $this->assertMatchesRegularExpression('/^[0-9]{4}$/', $pin);
        $user = SiteUser::first();
        $this->assertSame('ravi@example.com', $user->email);
        $this->assertSame($pin, $user->pin);
        Mail::assertSent(LoginOtp::class, fn (LoginOtp $m) => $m->name === 'Ravi Kumar'
            && $m->phone === '+919876543210'
            && $m->email === 'ravi@example.com'
            && $m->hasTo(config('mail.from.address')));
    }

    public function test_the_same_user_always_gets_the_same_pin(): void
    {
        Mail::fake();
        $this->flushSession();
        $first = $this->requestPin();

        // Signing in again later (new session, new name spelling) keeps the same PIN and one user row.
        $this->flushSession();
        RateLimiter::clear('site-otp-send:ravi@example.com|127.0.0.1');
        $second = $this->requestPin(['name' => 'Ravi K']);

        $this->assertSame($first, $second);
        $this->assertSame(1, SiteUser::count());
        $this->assertSame('Ravi K', SiteUser::first()->name);
    }

    public function test_different_emails_are_different_users(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->requestPin();
        $this->flushSession();
        $this->post('/login', $this->details(['email' => 'other@example.com']));

        $this->assertSame(2, SiteUser::count());
    }

    public function test_pin_is_not_stored_in_plain_text(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->requestPin();

        $raw = \DB::table('site_users')->value('pin');
        $this->assertNotSame($pin, $raw);
    }

    // ---------- verifying the PIN ----------

    public function test_pin_must_be_exactly_four_digits(): void
    {
        Mail::fake();
        $this->flushSession();
        $this->requestPin();

        $this->post('/login/verify', ['code' => '123456'])->assertSessionHasErrors('code');
        $this->post('/login/verify', ['code' => '12'])->assertSessionHasErrors('code');
    }

    public function test_correct_pin_signs_in_and_logs_the_user(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->requestPin();

        $this->post('/login/verify', ['code' => $pin])->assertRedirect('/');
        $this->get('/')->assertOk();

        $this->assertDatabaseHas('user_logins', [
            'username' => 'Ravi Kumar',
            'phone' => '+919876543210',
            'email' => 'ravi@example.com',
        ]);
    }

    public function test_wrong_pin_is_rejected(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->requestPin();
        $wrong = $pin === '0000' ? '1111' : '0000';

        $this->post('/login/verify', ['code' => $wrong])->assertSessionHasErrors('code');
        $this->get('/')->assertRedirect('/login');
        $this->assertSame(0, UserLogin::count());
    }

    public function test_user_is_locked_out_after_too_many_wrong_pins(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->requestPin();
        $wrong = $pin === '0000' ? '1111' : '0000';

        // Each new session gets 5 tries; 10 wrong PINs across sessions lock the user.
        for ($i = 0; $i < 10; $i++) {
            if ($i === 5) {
                $this->flushSession();
                RateLimiter::clear('site-otp-send:ravi@example.com|127.0.0.1');
                $this->requestPin();
            }
            $this->post('/login/verify', ['code' => $wrong]);
        }

        $this->flushSession();
        RateLimiter::clear('site-otp-send:ravi@example.com|127.0.0.1');
        $this->requestPin();
        $this->post('/login/verify', ['code' => $pin])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('code');
        $this->get('/')->assertRedirect('/login');
    }

    public function test_resend_sends_the_same_pin_again(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->requestPin();

        $this->post('/login/resend')->assertRedirect('/login');

        Mail::assertSent(LoginOtp::class, 2);
        Mail::assertSent(LoginOtp::class, fn (LoginOtp $m) => $m->code === $pin);
    }

    public function test_use_different_details_link_clears_the_pin_step(): void
    {
        Mail::fake();
        $this->flushSession();
        $this->requestPin();

        $this->get('/login')->assertSee('Enter your PIN');
        $this->get('/login?change=1')->assertSee('Phone number')->assertDontSee('Enter your PIN');
    }

    // ---------- owner bypass ----------

    public function test_bypass_name_signs_in_without_a_pin(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', $this->details(['name' => '  saravanan   NAMAKKAL ']))->assertRedirect('/');

        Mail::assertNothingSent();
        $this->assertDatabaseHas('user_logins', ['username' => 'saravanan NAMAKKAL', 'email' => 'ravi@example.com']);
        $this->get('/')->assertOk();
    }

    public function test_bypass_still_needs_valid_phone_and_email(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', ['name' => 'Saravanan Namakkal', 'phone' => '1', 'email' => 'x'])
            ->assertSessionHasErrors(['phone', 'email']);
        $this->get('/')->assertRedirect('/login');
    }

    public function test_other_names_still_need_a_pin(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', $this->details(['name' => 'Someone Else']))->assertRedirect('/login');

        Mail::assertSent(LoginOtp::class);
        $this->get('/')->assertRedirect('/login');
    }

    // ---------- 12-hour session and admin reset ----------

    public function test_session_ends_twelve_hours_after_login(): void
    {
        $this->withSession(['site_login' => true, 'site_login_at' => time() - 13 * 3600])
            ->get('/')->assertRedirect('/login');
    }

    public function test_session_still_valid_before_twelve_hours(): void
    {
        $this->withSession(['site_login' => true, 'site_login_at' => time() - 11 * 3600])
            ->get('/')->assertOk();
    }

    public function test_admin_reset_signs_every_visitor_out(): void
    {
        Mail::fake();
        $this->flushSession();
        config(['site.login_bypass_username' => 'Owner']);

        // A visitor signs in, then the admin resets all sessions.
        $this->post('/login', $this->details(['name' => 'Owner']))->assertRedirect('/');
        $this->get('/')->assertOk();

        Admin::create(['username' => 'boss', 'password' => 'secret123']);
        $visitor = session()->all();
        $this->flushSession();
        $this->withSession(['admin_id' => Admin::first()->id])
            ->post('/ktgadmin/user-logins/reset-sessions')
            ->assertRedirect('/ktgadmin/user-logins');

        // The old visitor session is rejected; a fresh sign-in works again.
        $this->flushSession();
        $this->withSession($visitor)->get('/')->assertRedirect('/login');
        $this->flushSession();
        $this->post('/login', $this->details(['name' => 'Owner']))->assertRedirect('/');
        $this->get('/')->assertOk();
    }

    public function test_guests_cannot_reset_sessions(): void
    {
        $this->post('/ktgadmin/user-logins/reset-sessions')->assertRedirect('/ktgadmin');
    }

    // ---------- admin list ----------

    public function test_user_logins_table_shows_name_phone_email_and_no_ip(): void
    {
        Admin::create(['username' => 'boss', 'password' => 'secret123']);
        UserLogin::create(['username' => 'client', 'phone' => '+919876543210', 'email' => 'client@example.com', 'login_at' => now()]);
        UserLogin::create(['username' => 'old row', 'login_at' => now()->subDay()]);

        $this->flushSession();
        $this->withSession(['admin_id' => Admin::first()->id])
            ->get('/ktgadmin/user-logins')
            ->assertOk()
            ->assertSee('client')->assertSee('+919876543210')->assertSee('client@example.com')
            ->assertSee('old row')
            ->assertSee('Phone')->assertSee('Email')
            ->assertDontSee('IP address');
        $this->assertFalse(Schema::hasColumn('user_logins', 'ip'));
    }

    public function test_login_times_are_shown_in_indian_time(): void
    {
        $this->assertSame('Asia/Kolkata', config('app.timezone'));

        Admin::create(['username' => 'boss', 'password' => 'secret123']);
        UserLogin::create([
            'username' => 'clock',
            'login_at' => Carbon::parse('2026-11-23 13:18:00', 'Asia/Kolkata'),
        ]);

        $this->flushSession();
        $this->withSession(['admin_id' => Admin::first()->id])
            ->get('/ktgadmin/user-logins')
            ->assertSee('01:18:00 PM IST');
    }
}
