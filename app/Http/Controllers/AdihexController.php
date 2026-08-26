<?php

namespace App\Http\Controllers;

use App\Models\AdihexLead;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdihexController extends Controller
{
    /**
     * Prize Table Configuration & Probabilities
     */
    private array $prizes = [
        [
            'id' => 'discount_10',
            'label_en' => '10% Discount Voucher',
            'label_ar' => 'قسيمة خصم 10%',
            'value_en' => 'Valid on any service at Veneno',
            'value_ar' => 'صالحة على جميع خدمات فينينو',
            'weight' => 25,
            'color' => '#8B0000', // Deep Crimson
            'textColor' => '#FFFFFF',
        ],
        [
            'id' => 'wash_slime',
            'label_en' => 'Free Slime Wash',
            'label_ar' => 'غسيل سلايم مجاني',
            'value_en' => 'Worth AED 180 • Complimentary',
            'value_ar' => 'بقيمة 180 درهم • مجاناً',
            'weight' => 20,
            'color' => '#1A1A1A', // Deep Carbon
            'textColor' => '#E5C07B',
        ],
        [
            'id' => 'wash_diamond',
            'label_en' => 'Free Diamond Car Wash',
            'label_ar' => 'غسيل دايموند مجاني',
            'value_en' => 'Worth AED 250 • Complimentary',
            'value_ar' => 'بقيمة 250 درهم • مجاناً',
            'weight' => 20,
            'color' => '#C5A059', // Champagne Gold
            'textColor' => '#0A0A0A',
        ],
        [
            'id' => 'voucher_100',
            'label_en' => 'AED 100 Gift Voucher',
            'label_ar' => 'قسيمة بقيمة 100 درهم',
            'value_en' => 'Direct credit towards bookings',
            'value_ar' => 'رصيد مباشر للحجوزات',
            'weight' => 15,
            'color' => '#8B0000',
            'textColor' => '#FFFFFF',
        ],
        [
            'id' => 'tint_10',
            'label_en' => '10% Off Window Tinting',
            'label_ar' => 'خصم 10% على التظليل',
            'value_en' => 'Premium Nano-Ceramic Heat Rejection',
            'value_ar' => 'عزل حراري نانو سيراميك فاخر',
            'weight' => 10,
            'color' => '#1A1A1A',
            'textColor' => '#E5C07B',
        ],
        [
            'id' => 'polish_detailing',
            'label_en' => 'Free Polish & Detailing',
            'label_ar' => 'بوليش وتلميع مجاني',
            'value_en' => 'Worth AED 650 • High Excitement',
            'value_ar' => 'بقيمة 650 درهم • لمعان استثنائي',
            'weight' => 7,
            'color' => '#C5A059',
            'textColor' => '#0A0A0A',
        ],
        [
            'id' => 'platinum_20',
            'label_en' => '20% Off Platinum Package',
            'label_ar' => 'خصم 20% على باقة البلاتينيوم',
            'value_en' => 'Grand Prize • Ultra Prestige',
            'value_ar' => 'الجائزة الكبرى • الحماية الملكية',
            'weight' => 3, // Capped at 2 winners/day
            'color' => '#E50914', // Glowing Crimson Red
            'textColor' => '#FFFFFF',
        ],
    ];

    /**
     * ADIHEX Exclusive Show Packages
     */
    private array $packages = [
        [
            'id' => 'show_special',
            'tier' => 1,
            'badge' => '🔥 SHOW SPECIAL',
            'badge_ar' => '🔥 عرض المعرض الخاص',
            'name_en' => 'Detailing + Tinting Package',
            'name_ar' => 'باقة التلميع الشامل + التظليل الحراري',
            'desc_en' => 'Full Deep Clean Polish & Premium Ceramic Heat Rejection Window Film',
            'desc_ar' => 'تلميع ساطع مع فيلم عازل للحرارة نانو سيراميك فائق الجودة',
            'image' => '/images/adihex/packages/pkg_show_special.jpg',
            'original_price' => 2500,
            'promo_price' => 1699,
            'deposit' => 50,
        ],
        [
            'id' => 'silver',
            'tier' => 2,
            'badge' => 'SILVER TIER',
            'badge_ar' => 'الفئة الفضية',
            'name_en' => 'Silver Package',
            'name_ar' => 'الباقة الفضية',
            'desc_en' => '9H Nano Ceramic Coating (3-Year Warranty) + Multi-Stage Paint Correction',
            'desc_ar' => 'طلاء نانو سيراميك 9H (ضمان 3 سنوات) مع معالجة وتصحيح الطلاء',
            'image' => '/images/adihex/packages/pkg_silver.jpg',
            'original_price' => 2730,
            'promo_price' => 1899,
            'deposit' => 50,
        ],
        [
            'id' => 'golden',
            'tier' => 3,
            'badge' => '⭐ BEST VALUE',
            'badge_ar' => '⭐ القيمة الأفضل',
            'name_en' => 'Golden Package',
            'name_ar' => 'الباقة الذهبية',
            'desc_en' => 'Front-End PPF Armor + 5-Year Dual-Layer Ceramic Body & Interior Protection',
            'desc_ar' => 'حماية PPF للمقدمة + سيراميك مزدوج 5 سنوات للهيكل والمقصورة',
            'image' => '/images/adihex/packages/pkg_golden.jpg',
            'original_price' => 5775,
            'promo_price' => 3999,
            'deposit' => 50,
        ],
        [
            'id' => 'platinum',
            'tier' => 4,
            'badge' => '👑 ULTRA PRESTIGE',
            'badge_ar' => '👑 الحماية الملكية الفائقة',
            'name_en' => 'Platinum Package',
            'name_ar' => 'باقة البلاتينيوم الملكية',
            'desc_en' => 'Full Body G100 Self-Healing PPF (10-Yr) + Rock 5-Yr Tint + Full Interior & Rim Ceramic',
            'desc_ar' => 'حماية كاملة بالجلاد الذاتي G100 (ضمان 10 سنوات) + تظليل 5 سنوات + سيراميك شامل للجنوط والمقصورة',
            'image' => '/images/adihex/packages/pkg_platinum.jpg',
            'original_price' => 15000,
            'promo_price' => 9999,
            'deposit' => 50,
        ],
    ];

    /**
     * Show the ADIHEX 2026 Interactive Portal
     */
    public function index(Request $request, ?string $locale = null): Response
    {
        $currentLocale = $locale ?: $request->get('locale', 'en');
        if (!in_array($currentLocale, ['en', 'ar'])) {
            $currentLocale = 'en';
        }

        // Calculate dynamic booth telemetry
        $todaySpinsCount = AdihexLead::whereDate('created_at', Carbon::today())->count();
        $displaySpinCount = 184 + $todaySpinsCount; // Baseline booth social proof + real leads

        // Grand prize remaining today
        $platinumWinnersToday = AdihexLead::whereDate('created_at', Carbon::today())
            ->where('won_prize_tier', 'platinum_20')
            ->count();
        $remainingPlatinumSlots = max(0, 2 - $platinumWinnersToday);

        // Check if campaign is expired (after 6 Sept 2026)
        $campaignCutoff = Carbon::create(2026, 9, 6, 23, 59, 59);
        $isExpired = Carbon::now()->greaterThan($campaignCutoff);

        return Inertia::render('Adihex/Index', [
            'initialLocale' => $currentLocale,
            'prizes' => $this->prizes,
            'packages' => $this->packages,
            'stats' => [
                'displaySpinCount' => $displaySpinCount,
                'remainingPlatinumSlots' => $remainingPlatinumSlots,
                'isExpired' => $isExpired,
            ],
            'stripePublicKey' => config('services.stripe.key', env('STRIPE_KEY', 'pk_test_mock_veneno')),
        ]);
    }

    /**
     * Register Lead & Calculate Winning Spin Server-Side
     */
    public function spin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'phone' => 'required|string|min:8|max:25',
            'email' => 'nullable|email|max:150',
            'service_intent' => 'nullable|array',
            'locale' => 'nullable|string|in:en,ar',
        ]);

        $normalizedPhone = preg_replace('/[^\+0-9]/', '', $validated['phone']);
        if (!str_starts_with($normalizedPhone, '+') && str_starts_with($normalizedPhone, '971')) {
            $normalizedPhone = '+' . $normalizedPhone;
        } elseif (str_starts_with($normalizedPhone, '05')) {
            $normalizedPhone = '+971' . substr($normalizedPhone, 1);
        }

        // Anti-Gaming: Unique Single Chance Participation per Phone Number
        $existingLead = AdihexLead::where('phone', $normalizedPhone)
            ->latest()
            ->first();

        if ($existingLead) {
            $existingLead->update([
                'name' => $validated['name'] ?: $existingLead->name,
                'email' => !empty($validated['email']) ? $validated['email'] : $existingLead->email,
                'locale' => $validated['locale'] ?? $existingLead->locale,
                'service_intent' => $validated['service_intent'] ?? $existingLead->service_intent,
            ]);
            $existingLead->refresh();

            // Find corresponding prize index
            $prizeIndex = 0;
            foreach ($this->prizes as $idx => $p) {
                if ($p['id'] === $existingLead->won_prize_tier) {
                    $prizeIndex = $idx;
                    break;
                }
            }

            return response()->json([
                'success' => true,
                'is_existing' => true,
                'lead_id' => $existingLead->id,
                'winning_prize_index' => $prizeIndex,
                'won_prize' => $this->prizes[$prizeIndex],
                'voucher_code' => $existingLead->voucher_code,
                'voucher_expires_at' => $existingLead->voucher_expires_at ? $existingLead->voucher_expires_at->format('Y-m-d') : Carbon::now()->addDays(60)->format('Y-m-d'),
                'selected_package_id' => $existingLead->selected_package_id,
                'deposit_status' => $existingLead->deposit_status,
                'message' => 'Your spin and voucher have been restored.',
            ]);
        }

        // Server-Side Deterministic Weighted RNG with Daily Cap Check
        $platinumWinnersToday = AdihexLead::whereDate('created_at', Carbon::today())
            ->where('won_prize_tier', 'platinum_20')
            ->count();

        $activeWeights = [];
        foreach ($this->prizes as $idx => $prize) {
            $weight = $prize['weight'];
            // If Platinum Grand Prize cap (2/day) reached, shift weight to 10% Discount
            if ($prize['id'] === 'platinum_20' && $platinumWinnersToday >= 2) {
                $weight = 0;
            }
            $activeWeights[$idx] = $weight;
        }

        // If platinum weight was zeroed, add the 3% weight to discount_10
        if ($platinumWinnersToday >= 2) {
            $activeWeights[0] += 3;
        }

        $winningIndex = $this->calculateWeightedRandom($activeWeights);
        $wonPrize = $this->prizes[$winningIndex];

        // Generate Unique Alphanumeric Voucher Code
        do {
            $voucherCode = 'VEN-ADIHEX-' . rand(1000, 9999);
        } while (AdihexLead::where('voucher_code', $voucherCode)->exists());

        // Determine Initial Lead Classification
        $serviceIntent = $validated['service_intent'] ?? [];
        $leadTier = 'SPIN_PRIZE';
        if (is_array($serviceIntent) && (in_array('PPF Protection', $serviceIntent) || in_array('Ceramic Coating', $serviceIntent))) {
            $leadTier = 'HIGH_INTENT_PPF';
        }

        // Expiration: 60 days validity
        $expiresAt = Carbon::now()->addDays(60);

        // Store Lead in Database
        $lead = AdihexLead::create([
            'name' => $validated['name'],
            'phone' => $normalizedPhone,
            'email' => $validated['email'] ?? null,
            'service_intent' => $serviceIntent,
            'won_prize_tier' => $wonPrize['id'],
            'won_prize_label' => $wonPrize['label_en'],
            'voucher_code' => $voucherCode,
            'voucher_expires_at' => $expiresAt,
            'is_redeemed' => false,
            'lead_tier' => $leadTier,
            'deposit_status' => 'pending',
            'locale' => $validated['locale'] ?? 'en',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'is_existing' => false,
            'lead_id' => $lead->id,
            'winning_prize_index' => $winningIndex,
            'won_prize' => $wonPrize,
            'voucher_code' => $voucherCode,
            'voucher_expires_at' => $expiresAt->format('Y-m-d'),
            'whatsapp_url' => $lead->getWhatsAppUrl(),
        ]);
    }

    /**
     * Handle Show Package Reservation (AED 500 or Skip)
     */
    public function reserve(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:adihex_leads,id',
            'package_id' => 'required|string',
            'action' => 'required|string|in:pay,skip',
            'payment_method' => 'nullable|string',
            'stripe_payment_id' => 'nullable|string',
        ]);

        $lead = AdihexLead::findOrFail($validated['lead_id']);

        if ($validated['action'] === 'skip' || $validated['package_id'] === 'skip') {
            $lead->update([
                'deposit_status' => 'skipped',
                'deposit_amount' => 0.00,
            ]);

            // Automated Step 7 Notifications (SMS & Email)
            $this->dispatchStep7Notifications($lead);

            return response()->json([
                'success' => true,
                'status' => 'skipped',
                'lead' => $lead,
                'whatsapp_url' => $lead->getWhatsAppUrl(),
            ]);
        }

        // Lookup Package
        $selectedPkg = collect($this->packages)->firstWhere('id', $validated['package_id']);
        if (!$selectedPkg) {
            $selectedPkg = $this->packages[2]; // Default Golden
        }

        $lead->update([
            'selected_package_id' => $selectedPkg['id'],
            'selected_package_name' => $selectedPkg['name_en'],
            'package_price' => $selectedPkg['promo_price'],
            'deposit_amount' => 500.00,
            'deposit_status' => 'paid',
            'lead_tier' => 'VIP_RESERVED',
            'stripe_payment_id' => $validated['stripe_payment_id'] ?? ('pi_adihex_' . Str::random(16)),
        ]);

        // Automated Step 7 Notifications (SMS & Email)
        $this->dispatchStep7Notifications($lead);

        return response()->json([
            'success' => true,
            'status' => 'paid',
            'lead' => $lead,
            'package' => $selectedPkg,
            'whatsapp_url' => $lead->getWhatsAppUrl(),
        ]);
    }

    /**
     * Dispatch Automated SMS & Email at Step 7
     */
    private function dispatchStep7Notifications(AdihexLead $lead): void
    {
        try {
            // 1. Send SMS via SMSGlobal
            $smsService = new \App\Services\SmsGlobalService();
            $smsService->sendAdihexVoucherSms($lead);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[ADIHEX] Automated SMS dispatch failed: ' . $e->getMessage());
        }

        try {
            // 2. Send Email via SMTP if customer provided email
            if (!empty($lead->email)) {
                \Illuminate\Support\Facades\Mail::to($lead->email)->send(new \App\Mail\AdihexVoucherMail($lead));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[ADIHEX] Automated Email dispatch failed: ' . $e->getMessage());
        }
    }

    /**
     * Create Real Stripe PaymentIntent for AED 500.00 Deposit
     */
    public function createPaymentIntent(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:adihex_leads,id',
            'package_id' => 'required|string',
        ]);

        $lead = AdihexLead::findOrFail($validated['lead_id']);
        $selectedPkg = collect($this->packages)->firstWhere('id', $validated['package_id']) ?? $this->packages[0];

        $stripeSecret = config('services.stripe.secret') ?: env('STRIPE_SECRET');
        if (!$stripeSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe secret key is not configured.',
            ], 500);
        }

        try {
            \Stripe\Stripe::setApiKey($stripeSecret);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 50000, // 500.00 AED (in fils)
                'currency' => 'aed',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'lead_id' => $lead->id,
                    'customer_name' => $lead->name,
                    'customer_phone' => $lead->phone,
                    'package_id' => $selectedPkg['id'],
                    'package_name' => $selectedPkg['name_en'],
                    'campaign' => 'ADIHEX_2026',
                ],
                'description' => 'Veneno Auto Care - ADIHEX 2026 Reservation Deposit: ' . $selectedPkg['name_en'],
            ]);

            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
                'publishableKey' => config('services.stripe.key') ?: env('STRIPE_KEY'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Redeem Voucher Code (CRM or Reception Action)
     */
    public function redeemVoucher(Request $request)
    {
        $validated = $request->validate([
            'voucher_code' => 'required|string',
        ]);

        $code = strtoupper(trim($validated['voucher_code']));
        $lead = AdihexLead::where('voucher_code', $code)->first();

        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher code not found.',
            ], 404);
        }

        if ($lead->is_redeemed) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher was already redeemed on ' . $lead->redeemed_at->format('M d, Y H:i'),
                'lead' => $lead,
            ], 422);
        }

        $lead->update([
            'is_redeemed' => true,
            'redeemed_at' => Carbon::now(),
            'status' => 'redeemed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher redeemed successfully for ' . $lead->name,
            'lead' => $lead,
        ]);
    }

    /**
     * Export ADIHEX Leads to CSV
     */
    public function exportLeads(): StreamedResponse
    {
        $fileName = 'veneno_adihex_leads_' . Carbon::now()->format('Y_m_d_His') . '.csv';
        $leads = AdihexLead::latest()->get();

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'ID',
            'Full Name',
            'Phone',
            'Email',
            'Lead Tier',
            'Won Prize',
            'Voucher Code',
            'Expires At',
            'Is Redeemed',
            'Redeemed At',
            'Selected Package',
            'Package Price (AED)',
            'Deposit Amount (AED)',
            'Deposit Status',
            'Service Intent',
            'Locale',
            'Created At'
        ];

        return response()->stream(function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->name,
                    $lead->phone,
                    $lead->email ?? 'N/A',
                    $lead->lead_tier,
                    $lead->won_prize_label,
                    $lead->voucher_code,
                    $lead->voucher_expires_at ? $lead->voucher_expires_at->format('Y-m-d') : '',
                    $lead->is_redeemed ? 'Yes' : 'No',
                    $lead->redeemed_at ? $lead->redeemed_at->format('Y-m-d H:i:s') : '',
                    $lead->selected_package_name ?? 'None',
                    $lead->package_price ?? 0,
                    $lead->deposit_amount,
                    $lead->deposit_status,
                    is_array($lead->service_intent) ? implode(', ', $lead->service_intent) : '',
                    $lead->locale,
                    $lead->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Helper to pick weighted random index
     */
    private function calculateWeightedRandom(array $weights): int
    {
        $totalWeight = array_sum($weights);
        if ($totalWeight <= 0) {
            return 0;
        }

        $rand = rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return (int)$index;
            }
        }

        return 0;
    }
}
