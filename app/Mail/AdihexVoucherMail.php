<?php

namespace App\Mail;

use App\Models\AdihexLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdihexVoucherMail extends Mailable
{
    use Queueable, SerializesModels;

    public AdihexLead $lead;

    public function __construct(AdihexLead $lead)
    {
        $this->lead = $lead;
    }

    public function envelope(): Envelope
    {
        $isAr = ($this->lead->locale === 'ar');
        $subject = $isAr
            ? "قسيمة الفائز في أديهيكس 2026 — فينينو للعناية بالسيارات [{$this->lead->voucher_code}]"
            : "Official ADIHEX 2026 Winner Voucher — Veneno Auto Care [{$this->lead->voucher_code}]";

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.adihex_voucher',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
