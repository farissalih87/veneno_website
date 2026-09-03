<?php

namespace App\Http\Controllers;

use App\Models\AdihexLead;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * ADIHEX & Lead Command Center CRM Hub.
     */
    public function index(Request $request): Response
    {
        $adihexLeads = AdihexLead::latest()->get();
        $inquiries = Inquiry::latest()->get();

        // ADIHEX 2026 Campaign KPIs
        $adihexTotalSpins = $adihexLeads->count();
        $adihexPaidReservations = $adihexLeads->where('deposit_status', 'paid')->count();
        $adihexDepositCashflow = $adihexLeads->where('deposit_status', 'paid')->sum('deposit_amount');
        $adihexPipelineRevenue = $adihexLeads->where('deposit_status', 'paid')->sum('package_price');
        $adihexRedeemedCount = $adihexLeads->where('is_redeemed', true)->count();
        $adihexActiveCount = $adihexLeads->where('is_redeemed', false)->count();
        $adihexConversionRate = $adihexTotalSpins > 0 ? round(($adihexPaidReservations / $adihexTotalSpins) * 100, 1) : 0;

        $vipReservedCount = $adihexLeads->where('lead_tier', 'VIP_RESERVED')->count();
        $highIntentCount = $adihexLeads->where('lead_tier', 'HIGH_INTENT_PPF')->count();
        $spinPrizeCount = $adihexLeads->where('lead_tier', 'SPIN_PRIZE')->count();

        // Website Quote Leads KPIs
        $inquiriesNew = $inquiries->where('status', 'new')->count();
        $inquiriesContacted = $inquiries->where('status', 'contacted')->count();
        $inquiriesBooked = $inquiries->where('status', 'booked')->count();
        $inquiriesLost = $inquiries->where('status', 'lost')->count();

        return Inertia::render('Dashboard/Index', [
            'adihexLeads' => $adihexLeads,
            'inquiries' => $inquiries,
            'adihexStats' => [
                'totalSpins' => $adihexTotalSpins,
                'paidReservations' => $adihexPaidReservations,
                'depositCashflow' => $adihexDepositCashflow,
                'pipelineRevenue' => $adihexPipelineRevenue,
                'redeemedCount' => $adihexRedeemedCount,
                'activeCount' => $adihexActiveCount,
                'conversionRate' => $adihexConversionRate,
                'vipReservedCount' => $vipReservedCount,
                'highIntentCount' => $highIntentCount,
                'spinPrizeCount' => $spinPrizeCount,
            ],
            'inquiryStats' => [
                'total' => $inquiries->count(),
                'new' => $inquiriesNew,
                'contacted' => $inquiriesContacted,
                'booked' => $inquiriesBooked,
                'lost' => $inquiriesLost,
            ],
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
}
