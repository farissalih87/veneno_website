<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AdminQuoteLeadMail extends Mailable
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
        $service = $this->leadData['service'] ?? 'Auto Care Service';
        $clientName = $this->leadData['name'] ?? 'New Client';
        $phone = $this->leadData['phone'] ?? '';

        $replyTo = [];
        if (!empty($this->leadData['email']) && filter_var($this->leadData['email'], FILTER_VALIDATE_EMAIL)) {
            $replyTo[] = new Address($this->leadData['email'], $clientName);
        }

        return new Envelope(
            subject: "🏎️ [Quote Lead #{$this->inquiry->id}] {$service} — {$clientName} ({$phone})",
            replyTo: $replyTo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_quote_lead',
            with: [
                'inquiry' => $this->inquiry,
                'lead' => $this->leadData,
            ],
        );
    }
}
