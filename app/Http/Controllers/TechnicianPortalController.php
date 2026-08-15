<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingStagesHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TechnicianPortalController extends Controller
{
    /**
     * Technician Bay Operations Board.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $bookings = Booking::with(['servicePackage', 'addons', 'vehicle', 'stagesHistory', 'assignedTechnician'])
            ->whereIn('status', ['confirmed', 'in_progress', 'polishing', 'curing', 'qc_ready', 'completed'])
            ->latest()
            ->get();

        $myJobs = $bookings->filter(fn ($b) => $user ? $b->assigned_technician_id == $user->id : true)->values();

        return Inertia::render('Technician/Portal', [
            'bookings' => $bookings,
            'myJobs' => $myJobs,
        ]);
    }

    /**
     * Update Bay Stage milestone for a booking.
     */
    public function updateStage(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'stage' => 'required|in:pending,confirmed,in_progress,polishing,curing,qc_ready,completed,cancelled',
            'notes' => 'nullable|string',
            'photo_url' => 'nullable|string',
        ]);

        $booking->update([
            'status' => $validated['stage'],
        ]);

        BookingStagesHistory::create([
            'booking_id' => $booking->id,
            'stage' => $validated['stage'],
            'notes' => $validated['notes'] ?? ('Stage updated to ' . ucfirst(str_replace('_', ' ', $validated['stage']))),
            'photo_url' => $validated['photo_url'] ?? null,
            'created_by' => $request->user()?->id,
        ]);

        return back()->with('success', 'Bay stage updated successfully.');
    }
}
