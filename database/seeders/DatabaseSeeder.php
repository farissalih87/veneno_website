<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\ServicePackage;
use App\Models\ServiceAddon;
use App\Models\Booking;
use App\Models\BookingStagesHistory;
use App\Models\Inquiry;
use App\Models\MarketingCampaign;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles & Permissions
        $roles = ['super_admin', 'manager', 'technician', 'receptionist', 'customer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $permissions = [
            'view-revenue',
            'manage-staff',
            'edit-pricing',
            'manage-campaigns',
            'delete-records',
            'update-job-status',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $adminRole = Role::findByName('super_admin');
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::findByName('manager');
        $managerRole->givePermissionTo(['view-revenue', 'manage-staff', 'edit-pricing', 'manage-campaigns', 'update-job-status']);

        $techRole = Role::findByName('technician');
        $techRole->givePermissionTo(['update-job-status']);

        // 2. Users
        $admin = User::firstOrCreate(['email' => 'admin@venenoautocare.com'], [
            'name' => 'Dominic Toretto (Super Admin)',
            'phone' => '+1 (555) 901-2000',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
            'loyalty_tier' => 'VIP Platinum',
            'loyalty_points' => 5000,
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('super_admin');

        $manager = User::firstOrCreate(['email' => 'manager@venenoautocare.com'], [
            'name' => 'Elena Rostova (Operations Manager)',
            'phone' => '+1 (555) 901-2001',
            'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80',
            'loyalty_tier' => 'Gold',
            'loyalty_points' => 1200,
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole('manager');

        $tech = User::firstOrCreate(['email' => 'marcus@venenoautocare.com'], [
            'name' => 'Marcus Vance (Master Detailer)',
            'phone' => '+1 (555) 901-2002',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
            'loyalty_tier' => 'Gold',
            'loyalty_points' => 850,
            'password' => Hash::make('password'),
        ]);
        $tech->assignRole('technician');

        $customer = User::firstOrCreate(['email' => 'alex@example.com'], [
            'name' => 'Alex Sterling',
            'phone' => '+1 (555) 234-5678',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
            'loyalty_tier' => 'VIP Platinum',
            'loyalty_points' => 3450,
            'address' => '742 Evergreen Terrace, Beverly Hills, CA 90210',
            'password' => Hash::make('password'),
        ]);
        $customer->assignRole('customer');

        // 3. Vehicles
        $car1 = Vehicle::firstOrCreate(['license_plate' => 'VEN911'], [
            'user_id' => $customer->id,
            'make' => 'Porsche',
            'model' => '911 Turbo S',
            'year' => 2024,
            'color' => 'Guards Red',
            'type' => 'coupe',
            'vin' => 'WP0AB2A99NS298311',
            'condition_notes' => 'Minor swirl marks on rear quarter panel. Clear coat in pristine condition.',
        ]);

        $car2 = Vehicle::firstOrCreate(['license_plate' => 'URUS88'], [
            'user_id' => $customer->id,
            'make' => 'Lamborghini',
            'model' => 'Urus Performante',
            'year' => 2023,
            'color' => 'Nero Nemesis Matte',
            'type' => 'suv',
            'vin' => 'ZPBUA1ZL3PLA01928',
            'condition_notes' => 'Matte clear coat requires dedicated matte ceramic protective formula.',
        ]);

        // 4. Service Packages
        $services = [
            [
                'name' => 'Diamond Ceramic Coating',
                'tagline' => '9H+ Multi-Layer Graphene Shield with 5-Year High-Gloss Warranty',
                'slug' => 'ceramic-coating',
                'category' => 'ceramic',
                'description' => 'Our flagship 9H+ nano-ceramic and graphene matrix formula bonds molecularly to clear coat, providing extreme hydrophobic water contact angle (115°), UV oxidation prevention, acid rain resistance, and permanent deep mirror reflections.',
                'duration_hours' => 8,
                'price_sedan' => 799,
                'price_coupe' => 749,
                'price_suv' => 949,
                'price_truck' => 1099,
                'price_exotic' => 1299,
                'warranty' => '5 Years Certified Warranty',
                'badge' => 'Most Popular',
                'popular' => true,
                'features' => [
                    'Multi-stage decontamination wash & clay bar treatment',
                    'Stage 1 Paint Correction to eliminate 85%+ swirls',
                    'Dual layer 9H Nano-Diamond ceramic base coat',
                    'Top coat ultra-slick hydrophobic topper',
                    'Wheel faces & exterior glass ceramic protection',
                    'IR Lamp heat cure for maximum bond density',
                    'Warranty certificate & CarFax detailing registry',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1607860108855-64acf2078ed9?auto=format&fit=crop&w=1000&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => 'Self-Healing PPF (Paint Protection Film)',
                'tagline' => 'Military-Grade 8mil Polyurethane Barrier Against Rock Chips & Scratches',
                'slug' => 'paint-protection-film',
                'category' => 'ppf',
                'description' => 'Precision computer-cut optical clear film that self-heals swirl marks and light scratches with sun heat. Protect your front bumper, hood, fenders, and mirrors against highway gravel and road debris.',
                'duration_hours' => 12,
                'price_sedan' => 1499,
                'price_coupe' => 1399,
                'price_suv' => 1699,
                'price_truck' => 1899,
                'price_exotic' => 2499,
                'warranty' => '10-Year Anti-Yellowing Warranty',
                'badge' => 'Ultimate Armor',
                'popular' => false,
                'features' => [
                    'Full Front Bumper, Full Hood & Mirror Caps coverage',
                    'High-gloss self-healing elastomeric polymer layer',
                    'Digitally pre-cut plotters for zero razor blade contact on paint',
                    'Wrapped edges for nearly invisible seamless seams',
                    'Resistant to rock chips, bug splatter, and road salt',
                    'Top-coated with ceramic slip layer for easy washing',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1000&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => 'Multi-Stage Paint Correction',
                'tagline' => 'Restores Deep Mirror Clarity & Eliminates 95% of Paint Defects',
                'slug' => 'paint-correction',
                'category' => 'correction',
                'description' => 'Microscopic paint surface leveling utilizing rotary and dual-action polishers with diminishing abrasives to permanently eliminate spiderweb swirls, buffer holograms, deep wash scratches, and water spots.',
                'duration_hours' => 6,
                'price_sedan' => 499,
                'price_coupe' => 449,
                'price_suv' => 599,
                'price_truck' => 699,
                'price_exotic' => 899,
                'warranty' => 'Surface Clarity Guaranteed',
                'badge' => 'Showroom Finish',
                'popular' => false,
                'features' => [
                    'Electronic digital paint depth gauge inspection',
                    'Heavy cutting micro-abrasive compound step',
                    'Refining jeweling polish for maximal optical reflection',
                    'Removal of bird drop etchings & hard water scaling',
                    'Panel wipe IPA alcohol strip inspection under LED sunlight lamps',
                    'Carnauba & synthetic sealant base sealant finish',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1000&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => 'Interior Master Deep Rejuvenation',
                'tagline' => 'Hospital-Grade Steam Sanitization, Leather Nourishing & Hot Water Extraction',
                'slug' => 'interior-detailing',
                'category' => 'interior',
                'description' => 'A 360-degree interior revival that extracts deep-seated bacteria, spills, pet hair, and odors from fabrics, carpets, vents, and headliners, complemented with pH-neutral conditioner that softens and protects leather.',
                'duration_hours' => 4,
                'price_sedan' => 299,
                'price_coupe' => 269,
                'price_suv' => 349,
                'price_truck' => 399,
                'price_exotic' => 449,
                'warranty' => 'Anti-Stain & Freshness Guarantee',
                'badge' => 'Best Value',
                'popular' => true,
                'features' => [
                    'Pressurized 212°F thermal steam vent & crevices extraction',
                    'Heated carpet & upholstery chemical extraction',
                    'Leather deep cleaning, brush scrub & lanolin conditioning',
                    'Ozone generator gas odor & allergen neutralization',
                    'UV matte protectant on dash, console, and door cards',
                    'Streak-free crystal glass clarifying on all interior glass',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=1000&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => 'Ceramic IR Nano Window Tinting',
                'tagline' => 'Up to 98% Infrared Heat Rejection with Total UV Block',
                'slug' => 'window-tinting',
                'category' => 'tinting',
                'description' => 'Premium ceramic nanoparticle window films that block solar energy without heat build up, keeping cabin 25°F cooler.',
                'duration_hours' => 3,
                'price_sedan' => 399,
                'price_coupe' => 349,
                'price_suv' => 449,
                'price_truck' => 479,
                'price_exotic' => 599,
                'warranty' => 'Lifetime Bubble & Fade Free',
                'badge' => 'Heat Shield',
                'popular' => false,
                'features' => [
                    'Computer-cut precision templates for every vehicle model',
                    '99% UV-A and UV-B cancer radiation blockage',
                    'Up to 94% Infrared (IR) solar heat rejection',
                    'Lifetime nationwide bubble, peel & color change warranty',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1000&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1000&q=80',
            ],
        ];

        foreach ($services as $srv) {
            ServicePackage::updateOrCreate(['slug' => $srv['slug']], $srv);
        }

        // 5. Addons
        $addons = [
            ['name' => 'Windshield & Glass Hydrophobic Shield', 'description' => '3-Year rain repellent coating on all glass surfaces', 'price' => 149.00, 'icon_name' => 'Droplets'],
            ['name' => 'Wheel Off Barrel & Caliper Ceramic', 'description' => 'High-temp 1200°F ceramic armor on alloy wheels and brake calipers', 'price' => 299.00, 'icon_name' => 'Disc'],
            ['name' => 'Engine Bay Detail & Plastic Restoration', 'description' => 'Steam degreasing, wiring harness protection & satin dress', 'price' => 179.00, 'icon_name' => 'Sun'],
            ['name' => 'Leather Ceramic Barrier & Stain Guard', 'description' => 'Hydrophobic breathable barrier against jean dye transfer', 'price' => 199.00, 'icon_name' => 'Sparkles'],
            ['name' => 'Concierge Flatbed Pickup & Delivery', 'description' => 'Enclosed luxury vehicle transportation within 50 miles', 'price' => 150.00, 'icon_name' => 'Truck'],
        ];

        foreach ($addons as $addon) {
            ServiceAddon::updateOrCreate(['name' => $addon['name']], $addon);
        }

        // 6. Sample Bookings
        $ceramicSrv = ServicePackage::where('slug', 'ceramic-coating')->first();
        $glassAddon = ServiceAddon::where('name', 'like', '%Glass%')->first();
        $wheelAddon = ServiceAddon::where('name', 'like', '%Wheel%')->first();

        $booking1 = Booking::updateOrCreate(['booking_code' => 'VEN-8492'], [
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
            'vehicle_id' => $car1->id,
            'vehicle_summary' => '2024 Porsche 911 Turbo S (Coupe)',
            'service_package_id' => $ceramicSrv->id,
            'booking_date' => now()->addDays(2)->format('Y-m-d'),
            'time_slot' => '09:00 AM',
            'status' => 'curing',
            'payment_status' => 'paid',
            'payment_method' => 'stripe_card',
            'total_amount' => 1197.00,
            'deposit_amount' => 250.00,
            'assigned_technician_id' => $tech->id,
            'notes' => 'Customer requested extra focus on front bumper and hood.',
            'marketing_source' => 'Google Search',
        ]);

        $booking1->addons()->syncWithoutDetaching([
            $glassAddon->id => ['price_at_booking' => 149.00],
            $wheelAddon->id => ['price_at_booking' => 299.00],
        ]);

        // Stage history
        BookingStagesHistory::create([
            'booking_id' => $booking1->id,
            'stage' => 'in_progress',
            'notes' => 'Car checked in. Iron decontamination wash and clay bar completed.',
            'created_by' => $tech->id,
        ]);
        BookingStagesHistory::create([
            'booking_id' => $booking1->id,
            'stage' => 'polishing',
            'notes' => 'Stage 1 correction completed. Swirl reduction measured at 92%.',
            'created_by' => $tech->id,
        ]);
        BookingStagesHistory::create([
            'booking_id' => $booking1->id,
            'stage' => 'curing',
            'notes' => 'Ceramic 9H dual layer applied. IR heat cure in progress.',
            'created_by' => $tech->id,
        ]);

        Payment::updateOrCreate(['booking_id' => $booking1->id], [
            'stripe_session_id' => 'cs_test_veneno_911_session',
            'stripe_payment_intent_id' => 'pi_3P9veneno911_secret',
            'amount' => 1197.00,
            'currency' => 'usd',
            'payment_method' => 'stripe_card',
            'status' => 'authorized',
            'receipt_number' => 'VEN-REC-90182',
        ]);

        // 7. Inquiries
        Inquiry::create([
            'customer_name' => 'Sheikh Rashid Al Mansoori',
            'phone' => '+971 50 123 4567',
            'vehicle_details' => '2024 Ferrari SF90 Stradale',
            'service_requested' => 'Full Body Self-Healing PPF & Ceramic Coating',
            'message_text' => 'Hi Veneno team, I just received my SF90 Stradale and need full body PPF before track day. Please contact me with availability.',
            'status' => 'new',
            'assigned_to' => $admin->id,
        ]);

        // 8. Marketing Campaigns
        MarketingCampaign::create([
            'title' => 'VIP Spring Graphene Protection',
            'subject' => '✨ Your Vehicle Deserves Showroom Mirror Armor: Exclusive $150 Off',
            'type' => 'email',
            'audience' => 'vip',
            'status' => 'active',
            'scheduled_at' => now()->subDays(3),
            'sent_count' => 840,
            'open_rate' => 52.4,
            'click_rate' => 24.1,
            'conversions' => 38,
            'revenue_generated' => 45600.00,
            'budget' => 650.00,
            'discount_code' => 'VENENO150',
            'body_content' => 'Exclusive invitation for luxury vehicle owners to refresh their hydrophobic ceramic barrier with complimentary glass protection.',
        ]);
    }
}
