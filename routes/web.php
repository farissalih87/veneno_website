<?php

use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\TechnicianPortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Clean Primary Storefront Routes (In-Place Multilingual - Zero 404s)
Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/services/{slug}', [StorefrontController::class, 'serviceDetail'])->name('service.detail');

// Multilingual URL prefix fallbacks (en | ar)
Route::get('/{locale}', [StorefrontController::class, 'home'])
    ->where('locale', 'en|ar');
Route::get('/{locale}/services/{slug}', [StorefrontController::class, 'serviceDetail'])
    ->where('locale', 'en|ar');

// API Routes
Route::post('/api/quote', [StorefrontController::class, 'submitQuote'])->name('api.quote.submit');
Route::post('/api/inquiries', [StorefrontController::class, 'storeInquiry'])->name('api.inquiries.store');

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
Route::post('/dashboard/campaigns', [DashboardController::class, 'storeCampaign'])->name('dashboard.campaigns.store');
