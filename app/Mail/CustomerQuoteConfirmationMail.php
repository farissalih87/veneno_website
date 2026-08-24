<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerQuoteConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Inquiry $inquiry;
    public array $leadData;

    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry, array $leadData)
    {
        $this->inquiry = $inquiry;
        $this->leadData = $leadData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "✨ Quote Request Received — Veneno Auto Care Center Abu Dhabi",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_quote_confirmation',
            with: [
                'inquiry' => $this->inquiry,
                'lead' => $this->leadData,
            ],
        );
    }
}
