<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Sparkles, ArrowRightLeft, CheckCircle2 } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const { t, currentLocale } = useI18n();

const props = defineProps({
  items: {
    type: Array,
    default: () => [
      {
        id: 'aston-martin',
        vehicle: 'Aston Martin Vantage',
        service: 'Peelable Color Wrap & 3M PPF',
        beforeImage: '/images/before-after/aston-martin-before.jpg',
        afterImage: '/images/before-after/aston-martin-after.jpg',
        beforeLabel: 'Before: Gloss Black (Original)',
        afterLabel: 'After: British Racing Green Wrap',
        beforeLabelAr: 'قبل: طلاء أسود لامع (أصلي)',
        afterLabelAr: 'بعد: تجليد أخضر بريطاني ميتاليك',
        treatment: 'Custom Peelable Wrap + Yellow Accent Aero Lip',
      },
      {
        id: 'porsche-911',
        vehicle: 'Porsche 911 Turbo S',
        service: 'Concourse Paint Correction & Ceramic',
        beforeImage: '/images/services/detailing/PHOTO-2024-07-12-14-12-51 18.JPG',
        afterImage: '/images/services/detailing/PHOTO-2024-07-12-14-12-51 24.JPG',
        beforeLabel: 'Before: Swirls & Clearcoat Haze',
        afterLabel: 'After: 9H GYEON Quartz Ceramic Matrix',
        beforeLabelAr: 'قبل: دوائر وخدوش واضحة',
        afterLabelAr: 'بعد: حماية نانو سيراميك 9H وانعكاس مرآة',
        treatment: 'Multi-Stage Micro-Abrasive Leveling',
      },
    ],
  },
  initialIndex: {
    type: Number,
    default: 0,
  },
});

const activeIndex = ref(props.initialIndex);
const activeItem = computed(() => props.items[activeIndex.value] || props.items[0]);

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
    
    <!-- Header Controls: Vehicle Case Switcher Tabs & Info -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 border-b border-zinc-800/80 pb-3 mb-3 sm:mb-4">
      
      <!-- Vehicle Case Switcher Buttons (No Scrollbar) -->
      <div class="flex items-center gap-1.5 sm:gap-2 p-1 rounded-xl bg-zinc-950/80 border border-zinc-800 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        <button
          v-for="(item, idx) in items"
          :key="item.id"
          @click="activeIndex = idx; sliderPosition = 50;"
          class="px-3 sm:px-4 py-1.5 rounded-lg text-xs font-mono font-bold transition-all shrink-0 flex items-center gap-2"
          :class="activeIndex === idx 
            ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md shadow-red-600/30' 
            : 'text-zinc-400 hover:text-white hover:bg-zinc-900'"
        >
          <Sparkles v-if="activeIndex === idx" class="w-3 h-3 text-white animate-pulse" />
          <span>{{ item.vehicle }}</span>
        </button>
      </div>

      <!-- Interactive Instruction / Hint -->
      <div class="flex items-center gap-2 text-[11px] font-mono text-zinc-400 self-end sm:self-auto">
        <ArrowRightLeft class="w-3.5 h-3.5 text-red-500 animate-pulse" />
        <span class="hidden sm:inline">{{ currentLocale === 'ar' ? 'اسحب المقبض لمشاهدة التحول' : 'Drag or click to reveal transformation' }}</span>
        <span class="sm:hidden">{{ currentLocale === 'ar' ? 'اسحب للمقارنة' : 'Slide to compare' }}</span>
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
        <span class="font-bold text-white">{{ activeItem.service }}</span>
        <span class="text-zinc-500">•</span>
        <span class="text-zinc-400 font-light">{{ activeItem.treatment }}</span>
      </div>

      <div class="text-[11px] text-zinc-400 font-mono">
        {{ currentLocale === 'ar' ? 'تصوير حقيقي من داخل صالات فينينو أبوظبي' : 'Photographed inside Veneno Abu Dhabi Clean-Room Bays' }}
      </div>
    </div>

  </div>
</template>
