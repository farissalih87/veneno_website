<?php

namespace App\Http\Controllers;

use App\Models\ServicePackage;
use App\Models\ServiceAddon;
use App\Models\Inquiry;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    /**
     * Homepage with cinematic video hero, services, before/after slider, and testimonials.
     */
    public function home(): Response
    {
        $services = ServicePackage::all();
        $addons = ServiceAddon::all();

        return Inertia::render('Storefront/Home', [
            'services' => $services,
            'addons' => $addons,
        ]);
    }

    /**
     * Dedicated Service Landing Page.
     */
    public function serviceDetail(string $slug): Response
    {
        $service = ServicePackage::where('slug', $slug)->firstOrFail();
        $allServices = ServicePackage::select('id', 'name', 'slug', 'category', 'badge', 'popular')->get();
        $addons = ServiceAddon::all();

        return Inertia::render('Storefront/ServiceDetail', [
            'service' => $service,
            'allServices' => $allServices,
            'addons' => $addons,
        ]);
    }

    /**
     * Store WhatsApp Inquiry lead in CRM database.
     */
    public function storeInquiry(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'vehicle_details' => 'nullable|string|max:255',
            'service_requested' => 'nullable|string|max:255',
            'message_text' => 'nullable|string',
        ]);

        $inquiry = Inquiry::create($validated);

        return response()->json([
            'success' => true,
            'inquiry_id' => $inquiry->id,
            'message' => 'Your inquiry has been received and logged to our concierge team.',
        ]);
    }

    /**
     * AI Vehicle Inspection & Quote Estimator.
     */
    public function aiQuoteEstimate(Request $request)
    {
        $make = $request->input('vehicleMake', 'Porsche');
        $model = $request->input('vehicleModel', '911');
        $year = $request->input('vehicleYear', 2024);
        $type = $request->input('vehicleType', 'coupe');
        $paintCondition = $request->input('paintCondition', 'Swirl marks and light scratches');
        $interiorCondition = $request->input('interiorCondition', 'Leather conditioning required');

        $isExotic = in_array(strtolower($type), ['exotic', 'coupe']);

        return response()->json([
            'success' => true,
            'recommendedPackage' => $isExotic ? 'Diamond Ceramic Coating' : 'Multi-Stage Paint Correction',
            'estimatedHours' => $isExotic ? 8 : 6,
            'estimatedPriceRange' => $isExotic ? '$750 - $1,250' : '$499 - $799',
            'urgencyLevel' => 'Medium',
            'summary' => "Appraisal for {$year} {$make} {$model}: Based on {$paintCondition} and {$interiorCondition}, a multi-stage corrective leveling followed by a certified 9H hydrophobic matrix will eliminate over 90% of optical micro-defects and lock in permanent showroom gloss.",
            'recommendedAddons' => [
                'Windshield & Glass Hydrophobic Shield',
                'Wheel Off Barrel & Caliper Ceramic',
                'Leather Ceramic Barrier & Stain Guard',
            ],
            'stages' => [
                'Decontamination Snow Foam Wash & Clay Bar Treatment',
                'Paint Depth Electronic Measurement & Panel Masking',
                'Dual-Action Micro-Compound & Jeweling Polish',
                'IPA Alcohol Surface Wipe & 9H Graphene Ceramic Layering',
            ],
        ]);
    }
}
