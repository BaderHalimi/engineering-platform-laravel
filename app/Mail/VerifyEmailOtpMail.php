<?php

namespace App\Mail;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;

class VerifyEmailOtpMail extends Mailable
{
    public function __construct(
        public string $otp
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email-otp',
        );
    }
}
