<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class StorefrontController extends Controller
{
    /**
     * Official 9 Services Data Dictionary with Authentic Media Paths & Bilingual Support
     * Fully aligned with official Veneno Profile (3M Pro Shop Dealer & GYEON Certified Detailer)
     */
    public static function getOfficialServices(string $locale = 'en'): array
    {
        $isAr = ($locale === 'ar');

        return [
            [
                'id' => 1,
                'name' => $isAr ? 'أفلام حماية الطلاء (3M PPF)' : '3M Paint Protection Film (PPF)',
                'tagline' => $isAr ? 'درع حماية بصري سمك 8 ميل معالج ذاتياً بضمان 10 سنوات من 3M' : 'Official 3M Self-Healing 8mil Optical Armor with 10-Year Warranty',
                'slug' => 'paint-protection-film',
                'category' => 'ppf',
                'badge' => $isAr ? 'وكيل 3M المعتمد' : '3M Pro Shop Certified',
                'popular' => true,
                'description' => $isAr 
                    ? 'فيلم بولي يوريثين بصري شفاف فائق الجودة من 3M مقصوص بالكمبيوتر يعالج الخدوش الدقيقة ذاتياً بحرارة الشمس، ويحمي من الحصى وسافي الطرق السريعة.'
                    : 'Precision computer-cut optical clear polyurethane film from 3M that self-heals swirl marks with ambient heat. Protects against stone chips, highway sand abrasion, and road debris.',
                'image' => '/images/services/ppf/IMG_5902.JPG',
                'before_image' => '/images/services/ppf/IMG_5968.JPG',
                'after_image' => '/images/services/ppf/IMG_5965.JPG',
                'warranty' => $isAr ? 'ضمان 10 سنوات' : '10-Year Warranty',
                'duration_hours' => 12,
                'features' => $isAr ? [
                    'قص إلكتروني دقيق ببرامج 3M الرقمية وثني الحواف بدون شفرات',
                    'طبقة معالجة ذاتية فائقة المرونة تلتئم بالحرارة الطبيعية',
                    'حماية شاملة ضد ضربات الحصى وحبيبات الرمل المتطايرة',
                    'مقاومة الأشعة فوق البنفسجية واصفرار الفيلم مع وضوح بصري تام',
                    'طبقة هيدروفوبيك طاردة للماء والأوساخ لتسهيل الغسيل والصيانة',
                ] : [
                    'Computer-cut digital plotters with wrapped seamless edges',
                    'Self-healing elastomeric top coat under ambient heat',
                    'Total rock chip & high-speed gravel protection',
                    'UV & anti-yellowing optical clarity guarantee',
                    'Hydrophobic top layer for effortless maintenance',
                ],
            ],
            [
                'id' => 2,
                'name' => $isAr ? 'نانو سيراميك GYEON الماسي 9H+' : 'GYEON Diamond Ceramic Coating',
                'tagline' => $isAr ? 'درع نانو جرافين متعدد الطبقات طارد فائق للماء من GYEON' : '9H+ Multi-Layer GYEON Graphene Hydrophobic Shield',
                'slug' => 'ceramic-coating',
                'category' => 'ceramic',
                'badge' => $isAr ? 'معتمد من GYEON' : 'GYEON Certified Detailer',
                'popular' => true,
                'description' => $isAr
                    ? 'تركيبتنا المعتمدة من نانو سيراميك GYEON ترتبط جزيئياً بطبقة الطلاء الشفاف لتمنح مقاومة فائقة للماء بزاوية 115° ولمعاناً زجاجياً عميقاً وحماية ضد الخدوش.'
                    : 'Our flagship GYEON 9H+ nano-ceramic formula bonds molecularly to automotive clear coat, delivering extreme 115° hydrophobic water beading, UV defense, and mirror reflection depth.',
                'image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
                'before_image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 10.JPG',
                'after_image' => '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 14.JPG',
                'warranty' => $isAr ? 'ضمان معتمد 5 سنوات' : '5-Year Certified Warranty',
                'duration_hours' => 8,
                'features' => $isAr ? [
                    'غسيل كيميائي شامل لإزالة الترسبات الحديدية واستخدام الصلصال الخاص',
                    'تصحيح الطلاء للمرحلة الأولى لإزالة الدوائر وتعظيم الانعكاس',
                    'طبقة نانو جرافين وسيراميك GYEON 9H مزدوجة الحماية',
                    'حماية سيراميك خاصة للجنوط وكليبرات الفرامل وزجاج السيارة',
                    'معالجة حرارية بمصابيح الأشعة تحت الحمراء لأقصى درجات الصلابة',
                ] : [
                    'Multi-stage chemical decontamination wash & clay bar',
                    'Stage 1 corrective polish to optimize surface reflection',
                    'Dual-layer GYEON 9H nano-graphene ceramic base coat',
                    'Wheels, brake calipers & exterior glass ceramic barrier',
                    'IR curing lamps for maximum surface bond hardness',
                ],
            ],
            [
                'id' => 3,
                'name' => $isAr ? 'تصحيح ومعالجة وتلميع الطلاء' : 'Detailing & Paint Correction',
                'tagline' => $isAr ? 'إزالة الدوائر والخدوش المجهرية واستعادة بريق الوكالة' : 'Concourse Swirl & Hologram Leveling with GYEON',
                'slug' => 'detailing-paint-correction',
                'category' => 'detailing',
                'badge' => $isAr ? 'تشطيب خالي من العيوب' : 'Flawless Finish',
                'popular' => false,
                'description' => $isAr
                    ? 'تسوية مجهرية لطبقة اللكر باستخدام أحدث أجهزة التلميع المزدوجة ومواد صقل متدرجة لإزالة دوائر الغسيل والهولوجرام والأكسدة نهائياً.'
                    : 'Concourse-grade microscopic surface leveling using precision rotary and dual-action polishers to eliminate swirl marks, buffer holograms, and oxidation.',
                'image' => '/images/services/detailing/IMG_5899.JPG',
                'before_image' => '/images/services/detailing/PHOTO-2024-07-12-14-12-51 18.JPG',
                'after_image' => '/images/services/detailing/PHOTO-2024-07-12-14-12-51 24.JPG',
                'warranty' => $isAr ? 'ضمان نقاء وانعكاس الطلاء' : 'Optical Reflection Guarantee',
                'duration_hours' => 6,
                'features' => $isAr ? [
                    'قياس إلكتروني رقمي لسماكة الطلاء في كل جزء من الهيكل',
                    'مركب قطع حبيبي دقيق لإزالة خدوش الغسيل العميقة',
                    'بولش تلميع نهائي فائق الدقة لانعكاس يشبه المرآة',
                    'مسح كامل بالكحول النقي والفحص تحت إضاءات LED المتخصصة',
                    'طبقة واقية من السيلنت التخليقي لحماية النتيجة',
                ] : [
                    'Digital electronic paint depth measurement per panel',
                    'Heavy cutting compound for deep wash scratch removal',
                    'Jeweling refining polish for concourse mirror gloss',
                    'Panel wipe IPA alcohol inspection under sunlight LEDs',
                    'Synthetic protective sealant finish',
                ],
            ],
            [
                'id' => 4,
                'name' => $isAr ? 'العازل الحراري نانو سيراميك 3M' : '3M Ceramic Window Tinting',
                'tagline' => $isAr ? 'عزل حراري للأشعة تحت الحمراء بنسبة تصل إلى 98% من 3M' : 'Up to 98% Infrared Heat & 99% UV Rejection by 3M',
                'slug' => 'window-tinting',
                'category' => 'tinting',
                'badge' => $isAr ? 'عزل حراري معتمد' : '3M Thermal Shield',
                'popular' => false,
                'description' => $isAr
                    ? 'أفلام نانو سيراميك أصلية من 3M مخصصة لمناخ الخليج والإمارات، تحافظ على برودة المقصورة وتمنع 99% من الأشعة فوق البنفسجية الضارة.'
                    : 'Official 3M ultra-high heat rejection nano-ceramic window films designed for the Middle East climate. Keeps interior cooler while blocking 99% UV rays.',
                'image' => '/images/services/tinting/IMG_5967.JPG',
                'before_image' => '/images/services/tinting/IMG_5969.JPG',
                'after_image' => '/images/services/tinting/IMG_5971.JPG',
                'warranty' => $isAr ? 'ضمان مدى الحياة ضد التغير والفقاعات' : 'Lifetime Bubble-Free Warranty',
                'duration_hours' => 3,
                'features' => $isAr ? [
                    'قص إلكتروني مطابق لأبعاد زجاج سيارتك بدقة متناهية',
                    'حجب 99% من الأشعة فوق البنفسجية الضارة بالجلد والفرش الداخلي',
                    'عزل حتى 94% من حرارة الأشعة تحت الحمراء للشمس',
                    'لا يؤثر إطلاقاً على إشارات الهواتف أو أنظمة الملاحة GPS',
                ] : [
                    'Computer-cut glass templates tailored per model',
                    '99% UV-A / UV-B skin & upholstery protection',
                    'Up to 94% Infrared (IR) solar heat barrier',
                    'Zero signal interference for mobile & GPS',
                ],
            ],
            [
                'id' => 5,
                'name' => $isAr ? 'تجليد وتغيير لون السيارات' : 'Vehicle Wrapping & Color Change',
                'tagline' => $isAr ? 'أفلام فينيل 3M فاخرة بتشطيبات لامعة ومطفية وساتان' : 'Premium 3M Cast Vinyl in Gloss, Satin & Matte Finishes',
                'slug' => 'car-wrapping',
                'category' => 'wrapping',
                'badge' => $isAr ? 'لمسة تصميم حصرية' : 'Bespoke Styling',
                'popular' => false,
                'description' => $isAr
                    ? 'غيّر مظهر سيارتك بالكامل بأفلام الفينيل الفاخرة من كبرى الشركات العالمية (3M) مع الحفاظ الكامل على صبغة الوكالة.'
                    : 'Transform your vehicle aesthetics with world-class vinyl wraps from 3M. Reversible protection with endless finish possibilities.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 20.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 23.JPG',
                'warranty' => $isAr ? 'ضمان تركيب 3 سنوات' : '3-Year Installation Warranty',
                'duration_hours' => 24,
                'features' => $isAr ? [
                    'فك وتركيب احترافي للأجزاء الخارجية لإخفاء الحواف بالكامل',
                    'تشكيلة واسعة من الألوان اللامعة، الساتان، المطفية، والكروم',
                    'حماية تامة لصبغة الوكالة الأصلية تحت طبقة التجليد',
                    'إمكانية تجليد حواف الأبواب الداخلية بالكامل',
                ] : [
                    'Disassembly by certified technicians for wrapped tucks',
                    'Extensive choice of gloss, satin, matte, and chrome',
                    'Original OEM paint preserved underneath',
                    'Complete door jambs wrapping available',
                ],
            ],
            [
                'id' => 6,
                'name' => $isAr ? 'شفط الصدمات بدون دهان (PDR)' : 'Paintless Dent Repair (PDR)',
                'tagline' => $isAr ? 'إصلاح دقيق للصدمات مع الحفاظ الكامل على صبغ الوكالة' : 'Factory-Finish Restoration with Zero Repainting',
                'slug' => 'paintless-dent-repair',
                'category' => 'pdr',
                'badge' => $isAr ? 'الحفاظ على صبغ الوكالة' : 'Preserve Factory Paint',
                'popular' => false,
                'description' => $isAr
                    ? 'إصلاح انبعاجات وصدمات الهيكل بأدوات معدنية فائقة الدقة من خلف القطعة دون الحاجة إلى معجون أو إعادة صبغ، مما يحافظ على قيمة السيارة.'
                    : 'Precision dent removal utilizing specialized metallurgy tools from behind the panel. Preserves 100% of original factory paint and vehicle resale value.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 17.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 11.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 19.JPG',
                'warranty' => $isAr ? 'ضمان سلامة الطلاء الأصلي' : 'Lifetime Paint Integrity',
                'duration_hours' => 2,
                'features' => $isAr ? [
                    'بدون أي معجون أو صنفرة أو إعادة صبغ نهائياً',
                    'تسليم سريع في نفس اليوم لضربات الأبواب والانبعاجات',
                    'الحفاظ على 100% من طبقة طلاء الوكالة الأصلية',
                    'استخدام ألواح إضاءة LED مجهرية لضبط انحناءات الهيكل بدقة',
                ] : [
                    'Zero body filler, sanding, or repainting required',
                    'Fast same-day turnaround for door dings & creases',
                    '100% preservation of original factory clear coat',
                    'Specialized LED reflection board precision alignment',
                ],
            ],
            [
                'id' => 7,
                'name' => $isAr ? 'حماية وتجديد الجنوط' : 'Rims Protection & Wheel Repair',
                'tagline' => $isAr ? 'خراطة CNC لضربات الرصيف وطلاء سيراميك حراري' : 'Curb Rash CNC Machining & High-Temp Ceramic Armor',
                'slug' => 'rims-protection-repair',
                'category' => 'rims',
                'badge' => $isAr ? 'إتقان حواف الإطارات' : 'Wheel Perfection',
                'popular' => false,
                'description' => $isAr
                    ? 'تجديد شامل لجنوط الألمنيوم، خراطة وقص CNC للوجه الماسي، وطلاء سيراميك حراري 1200°F لمقاومة غبار الفرامل الحارق.'
                    : 'Complete wheel restoration, diamond-cut CNC face re-machining, custom powder coating, and high-temp ceramic coating to resist corrosive brake dust.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 21.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 3.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 4.JPG',
                'warranty' => $isAr ? 'ضمان متانة وجودة التشطيب' : 'Finish Durability Guaranteed',
                'duration_hours' => 4,
                'features' => $isAr ? [
                    'إصلاح دقيق لحكات الرصيف واستعدال الجنوط المنبعجة',
                    'مطابقة ألوان الوكالة الأصلية وقص الوجه الماسي CNC',
                    'طلاء سيراميك حراري 1200°F لمقاومة التصاق بودرة الفرامل',
                    'تنظيف عميق لبطائن الجنوط وتلميع كليبرات الفرامل',
                ] : [
                    'Precision curb rash repair and structural trueing',
                    'Factory OEM color matching and diamond-cut CNC finish',
                    '1200°F high-temp ceramic coating against brake dust',
                    'Wheel barrel deep cleaning and caliper detailing',
                ],
            ],
            [
                'id' => 8,
                'name' => $isAr ? 'رش ودهان السيارات بالفرن الحراري' : 'Paint & Body Restoration',
                'tagline' => $isAr ? 'مطابقة ألوان إلكترونية ورش في كبائن حرارية معقمة' : 'Concourse Panel Spraying & Scratch Elimination',
                'slug' => 'paint-body-work',
                'category' => 'paint',
                'badge' => $isAr ? 'أعلى معايير الصبغ' : 'Concourse Bodywork',
                'popular' => false,
                'description' => $isAr
                    ? 'صبغ ورش القطع والأجزاء في كبائن أفران حرارية خالية من الغبار باستخدام أجهزة مطابقة الألوان الطيفية وليرات اللكر عالية الصلابة المطابقة للمصنع.'
                    : 'Down-draft heated spray booth painting using computer-spectrometer color matching and OEM-approved high-solid clear coats for an undetectable finish.',
                'image' => '/images/services/paint/IMG_5901.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 12.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 13.JPG',
                'warranty' => $isAr ? 'ضمان مطابقة لون الوكالة' : 'Color Match Guaranteed',
                'duration_hours' => 16,
                'features' => $isAr ? [
                    'جهاز مطابقة إلكتروني طيفي لخلط درجات الألوان بدقة متناهية',
                    'كبائن رش أفران بضغط إيجابي لتجنب أي ذرات غبار',
                    'طبقات لكر عالية الصلابة ومقاومة للأشعة فوق البنفسجية',
                    'صنفرة وتلميع مائي بعد جفاف الصبغ للوصول لدرجة بريق الوكالة',
                ] : [
                    'Computerized spectrometer color formulation',
                    'Dust-free positive pressure down-draft spray booth',
                    'High-solid UV clear coats matching factory orange peel',
                    'Post-cure wet sanding and mirror gloss buffing',
                ],
            ],
            [
                'id' => 9,
                'name' => $isAr ? 'غسيل إزالة الشوائب الفاخر' : 'Signature Decontamination Car Wash',
                'tagline' => $isAr ? 'غسيل ثنائي الدلو آمن مع إزالة الرواسب والشوائب الحديدية' : 'Two-Bucket Scratch-Free Wash with Iron Decontamination',
                'slug' => 'premium-car-wash',
                'category' => 'wash',
                'badge' => $isAr ? 'عناية أساسية فائقة' : 'Essential Care',
                'popular' => false,
                'description' => $isAr
                    ? 'غسيل رغوي متعادل الحموضة بتقنية الدلوين وحواجز الأتربة، تنظيف وضخ بطائن الرفارف، إزالة برادة الحديد الكيميائية، وتجفيف بالهواء الساخن المفلتر.'
                    : 'pH-neutral snow foam wash with grit-guard two-bucket method, wheel arch pressure flush, chemical iron fallout removal, and filtered warm-air drying.',
                'image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 5.JPG',
                'before_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51 7.JPG',
                'after_image' => '/images/gallery/PHOTO-2024-07-12-14-12-51.JPG',
                'warranty' => $isAr ? 'ضمان غسيل آمن 100% بدون خدوش' : '100% Scratch-Free Guarantee',
                'duration_hours' => 2,
                'features' => $isAr ? [
                    'رغوة ثلجية كثيفة متعادلة الحموضة لعزل الأتربة والرمال',
                    'قفازات مايكروفايبر فائقة النعومة مع حواجز ترسبات الشوائب',
                    'إزالة الرواسب والبرادة الحديدية العالقة وتنظيف بطائن الجنوط',
                    'تجفيف لا تلامسي باستخدام مدافع الهواء الساخن المفلتر',
                    'تنظيف داخلي شامل بالمكنسة ومسح الطبلون ومعالجة الإطارات',
                ] : [
                    'pH-neutral thick foam bath encapsulating dirt',
                    'Ultra-soft plush microfiber mitts with grit guards',
                    'Iron fallout decontamination & wheel barrel wash',
                    'Touchless heated filtered air drying',
                    'Interior vacuum, dashboard wipe, and tire satin dress',
                ],
            ],
        ];
    }

    /**
     * Root URL router with intelligent client-side redirect fallback
     */
    public function index(Request $request)
    {
        $acceptLang = $request->header('Accept-Language', '');
        $preferredLocale = str_contains(strtolower($acceptLang), 'ar') ? 'ar' : 'en';

        return redirect("/{$preferredLocale}");
    }

    /**
     * Homepage with localized content & 9 services
     */
    public function home(string $locale = 'en'): Response
    {
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        $services = self::getOfficialServices($locale);
        
        $galleryImages = [
            '/images/gallery/PHOTO-2024-07-12-14-12-51.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 24.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 23.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 15.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 14.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 13.JPG',
            '/images/gallery/PHOTO-2024-07-12-14-12-51 9.JPG',
            '/images/gallery/IMG_5902.JPG',
            '/images/gallery/IMG_5899.JPG',
            '/images/gallery/IMG_5965.JPG',
            '/images/gallery/IMG_5967.JPG',
        ];

        return Inertia::render('Storefront/Home', [
            'locale' => $locale,
            'services' => $services,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Dedicated Standalone Service Landing Page
     */
    public function serviceDetail(string $locale, string $slug): Response
    {
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        $services = self::getOfficialServices($locale);
        $service = collect($services)->firstWhere('slug', $slug);

        if (!$service) {
            abort(404, 'Service not found');
        }

        return Inertia::render('Storefront/ServiceDetail', [
            'locale' => $locale,
            'service' => $service,
            'allServices' => $services,
        ]);
    }

    /**
     * Submit Quote Request form (sends email to info@veneno.ae and logs to CRM database).
     */
    public function submitQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'branch' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        $selectedBranch = $validated['branch'] ?? 'Musaffah — Main Branch';

        // 1. Log Inquiry to CRM database
        $inquiry = Inquiry::create([
            'customer_name' => $validated['name'],
            'phone' => $validated['phone'],
            'service_requested' => ($validated['service'] ?? 'General Inquiry') . " ({$selectedBranch})",
            'message_text' => "Branch: {$selectedBranch}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}",
            'status' => 'new',
        ]);

        // 2. Dispatch Email notification to company email info@veneno.ae
        try {
            $toEmail = 'info@veneno.ae';
            $subject = "🏎️ New Quote Request ({$selectedBranch}) from {$validated['name']} - VENENO Auto Care Center";
            $emailBody = "New Quote Request via veneno.ae\n\n"
                . "Client Name: {$validated['name']}\n"
                . "Phone: {$validated['phone']}\n"
                . "Email: {$validated['email']}\n"
                . "Preferred Branch: {$selectedBranch}\n"
                . "Service Requested: " . ($validated['service'] ?? 'Not specified') . "\n\n"
                . "Message:\n{$validated['message']}\n\n"
                . "Inquiry ID: #{$inquiry->id}\n"
                . "Date: " . now()->format('Y-m-d H:i:s T');

            Mail::raw($emailBody, function ($msg) use ($toEmail, $subject, $validated) {
                $msg->to($toEmail)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error("Failed to send quote email to info@veneno.ae: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your quote request has been sent to info@veneno.ae. Our concierge will contact you shortly.',
        ]);
    }

    /**
     * Store WhatsApp Inquiry lead in CRM database.
     */
    public function storeInquiry(Request $request)
    {
        return $this->submitQuote($request);
    }
}
