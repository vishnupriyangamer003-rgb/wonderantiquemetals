<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** A user's fixed login PIN, sent to the admin inbox; the admin passes it to the client. */
class LoginOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public string $code,
        public int $minutes = 5,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Your Wonder Antique Metals login PIN',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.otp',
            text: 'mail.otp-text',
            with: [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'code' => $this->code,
                'minutes' => $this->minutes,
            ],
        );
    }
}
