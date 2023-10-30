<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $request){}

    
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->request->public_email, $this->request->name),
            subject: "Public Message : ".$this->request->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'landlord.public-section.emails.contact-us',
            with: [
                'name' => $this->request->name,
                'bodyMessage' => $this->request->message,
                'phone' => $this->request->phone,
                'public_email' => $this->request->public_email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
