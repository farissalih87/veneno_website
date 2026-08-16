<?php

namespace App\Http\Controllers;

use App\Models\ServicePackage;
use App\Models\ServiceAddon;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class StorefrontController extends Controller
{
    /**
     * Official 9 Services Data Dictionary with Authentic Media Paths
     */
    public static function getOfficialServices(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Paint Protection Film (PPF)',
                'tagline' => 'Self-Healing 8mil Optical Armor with 10-Year Warranty',
                'slug' => 'paint-protection-film',
                'category' => 'ppf',
                'badge' => 'Ultimate Protection',
                'popular' => true,
                'description' => 'Precision computer-cut optical clear polyurethane film that self-heals swirl marks with sun heat. Protects against stone chips, highway sand abrasion, and road debris.',
                'image' => '/images/services/ppf/IMG_5902.JPG',
                'before_image' => '/images/services/ppf/IMG_5968.JPG',
                'after_image' => '/images/services/ppf/IMG_5965.JPG',
                'warranty' => '10-Year Warranty',
                'duration_hours' => 12,
                'features' => [
                    'Computer-cut digital plotters with wrapped seamless edges',
                    'Self-healing elastomeric top coat under ambient heat',
                    'Total rock chip & high-speed gravel protection',
                    'UV & anti-yellowing optical clarity guarantee',
                    'Hydrophobic top layer for effortless maintenance',
                ],
            ],
            [
                'id' => 2,
                'name' => 'Diamond Ceramic Coating',
                'tagline' => '9H+ Multi-Layer Graphene Hydrophobic Shield',
                'slug' => 'ceramic-coating',
                'category' => 'ceramic',
                'badge' => 'Showroom Reflection',
                'popular' => true,
                'description' => 'Our flagship 9H+ nano-ceramic formula bonds molecularly to automotive clear coat, delivering extreme 115° hydrophobic water beading, UV defense, and mirror reflection depth.',
                'image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
                'before_image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 10.JPG',
                'after_image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 14.JPG',
                'warranty' => '5-Year Certified Warranty',
                'duration_hours' => 8,
                'features' => [
                    'Multi-stage chemical decontamination wash & clay bar',
                    'Stage 1 corrective polish to optimize surface reflection',
                    'Dual-layer 9H nano-graphene ceramic base coat',
                    'Wheels, brake calipers & exterior glass ceramic barrier',
                    'IR curing lamps for maximum surface bond hardness',
                ],
            ],
            [
                'id' => 3,
                'name' => 'Detailing & Paint Correction',
                'tagline' => 'Concourse Swirl & Hologram Leveling',
                'slug' => 'detailing-paint-correction',
                'category' => 'detailing',
                'badge' => 'Flawless Finish',
                'popular' => false,
                'description' => 'Concourse-grade microscopic surface leveling using precision rotary and dual-action polishers to eliminate swirl marks, buffer holograms, and oxidation.',
                'image' => '/images/services/detailing/IMG_5899.JPG',
                'before_image' => '/images/services/detailing/PHOTO-2024-07-12-14-12-51 18.JPG',
                'after_image' => '/images/services/detailing/PHOTO-2024-07-12-14-12-51 24.JPG',
                'warranty' => 'Optical Reflection Guarantee',
                'duration_hours' => 6,
                'features' => [
                    'Digital electronic paint depth measurement per panel',
                    'Heavy cutting compound for deep wash scratch removal',
                    'Jeweling refining polish for concourse mirror gloss',
                    'Panel wipe IPA alcohol inspection under sunlight LEDs',
                    'Synthetic protective sealant finish',
                ],
            ],
            [
                'id' => 4,
                'name' => 'Ceramic Window Tinting',
                'tagline' => 'Up to 98% Infrared Heat & 99% UV Rejection',
                'slug' => 'window-tinting',
                'category' => 'tinting',
                'badge' => 'Thermal Shield',
                'popular' => false,
                'description' => 'Ultra-high heat rejection nano-ceramic window films designed specifically for Middle East climate. Keeps interior significantly cooler while blocking 99% UV rays.',
                'image' => '/images/services/tinting/IMG_5967.JPG',
                'before_image' => '/images/services/tinting/IMG_5969.JPG',
                'after_image' => '/images/services/tinting/IMG_5971.JPG',
                'warranty' => 'Lifetime Bubble-Free Warranty',
                'duration_hours' => 3,
                'features' => [
                    'Computer-cut glass templates tailored per model',
                    '99% UV-A / UV-B skin & upholstery protection',
                    'Up to 94% Infrared (IR) solar heat barrier',
                    'Zero signal interference for mobile & GPS',
                ],
            ],
            [
                'id' => 5,
                'name' => 'Vehicle Wrapping & Color Change',
                'tagline' => 'Premium Cast Vinyl in Gloss, Satin & Matte Finishes',
                'slug' => 'car-wrapping',
                'category' => 'wrapping',
                'badge' => 'Bespoke Styling',
                'popular' => false,
                'description' => 'Transform your vehicle aesthetics with world-class vinyl wraps from 3M, Avery Dennison, and Inozetek. Reversible protection with endless finish possibilities.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 20.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 23.JPG',
                'warranty' => '3-Year Installation Warranty',
                'duration_hours' => 24,
                'features' => [
                    'Disassembly by certified technicians for wrapped tucks',
                    'Extensive choice of gloss, satin, matte, and chrome',
                    'Original OEM paint preserved underneath',
                    'Complete door jambs wrapping available',
                ],
            ],
            [
                'id' => 6,
                'name' => 'Paintless Dent Repair (PDR)',
                'tagline' => 'Factory-Finish Restoration with Zero Repainting',
                'slug' => 'paintless-dent-repair',
                'category' => 'pdr',
                'badge' => 'Preserve Factory Paint',
                'popular' => false,
                'description' => 'Precision dent removal utilizing specialized metallurgy tools from behind the panel. Preserves 100% of original factory paint and vehicle resale value.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 17.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 11.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 19.JPG',
                'warranty' => 'Lifetime Paint Integrity',
                'duration_hours' => 2,
                'features' => [
                    'Zero body filler, sanding, or repainting required',
                    'Fast same-day turnaround for door dings & creases',
                    '100% preservation of original factory clear coat',
                    'Specialized LED reflection board precision alignment',
                ],
            ],
            [
                'id' => 7,
                'name' => 'Rims Protection & Wheel Repair',
                'tagline' => 'Curb Rash CNC Machining & High-Temp Ceramic Armor',
                'slug' => 'rims-protection-repair',
                'category' => 'rims',
                'badge' => 'Wheel Perfection',
                'popular' => false,
                'description' => 'Complete wheel restoration, diamond-cut CNC face re-machining, custom powder coating, and high-temp ceramic coating to resist corrosive brake dust.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 21.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 3.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 4.JPG',
                'warranty' => 'Finish Durability Guaranteed',
                'duration_hours' => 4,
                'features' => [
                    'Precision curb rash repair and structural trueing',
                    'Factory OEM color matching and diamond-cut CNC finish',
                    '1200°F high-temp ceramic coating against brake dust',
                    'Wheel barrel deep cleaning and caliper detailing',
                ],
            ],
            [
                'id' => 8,
                'name' => 'Paint & Body Restoration',
                'tagline' => 'Concourse Panel Spraying & Scratch Elimination',
                'slug' => 'paint-body-work',
                'category' => 'paint',
                'badge' => 'Concourse Bodywork',
                'popular' => false,
                'description' => 'Down-draft heated spray booth painting using computer-spectrometer color matching and OEM-approved high-solid clear coats for an undetectable finish.',
                'image' => '/images/services/paint/IMG_5901.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 12.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 13.JPG',
                'warranty' => 'Color Match Guaranteed',
                'duration_hours' => 16,
                'features' => [
                    'Computerized spectrometer color formulation',
                    'Dust-free positive pressure down-draft spray booth',
                    'High-solid UV clear coats matching factory orange peel',
                    'Post-cure wet sanding and mirror gloss buffing',
                ],
            ],
            [
                'id' => 9,
                'name' => 'Signature Decontamination Car Wash',
                'tagline' => 'Two-Bucket Scratch-Free Wash with Iron Decontamination',
                'slug' => 'premium-car-wash',
                'category' => 'wash',
                'badge' => 'Essential Care',
                'popular' => false,
                'description' => 'pH-neutral snow foam wash with grit-guard two-bucket method, wheel arch pressure flush, chemical iron fallout removal, and filtered warm-air drying.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 5.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 7.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51.JPG',
                'warranty' => '100% Scratch-Free Guarantee',
                'duration_hours' => 2,
                'features' => [
                    'pH-neutral thick foam bath encapsulating dirt',
                    'Ultra-soft plush microfiber mitts with grit guards',
                    'Iron fallout decontamination & wheel barrel wash',
                    'Touchless heated filtered air drying',
                    'Interior vacuum, dashboard wipe, and tire satin dress',
                ],
            ],
        ];
    }

    /**
     * Homepage with cinematic video hero, 9 services, real before/after, and quote section.
     */
    public function home(): Response
    {
        $services = self::getOfficialServices();
        
        $galleryImages = [
            '/images/gallery/PHOTO-2024-07-12-14-12-51.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 24.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 23.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 15.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 14.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 13.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 9.JPG',
            '/images/gallery/IMG_5902.JPG',
            '/images/gallery/IMG_5899.JPG',
            '/images/gallery/IMG_5965.JPG',
            '/images/gallery/IMG_5967.JPG',
        ];

        return Inertia::render('Storefront/Home', [
            'services' => $services,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Dedicated Standalone Service Landing Page.
     */
    public function serviceDetail(string $slug): Response
    {
        $services = self::getOfficialServices();
        $service = collect($services)->firstWhere('slug', $slug);

        if (!$service) {
            abort(404, 'Service not found');
        }

        return Inertia::render('Storefront/ServiceDetail', [
            'service' => $service,
            'allServices' => $services,
        ]);
    }

    /**
     * Submit Quote Request form (sends email to info@veneno.ae and logs to CRM database).
     */
    public function submitQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        // 1. Log Inquiry to CRM database
        $inquiry = Inquiry::create([
            'customer_name' => $validated['name'],
            'phone' => $validated['phone'],
            'service_requested' => $validated['service'] ?? 'General Inquiry',
            'message_text' => "Email: {$validated['email']}\n\nMessage:\n{$validated['message']}",
            'status' => 'new',
        ]);

        // 2. Dispatch Email notification to company email info@veneno.ae
        try {
            $toEmail = 'info@veneno.ae';
            $subject = "🏎️ New Quote Request from {$validated['name']} - Veneno Auto Care";
            $emailBody = "New Quote Request via veneno.ae\n\n"
                . "Client Name: {$validated['name']}\n"
                . "Phone: {$validated['phone']}\n"
                . "Email: {$validated['email']}\n"
                . "Service Requested: " . ($validated['service'] ?? 'Not specified') . "\n\n"
                . "Message:\n{$validated['message']}\n\n"
                . "Inquiry ID: #{$inquiry->id}\n"
                . "Date: " . now()->format('Y-m-d H:i:s T');

            Mail::raw($emailBody, function ($msg) use ($toEmail, $subject, $validated) {
                $msg->to($toEmail)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error("Failed to send quote email to info@veneno.ae: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your quote request has been sent to info@veneno.ae. Our concierge will contact you shortly.',
        ]);
    }

    /**
     * Store WhatsApp Inquiry lead in CRM database.
     */
    public function storeInquiry(Request $request)
    {
        return $this->submitQuote($request);
    }
}

