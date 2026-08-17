<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Sparkles, ArrowRightLeft, CheckCircle2, SlidersHorizontal, ShieldCheck } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const { t, currentLocale } = useI18n();

const props = defineProps({
  // Standalone Single-Service Mode props
  beforeImage: {
    type: String,
    default: null,
  },
  afterImage: {
    type: String,
    default: null,
  },
  beforeLabel: {
    type: String,
    default: null,
  },
  afterLabel: {
    type: String,
    default: null,
  },
  title: {
    type: String,
    default: null,
  },
  subtitle: {
    type: String,
    default: null,
  },

  // Multi-Vehicle Showcase Mode props (STRICTLY THE 5 ATTACHED VEHICLE IMAGES ONLY)
  items: {
    type: Array,
    default: () => [
      {
        id: 'aston-martin-vantage',
        category: 'exterior',
        vehicle: 'Aston Martin Vantage (Front)',
        vehicleAr: 'أستون مارتن فانتاج (المقدمة)',
        service: 'Peelable Color Wrap & 3M PPF',
        serviceAr: 'تجليد سائل مطاطي وحماية 3M PPF',
        beforeImage: '/images/before-after/aston-martin-vantage-before.jpg',
        afterImage: '/images/before-after/aston-martin-vantage-after.jpg',
        beforeLabel: 'Before: Gloss Black (OEM)',
        afterLabel: 'After: British Racing Green Metallic',
        beforeLabelAr: 'قبل: أسود لامع (وكالة)',
        afterLabelAr: 'بعد: أخضر بريطاني ميتاليك',
        treatment: 'Liquid Wrap + Lime Aero Lip & Strakes',
        treatmentAr: 'تجليد مطاطي فاخر + زوائد هوائية بلون ليموني',
      },
      {
        id: 'aston-martin-side',
        category: 'exterior',
        vehicle: 'Aston Martin Vantage (Side 3/4)',
        vehicleAr: 'أستون مارتن فانتاج (الجانب 3/4)',
        service: 'Bespoke Wrap & Carbon Accents',
        serviceAr: 'تجليد مخصص ولمسات كربون',
        beforeImage: '/images/before-after/aston-martin-side-before.jpg',
        afterImage: '/images/before-after/aston-martin-side-after.jpg',
        beforeLabel: 'Before: Gloss Black Metallic',
        afterLabel: 'After: British Racing Green + Lime Aero',
        beforeLabelAr: 'قبل: أسود لامع ميتاليك',
        afterLabelAr: 'بعد: أخضر بريطاني مع لمسات ليمونية',
        treatment: 'Precision Panel Wrapping & Wrapped Edges',
        treatmentAr: 'تجليد الأبواب وثني الحواف بدقة عالية',
      },
      {
        id: 'ferrari-488',
        category: 'exterior',
        vehicle: 'Ferrari 488 GTB',
        vehicleAr: 'فيراري 488 جي تي بي',
        service: 'Stealth Satin Matte Black Wrap',
        serviceAr: 'تجليد كامل أسود ساتان مطفي',
        beforeImage: '/images/before-after/ferrari-488-gtb-before.jpg',
        afterImage: '/images/before-after/ferrari-488-gtb-after.jpg',
        beforeLabel: 'Before: Grigio Silverstone Gloss',
        afterLabel: 'After: Stealth Satin Matte Black Wrap',
        beforeLabelAr: 'قبل: رمادي ميتاليك لامع',
        afterLabelAr: 'بعد: أسود ساتان مطفي شبحي',
        treatment: '3M Cast Satin Wrap + Yellow Brembo Calipers',
        treatmentAr: 'تجليد 3M ساتان + إبراز كليبرات بريمبو باللون الأصفر',
      },
      {
        id: 'audi-r8-front',
        category: 'exterior',
        vehicle: 'Audi R8 V10 Plus',
        vehicleAr: 'أودي R8 V10 بلس',
        service: 'Paint Resurfacing & Desert Sand Wrap',
        serviceAr: 'معالجة صبغ وتجليد بلون رملي صحراوي',
        beforeImage: '/images/before-after/audi-r8-front-before.jpg',
        afterImage: '/images/before-after/audi-r8-front-after.jpg',
        beforeLabel: 'Before: Sun-Damaged Peeling Clearcoat',
        afterLabel: 'After: Desert Sand Khaki + Gloss Black',
        beforeLabelAr: 'قبل: لكر متقشر وتالف من الشمس',
        afterLabelAr: 'بعد: تجليد رملي صحراوي ولمسات سوداء',
        treatment: 'Clearcoat Resurfacing + High-Gloss Desert Sand Film',
        treatmentAr: 'إعادة تسوية اللكر + فيلم رملي صحراوي فائق اللمعان',
      },
      {
        id: 'defender-interior',
        category: 'interior',
        vehicle: 'Land Rover Defender 110',
        vehicleAr: 'لاند روفر ديفندر 110',
        service: 'Italian Saddle Tan Custom Leather',
        serviceAr: 'تفصيل جلد إيطالي تان صحراوي مخصص',
        beforeImage: '/images/before-after/defender-interior-before.jpg',
        afterImage: '/images/before-after/defender-interior-after.jpg',
        beforeLabel: 'Before: Standard OEM Black Plastic & Fabric',
        afterLabel: 'After: Saddle Tan Italian Nappa Leather',
        beforeLabelAr: 'قبل: داخلية سوداء قياسية وبلاستيك',
        afterLabelAr: 'بعد: جلد نابا إيطالي فاخر بلون تان جملي',
        treatment: 'Hand-Stitched Dashboard, Console & Steering Wheel',
        treatmentAr: 'خياطة يدوية للطبلون، الكونسول الأوسط، وعجلة القيادة',
      },
    ],
  },
  initialIndex: {
    type: Number,
    default: null,
  },
  randomize: {
    type: Boolean,
    default: true,
  },
  category: {
    type: String,
    default: 'all',
  },
});

// Detect single service mode vs multi-vehicle mode
const isSingleMode = computed(() => !!(props.beforeImage && props.afterImage));

const selectedCategory = ref(props.category);

const filteredItems = computed(() => {
  if (selectedCategory.value === 'all') return props.items;
  return props.items.filter(item => item.category === selectedCategory.value);
});

// Pick a random starting item if in multi-mode and randomize is enabled
const getInitialIndex = () => {
  if (props.initialIndex !== null && props.initialIndex < filteredItems.value.length) {
    return props.initialIndex;
  }
  if (props.randomize && filteredItems.value.length > 0) {
    return Math.floor(Math.random() * filteredItems.value.length);
  }
  return 0;
};

const activeIndex = ref(getInitialIndex());

// Watch for category change to reset index
watch(selectedCategory, () => {
  activeIndex.value = 0;
  sliderPosition.value = 50;
});

// Active item resolved
const activeItem = computed(() => {
  if (isSingleMode.value) {
    return {
      vehicle: props.title || 'Veneno Transformation',
      vehicleAr: props.title || 'تحول فينينو الفاخر',
      service: props.title || 'Master Craftsmanship',
      serviceAr: props.title || 'حرفية معتمدة',
      beforeImage: props.beforeImage,
      afterImage: props.afterImage,
      beforeLabel: props.beforeLabel || 'Before Treatment',
      afterLabel: props.afterLabel || 'After Transformation',
      beforeLabelAr: props.beforeLabel || 'قبل المعالجة',
      afterLabelAr: props.afterLabel || 'بعد التحول',
      treatment: props.subtitle || 'Concourse Grade Precision Finish',
      treatmentAr: props.subtitle || 'تشطيب دقيق بمواصفات كونكور',
    };
  }
  return filteredItems.value[activeIndex.value] || filteredItems.value[0] || props.items[0];
});

const sliderPosition = ref(50);
const containerRef = ref(null);
const isDragging = ref(false);

const handleMove = (clientX) => {
  if (!containerRef.value) return;
  const rect = containerRef.value.getBoundingClientRect();
  const x = clientX - rect.left;
  const percentage = Math.max(0, Math.min(100, (x / rect.width) * 100));
  sliderPosition.value = percentage;
};

const handleTouchMove = (e) => {
  if (e.touches && e.touches[0]) {
    handleMove(e.touches[0].clientX);
  }
};

const handleMouseMove = (e) => {
  if (isDragging.value) {
    handleMove(e.clientX);
  }
};

const startDrag = (e) => {
  isDragging.value = true;
  if (e.clientX) handleMove(e.clientX);
};

const stopDrag = () => {
  isDragging.value = false;
};

onMounted(() => {
  window.addEventListener('mouseup', stopDrag);
  window.addEventListener('mouseleave', stopDrag);
});

onUnmounted(() => {
  window.removeEventListener('mouseup', stopDrag);
  window.removeEventListener('mouseleave', stopDrag);
});
</script>

<template>
  <div class="relative w-full rounded-2xl sm:rounded-3xl overflow-hidden glass-panel p-3 sm:p-5 border border-zinc-800 shadow-2xl shadow-black/90">
    
    <!-- Header Controls: Vehicle Case Switcher Tabs & Info (Only in Multi-Mode) -->
    <div v-if="!isSingleMode" class="space-y-2.5 sm:space-y-3 border-b border-zinc-800/80 pb-3 mb-3 sm:mb-4">
      
      <!-- Category Filter Pills (All / Wraps & Supercars / Bespoke Interiors) -->
      <div class="flex items-center justify-between gap-2 flex-wrap">
        <div class="flex items-center gap-1.5 p-1 rounded-xl bg-zinc-950 border border-zinc-800 text-[11px] font-mono">
          <button
            @click="selectedCategory = 'all'"
            class="px-2.5 py-1 rounded-lg transition-all font-semibold"
            :class="selectedCategory === 'all' ? 'bg-zinc-800 text-white shadow-sm' : 'text-zinc-400 hover:text-white'"
          >
            {{ currentLocale === 'ar' ? 'الكل (5)' : 'All (5)' }}
          </button>
          <button
            @click="selectedCategory = 'exterior'"
            class="px-2.5 py-1 rounded-lg transition-all font-semibold"
            :class="selectedCategory === 'exterior' ? 'bg-zinc-800 text-white shadow-sm' : 'text-zinc-400 hover:text-white'"
          >
            {{ currentLocale === 'ar' ? 'تجليد وسيارات خارقة (4)' : 'Wraps & Supercars (4)' }}
          </button>
          <button
            @click="selectedCategory = 'interior'"
            class="px-2.5 py-1 rounded-lg transition-all font-semibold"
            :class="selectedCategory === 'interior' ? 'bg-zinc-800 text-white shadow-sm' : 'text-zinc-400 hover:text-white'"
          >
            {{ currentLocale === 'ar' ? 'مقصورات وتفصيل جلد (1)' : 'Bespoke Interiors (1)' }}
          </button>
        </div>

        <!-- Interactive Instruction / Hint -->
        <div class="flex items-center gap-2 text-[11px] font-mono text-zinc-400 self-end sm:self-auto">
          <ArrowRightLeft class="w-3.5 h-3.5 text-red-500 animate-pulse" />
          <span class="hidden sm:inline">{{ currentLocale === 'ar' ? 'اسحب المقبض لمشاهدة التحول' : 'Drag or click to reveal transformation' }}</span>
          <span class="sm:hidden">{{ currentLocale === 'ar' ? 'اسحب للمقارنة' : 'Slide to compare' }}</span>
        </div>
      </div>

      <!-- Vehicle Case Switcher Buttons Strip -->
      <div class="flex items-center gap-1.5 sm:gap-2 p-1 rounded-xl bg-zinc-950/90 border border-zinc-800 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        <button
          v-for="(item, idx) in filteredItems"
          :key="item.id"
          @click="activeIndex = idx; sliderPosition = 50;"
          class="px-3 sm:px-4 py-1.5 rounded-lg text-xs font-mono font-bold transition-all shrink-0 flex items-center gap-2"
          :class="activeIndex === idx 
            ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md shadow-red-600/30' 
            : 'text-zinc-400 hover:text-white hover:bg-zinc-900'"
        >
          <Sparkles v-if="activeIndex === idx" class="w-3 h-3 text-white animate-pulse" />
          <span>{{ currentLocale === 'ar' ? (item.vehicleAr || item.vehicle) : item.vehicle }}</span>
        </button>
      </div>

    </div>

    <!-- Standalone Single Mode Header (For Service Detail Pages) -->
    <div v-else class="flex items-center justify-between gap-3 border-b border-zinc-800/80 pb-3 mb-3 sm:mb-4">
      <div class="flex items-center gap-2">
        <div class="p-1.5 rounded-lg bg-red-600/20 text-red-500 border border-red-500/30">
          <ShieldCheck class="w-4 h-4" />
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-display uppercase font-bold text-white tracking-wide">
            {{ activeItem.vehicle }}
          </h4>
          <p class="text-[10px] text-zinc-400 font-mono">{{ activeItem.treatment }}</p>
        </div>
      </div>

      <!-- Slide Instruction Hint -->
      <div class="flex items-center gap-2 text-[11px] font-mono text-zinc-400">
        <ArrowRightLeft class="w-3.5 h-3.5 text-red-500 animate-pulse" />
        <span class="hidden sm:inline">{{ currentLocale === 'ar' ? 'اسحب المقبض لمقارنة النتيجة' : 'Drag slider to compare before & after' }}</span>
        <span class="sm:hidden">{{ currentLocale === 'ar' ? 'اسحب للمقارنة' : 'Slide' }}</span>
      </div>
    </div>

    <!-- Image Comparison Frame -->
    <div
      ref="containerRef"
      class="relative w-full aspect-[16/10] sm:aspect-[16/9.3] rounded-xl sm:rounded-2xl overflow-hidden cursor-ew-resize select-none border border-zinc-800/60 bg-zinc-950"
      @mousedown="startDrag"
      @mousemove="handleMouseMove"
      @touchmove="handleTouchMove"
      @touchstart="startDrag"
    >
      <!-- AFTER IMAGE (Background - Layer 1) -->
      <img
        :src="activeItem.afterImage"
        :alt="activeItem.vehicle + ' After'"
        class="absolute inset-0 w-full h-full object-cover pointer-events-none transition-opacity duration-300"
      />

      <!-- BEFORE IMAGE (Clipped Overlay - Layer 2) -->
      <div
        class="absolute inset-0 overflow-hidden pointer-events-none"
        :style="{ width: `${sliderPosition}%` }"
      >
        <img
          :src="activeItem.beforeImage"
          :alt="activeItem.vehicle + ' Before'"
          class="absolute inset-0 w-full h-full object-cover max-w-none pointer-events-none"
          :style="{ width: containerRef ? `${containerRef.offsetWidth}px` : '100%' }"
        />
      </div>

      <!-- Before Floating Badge (Top Left - Layer 3 - Unclipped & Dynamic Opacity) -->
      <div
        class="absolute top-3 sm:top-4 left-3 sm:left-4 rtl:left-auto rtl:right-3 rtl:sm:right-4 z-20 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl bg-black/85 backdrop-blur-md border border-red-500/50 text-red-400 text-[10px] sm:text-xs font-mono font-bold tracking-wider uppercase shadow-xl flex items-center gap-1.5 transition-opacity duration-200"
        :class="{ 'opacity-20': sliderPosition < 15 }"
      >
        <span class="w-2 h-2 rounded-full bg-red-500 shrink-0"></span>
        <span class="truncate max-w-[140px] sm:max-w-none">{{ currentLocale === 'ar' ? (activeItem.beforeLabelAr || activeItem.beforeLabel) : activeItem.beforeLabel }}</span>
      </div>

      <!-- After Floating Badge (Top Right - Layer 3 - Unclipped & Dynamic Opacity) -->
      <div
        class="absolute top-3 sm:top-4 right-3 sm:right-4 rtl:right-auto rtl:left-3 rtl:sm:left-4 z-20 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl bg-black/85 backdrop-blur-md border border-emerald-500/50 text-emerald-400 text-[10px] sm:text-xs font-mono font-bold tracking-wider uppercase shadow-xl flex items-center gap-1.5 transition-opacity duration-200"
        :class="{ 'opacity-20': sliderPosition > 85 }"
      >
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
        <span class="truncate max-w-[140px] sm:max-w-none">{{ currentLocale === 'ar' ? (activeItem.afterLabelAr || activeItem.afterLabel) : activeItem.afterLabel }}</span>
      </div>

      <!-- Vertical Laser Divider Line & Handle -->
      <div
        class="absolute top-0 bottom-0 w-0.5 sm:w-1 bg-white pointer-events-none shadow-[0_0_15px_rgba(255,255,255,1)] z-30"
        :style="{ left: `${sliderPosition}%` }"
      >
        <!-- Center Handle Button -->
        <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-black border-2 border-white shadow-2xl flex items-center justify-center pointer-events-auto cursor-ew-resize hover:scale-110 active:scale-95 transition-transform">
          <div class="flex items-center gap-1 text-white text-xs font-black">
            <span class="text-red-500">&#9664;</span>
            <span class="text-white text-[10px] font-mono">|</span>
            <span class="text-emerald-400">&#9654;</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Treatment Details Strip -->
    <div class="mt-3 sm:mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs font-mono text-zinc-400 px-1">
      <div class="flex items-center gap-2 text-zinc-300">
        <CheckCircle2 class="w-4 h-4 text-red-500 shrink-0" />
        <span class="font-bold text-white">{{ currentLocale === 'ar' ? (activeItem.serviceAr || activeItem.service) : activeItem.service }}</span>
        <span class="text-zinc-500">•</span>
        <span class="text-zinc-400 font-light">{{ currentLocale === 'ar' ? (activeItem.treatmentAr || activeItem.treatment) : activeItem.treatment }}</span>
      </div>

      <div class="text-[11px] text-zinc-400 font-mono">
        {{ currentLocale === 'ar' ? 'تصوير حقيقي من داخل صالات فينينو أبوظبي' : 'Photographed inside Veneno Abu Dhabi Clean-Room Bays' }}
      </div>
    </div>

  </div>
</template>
