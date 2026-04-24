<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Contact $contact
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->contact->subject
            ?: 'Liên hệ mới từ ' . $this->contact->name;

        return new Envelope(
            subject: '[Viam Semicon] ' . $subject,
            replyTo: array_filter([
                $this->contact->email ? new \Illuminate\Mail\Mailables\Address(
                    $this->contact->email,
                    $this->contact->name
                ) : null,
            ]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
