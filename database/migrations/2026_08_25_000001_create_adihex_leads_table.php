<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adihex_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->index();
            $table->string('email')->nullable();
            $table->json('service_intent')->nullable(); // PPF, Ceramic, Tinting, Detailing, Peelable Paint, PDR
            
            // Spin Wheel & Won Prize
            $table->string('won_prize_tier')->default('discount_10'); // discount_10, wash_slime, wash_diamond, voucher_100, tint_10, polish_detailing, platinum_20
            $table->string('won_prize_label')->default('10% Discount Voucher');
            $table->string('voucher_code')->unique(); // VEN-ADIHEX-XXXX
            $table->timestamp('voucher_expires_at')->nullable();
            $table->boolean('is_redeemed')->default(false);
            $table->timestamp('redeemed_at')->nullable();
            
            // Package Reservation
            $table->string('selected_package_id')->nullable(); // show_special, silver, golden, platinum
            $table->string('selected_package_name')->nullable();
            $table->decimal('package_price', 10, 2)->nullable();
            $table->decimal('deposit_amount', 10, 2)->default(0.00);
            $table->enum('deposit_status', ['skipped', 'pending', 'paid'])->default('pending');
            $table->string('stripe_payment_id')->nullable();
            
            // Lead Categorization & CRM
            $table->string('lead_tier')->default('SPIN_PRIZE'); // VIP_RESERVED, HIGH_INTENT_PPF, SPIN_PRIZE
            $table->string('status')->default('new'); // new, contacted, booked, redeemed, lost
            $table->text('notes')->nullable();
            $table->string('locale')->default('en');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adihex_leads');
    }
};
