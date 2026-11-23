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
}
