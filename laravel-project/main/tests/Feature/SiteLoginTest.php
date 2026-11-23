<?php

namespace Tests\Feature;

use App\Mail\LoginOtp;
use App\Models\Admin;
use App\Models\SiteUser;
use App\Models\UserLogin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiteLoginTest extends TestCase
{
    /** A valid registration payload; override single fields per test. */
    private function details(array $override = []): array
    {
        return array_merge([
            'name' => 'Ravi Kumar',
            'phone' => '+91 98765 43210',
            'email' => 'Ravi@Example.com',
        ], $override);
    }

    /** Registers a user and returns the PIN that was mailed to the admin. */
    private function register(array $override = []): string
    {
        $this->post('/register', $this->details($override))->assertRedirect('/login');

        $pin = null;
        Mail::assertSent(LoginOtp::class, function (LoginOtp $m) use (&$pin) {
            $pin = $m->code;

            return true;
        });

        return $pin;
    }

    // ---------- login page ----------

    public function test_login_page_has_only_the_pin_field_and_a_register_link(): void
    {
        $this->flushSession();

        $this->get('/login')
            ->assertOk()
            ->assertSee('Enter pincode')
            ->assertSee('name="pin"', false)
            ->assertDontSee('name="name"', false)
            ->assertDontSee('name="email"', false)
            ->assertDontSee('name="phone"', false)
            ->assertDontSee('name="username"', false)
            ->assertSee('/register', false);
    }

    public function test_register_page_has_name_phone_and_email(): void
    {
        $this->flushSession();

        $this->get('/register')
            ->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="phone"', false)
            ->assertSee('name="email"', false);
    }

    // ---------- registration ----------

    public function test_registration_requires_name_phone_and_email(): void
    {
        $this->flushSession();

        $this->post('/register', [])->assertSessionHasErrors(['name', 'phone', 'email']);
    }

    public function test_name_phone_and_email_are_validated(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/register', $this->details(['name' => 'R']))->assertSessionHasErrors('name');
        $this->post('/register', $this->details(['name' => 'Ravi 123 <b>']))->assertSessionHasErrors('name');
        $this->post('/register', $this->details(['phone' => '12345']))->assertSessionHasErrors('phone');
        $this->post('/register', $this->details(['phone' => 'abcdefghij']))->assertSessionHasErrors('phone');
        $this->post('/register', $this->details(['email' => 'not-an-email']))->assertSessionHasErrors('email');

        Mail::assertNothingSent();
        $this->assertSame(0, SiteUser::count());
    }

    public function test_phone_accepts_spaces_dashes_and_country_code(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/register', $this->details(['phone' => '(+91) 98765-43210']))->assertSessionHasNoErrors();

        $this->assertSame('+919876543210', SiteUser::first()->phone);
    }

    public function test_registering_mails_the_pin_to_the_admin_and_never_shows_it(): void
    {
        Mail::fake();
        $this->flushSession();

        $response = $this->post('/register', $this->details());
        $pin = SiteUser::first()->pin;

        $response->assertRedirect('/login')
            ->assertSessionHas('status', 'Thank you for registering. Kindly contact the admin and get your pincode.');
        $this->assertMatchesRegularExpression('/^[0-9]{4}$/', $pin);
        Mail::assertSent(LoginOtp::class, fn (LoginOtp $m) => $m->code === $pin
            && $m->name === 'Ravi Kumar'
            && $m->phone === '+919876543210'
            && $m->email === 'ravi@example.com'
            && $m->hasTo(config('mail.from.address')));

        $page = $this->get('/login')->assertOk()->assertSee('Kindly contact the admin and get your pincode');
        $this->assertStringNotContainsString('value="'.$pin.'"', $page->getContent());
        $this->assertStringNotContainsString('>'.$pin.'<', $page->getContent());
    }

    public function test_registering_again_with_the_same_email_keeps_one_user_and_the_same_pin(): void
    {
        Mail::fake();
        $this->flushSession();
        $first = $this->register();

        $this->flushSession();
        RateLimiter::clear('site-register:127.0.0.1');
        $second = $this->register(['name' => 'Ravi K']);

        $this->assertSame($first, $second);
        $this->assertSame(1, SiteUser::count());
        $this->assertSame('Ravi K', SiteUser::first()->name);
    }

    public function test_every_user_gets_a_different_pin(): void
    {
        Mail::fake();
        $this->flushSession();

        foreach (range(1, 25) as $i) {
            RateLimiter::clear('site-register:127.0.0.1');
            $this->post('/register', $this->details(['email' => "user{$i}@example.com"]));
        }

        $this->assertSame(25, SiteUser::count());
        $this->assertSame(25, SiteUser::distinct()->count('pin_hash'));
    }

    public function test_pin_is_not_stored_in_plain_text(): void
    {
        Mail::fake();
        $this->flushSession();
        $this->post('/register', $this->details());
        $pin = SiteUser::first()->pin;

        $this->assertNotSame($pin, DB::table('site_users')->value('pin'));
        $this->assertNotSame($pin, DB::table('site_users')->value('pin_hash'));
    }

    // ---------- signing in with the pin ----------

    public function test_correct_pin_signs_in_and_logs_the_user(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->register();

        $this->post('/login', ['pin' => $pin])->assertRedirect('/');
        $this->get('/')->assertOk();

        $this->assertDatabaseHas('user_logins', [
            'username' => 'Ravi Kumar',
            'phone' => '+919876543210',
            'email' => 'ravi@example.com',
        ]);
    }

    public function test_pin_must_be_four_digits(): void
    {
        $this->flushSession();

        $this->post('/login', ['pin' => '123456'])->assertSessionHasErrors('pin');
        $this->post('/login', ['pin' => '12'])->assertSessionHasErrors('pin');
        $this->post('/login', ['pin' => 'abcd'])->assertSessionHasErrors('pin');
        $this->post('/login', [])->assertSessionHasErrors('pin');
    }

    public function test_wrong_pin_is_rejected(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->register();
        $wrong = $pin === '0000' ? '1111' : '0000';

        $this->post('/login', ['pin' => $wrong])->assertSessionHasErrors('pin');
        $this->get('/')->assertRedirect('/login');
        $this->assertSame(0, UserLogin::count());
    }

    public function test_an_ip_is_locked_out_after_five_wrong_pins(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->register();
        $wrong = $pin === '0000' ? '1111' : '0000';

        foreach (range(1, 5) as $i) {
            $this->post('/login', ['pin' => $wrong]);
        }

        // Even the right PIN is refused while locked out.
        $this->post('/login', ['pin' => $pin])->assertSessionHasErrors('pin');
        $this->get('/')->assertRedirect('/login');
    }

    public function test_everyone_is_locked_out_after_thirty_wrong_pins_overall(): void
    {
        Mail::fake();
        $this->flushSession();
        $pin = $this->register();

        // Simulates many different IPs that each stayed under their own limit.
        for ($i = 0; $i < 30; $i++) {
            RateLimiter::hit('site-pin-all', 900);
        }

        $this->post('/login', ['pin' => $pin])->assertSessionHasErrors('pin');
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
        $pin = $this->register();

        $this->post('/login', ['pin' => $pin])->assertRedirect('/');
        $this->get('/')->assertOk();

        Admin::create(['username' => 'boss', 'password' => 'secret123']);
        $visitor = session()->all();
        $this->flushSession();
        $this->withSession(['admin_id' => Admin::first()->id])
            ->post('/ktgadmin/user-logins/reset-sessions')
            ->assertRedirect('/ktgadmin/user-logins');

        // The old visitor session is rejected; signing in again works with the same PIN.
        $this->flushSession();
        $this->withSession($visitor)->get('/')->assertRedirect('/login');
        $this->flushSession();
        $this->post('/login', ['pin' => $pin])->assertRedirect('/');
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
