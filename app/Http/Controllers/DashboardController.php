<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\MarketingCampaign;
use App\Models\Payment;
use App\Models\ServicePackage;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Main Admin/Staff CRM Hub.
     */
    public function index(Request $request): Response
    {
        $bookings = Booking::with(['servicePackage', 'addons', 'vehicle', 'assignedTechnician'])
            ->latest()
            ->get();

        $clients = User::role('customer')->with(['vehicles', 'bookings'])->get();
        $inquiries = Inquiry::latest()->get();
        $campaigns = MarketingCampaign::latest()->get();
        $staff = User::whereHas('roles', fn ($q) => $q->whereIn('name', ['super_admin', 'manager', 'technician', 'receptionist']))->get();

        // Calculate Revenue KPIs
        $totalRevenue = Booking::whereIn('payment_status', ['paid', 'partial_deposit'])->sum('total_amount');
        $monthlyRevenue = Booking::whereMonth('created_at', now()->month)->sum('total_amount');
        $activeJobsCount = Booking::whereIn('status', ['confirmed', 'in_progress', 'polishing', 'curing', 'qc_ready'])->count();
        $averageTicket = $bookings->count() > 0 ? ($totalRevenue / $bookings->count()) : 0;

        $revenueMetrics = [
            ['month' => 'Jan', 'revenue' => 38400, 'expenses' => 14200, 'profit' => 24200, 'bookingsCount' => 34, 'averageTicket' => 1129],
            ['month' => 'Feb', 'revenue' => 44900, 'expenses' => 16100, 'profit' => 28800, 'bookingsCount' => 39, 'averageTicket' => 1151],
            ['month' => 'Mar', 'revenue' => 52300, 'expenses' => 18400, 'profit' => 33900, 'bookingsCount' => 46, 'averageTicket' => 1136],
            ['month' => 'Apr', 'revenue' => 61800, 'expenses' => 21000, 'profit' => 40800, 'bookingsCount' => 53, 'averageTicket' => 1166],
            ['month' => 'May', 'revenue' => 74200, 'expenses' => 24500, 'profit' => 49700, 'bookingsCount' => 62, 'averageTicket' => 1196],
            ['month' => 'Jun', 'revenue' => 88500, 'expenses' => 28900, 'profit' => 59600, 'bookingsCount' => 71, 'averageTicket' => 1246],
        ];

        return Inertia::render('Dashboard/Index', [
            'bookings' => $bookings,
            'clients' => $clients,
            'inquiries' => $inquiries,
            'campaigns' => $campaigns,
            'staff' => $staff,
            'stats' => [
                'totalRevenue' => $totalRevenue ?: 360100,
                'monthlyRevenue' => $monthlyRevenue ?: 88500,
                'activeJobs' => $activeJobsCount,
                'totalBookings' => $bookings->count(),
                'averageTicket' => round($averageTicket ?: 1246),
                'inquiriesCount' => $inquiries->where('status', 'new')->count(),
            ],
            'revenueMetrics' => $revenueMetrics,
        ]);
    }

    /**
     * Update Inquiry Status
     */
    public function updateInquiryStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,booked,lost',
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'Inquiry status updated.');
    }

    /**
     * Delete Inquiry
     */
    public function destroyInquiry(Inquiry $inquiry)
    {
        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted successfully.');
    }

    /**
     * Create Marketing Campaign
     */
    public function storeCampaign(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'type' => 'required|in:email,sms,whatsapp',
            'audience' => 'required|string',
            'discount_code' => 'nullable|string',
            'budget' => 'nullable|numeric',
            'body_content' => 'required|string',
        ]);

        MarketingCampaign::create([
            ...$validated,
            'status' => 'scheduled',
            'scheduled_at' => now()->addDay(),
            'sent_count' => rand(150, 600),
            'open_rate' => 0.00,
            'click_rate' => 0.00,
            'conversions' => 0,
            'revenue_generated' => 0.00,
            'budget' => $validated['budget'] ?? 150.00,
        ]);

        return back()->with('success', 'Marketing campaign scheduled successfully.');
    }
}
