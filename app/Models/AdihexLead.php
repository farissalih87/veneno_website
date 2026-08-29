<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdihexLead extends Model
{
    use HasFactory;

    protected $table = 'adihex_leads';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'service_intent',
        'won_prize_tier',
        'won_prize_label',
        'voucher_code',
        'voucher_expires_at',
        'is_redeemed',
        'redeemed_at',
        'selected_package_id',
        'selected_package_name',
        'package_price',
        'deposit_amount',
        'deposit_status',
        'stripe_payment_id',
        'lead_tier',
        'status',
        'notes',
        'locale',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'service_intent' => 'array',
        'is_redeemed' => 'boolean',
        'voucher_expires_at' => 'datetime',
        'redeemed_at' => 'datetime',
        'package_price' => 'float',
        'deposit_amount' => 'float',
    ];

    // Scopes
    public function scopeVipReserved($query)
    {
        return $query->where('lead_tier', 'VIP_RESERVED');
    }

    public function scopeHighIntent($query)
    {
        return $query->where('lead_tier', 'HIGH_INTENT_PPF');
    }

    public function scopeSpinWinners($query)
    {
        return $query->where('lead_tier', 'SPIN_PRIZE');
    }

    public function scopeRedeemed($query)
    {
        return $query->where('is_redeemed', true);
    }

    public function scopeUnredeemed($query)
    {
        return $query->where('is_redeemed', false);
    }

    /**
     * Get Localized Won Prize Label
     */
    public function getPrizeLabel(?string $locale = null): string
    {
        $loc = $locale ?: ($this->locale ?: 'en');
        $map = [
            'polish_detailing' => ['en' => 'Free Polish & Detailing', 'ar' => 'بوليش وتلميع مجاني'],
            'tint_20' => ['en' => '20% Off Window Tinting', 'ar' => 'خصم 20% على التظليل'],
            'voucher_100' => ['en' => 'AED 100 Gift Voucher', 'ar' => 'قسيمة 100 درهم'],
            'wash_diamond' => ['en' => 'Free Diamond Car Wash', 'ar' => 'غسيل دايموند مجاني'],
            'wash_slime' => ['en' => 'Free Slime Wash', 'ar' => 'غسيل سلايم مجاني'],
            'discount_20' => ['en' => '20% Off All Services', 'ar' => 'خصم 20% على جميع الخدمات'],
            'platinum_20' => ['en' => '20% Off Platinum Package', 'ar' => 'خصم 20% على باقة Platinum'],
            // Backwards compatibility
            'discount_10' => ['en' => '20% Off All Services', 'ar' => 'خصم 20% على جميع الخدمات'],
            'tint_10' => ['en' => '20% Off Window Tinting', 'ar' => 'خصم 20% على التظليل'],
        ];

        if (isset($map[$this->won_prize_tier][$loc])) {
            return $map[$this->won_prize_tier][$loc];
        }

        return $this->won_prize_label ?: 'ADIHEX 2026 Prize';
    }

    /**
     * Get Localized Package Name
     */
    public function getPackageName(?string $locale = null): ?string
    {
        if (!$this->selected_package_id) return $this->selected_package_name;
        $loc = $locale ?: ($this->locale ?: 'en');
        $pkgMap = [
            'silver' => ['en' => 'Silver Protection Package', 'ar' => 'باقة الحماية الفضية'],
            'show_special' => ['en' => 'Show Special Detailing & Tint', 'ar' => 'عرض المعرض الخاص: تلميع وتظليل'],
            'golden' => ['en' => 'Golden Armor PPF Package', 'ar' => 'باقة الدرع الذهبي لحماية الطلاء'],
            'platinum' => ['en' => 'Platinum Prestige Full PPF', 'ar' => 'باقة برستيج البلاتينية الكاملة PPF'],
        ];

        if (isset($pkgMap[$this->selected_package_id][$loc])) {
            return $pkgMap[$this->selected_package_id][$loc];
        }

        return $this->selected_package_name;
    }

    /**
     * Generate WhatsApp Direct Booking URL
     */
    public function getWhatsAppUrl(): string
    {
        $phoneClean = preg_replace('/[^0-9]/', '', $this->phone);
        $conciergeNumber = '97126344403';
        $isAr = ($this->locale === 'ar');
        $prize = $this->getPrizeLabel($this->locale);
        $pkg = $this->getPackageName($this->locale);
        
        if ($isAr) {
            $msg = "مرحباً فينينو، لقد فزت بـ *{$prize}* في معرض أديهيكس 2026";
            if ($pkg && $this->deposit_status === 'paid') {
                $msg .= " وقمت بحجز *{$pkg}* (العربون: {$this->deposit_amount} درهم مدفوع)";
            }
            $msg .= ". كود القسيمة الخاص بي: *{$this->voucher_code}*. العميل: {$this->name} ({$this->phone})";
        } else {
            $msg = "Hello Veneno, I won *{$prize}* at ADIHEX 2026";
            if ($pkg && $this->deposit_status === 'paid') {
                $msg .= " and reserved the *{$pkg}* (Deposit: AED {$this->deposit_amount} Paid)";
            }
            $msg .= ". My voucher code is *{$this->voucher_code}*. Customer: {$this->name} ({$this->phone})";
        }

        return "https://wa.me/{$conciergeNumber}?text=" . urlencode($msg);
    }
}
