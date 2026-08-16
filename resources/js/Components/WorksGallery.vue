<script setup>
import { ref, computed } from 'vue';
import { Play, Eye, X, ChevronLeft, ChevronRight, Sparkles, ShieldCheck } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const emit = defineEmits(['open-quote']);

const { t, currentLocale } = useI18n();

const activeLightboxItem = ref(null);

// Category carousels dataset with all authentic videos & photos
const categoriesData = computed(() => [
  {
    id: 'ppf',
    title: t('gallery.ppfTitle'),
    tag: '3M PPF Studio',
    items: [
      {
        id: 'vid_ppf1',
        title: t('gallery.vid_ppf1'),
        type: 'video',
        src: '/videos/gallery/c7c29145-92a8-4372-aa25-6207c0e5a30e.mp4',
        thumbnail: '/images/services/ppf/IMG_5968.JPG',
      },
      {
        id: 'vid_ppf2',
        title: t('gallery.vid_ppf2'),
        type: 'video',
        src: '/videos/gallery/9b76c499-4d04-46ac-a68f-4021ac3a4777.mp4',
        thumbnail: '/images/services/ppf/IMG_5965.JPG',
      },
      {
        id: 'vid_ppf3',
        title: t('gallery.vid_ppf3'),
        type: 'video',
        src: '/videos/gallery/c74d182a-d556-4798-ab43-cd27a1520ef6.mp4',
        thumbnail: '/images/services/ppf/IMG_5967.JPG',
      },
      {
        id: 'vid_ppf4',
        title: t('gallery.vid_ppf4'),
        type: 'video',
        src: '/videos/gallery/3c09c81a2c74453fa06dee52953f4c95.mp4',
        thumbnail: '/images/services/ppf/IMG_5970.JPG',
      },
      {
        id: 'vid_ppf5',
        title: t('gallery.vid_ppf5'),
        type: 'video',
        src: '/videos/gallery/IMG_4055.mov',
        thumbnail: '/images/services/ppf/IMG_5969.JPG',
      },
      {
        id: 'photo_ppf',
        title: t('gallery.item1_title'),
        type: 'image',
        src: '/images/services/ppf/IMG_5968.JPG',
        thumbnail: '/images/services/ppf/IMG_5968.JPG',
      },
    ],
  },
  {
    id: 'ceramic',
    title: t('gallery.ceramicTitle'),
    tag: 'GYEON Certified Lab',
    items: [
      {
        id: 'vid_ceramic1',
        title: t('gallery.vid_ceramic1'),
        type: 'video',
        src: '/videos/gallery/3c9c1f38-026d-4c88-846f-e024c4b0f13a.mp4',
        thumbnail: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
      },
      {
        id: 'vid_ceramic2',
        title: t('gallery.vid_ceramic2'),
        type: 'video',
        src: '/videos/gallery/IMG_4612.mov',
        thumbnail: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 10.JPG',
      },
      {
        id: 'vid_ceramic3',
        title: t('gallery.vid_ceramic3'),
        type: 'video',
        src: '/videos/gallery/IMG_4630.mov',
        thumbnail: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 14.JPG',
      },
      {
        id: 'photo_ceramic',
        title: t('gallery.item2'),
        type: 'image',
        src: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
        thumbnail: '/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG',
      },
    ],
  },
  {
    id: 'tinting',
    title: t('gallery.tintingTitle'),
    tag: '3M Thermal Shield',
    items: [
      {
        id: 'vid_tinting1',
        title: t('gallery.vid_tinting1'),
        type: 'video',
        src: '/videos/gallery/a8d5540a-408b-471b-be49-ce2b27f7bffe.mp4',
        thumbnail: '/images/services/tinting/IMG_5971.JPG',
      },
      {
        id: 'vid_tinting2',
        title: t('gallery.vid_tinting2'),
        type: 'video',
        src: '/videos/gallery/bd1181e0-20d3-4f8a-9846-af34d3c98224.mp4',
        thumbnail: '/images/services/tinting/IMG_5967.JPG',
      },
      {
        id: 'vid_tinting3',
        title: t('gallery.vid_tinting3'),
        type: 'video',
        src: '/videos/gallery/IMG_4369.mov',
        thumbnail: '/images/services/tinting/IMG_5969.JPG',
      },
      {
        id: 'photo_tinting',
        title: t('gallery.item4'),
        type: 'image',
        src: '/images/services/tinting/IMG_5971.JPG',
        thumbnail: '/images/services/tinting/IMG_5971.JPG',
      },
    ],
  },
  {
    id: 'detailing',
    title: t('gallery.detailingTitle'),
    tag: 'Master Refinement',
    items: [
      {
        id: 'vid_detailing1',
        title: t('gallery.vid_detailing1'),
        type: 'video',
        src: '/videos/gallery/SaveInsta.App - 3239432449981201130.mp4',
        thumbnail: '/images/services/detailing/PHOTO-2024-07-12-14-12-51 13.JPG',
      },
      {
        id: 'vid_paint1',
        title: t('gallery.vid_paint1'),
        type: 'video',
        src: '/videos/gallery/136b949d-acf0-41f3-ac15-0292388d9e4c.mp4',
        thumbnail: '/images/services/paint/IMG_5901.JPG',
      },
      {
        id: 'photo_detailing',
        title: t('gallery.item6'),
        type: 'image',
        src: '/images/services/detailing/PHOTO-2024-07-12-14-12-51 13.JPG',
        thumbnail: '/images/services/detailing/PHOTO-2024-07-12-14-12-51 13.JPG',
      },
    ],
  },
  {
    id: 'wrapping_wheels',
    title: t('gallery.wrappingTitle'),
    tag: 'Wrapping, PDR & Wheels',
    items: [
      {
        id: 'vid_wrapping1',
        title: t('gallery.vid_wrapping1'),
        type: 'video',
        src: '/videos/gallery/2b8398c9-f8cb-41ae-92dc-e67b6802a3fb.mp4',
        thumbnail: '/images/services/wrapping/vinyl-wrap-bubbling-dubai.webp',
      },
      {
        id: 'vid_wrapping2',
        title: t('gallery.vid_wrapping2'),
        type: 'video',
        src: '/videos/gallery/4dddf6e9-0449-45c9-915d-c74da1adc5ab.mp4',
        thumbnail: '/images/gallery/PHOTO-2024-07-12-14-12-51 22.JPG',
      },
      {
        id: 'vid_pdr1',
        title: t('gallery.vid_pdr1'),
        type: 'video',
        src: '/videos/gallery/SaveInsta.App - 3384306979580878525.mp4',
        thumbnail: '/images/services/pdr/PHOTO-2024-07-12-14-12-51 11.JPG',
      },
      {
        id: 'vid_pdr2',
        title: t('gallery.vid_pdr2'),
        type: 'video',
        src: '/videos/gallery/SaveInsta.App - 3388673030153503380.mp4',
        thumbnail: '/images/gallery/PHOTO-2024-07-12-14-12-51 17.JPG',
      },
      {
        id: 'vid_pdr3',
        title: t('gallery.vid_pdr3'),
        type: 'video',
        src: '/videos/gallery/c880c97ee4464659b32d8fb4c7f00218.mp4',
        thumbnail: '/images/gallery/PHOTO-2024-07-12-14-12-51 19.JPG',
      },
      {
        id: 'vid_rims1',
        title: t('gallery.vid_rims1'),
        type: 'video',
        src: '/videos/gallery/IMG_4456.mov',
        thumbnail: '/images/services/rims/PHOTO-2024-07-12-14-12-51 9.JPG',
      },
      {
        id: 'photo_wrapping',
        title: t('gallery.item5'),
        type: 'image',
        src: '/images/services/wrapping/vinyl-wrap-bubbling-dubai.webp',
        thumbnail: '/images/services/wrapping/vinyl-wrap-bubbling-dubai.webp',
      },
      {
        id: 'photo_rims',
        title: t('gallery.item7'),
        type: 'image',
        src: '/images/services/rims/PHOTO-2024-07-12-14-12-51 9.JPG',
        thumbnail: '/images/services/rims/PHOTO-2024-07-12-14-12-51 9.JPG',
      },
    ],
  },
]);

// Carousel scroll controls
const scrollCarousel = (categoryId, direction) => {
  const container = document.getElementById(`carousel-${categoryId}`);
  if (container) {
    const scrollAmount = 340 * direction;
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
};
</script>

<template>
  <section id="gallery" class="py-20 bg-zinc-950 relative border-t border-zinc-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 gap-4">
        <div>
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">{{ t('gallery.tag') }}</span>
          <h2 class="text-2xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-1">
            {{ t('gallery.title') }}
          </h2>
          <p class="text-xs sm:text-sm text-zinc-400 mt-1 max-w-xl">
            {{ t('gallery.subtitle') }}
          </p>
        </div>

        <button
          @click="emit('open-quote')"
          class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-display text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all self-start sm:self-auto"
        >
          {{ t('services.getQuote') }}
        </button>
      </div>

      <!-- CATEGORY-SEGMENTED 2-ROW CAROUSELS -->
      <div class="space-y-16">
        <div
          v-for="cat in categoriesData"
          :key="cat.id"
          class="space-y-4"
        >
          <!-- Category Header & Scroll Controls -->
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
              <h3 class="text-lg sm:text-xl font-display font-semibold uppercase tracking-wide text-white">
                {{ cat.title }}
              </h3>
              <span class="text-[10px] font-mono text-zinc-500 px-2 py-0.5 rounded-full bg-zinc-900 border border-zinc-800">
                {{ cat.items.length }} {{ t('gallery.mediaItems') }}
              </span>
            </div>

            <!-- Left / Right Nav Arrows -->
            <div class="flex items-center gap-2">
              <button
                @click="scrollCarousel(cat.id, -1)"
                aria-label="Scroll left"
                class="p-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-300 hover:text-white transition-colors"
              >
                <ChevronLeft class="w-4 h-4 rtl:rotate-180" />
              </button>
              <button
                @click="scrollCarousel(cat.id, 1)"
                aria-label="Scroll right"
                class="p-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-300 hover:text-white transition-colors"
              >
                <ChevronRight class="w-4 h-4 rtl:rotate-180" />
              </button>
            </div>
          </div>

          <!-- 2-ROW HORIZONTAL SLIDING TRACK -->
          <div
            :id="`carousel-${cat.id}`"
            class="grid grid-rows-2 grid-flow-col gap-4 overflow-x-auto scrollbar-none scroll-smooth pb-2 pt-1 -mx-4 px-4 sm:mx-0 sm:px-0"
          >
            <div
              v-for="item in cat.items"
              :key="item.id"
              @click="activeLightboxItem = item"
              class="group relative w-[280px] sm:w-[320px] h-[175px] rounded-2xl overflow-hidden glass-panel border border-zinc-800/80 hover:border-red-500/60 transition-all duration-300 cursor-pointer shadow-lg hover:shadow-red-950/20 shrink-0"
            >
              <!-- Thumbnail -->
              <img
                :src="item.thumbnail || item.src"
                :alt="item.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
              />

              <!-- Dark Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/30 to-transparent"></div>

              <!-- Media Type Indicator -->
              <div class="absolute top-3 left-3 z-10">
                <span
                  v-if="item.type === 'video'"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-600/90 text-white text-[10px] font-mono font-bold uppercase tracking-wider shadow-md backdrop-blur-sm"
                >
                  <Play class="w-2.5 h-2.5 fill-current" />
                  <span>Video</span>
                </span>
                <span
                  v-else
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-zinc-900/80 border border-zinc-700 text-zinc-300 text-[10px] font-mono uppercase tracking-wider backdrop-blur-sm"
                >
                  <Eye class="w-2.5 h-2.5" />
                  <span>Studio</span>
                </span>
              </div>

              <!-- Play Center Pulse on Hover -->
              <div
                v-if="item.type === 'video'"
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none"
              >
                <div class="w-12 h-12 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-xl shadow-red-600/50 transform scale-90 group-hover:scale-100 transition-transform">
                  <Play class="w-5 h-5 fill-current ml-0.5" />
                </div>
              </div>

              <!-- Title Label -->
              <div class="absolute bottom-3 left-3 right-3 z-10">
                <h4 class="text-xs font-bold text-white group-hover:text-red-400 transition-colors line-clamp-1">
                  {{ item.title }}
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- FULLSCREEN LIGHTBOX MODAL -->
    <div
      v-if="activeLightboxItem"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-md animate-in fade-in duration-200"
      @click="activeLightboxItem = null"
    >
      <div
        class="relative max-w-4xl w-full glass-panel rounded-3xl border border-zinc-700 overflow-hidden shadow-2xl"
        @click.stop
      >
        <!-- Close Button -->
        <button
          @click="activeLightboxItem = null"
          class="absolute top-4 right-4 z-20 p-2 rounded-full bg-zinc-900/80 text-zinc-300 hover:text-white hover:bg-zinc-800 transition-colors"
        >
          <X class="w-5 h-5" />
        </button>

        <!-- Video Player -->
        <div v-if="activeLightboxItem.type === 'video'" class="relative aspect-video bg-black flex items-center justify-center">
          <video
            :src="activeLightboxItem.src"
            controls
            autoplay
            playsinline
            class="w-full h-full object-contain"
          ></video>
        </div>

        <!-- Image Viewer -->
        <div v-else class="relative max-h-[75vh] bg-black flex items-center justify-center overflow-hidden">
          <img
            :src="activeLightboxItem.src"
            :alt="activeLightboxItem.title"
            class="w-full h-full object-contain max-h-[75vh]"
          />
        </div>

        <!-- Caption Bar -->
        <div class="p-5 bg-zinc-950 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-zinc-800">
          <div>
            <h3 class="text-sm sm:text-base font-bold text-white">{{ activeLightboxItem.title }}</h3>
            <p class="text-xs text-zinc-400 mt-0.5">Veneno Auto Care Center — Certified Studio</p>
          </div>

          <button
            @click="emit('open-quote'); activeLightboxItem = null;"
            class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-display text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all self-start sm:self-auto"
          >
            {{ t('services.getQuote') }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

