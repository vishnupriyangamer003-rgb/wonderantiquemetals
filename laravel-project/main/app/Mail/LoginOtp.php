<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** One-time login code sent to the admin inbox; the admin passes it to the client. */
class LoginOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $username,
        public string $code,
        public int $minutes = 5,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login code for '.$this->username,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.otp',
            with: [
                'username' => $this->username,
                'code' => $this->code,
                'minutes' => $this->minutes,
            ],
        );
    }
}
