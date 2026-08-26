<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import {
  ArrowLeft,
  ArrowRight,
  ShieldCheck,
  Scale,
  Clock,
  RotateCcw,
  Ban,
  MapPin,
  CheckCircle2,
  Phone,
  MessageCircle,
  ExternalLink,
} from 'lucide-vue-next';

const props = defineProps({
  initialLocale: {
    type: String,
    default: 'ar',
  },
});

const currentLocale = ref(props.initialLocale === 'en' ? 'en' : 'ar');

const setLocale = (lang) => {
  currentLocale.value = lang;
};

const t = computed(() => {
  const isAr = currentLocale.value === 'ar';
  return {
    isAr,
    dir: isAr ? 'rtl' : 'ltr',
    fontClass: isAr ? 'font-arabic' : 'font-sans',
    pageTitle: isAr ? 'الشروط والأحكام الرسمية • حملة أديهيكس 2026 — فينينو' : 'Official Terms & Conditions • ADIHEX 2026 — Veneno Auto Care',
    headerTitle: isAr ? 'الشروط والأحكام الرسمية' : 'Official Terms & Conditions',
    campaignTag: isAr ? 'حملة معرض أبوظبي الدولي للصيد والفروسية 2026' : 'ADIHEX 2026 Official Campaign Platform',
    backToCampaign: isAr ? 'العودة إلى عجلة الحظ والعروض' : 'Back to Spin Wheel & Offers',
    effectiveDate: isAr ? 'تاريخ السريان: أغسطس 2026' : 'Effective Date: August 2026',
    brandName: isAr ? 'مركز فينينو للعناية بالسيارات' : 'Veneno Auto Care Center',
    address: isAr ? 'مصفح M37، أبوظبي، الإمارات العربية المتحدة' : 'Musaffah M37, Abu Dhabi, United Arab Emirates',
    phone: '+971 2 634 4403',
  };
});
</script>

<template>
  <Head>
    <title>{{ t.pageTitle }}</title>
    <meta name="description" :content="t.pageTitle" />
  </Head>

  <div
    class="min-h-screen bg-[#070709] text-zinc-100 selection:bg-amber-500 selection:text-black relative overflow-x-hidden flex flex-col font-sans"
    :dir="t.dir"
  >
    <!-- Ambient Red & Gold Glows -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-gradient-to-b from-red-600/15 via-amber-500/10 to-transparent blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-0 w-[500px] h-[300px] bg-amber-600/10 blur-3xl pointer-events-none -z-10"></div>

    <!-- Top Header -->
    <header class="w-full border-b border-zinc-800/80 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-40">
      <div class="max-w-4xl mx-auto px-4 py-3 sm:py-4 flex items-center justify-between gap-3">
        
        <!-- Back Link -->
        <Link
          :href="currentLocale === 'ar' ? '/ar/adihex' : '/adihex'"
          class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-zinc-900 border border-zinc-800 hover:border-amber-500/50 text-xs sm:text-sm font-semibold text-zinc-300 hover:text-amber-400 transition-colors"
        >
          <component :is="t.isAr ? ArrowRight : ArrowLeft" class="w-4 h-4 text-amber-400" />
          <span>{{ t.backToCampaign }}</span>
        </Link>

        <!-- Brand Logos -->
        <div class="flex items-center gap-2">
          <img src="/images/adihex/veneno-header-icon.png" alt="Veneno" class="h-9 w-9 object-contain rounded-xl" />
          <img src="/images/adihex/adihex-header-icon.png" alt="ADIHEX 2026" class="h-9 w-9 object-contain" />
        </div>

        <!-- Language Toggle -->
        <div class="flex items-center gap-1 bg-zinc-900 p-1 rounded-xl border border-zinc-800">
          <button
            type="button"
            @click="setLocale('ar')"
            :class="[
              'px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer',
              currentLocale === 'ar' ? 'bg-amber-500 text-black shadow' : 'text-zinc-400 hover:text-zinc-200'
            ]"
          >
            العربية
          </button>
          <button
            type="button"
            @click="setLocale('en')"
            :class="[
              'px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer',
              currentLocale === 'en' ? 'bg-amber-500 text-black shadow' : 'text-zinc-400 hover:text-zinc-200'
            ]"
          >
            English
          </button>
        </div>

      </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-4xl mx-auto w-full px-4 py-8 sm:py-12 space-y-8">
      
      <!-- Title Hero -->
      <div class="space-y-2 text-center sm:text-start">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-mono font-bold">
          <Scale class="w-3.5 h-3.5" />
          <span>{{ t.campaignTag }}</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">{{ t.headerTitle }}</h1>
        <p class="text-xs sm:text-sm text-zinc-400">{{ t.brandName }} • {{ t.effectiveDate }}</p>
      </div>

      <!-- Legal Sections Box -->
      <div class="rounded-3xl bg-zinc-900/70 border border-zinc-800/90 backdrop-blur-md p-6 sm:p-8 space-y-6 text-sm leading-relaxed text-zinc-300 shadow-2xl">
        
        <!-- Arabic Terms -->
        <template v-if="currentLocale === 'ar'">
          <!-- 1 -->
          <div class="space-y-2">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Clock class="w-5 h-5 shrink-0" />
              <h2>1. صلاحية الجوائز وعروض المعرض (60 يوماً)</h2>
            </div>
            <p>
              كافة الجوائز المجانية المكتسبة عبر عجلة الحظ التفاعلية، وكافة باقات وعروض معرض الصيد والفروسية (أديهيكس 2026) المحجوزة، صالحة للاستخدام والتنفيذ لمدة <strong>60 يوماً تقويمياً</strong> تبدأ من تاريخ التسجيل والسحب. بعد انقضاء الـ 60 يوماً، تعتبر القسيمة منتهية الصلاحية تلقائياً ولا يمكن تمديدها أو المطالبة بها.
            </p>
          </div>

          <!-- 2 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <RotateCcw class="w-5 h-5 shrink-0" />
              <h2>2. سياسة عربون الحجز والاسترداد (500 درهم إماراتي)</h2>
            </div>
            <ul class="list-disc list-inside space-y-2 pr-2">
              <li>عربون تثبيت العرض بقيمة <strong>500 درهم إماراتي</strong> يُخصم بنسبة 100% بالكامل من قيمة الفاتورة النهائية عند تنفيذ الخدمة في المركز.</li>
              <li>يحق للعميل طلب إلغاء الحجز واسترداد مبلغ العربون من خلال تقديم طلب خطي عبر خدمة العملاء أو تطبيق واتساب الرسمي (+97126344403).</li>
              <li>تتم معالجة مبالغ الاسترداد وإعادتها إلى البطاقة البنكية أو وسيلة الدفع الأصلية خلال <strong>30 يوم عمل</strong> من تاريخ استلام الطلب الخطي.</li>
            </ul>
          </div>

          <!-- 3 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Ban class="w-5 h-5 shrink-0" />
              <h2>3. عدم دمج العروض والشروط الترويجية</h2>
            </div>
            <p>
              لا يجوز دمج أو جمع قسائم وجوائز هذه الحملة مع أي عروض ترويجية أخرى، أو خصومات جارية، أو اتفاقيات شركات، أو باقات مخفضة مسبقاً في مركز فينينو. الجوائز المجانية مخصصة للمستفيد المسجل ولا يمكن استبدالها نقداً أو تحويلها لرصيد مالي.
            </p>
          </div>

          <!-- 4 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <ShieldCheck class="w-5 h-5 shrink-0" />
              <h2>4. إثبات الاستحقاق والرسالة النصية (SMS)</h2>
            </div>
            <p>
              يشترط للاستفادة من الجائزة أو الباقة المحجوزة <strong>إبراز الرسالة النصية الرسمية (SMS)</strong> المستلمة على الهاتف المحمول المسجل عند إحضار السيارة وتسليمها للمركز. يُسمح بفرصة سحب واحدة فقط لكل رقم هاتف/مركبة مسجلة.
            </p>
          </div>

          <!-- 5 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <MapPin class="w-5 h-5 shrink-0" />
              <h2>5. الحجز المسبق ومقر الخدمة</h2>
            </div>
            <p>
              يتوجب على العميل حجز موعد الخدمة مسبقاً عبر الاتصال بالرقم <strong>02 634 4403</strong> أو عبر محادثة واتساب الرسمية لضمان توفر الطاقة الاستيعابية في الورشة. يتم تنفيذ جميع الأعمال في المقر الرئيسي لمركز فينينو للعناية بالسيارات: <strong>مصفح M37، أبوظبي، دولة الإمارات العربية المتحدة</strong>.
            </p>
          </div>

          <!-- 6 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Scale class="w-5 h-5 shrink-0" />
              <h2>6. القانون الحاكم والاختصاص القضائي</h2>
            </div>
            <p class="text-zinc-400 text-xs sm:text-sm">
              تخضع هذه الشروط والأحكام وتفسر وفقاً للتشريعات والقوانين الاتحادية المعمول بها في دولة الإمارات العربية المتحدة والقوانين المحلية لإمارة أبوظبي، وتختص محاكم أبوظبي بنظر أي نزاع قد ينشأ عنها.
            </p>
          </div>
        </template>

        <!-- English Terms -->
        <template v-else>
          <!-- 1 -->
          <div class="space-y-2">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Clock class="w-5 h-5 shrink-0" />
              <h2>1. Promotional Validity Window (60 Days)</h2>
            </div>
            <p>
              All complimentary prizes won through the interactive lucky wheel and all exclusive ADIHEX 2026 exhibition packages are strictly valid for <strong>60 calendar days</strong> starting from the registration and spin date. Unclaimed vouchers automatically expire and cannot be reinstated after 60 days.
            </p>
          </div>

          <!-- 2 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <RotateCcw class="w-5 h-5 shrink-0" />
              <h2>2. Reservation Deposit & Refund Policy (AED 500)</h2>
            </div>
            <ul class="list-disc list-inside space-y-2 pl-2">
              <li>The AED 500 reservation deposit is <strong>100% deductible</strong> from your final invoice upon service completion at Veneno Auto Care Center.</li>
              <li>Should you choose to cancel your reservation, a formal written refund request must be submitted via customer support or official WhatsApp concierge (+971 2 634 4403).</li>
              <li>Approved refunds are credited back to the original payment method within <strong>30 business days</strong> following receipt of the written request.</li>
            </ul>
          </div>

          <!-- 3 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Ban class="w-5 h-5 shrink-0" />
              <h2>3. Non-Combinability & Non-Transferability</h2>
            </div>
            <p>
              Campaign vouchers and exhibition discounts cannot be combined or stacked with any other concurrent promotions, corporate discounts, or special packages at Veneno. Complimentary prizes have zero cash exchange value and cannot be redeemed for cash or credit.
            </p>
          </div>

          <!-- 4 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <ShieldCheck class="w-5 h-5 shrink-0" />
              <h2>4. Verification & Official SMS Requirement</h2>
            </div>
            <p>
              To claim any prize or execute a reserved package, the customer must <strong>present the official SMS message</strong> delivered to their registered mobile device upon vehicle check-in at the center. Exactly one participation is permitted per mobile number/vehicle.
            </p>
          </div>

          <!-- 5 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <MapPin class="w-5 h-5 shrink-0" />
              <h2>5. Prior Booking & Service Facility</h2>
            </div>
            <p>
              Prior appointment booking is mandatory by calling <strong>+971 2 634 4403</strong> or via WhatsApp concierge subject to workshop capacity. All services are performed at Veneno Auto Care Center headquarters: <strong>Musaffah M37, Abu Dhabi, United Arab Emirates</strong>.
            </p>
          </div>

          <!-- 6 -->
          <div class="space-y-2 pt-4 border-t border-zinc-800">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
              <Scale class="w-5 h-5 shrink-0" />
              <h2>6. Governing Law & Legal Jurisdiction</h2>
            </div>
            <p class="text-zinc-400 text-xs sm:text-sm">
              These Terms & Conditions are governed by and construed in accordance with the Federal Laws of the United Arab Emirates and the local laws of the Emirate of Abu Dhabi. The courts of Abu Dhabi shall have exclusive jurisdiction over any disputes.
            </p>
          </div>
        </template>

      </div>

      <!-- Action Footer -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-5 rounded-2xl bg-zinc-950/80 border border-zinc-800">
        <div class="text-center sm:text-start space-y-0.5">
          <h3 class="text-sm font-bold text-white">{{ t.brandName }}</h3>
          <p class="text-xs text-zinc-400">{{ t.address }} • {{ t.phone }}</p>
        </div>
        <Link
          :href="currentLocale === 'ar' ? '/ar/adihex' : '/adihex'"
          class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 via-red-500 to-amber-600 hover:from-red-500 hover:to-amber-500 text-white font-bold text-xs uppercase tracking-wider text-center shadow-lg shadow-red-950/50 transition-all active:scale-95 cursor-pointer"
        >
          {{ t.backToCampaign }}
        </Link>
      </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-zinc-800/80 py-4 text-center text-xs text-zinc-500 bg-zinc-950">
      <div class="max-w-4xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
        <p>© 2026 Veneno Auto Care Center. All Rights Reserved.</p>
        <p class="flex items-center gap-1.5">
          <CheckCircle2 class="w-3.5 h-3.5 text-emerald-400" />
          <span>Consumer Protection Verified • UAE</span>
        </p>
      </div>
    </footer>

  </div>
</template>
