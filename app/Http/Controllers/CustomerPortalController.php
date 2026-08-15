<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerPortalController extends Controller
{
    /**
     * Customer VIP Portal view with garage, active tracking, and receipts.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $bookings = Booking::with(['servicePackage', 'addons', 'vehicle', 'stagesHistory', 'payment'])
            ->when($user, function ($query, $user) {
                $query->where('user_id', $user->id)
                      ->orWhere('customer_email', $user->email);
            }, function ($query) {
                // Demo fallback if testing as guest
                $query->latest()->limit(5);
            })
            ->latest()
            ->get();

        $vehicles = Vehicle::when($user, function ($query, $user) {
            $query->where('user_id', $user->id);
        })->get();

        $activeJob = $bookings->first(fn ($b) => in_array($b->status, ['in_progress', 'polishing', 'curing', 'qc_ready', 'confirmed'])) ?? $bookings->first();

        return Inertia::render('Customer/Portal', [
            'bookings' => $bookings,
            'vehicles' => $vehicles,
            'activeJob' => $activeJob,
            'loyalty' => [
                'tier' => $user->loyalty_tier ?? 'VIP Platinum',
                'points' => $user->loyalty_points ?? 3450,
                'nextTierPoints' => 5000,
            ],
        ]);
    }
}
