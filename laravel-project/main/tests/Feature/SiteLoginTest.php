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
}
