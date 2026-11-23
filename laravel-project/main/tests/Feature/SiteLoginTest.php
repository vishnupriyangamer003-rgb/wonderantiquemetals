<?php

namespace Tests\Feature;

use App\Mail\LoginOtp;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteLoginTest extends TestCase
{
    public function test_otp_is_four_digits_and_mailed(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', ['username' => 'client'])->assertRedirect('/login');

        Mail::assertSent(LoginOtp::class, fn (LoginOtp $m) => preg_match('/^[0-9]{4}$/', $m->code) === 1);
    }

    public function test_code_must_be_exactly_four_digits(): void
    {
        $this->flushSession();
        $this->post('/login', ['username' => 'client']);

        $this->post('/login/verify', ['code' => '123456'])->assertSessionHasErrors('code');
        $this->post('/login/verify', ['code' => '12'])->assertSessionHasErrors('code');
    }

    public function test_correct_code_signs_in(): void
    {
        Mail::fake();
        $this->flushSession();
        $this->post('/login', ['username' => 'client']);

        $code = null;
        Mail::assertSent(LoginOtp::class, function (LoginOtp $m) use (&$code) {
            $code = $m->code;

            return true;
        });

        $this->post('/login/verify', ['code' => $code])->assertRedirect('/');
        $this->get('/')->assertOk();
    }

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

    public function test_bypass_username_signs_in_without_otp(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', ['username' => '  saravanan   NAMAKKAL '])->assertRedirect('/');

        Mail::assertNothingSent();
        $this->assertDatabaseHas('user_logins', ['username' => 'saravanan NAMAKKAL']);
        $this->get('/')->assertOk();
    }

    public function test_other_usernames_still_need_otp(): void
    {
        Mail::fake();
        $this->flushSession();

        $this->post('/login', ['username' => 'someone'])->assertRedirect('/login');

        Mail::assertSent(LoginOtp::class);
        $this->get('/')->assertRedirect('/login');
    }

    public function test_admin_reset_signs_every_visitor_out(): void
    {
        Mail::fake();
        $this->flushSession();
        config(['site.login_bypass_username' => 'Owner']);

        // A visitor signs in, then the admin resets all sessions.
        $this->post('/login', ['username' => 'Owner'])->assertRedirect('/');
        $this->get('/')->assertOk();

        \App\Models\Admin::create(['username' => 'boss', 'password' => 'secret123']);
        $visitor = session()->all();
        $this->flushSession();
        $this->withSession(['admin_id' => \App\Models\Admin::first()->id])
            ->post('/ktgadmin/user-logins/reset-sessions')
            ->assertRedirect('/ktgadmin/user-logins');

        // The old visitor session is rejected; a fresh sign-in works again.
        $this->flushSession();
        $this->withSession($visitor)->get('/')->assertRedirect('/login');
        $this->flushSession();
        $this->post('/login', ['username' => 'Owner'])->assertRedirect('/');
        $this->get('/')->assertOk();
    }

    public function test_guests_cannot_reset_sessions(): void
    {
        $this->post('/ktgadmin/user-logins/reset-sessions')->assertRedirect('/ktgadmin');
    }

    public function test_user_logins_table_has_no_ip_column(): void
    {
        \App\Models\Admin::create(['username' => 'boss', 'password' => 'secret123']);
        \App\Models\UserLogin::create(['username' => 'client', 'login_at' => now()]);

        $this->flushSession();
        $this->withSession(['admin_id' => \App\Models\Admin::first()->id])
            ->get('/ktgadmin/user-logins')
            ->assertOk()->assertSee('client')
            ->assertDontSee('IP address');
        $this->assertFalse(\Illuminate\Support\Facades\Schema::hasColumn('user_logins', 'ip'));
    }

    public function test_login_times_are_shown_in_indian_time(): void
    {
        $this->assertSame('Asia/Kolkata', config('app.timezone'));

        \App\Models\Admin::create(['username' => 'boss', 'password' => 'secret123']);
        \App\Models\UserLogin::create([
            'username' => 'clock',
            'login_at' => \Illuminate\Support\Carbon::parse('2026-11-23 13:18:00', 'Asia/Kolkata'),
        ]);

        $this->flushSession();
        $this->withSession(['admin_id' => \App\Models\Admin::first()->id])
            ->get('/ktgadmin/user-logins')
            ->assertSee('01:18:00 PM IST');
    }
}
