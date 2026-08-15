<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingStagesHistory;
use App\Models\Payment;
use App\Models\ServicePackage;
use App\Models\ServiceAddon;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Store a new booking with optional Stripe payment session.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'vehicle_make' => 'required|string|max:100',
            'vehicle_model' => 'required|string|max:100',
            'vehicle_year' => 'required|integer|min:1950|max:2030',
            'vehicle_color' => 'nullable|string|max:50',
            'vehicle_type' => 'required|in:sedan,coupe,suv,truck,exotic',
            'license_plate' => 'nullable|string|max:50',
            'service_package_id' => 'required|exists:service_packages,id',
            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'exists:service_addons,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'payment_choice' => 'required|in:deposit,full',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $user = $request->user();

            // Create or find Vehicle
            $vehicle = Vehicle::create([
                'user_id' => $user?->id,
                'make' => $validated['vehicle_make'],
                'model' => $validated['vehicle_model'],
                'year' => $validated['vehicle_year'],
                'color' => $validated['vehicle_color'] ?? 'Black',
                'license_plate' => $validated['license_plate'] ?? ('VEN' . rand(100, 999)),
                'type' => $validated['vehicle_type'],
            ]);

            // Calculate total price dynamically
            $service = ServicePackage::findOrFail($validated['service_package_id']);
            $priceField = 'price_' . $validated['vehicle_type'];
            $basePrice = (float) $service->{$priceField};

            $addonsTotal = 0;
            $addonRecords = [];
            if (!empty($validated['addon_ids'])) {
                $addons = ServiceAddon::whereIn('id', $validated['addon_ids'])->get();
                foreach ($addons as $addon) {
                    $addonsTotal += (float) $addon->price;
                    $addonRecords[$addon->id] = ['price_at_booking' => $addon->price];
                }
            }

            $totalAmount = $basePrice + $addonsTotal;
            $depositAmount = $validated['payment_choice'] === 'deposit' ? min(250.00, $totalAmount) : $totalAmount;

            $bookingCode = 'VEN-' . strtoupper(Str::random(4)) . rand(10, 99);

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => $user?->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'vehicle_id' => $vehicle->id,
                'vehicle_summary' => "{$vehicle->year} {$vehicle->make} {$vehicle->model} (" . ucfirst($vehicle->type) . ")",
                'service_package_id' => $service->id,
                'booking_date' => $validated['booking_date'],
                'time_slot' => $validated['time_slot'],
                'status' => 'confirmed',
                'payment_status' => $validated['payment_choice'] === 'deposit' ? 'partial_deposit' : 'paid',
                'payment_method' => 'stripe_card',
                'total_amount' => $totalAmount,
                'deposit_amount' => $depositAmount,
                'notes' => $validated['notes'] ?? null,
            ]);

            if (!empty($addonRecords)) {
                $booking->addons()->attach($addonRecords);
            }

            // Create initial milestone
            BookingStagesHistory::create([
                'booking_id' => $booking->id,
                'stage' => 'pending',
                'notes' => 'Booking placed online and confirmed in schedule.',
            ]);

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'stripe_session_id' => 'cs_test_' . Str::random(24),
                'stripe_payment_intent_id' => 'pi_3' . Str::random(20),
                'amount' => $depositAmount,
                'currency' => 'usd',
                'payment_method' => 'stripe_card',
                'status' => 'authorized',
                'receipt_number' => 'VEN-REC-' . rand(100000, 999999),
            ]);

            return response()->json([
                'success' => true,
                'booking_code' => $booking->booking_code,
                'booking_id' => $booking->id,
                'message' => 'Reservation confirmed successfully!',
            ]);
        });
    }

    /**
     * Confirmation Page.
     */
    public function confirmation(string $bookingCode): Response
    {
        $booking = Booking::with(['servicePackage', 'addons', 'vehicle', 'payment'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        return Inertia::render('Storefront/Confirmation', [
            'booking' => $booking,
        ]);
    }
}
