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
        // Vehicles
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('make');
            $table->string('model');
            $table->integer('year')->default(2024);
            $table->string('color')->nullable();
            $table->string('license_plate')->nullable();
            $table->enum('type', ['sedan', 'coupe', 'suv', 'truck', 'exotic'])->default('sedan');
            $table->string('vin')->nullable();
            $table->text('condition_notes')->nullable();
            $table->timestamps();
        });

        // Service Packages
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('slug')->unique();
            $table->string('category'); // ceramic, ppf, correction, interior, tinting, engine
            $table->text('description');
            $table->integer('duration_hours')->default(4);
            $table->decimal('price_sedan', 10, 2);
            $table->decimal('price_coupe', 10, 2);
            $table->decimal('price_suv', 10, 2);
            $table->decimal('price_truck', 10, 2);
            $table->decimal('price_exotic', 10, 2);
            $table->string('warranty')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('popular')->default(false);
            $table->json('features')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->timestamps();
        });

        // Service Addons
        Schema::create('service_addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('icon_name')->default('Sparkles');
            $table->timestamps();
        });

        // Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // VEN-XXXX
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('vehicle_summary')->nullable(); // Porsche 911 Turbo S (Coupe)
            $table->foreignId('service_package_id')->constrained()->cascadeOnDelete();
            $table->date('booking_date');
            $table->string('time_slot'); // 09:00 AM, 01:00 PM
            $table->enum('status', [
                'pending',
                'confirmed',
                'in_progress',
                'polishing',
                'curing',
                'qc_ready',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->enum('payment_status', ['pending', 'partial_deposit', 'paid', 'refunded'])->default('pending');
            $table->enum('payment_method', ['stripe_card', 'apple_pay', 'cash_in_store', 'wire_transfer'])->default('stripe_card');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('deposit_amount', 10, 2)->default(0.00);
            $table->foreignId('assigned_technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('marketing_source')->nullable();
            $table->timestamps();
        });

        // Pivot: Booking Addons
        Schema::create('booking_addon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_addon_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_at_booking', 10, 2);
            $table->timestamps();
        });

        // Stage history & visual inspection milestones
        Schema::create('booking_stages_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('stage');
            $table->text('notes')->nullable();
            $table->string('photo_url')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Payments & Stripe Sessions
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('usd');
            $table->string('payment_method')->default('stripe_card');
            $table->string('status')->default('authorized');
            $table->string('receipt_number')->nullable();
            $table->timestamps();
        });

        // Inquiries & WhatsApp Leads
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('vehicle_details')->nullable();
            $table->string('service_requested')->nullable();
            $table->text('message_text')->nullable();
            $table->enum('status', ['new', 'contacted', 'booked', 'lost'])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Marketing Campaigns
        Schema::create('marketing_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->enum('type', ['email', 'sms', 'whatsapp'])->default('email');
            $table->string('audience')->default('all');
            $table->enum('status', ['draft', 'scheduled', 'active', 'completed'])->default('draft');
            $table->dateTime('scheduled_at')->nullable();
            $table->integer('sent_count')->default(0);
            $table->decimal('open_rate', 5, 2)->default(0.00);
            $table->decimal('click_rate', 5, 2)->default(0.00);
            $table->integer('conversions')->default(0);
            $table->decimal('revenue_generated', 12, 2)->default(0.00);
            $table->decimal('budget', 10, 2)->default(0.00);
            $table->string('discount_code')->nullable();
            $table->longText('body_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_campaigns');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('booking_stages_histories');
        Schema::dropIfExists('booking_addon');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('service_addons');
        Schema::dropIfExists('service_packages');
        Schema::dropIfExists('vehicles');
    }
};
