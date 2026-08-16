<script setup>
import { ref, computed } from 'vue';
import { Sparkles, Play, Eye, X, ChevronRight, ShieldCheck } from 'lucide-vue-next';

const emit = defineEmits(['open-quote']);

const activeFilter = ref('all');
const activeLightboxItem = ref(null);

const galleryItems = [
  {
    id: 1,
    title: 'Porsche 911 Turbo S — Full Body PPF & 9H Graphene',
    category: 'ppf',
    type: 'image',
    src: '/images/services/ppf/IMG_5902.JPG',
    tag: 'Full Body PPF',
  },
  {
    id: 2,
    title: 'Mercedes-AMG G63 — Concourse Leveling & Dual Ceramic Shield',
    category: 'ceramic',
    type: 'image',
    src: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
    tag: 'Ceramic 9H',
  },
  {
    id: 3,
    title: 'Ferrari SF90 — Micro-Abrasive Paint Correction Lab',
    category: 'detailing',
    type: 'image',
    src: '/images/services/detailing/IMG_5899.JPG',
    tag: 'Paint Correction',
  },
  {
    id: 4,
    title: 'Lamborghini Urus — Nano-Ceramic Infrared Window Tinting',
    category: 'tinting',
    type: 'image',
    src: '/images/services/tinting/IMG_5967.JPG',
    tag: 'Ceramic Tint',
  },
  {
    id: 5,
    title: 'Rolls-Royce Ghost — Satin Metallic Cast Vinyl Wrap',
    category: 'wrapping',
    type: 'image',
    src: '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
    tag: 'Custom Wrap',
  },
  {
    id: 6,
    title: 'Aston Martin DBS — Multi-Stage Surface Restoration & Reflection',
    category: 'detailing',
    type: 'image',
    src: '/images/gallery/PHOTO-2024-07-12-14-12-51 24.JPG',
    tag: 'Mirror Gloss',
  },
  {
    id: 7,
    title: 'Bentley Continental GT — CNC Diamond Cut Rim Refurbishment',
    category: 'rims',
    type: 'image',
    src: '/images/gallery/PHOTO-2024-07-12-14-12-51 21.JPG',
    tag: 'Wheel Repair',
  },
  {
    id: 8,
    title: 'McLaren 720S — Specialized Paintless Dent Repair (PDR)',
    category: 'pdr',
    type: 'image',
    src: '/images/gallery/PHOTO-2024-07-12-14-12-51 17.JPG',
    tag: 'Factory PDR',
  },
  {
    id: 9,
    title: 'Supercar Bay Floor — Concourse Decon & Prep Process',
    category: 'videos',
    type: 'video',
    src: '/videos/gallery/SaveInsta.App - 3239432449981201130.mp4',
    thumbnail: '/images/services/ppf/IMG_5965.JPG',
    tag: 'Workshop Video',
  },
  {
    id: 10,
    title: '9H Ceramic Hydrophobic Water Beading Test',
    category: 'videos',
    type: 'video',
    src: '/videos/gallery/SaveInsta.App - 3384306979580878525.mp4',
    thumbnail: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 14.JPG',
    tag: 'Hydrophobic Test',
  },
];

const filteredItems = computed(() => {
  if (activeFilter.value === 'all') return galleryItems;
  return galleryItems.filter((i) => i.category === activeFilter.value);
});
</script>

<template>
  <section id="gallery" class="py-24 bg-zinc-950 relative border-t border-zinc-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Studio Portfolio</span>
          <h2 class="text-3xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-1">
            Our Works & Supercar Gallery
          </h2>
          <p class="text-xs sm:text-sm text-zinc-400 mt-2 max-w-xl">
            Explore authentic transformation results from our studio bay. Every exotic is treated with concourse precision and master craftsmanship.
          </p>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-1.5 p-1.5 rounded-2xl bg-zinc-900/90 border border-zinc-800 text-xs font-semibold">
          <button
            v-for="f in [
              { id: 'all', label: 'All Works' },
              { id: 'ppf', label: 'PPF Armor' },
              { id: 'ceramic', label: 'Ceramic 9H' },
              { id: 'detailing', label: 'Correction' },
              { id: 'tinting', label: 'Tinting' },
              { id: 'videos', label: 'Videos' },
            ]"
            :key="f.id"
            @click="activeFilter = f.id"
            class="px-3.5 py-1.5 rounded-xl transition-all font-mono text-[11px] uppercase tracking-wider"
            :class="activeFilter === f.id ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-zinc-400 hover:text-white hover:bg-zinc-800'"
          >
            {{ f.label }}
          </button>
        </div>
      </div>

      <!-- Gallery Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="item in filteredItems"
          :key="item.id"
          @click="activeLightboxItem = item"
          class="group relative rounded-3xl overflow-hidden glass-panel border border-zinc-800/80 hover:border-red-500/50 transition-all duration-300 cursor-pointer shadow-xl"
        >
          <!-- Media Thumbnail -->
          <div class="relative h-64 overflow-hidden bg-zinc-900">
            <img
              :src="item.type === 'video' ? item.thumbnail : item.src"
              :alt="item.title"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
            
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-transparent"></div>

            <!-- Video Play Badge -->
            <div
              v-if="item.type === 'video'"
              class="absolute inset-0 flex items-center justify-center pointer-events-none"
            >
              <div class="w-14 h-14 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                <Play class="w-6 h-6 fill-current translate-x-0.5" />
              </div>
            </div>

            <!-- Category Tag -->
            <div class="absolute top-4 left-4">
              <span class="px-3 py-1 rounded-full bg-zinc-900/90 text-white text-[10px] font-mono font-bold uppercase border border-zinc-700 backdrop-blur-md shadow-lg">
                {{ item.tag }}
              </span>
            </div>

            <!-- Hover Overlay Action -->
            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
              <span class="p-2.5 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-lg">
                <Eye class="w-4 h-4" />
              </span>
            </div>
          </div>

          <!-- Caption -->
          <div class="p-4 bg-zinc-950/80">
            <h3 class="text-xs font-bold text-zinc-200 group-hover:text-red-400 transition-colors line-clamp-1">
              {{ item.title }}
            </h3>
            <span class="text-[10px] text-zinc-500 font-mono mt-0.5 block">Veneno Al Quoz Detailing Studio</span>
          </div>
        </div>
      </div>

      <!-- Bottom Banner CTA -->
      <div class="mt-12 p-8 rounded-3xl glass-panel border border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
        <div>
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Custom Appraisal</span>
          <h3 class="text-xl sm:text-2xl font-display font-semibold uppercase tracking-wider text-white mt-1">
            Want This Mirror Finish For Your Vehicle?
          </h3>
          <p class="text-xs text-zinc-400 mt-1">
            Contact our studio team today for a complimentary vehicle appraisal and quote.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <button
            @click="emit('open-quote')"
            class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all"
          >
            Get a Free Quote
          </button>
          
          <a
            href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20saw%20your%20works%20gallery%20and%20would%20like%20a%20quote."
            target="_blank"
            rel="noopener noreferrer"
            class="px-5 py-3.5 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 font-bold text-xs flex items-center gap-2 transition-all"
          >
            <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
            </svg>
            <span>WhatsApp</span>
          </a>
        </div>
      </div>

    </div>

    <!-- Lightbox Modal -->
    <div
      v-if="activeLightboxItem"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-xl animate-in fade-in duration-200"
    >
      <div class="relative max-w-4xl w-full glass-panel rounded-3xl overflow-hidden border border-zinc-800 p-4">
        <!-- Close -->
        <button
          @click="activeLightboxItem = null"
          class="absolute top-6 right-6 z-20 p-2 rounded-xl bg-zinc-900/90 text-zinc-300 hover:text-white border border-zinc-700"
        >
          <X class="w-5 h-5" />
        </button>

        <!-- Media Display -->
        <div class="rounded-2xl overflow-hidden bg-black max-h-[70vh] flex items-center justify-center">
          <video
            v-if="activeLightboxItem.type === 'video'"
            :src="activeLightboxItem.src"
            controls
            autoplay
            class="max-h-[68vh] w-auto max-w-full rounded-2xl"
          ></video>
          <img
            v-else
            :src="activeLightboxItem.src"
            :alt="activeLightboxItem.title"
            class="max-h-[68vh] w-auto max-w-full object-contain rounded-2xl"
          />
        </div>

        <!-- Lightbox Caption & Action -->
        <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-2">
          <div>
            <span class="text-xs font-mono uppercase text-red-400 font-bold">{{ activeLightboxItem.tag }}</span>
            <h4 class="text-base font-bold text-white">{{ activeLightboxItem.title }}</h4>
          </div>

          <button
            @click="emit('open-quote'); activeLightboxItem = null;"
            class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30"
          >
            Get a Quote for this Treatment
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
