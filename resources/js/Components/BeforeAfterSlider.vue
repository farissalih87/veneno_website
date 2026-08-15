<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Sparkles } from 'lucide-vue-next';

const props = defineProps({
  beforeImage: {
    type: String,
    required: true,
  },
  afterImage: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    default: 'Concourse Paint Correction & Ceramic Reflection',
  },
  subtitle: {
    type: String,
    default: 'Drag slider to reveal 95%+ swirl defect elimination and glass-mirror depth',
  },
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

const startDrag = () => {
  isDragging.value = true;
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
  <div class="relative w-full rounded-2xl overflow-hidden glass-panel p-2 md:p-3 border border-zinc-800 shadow-2xl shadow-black/80">
    <!-- Header banner -->
    <div class="flex items-center justify-between px-3 py-2 text-xs font-mono text-zinc-400 border-b border-zinc-800/80 mb-2">
      <div class="flex items-center gap-2">
        <Sparkles class="w-4 h-4 text-red-500" />
        <span class="text-white font-semibold">{{ title }}</span>
      </div>
      <div class="text-[11px] text-zinc-500 hidden sm:block">{{ subtitle }}</div>
    </div>

    <!-- Image comparison container -->
    <div
      ref="containerRef"
      class="relative w-full aspect-[16/9] md:aspect-[21/9] rounded-xl overflow-hidden cursor-ew-resize select-none"
      @mousedown="startDrag"
      @mousemove="handleMouseMove"
      @touchmove="handleTouchMove"
    >
      <!-- After Image (Background) -->
      <img
        :src="afterImage"
        alt="After Detailing"
        class="absolute inset-0 w-full h-full object-cover pointer-events-none"
      />
      <div class="absolute top-4 right-4 z-10 px-3 py-1 rounded-full bg-zinc-950/80 backdrop-blur-md border border-emerald-500/40 text-emerald-400 text-xs font-mono font-bold tracking-wider uppercase shadow-lg">
        After: 9H Ceramic Matrix
      </div>

      <!-- Before Image (Clipped Overlay) -->
      <div
        class="absolute inset-0 overflow-hidden pointer-events-none"
        :style="{ width: `${sliderPosition}%` }"
      >
        <img
          :src="beforeImage"
          alt="Before Detailing"
          class="absolute inset-0 w-full h-full object-cover max-w-none pointer-events-none"
          :style="{ width: containerRef ? `${containerRef.offsetWidth}px` : '100%' }"
        />
        <div class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-zinc-950/80 backdrop-blur-md border border-red-500/40 text-red-400 text-xs font-mono font-bold tracking-wider uppercase shadow-lg">
          Before: Swirls & Oxidation
        </div>
      </div>

      <!-- Divider Bar & Handle -->
      <div
        class="absolute top-0 bottom-0 w-1 bg-gradient-to-b from-red-500 via-white to-red-500 pointer-events-none shadow-[0_0_12px_rgba(239,68,68,0.8)]"
        :style="{ left: `${sliderPosition}%` }"
      >
        <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-zinc-950 border-2 border-red-500 shadow-2xl flex items-center justify-center pointer-events-auto cursor-ew-resize">
          <div class="flex items-center gap-0.5 text-red-400 text-xs font-black">
            <span>&#9664;</span>
            <span>&#9654;</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
