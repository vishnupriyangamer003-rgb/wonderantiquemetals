<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** A registered user's fixed PIN, sent to the admin inbox only; the admin passes it to the user. */
class LoginOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public string $code,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'New registration - pincode for '.$this->name,
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
            ],
        );
    }
}
