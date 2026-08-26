<?php

use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\TechnicianPortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdihexController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Clean Primary Storefront Routes (In-Place Multilingual - Zero 404s)
Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/services/{slug}', [StorefrontController::class, 'serviceDetail'])->name('service.detail');

// ADIHEX 2026 Campaign Portal & Digital Signage Kiosk
Route::get('/adihex', [AdihexController::class, 'index'])->name('adihex.index');
Route::get('/adihex/display', [AdihexController::class, 'display'])->name('adihex.display');
Route::get('/adihex/screen', [AdihexController::class, 'display'])->name('adihex.screen');
Route::get('/{locale}/adihex', [AdihexController::class, 'index'])
    ->where('locale', 'en|ar');
Route::get('/{locale}/adihex/display', [AdihexController::class, 'display'])
    ->where('locale', 'en|ar');

// Multilingual URL prefix fallbacks (en | ar)
Route::get('/{locale}', [StorefrontController::class, 'home'])
    ->where('locale', 'en|ar');
Route::get('/{locale}/services/{slug}', [StorefrontController::class, 'serviceDetail'])
    ->where('locale', 'en|ar');

// API Routes
Route::post('/api/quote', [StorefrontController::class, 'submitQuote'])->name('api.quote.submit');
Route::post('/api/inquiries', [StorefrontController::class, 'storeInquiry'])->name('api.inquiries.store');

// ADIHEX 2026 Activation APIs
Route::post('/api/adihex/spin', [AdihexController::class, 'spin'])->name('api.adihex.spin');
Route::post('/api/adihex/reserve', [AdihexController::class, 'reserve'])->name('api.adihex.reserve');
Route::post('/api/adihex/payment-intent', [AdihexController::class, 'createPaymentIntent'])->name('api.adihex.payment-intent');
Route::post('/api/adihex/redeem', [AdihexController::class, 'redeemVoucher'])->name('api.adihex.redeem');

// Booking Engine
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/confirmation/{bookingCode}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Customer VIP Portal (Authenticated or Guest Demo Access)
Route::get('/customer-portal', [CustomerPortalController::class, 'index'])->name('customer.portal');

// Technician Portal (Bay Floor)
Route::get('/technician-portal', [TechnicianPortalController::class, 'index'])->name('technician.portal');
Route::post('/technician/bookings/{booking}/stage', [TechnicianPortalController::class, 'updateStage'])->name('technician.bookings.stage');

// Admin / Manager Dashboard CRM
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::patch('/dashboard/inquiries/{inquiry}', [DashboardController::class, 'updateInquiryStatus'])->name('dashboard.inquiries.update');
Route::delete('/dashboard/inquiries/{inquiry}', [DashboardController::class, 'destroyInquiry'])->name('dashboard.inquiries.destroy');
Route::post('/dashboard/campaigns', [DashboardController::class, 'storeCampaign'])->name('dashboard.campaigns.store');
Route::get('/dashboard/adihex/export', [AdihexController::class, 'exportLeads'])->name('dashboard.adihex.export');

