<script setup>
import { ref, computed } from 'vue';
import { X, ShieldCheck, FileText, CheckCircle2, AlertCircle, Clock, RotateCcw, Ban, MapPin, Scale } from 'lucide-vue-next';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  locale: {
    type: String,
    default: 'ar',
  },
});

const emit = defineEmits(['close', 'accept']);

const activeTab = ref(props.locale === 'en' ? 'en' : 'ar');

const switchTab = (lang) => {
  activeTab.value = lang;
};

const t = computed(() => {
  const isAr = activeTab.value === 'ar';
  return {
    isAr,
    dir: isAr ? 'rtl' : 'ltr',
    title: isAr ? 'الشروط والأحكام الرسمية • حملة أديهيكس 2026' : 'Official Terms & Conditions • ADIHEX 2026',
    subtitle: isAr ? 'مركز فينينو للعناية بالسيارات — أبوظبي، الإمارات' : 'Veneno Auto Care Center — Abu Dhabi, UAE',
    closeBtn: isAr ? 'إغلاق' : 'Close',
    acceptBtn: isAr ? 'أوافق على كافة الشروط والأحكام' : 'I Understand & Agree to All Terms',
    tabAr: 'العربية (Arabic)',
    tabEn: 'English (الإنجليزية)',
    effectiveDate: isAr ? 'تاريخ السريان: أغسطس 2026' : 'Effective Date: August 2026',
    governingLaw: isAr ? 'تخضع هذه الشروط لقوانين إمارة أبوظبي ودولة الإمارات العربية المتحدة' : 'Governed by the laws of the Emirate of Abu Dhabi & UAE Federal Law',
  };
});
</script>

<template>
  <Teleport to="body">
    <div
      v-if="show"
      class="fixed inset-0 z-[100] flex items-center justify-center p-3 sm:p-5 bg-black/85 backdrop-blur-md animate-in fade-in duration-300"
      @click.self="emit('close')"
    >
      <div
        class="relative w-full max-w-2xl max-h-[90vh] bg-gradient-to-b from-[#16161a] via-[#101013] to-[#0a0a0c] border border-zinc-700/80 rounded-3xl shadow-2xl shadow-black flex flex-col overflow-hidden text-zinc-200"
        :dir="t.dir"
      >
        <!-- Modal Top Bar -->
        <div class="px-5 py-4 border-b border-zinc-800/80 flex items-center justify-between bg-zinc-950/60 shrink-0">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
              <Scale class="w-4 h-4" />
            </div>
            <div>
              <h3 class="text-sm sm:text-base font-black text-white leading-tight">{{ t.title }}</h3>
              <p class="text-[11px] text-zinc-400">{{ t.subtitle }}</p>
            </div>
          </div>
          <button
            type="button"
            @click="emit('close')"
            class="p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors cursor-pointer"
            aria-label="Close"
          >
            <X class="w-5 h-5" />
          </button>
        </div>

        <!-- Language Switcher Tabs -->
        <div class="px-5 py-2.5 bg-zinc-900/80 border-b border-zinc-800/60 flex items-center justify-between gap-2 shrink-0">
          <div class="flex items-center gap-1.5 p-1 bg-zinc-950 rounded-xl border border-zinc-800">
            <button
              type="button"
              @click="switchTab('ar')"
              :class="[
                'px-3 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer',
                activeTab === 'ar' ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-black shadow' : 'text-zinc-400 hover:text-zinc-200'
              ]"
            >
              العربية 🇦🇪
            </button>
            <button
              type="button"
              @click="switchTab('en')"
              :class="[
                'px-3 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer',
                activeTab === 'en' ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-black shadow' : 'text-zinc-400 hover:text-zinc-200'
              ]"
            >
              English 🇬🇧
            </button>
          </div>
          <span class="text-[11px] font-mono text-zinc-500 hidden sm:inline-block">{{ t.effectiveDate }}</span>
        </div>

        <!-- Modal Body (Scrollable Legal Content) -->
        <div class="p-5 sm:p-6 overflow-y-auto space-y-5 text-xs sm:text-[13px] leading-relaxed text-zinc-300 divide-y divide-zinc-800/60">
          
          <!-- Arabic Content -->
          <template v-if="activeTab === 'ar'">
            <!-- Section 1 -->
            <div class="space-y-2 pt-1 first:pt-0">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Clock class="w-4 h-4 shrink-0" />
                <h4>1. فترة صلاحية العروض والجوائز (60 يوماً)</h4>
              </div>
              <p class="text-zinc-300">
                كافة الجوائز المجانية المكتسبة عبر عجلة الحظ، بالإضافة إلى عروض وباقات معرض أديهيكس 2026 المحجوزة، صالحة للاستخدام والتنفيذ لمدة <strong>60 يوماً تقويمياً</strong> تبدأ من تاريخ التسجيل والسحب. تعتبر القسيمة منتهية الصلاحية وغير قابلة للمطالبة بعد انقضاء هذه المدة.
              </p>
            </div>

            <!-- Section 2 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <RotateCcw class="w-4 h-4 shrink-0" />
                <h4>2. سياسة عربون الحجز والاسترداد (500 درهم)</h4>
              </div>
              <ul class="list-disc list-inside space-y-1.5 text-zinc-300 pr-2">
                <li>عربون تثبيت الباقة (500 درهم إماراتي) <strong>يُخصم بنسبة 100% بالكامل</strong> من قيمة الفاتورة النهائية عند تنفيذ الخدمة في المركز.</li>
                <li>في حال رغبة العميل في إلغاء الحجز واسترداد العربون، يتم تقديم طلب خطي عبر خدمة العملاء أو تطبيق واتساب، وتتم معالجة الاسترداد المالي وإعادته إلى وسيلة الدفع الأصلية خلال <strong>30 يوم عمل</strong> من تاريخ تقديم الطلب.</li>
              </ul>
            </div>

            <!-- Section 3 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Ban class="w-4 h-4 shrink-0" />
                <h4>3. عدم دمج العروض وقابلية التحويل</h4>
              </div>
              <p class="text-zinc-300">
                لا يمكن دمج أو جمع قسائم وجوائز هذه الحملة مع أي عروض ترويجية أخرى أو خصومات جارية أو اتفاقيات شركات في مركز فينينو. القسيمة مخصصة للعميل المسجل ولا يحق استبدال الجوائز المجانية بمبالغ نقدية.
              </p>
            </div>

            <!-- Section 4 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <ShieldCheck class="w-4 h-4 shrink-0" />
                <h4>4. إثبات الاستحقاق والرسالة النصية (SMS)</h4>
              </div>
              <p class="text-zinc-300">
                يشترط للاستفادة من الجائزة أو الباقة المحجوزة <strong>إبراز الرسالة النصية الرسمية (SMS)</strong> المستلمة على الهاتف المحمول المسجل عند تسليم السيارة في المركز، وتطابق رقم الهاتف مع السجلات الرسمية للنظام. يُسمح بفرصة سحب واحدة فقط لكل رقم هاتف/مركبة لمنع التحايل.
              </p>
            </div>

            <!-- Section 5 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <MapPin class="w-4 h-4 shrink-0" />
                <h4>5. الحجز المسبق وموقع الخدمة</h4>
              </div>
              <p class="text-zinc-300">
                يجب حجز موعد الخدمة مسبقاً قبل زيارة المركز عبر الهاتف (026344403) أو واتساب لضمان توفر الطاقة الاستيعابية. يتم تقديم كافة الخدمات في المقر الرئيسي لمركز فينينو للعناية بالسيارات: <strong>مصفح M37، أبوظبي، الإمارات العربية المتحدة</strong>.
              </p>
            </div>

            <!-- Section 6 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Scale class="w-4 h-4 shrink-0" />
                <h4>6. الاختصاص القضائي والقانون الحاكم</h4>
              </div>
              <p class="text-zinc-400 text-xs">
                تخضع هذه الشروط والأحكام وتفسر وفقاً للقوانين والتشريعات الاتحادية السارية في دولة الإمارات العربية المتحدة وقوانين إمارة أبوظبي، وتختص محاكم أبوظبي بالفصل في أي نزاع ينشأ عنها.
              </p>
            </div>
          </template>

          <!-- English Content -->
          <template v-else>
            <!-- Section 1 -->
            <div class="space-y-2 pt-1 first:pt-0">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Clock class="w-4 h-4 shrink-0" />
                <h4>1. Promotional Validity Window (60 Days)</h4>
              </div>
              <p class="text-zinc-300">
                All complimentary prizes won via the spin wheel and all exclusive ADIHEX 2026 show package reservations are strictly valid for <strong>60 calendar days</strong> from the date of registration/spin. Unclaimed vouchers automatically expire and cannot be reinstated after 60 days.
              </p>
            </div>

            <!-- Section 2 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <RotateCcw class="w-4 h-4 shrink-0" />
                <h4>2. Reservation Deposit & Refund Policy (AED 500)</h4>
              </div>
              <ul class="list-disc list-inside space-y-1.5 text-zinc-300 pl-2">
                <li>The AED 500 package reservation deposit is <strong>100% deductible</strong> from your final invoice upon service completion at Veneno Auto Care Center.</li>
                <li>Should you wish to cancel your package reservation, a formal written refund request must be submitted to customer support or WhatsApp concierge. Approved refunds are processed back to the original payment method within <strong>30 business days</strong> following the request.</li>
              </ul>
            </div>

            <!-- Section 3 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Ban class="w-4 h-4 shrink-0" />
                <h4>3. Non-Combinability & Non-Transferability</h4>
              </div>
              <p class="text-zinc-300">
                Campaign vouchers and show discounts cannot be combined or stacked with any other ongoing promotions, corporate agreements, or seasonal discounts at Veneno. Complimentary prizes have zero cash exchange value and cannot be traded for cash or credit.
              </p>
            </div>

            <!-- Section 4 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <ShieldCheck class="w-4 h-4 shrink-0" />
                <h4>4. Verification & Official SMS Requirement</h4>
              </div>
              <p class="text-zinc-300">
                To claim your prize or execute your reserved package, you must <strong>present the official SMS message</strong> delivered to your registered mobile number upon vehicle check-in. Exactly 1 participation is permitted per mobile number/vehicle.
              </p>
            </div>

            <!-- Section 5 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <MapPin class="w-4 h-4 shrink-0" />
                <h4>5. Prior Booking & Service Location</h4>
              </div>
              <p class="text-zinc-300">
                Prior appointment booking is mandatory via phone (+971 2 634 4403) or WhatsApp concierge subject to workshop availability. All services are performed at Veneno Auto Care Center: <strong>Musaffah M37, Abu Dhabi, United Arab Emirates</strong>.
              </p>
            </div>

            <!-- Section 6 -->
            <div class="space-y-2 pt-4">
              <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                <Scale class="w-4 h-4 shrink-0" />
                <h4>6. Governing Law & Jurisdiction</h4>
              </div>
              <p class="text-zinc-400 text-xs">
                These terms are governed by and construed in accordance with the applicable laws of the Emirate of Abu Dhabi and the Federal Laws of the United Arab Emirates.
              </p>
            </div>
          </template>

        </div>

        <!-- Modal Bottom Actions -->
        <div class="p-4 sm:p-5 border-t border-zinc-800/80 bg-zinc-950/80 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
          <p class="text-[11px] text-zinc-400 text-center sm:text-start flex items-center gap-1.5">
            <CheckCircle2 class="w-3.5 h-3.5 text-emerald-400 shrink-0" />
            <span>{{ t.governingLaw }}</span>
          </p>
          <button
            type="button"
            @click="emit('accept'); emit('close')"
            class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 hover:from-amber-500 hover:to-amber-400 text-black font-black text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-amber-950/50 transition-all cursor-pointer active:scale-95"
          >
            {{ t.acceptBtn }}
          </button>
        </div>

      </div>
    </div>
  </Teleport>
</template>
