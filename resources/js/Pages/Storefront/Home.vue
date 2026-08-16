<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import BeforeAfterSlider from '@/Components/BeforeAfterSlider.vue';
import WorksGallery from '@/Components/WorksGallery.vue';
import QuoteSection from '@/Components/QuoteSection.vue';
import QuoteModal from '@/Components/QuoteModal.vue';
import WhatsAppWidget from '@/Components/WhatsAppWidget.vue';
import {
  Sparkles,
  ShieldCheck,
  Phone,
  Award,
  ChevronRight,
  Star,
  CheckCircle2,
  MapPin,
  Clock,
  Mail,
  ArrowUpRight,
  Flame,
  Wrench
} from 'lucide-vue-next';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
  galleryImages: {
    type: Array,
    default: () => [],
  },
});

const isQuoteModalOpen = ref(false);
const selectedServiceName = ref('');

const openQuoteWithService = (serviceName) => {
  selectedServiceName.value = serviceName;
  isQuoteModalOpen.value = true;
};
</script>

<template>
  <Head title="Veneno Auto Care — Luxury Car Detailing, PPF & Ceramic Coating Studio in UAE" />

  <div class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 font-sans selection:bg-red-600 selection:text-white">
    <!-- Navbar -->
    <Navbar @open-quote="isQuoteModalOpen = true" />

    <!-- 1. CINEMATIC VIDEO HERO SECTION -->
    <section id="home" class="relative min-h-[92vh] flex items-center justify-center overflow-hidden bg-zinc-950">
      <!-- Background Video Overlay & Media -->
      <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none select-none">
        <!-- YouTube Background Video -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100vw] h-[56.25vw] min-h-[100vh] min-w-[177.77vh] opacity-55 filter brightness-75 contrast-110">
          <iframe
            class="w-full h-full pointer-events-none"
            src="https://www.youtube-nocookie.com/embed/I4cZjZX3S00?autoplay=1&mute=1&loop=1&playlist=I4cZjZX3S00&controls=0&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&playsinline=1"
            title="Veneno Luxury Auto Care Hero Video"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
          ></iframe>
        </div>

        <!-- Dark Gradient & Spotlight Overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/65 to-zinc-950/40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/85 via-transparent to-zinc-950/85"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-red-600/20 rounded-full blur-3xl pointer-events-none"></div>
      </div>

      <!-- Hero Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <!-- Floating Accreditation Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-red-500/30 text-xs font-mono text-zinc-300 mb-6 shadow-xl shadow-black/60 animate-in fade-in slide-in-from-top-4 duration-300">
          <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
          <span class="text-red-400 font-bold uppercase tracking-wider">Accredited Luxury Auto Studio</span>
          <span class="text-zinc-600">|</span>
          <span>Certified XPEL & Gyeon Master Installers</span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-display font-semibold uppercase tracking-wider text-white max-w-5xl mx-auto leading-[1.15]">
          The Apex of Automotive <br class="hidden sm:inline" />
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-white to-red-400">
            Detailing & Protection
          </span>
        </h1>

        <p class="mt-6 text-base sm:text-lg text-zinc-300 max-w-2xl mx-auto font-light leading-relaxed">
          Preserve concourse showroom reflections with military-grade self-healing PPF, 9H+ graphene ceramic coatings, and certified master paint correction.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
          <button
            @click="isQuoteModalOpen = true"
            class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-2xl shadow-red-600/40 transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3"
          >
            <Sparkles class="w-4 h-4" />
            <span>Get a Tailored Quote</span>
          </button>

          <a
            href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20would%20like%20to%20inquire%20about%20your%20services."
            target="_blank"
            rel="noopener noreferrer"
            class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 hover:text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-3 transition-all shadow-xl"
          >
            <!-- Official WhatsApp SVG Icon -->
            <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
            </svg>
            <span>WhatsApp Us Now</span>
          </a>
        </div>

        <!-- Trust Stats Banner -->
        <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-4xl mx-auto">
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-display font-bold italic text-white">2,500+</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Exotics Protected</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-display font-bold italic text-red-500">9H+</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Graphene Matrix</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-display font-bold italic text-white">10-Yr</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Certified Warranty</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-display font-bold italic text-amber-400">4.99 ★</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Client Satisfaction</div>
          </div>
        </div>
      </div>
    </section>

    <!-- 2. ABOUT US SECTION -->
    <section id="about" class="py-24 bg-zinc-950 relative border-t border-zinc-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          
          <!-- Image Collage from real workshop photos -->
          <div class="lg:col-span-6 grid grid-cols-2 gap-4">
            <div class="space-y-4">
              <div class="rounded-3xl overflow-hidden glass-panel border border-zinc-800 h-64">
                <img
                  src="/images/services/ppf/IMG_5902.JPG"
                  alt="Veneno Workshop Bay PPF"
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                />
              </div>
              <div class="rounded-3xl overflow-hidden glass-panel border border-zinc-800 h-44">
                <img
                  src="/images/services/detailing/IMG_5899.JPG"
                  alt="Veneno Paint Correction Studio"
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                />
              </div>
            </div>
            
            <div class="space-y-4 pt-8">
              <div class="rounded-3xl overflow-hidden glass-panel border border-zinc-800 h-44">
                <img
                  src="/images/services/ceramic/PHOTO-2024-07-12-14-12-51 15.JPG"
                  alt="Veneno Ceramic Coating"
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                />
              </div>
              <div class="rounded-3xl overflow-hidden glass-panel border border-zinc-800 h-64">
                <img
                  src="/images/gallery/PHOTO-2024-07-12-14-12-51 24.JPG"
                  alt="Veneno Concourse Finish"
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                />
              </div>
            </div>
          </div>

          <!-- Story & Heritage Content -->
          <div class="lg:col-span-6 space-y-6">
            <div>
              <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">About Veneno Auto Care</span>
              <h2 class="text-3xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-1">
                Concourse Craftsmanship In Dubai & UAE
              </h2>
            </div>

            <p class="text-sm text-zinc-300 leading-relaxed font-light">
              Founded on an uncompromising standard for automotive perfection, <strong class="text-white">Veneno Auto Care</strong> operates a state-of-the-art detailing studio in the United Arab Emirates. We specialize exclusively in the aesthetic preservation and protection of supercars, luxury SUVs, and bespoke classics.
            </p>

            <p class="text-sm text-zinc-400 leading-relaxed">
              Every vehicle undergoes climate-controlled paint depth analysis, meticulous dual-action compound jeweling, and computer-plotted film application by master technicians with over a decade of concourse experience.
            </p>

            <!-- Key Pillars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
              <div class="p-4 rounded-2xl bg-zinc-900/70 border border-zinc-800">
                <ShieldCheck class="w-5 h-5 text-red-500 mb-2" />
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Dust-Free Clean Bays</h4>
                <p class="text-xs text-zinc-400 mt-1">Positive-pressure climate bays ensure zero airborne contaminants during PPF and ceramic bonding.</p>
              </div>

              <div class="p-4 rounded-2xl bg-zinc-900/70 border border-zinc-800">
                <Award class="w-5 h-5 text-amber-400 mb-2" />
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Certified Installers</h4>
                <p class="text-xs text-zinc-400 mt-1">Factory-certified installers with official warranties registered for your peace of mind.</p>
              </div>
            </div>

            <div class="pt-4 flex flex-wrap items-center gap-4">
              <button
                @click="isQuoteModalOpen = true"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all"
              >
                Inquire With Our Studio
              </button>

              <a
                href="tel:+97126344403"
                class="flex items-center gap-2 px-5 py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-200 border border-zinc-700 text-xs font-semibold transition-colors"
              >
                <Phone class="w-3.5 h-3.5 text-red-500" />
                <span>Call Landline: +971 2 634 4403</span>
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 3. BEFORE / AFTER INTERACTIVE SHOWCASE -->
    <section class="py-20 bg-zinc-950 relative border-t border-zinc-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Surface Correction Lab</span>
          <h2 class="text-2xl sm:text-3xl font-display font-semibold uppercase tracking-wider text-white mt-1">
            Concourse Laser Reflection & Depth
          </h2>
          <p class="text-xs sm:text-sm text-zinc-400 mt-2">
            Drag the center divider to compare micro-abrasive paint leveling and 9H graphene ceramic gloss against severe swirl defects.
          </p>
        </div>

        <BeforeAfterSlider
          beforeImage="/images/services/detailing/PHOTO-2024-07-12-14-12-51 18.JPG"
          afterImage="/images/services/detailing/PHOTO-2024-07-12-14-12-51 24.JPG"
          title="Porsche 911 Turbo S — Multi-Stage Swirl Elimination & 9H Ceramic Shield"
          subtitle="Real workshop transformation photographed in Veneno clean-room lighting."
        />
      </div>
    </section>

    <!-- 4. OFFICIAL 9 CORE SERVICES GRID -->
    <section id="services" class="py-24 bg-zinc-950 relative border-t border-zinc-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
          <div>
            <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Bespoke Treatments</span>
            <h2 class="text-2xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-2">
              Our 9 Core Service Lines
            </h2>
            <p class="text-xs sm:text-sm text-zinc-400 mt-2 max-w-xl">
              Engineered for the demanding UAE environment. Select any service to explore detailed specifications or receive a personalized quote.
            </p>
          </div>

          <button
            @click="isQuoteModalOpen = true"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600/20 text-red-400 hover:text-white border border-red-500/40 text-xs font-mono uppercase tracking-wider transition-all"
          >
            <span>Request Full Catalog Quote</span>
            <ChevronRight class="w-4 h-4" />
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="service in services"
            :key="service.id"
            class="group relative glass-panel rounded-3xl overflow-hidden border border-zinc-800/80 hover:border-red-500/40 transition-all duration-300 hover:shadow-2xl hover:shadow-red-950/20 flex flex-col"
          >
            <!-- Service Image Banner -->
            <div class="relative h-56 overflow-hidden bg-zinc-900">
              <img
                :src="service.image"
                :alt="service.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
              
              <div class="absolute top-4 left-4 flex gap-2">
                <span v-if="service.badge" class="px-3 py-1 rounded-full bg-red-600 text-white font-mono text-[10px] font-bold uppercase tracking-wider shadow-lg">
                  {{ service.badge }}
                </span>
                <span v-if="service.warranty" class="px-3 py-1 rounded-full bg-zinc-900/90 text-zinc-300 font-mono text-[10px] border border-zinc-700 backdrop-blur-md">
                  {{ service.warranty }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
              <div>
                <h3 class="text-lg sm:text-xl font-display font-semibold uppercase tracking-wide text-white group-hover:text-red-400 transition-colors">
                  {{ service.name }}
                </h3>
                <p class="text-xs text-zinc-400 mt-2 line-clamp-2 leading-relaxed">
                  {{ service.description }}
                </p>
              </div>

              <!-- Features checklist -->
              <div class="space-y-2 pt-2 border-t border-zinc-800/80 text-xs">
                <div
                  v-for="(feat, idx) in (service.features || []).slice(0, 3)"
                  :key="idx"
                  class="flex items-center gap-2 text-zinc-300"
                >
                  <CheckCircle2 class="w-3.5 h-3.5 text-red-500 shrink-0" />
                  <span class="line-clamp-1 text-xs">{{ feat }}</span>
                </div>
              </div>

              <!-- Action CTAs -->
              <div class="pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                <Link
                  :href="route('service.detail', service.slug)"
                  class="text-xs font-mono uppercase text-zinc-400 hover:text-white flex items-center gap-1 transition-colors"
                >
                  <span>Explore Details</span>
                  <ArrowUpRight class="w-3.5 h-3.5" />
                </Link>

                <button
                  @click="openQuoteWithService(service.name)"
                  class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all"
                >
                  Get a Quote
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. OUR WORKS: PHOTO & VIDEO GALLERY -->
    <WorksGallery @open-quote="isQuoteModalOpen = true" />

    <!-- 6. GET A QUOTE SECTION -->
    <QuoteSection />

    <!-- 7. CONTACT US & STUDIO HUB -->
    <section id="contact" class="py-24 bg-zinc-950 relative border-t border-zinc-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Studio Hub</span>
          <h2 class="text-3xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-1">
            Visit Our Concierge Studio
          </h2>
          <p class="text-xs sm:text-sm text-zinc-400 mt-2">
            Schedule an in-person paint inspection or drop by our studio in UAE.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
          <!-- Card 1: Landline & Phone -->
          <div class="glass-panel p-6 rounded-3xl border border-zinc-800 flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-2xl bg-red-600/20 text-red-400 border border-red-500/30 flex items-center justify-center mb-4">
              <Phone class="w-6 h-6" />
            </div>
            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Direct Landline & Hotline</h4>
            <p class="text-xs text-zinc-400 mt-1">Available 6 days a week for inquiries and bookings</p>
            <a href="tel:+97126344403" class="text-base font-mono font-bold text-red-400 hover:underline mt-3">
              +971 2 634 4403
            </a>
          </div>

          <!-- Card 2: Official WhatsApp -->
          <div class="glass-panel p-6 rounded-3xl border border-zinc-800 flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center mb-4">
              <svg class="w-6 h-6 fill-current text-[#25D366]" viewBox="0 0 24 24">
                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
              </svg>
            </div>
            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Official WhatsApp Concierge</h4>
            <p class="text-xs text-zinc-400 mt-1">Instant chat, media appraisal, and quotation</p>
            <a
              href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20would%20like%20to%20inquire%20about%20your%20services."
              target="_blank"
              rel="noopener noreferrer"
              class="text-base font-mono font-bold text-emerald-400 hover:underline mt-3 flex items-center gap-1.5"
            >
              <span>+971 2 634 4403</span>
            </a>
          </div>

          <!-- Card 3: Email & Location -->
          <div class="glass-panel p-6 rounded-3xl border border-zinc-800 flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center mb-4">
              <Mail class="w-6 h-6" />
            </div>
            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Corporate Email & Location</h4>
            <p class="text-xs text-zinc-400 mt-1">Al Quoz Industrial Area 3, Dubai, UAE</p>
            <a href="mailto:info@veneno.ae" class="text-base font-mono font-bold text-red-400 hover:underline mt-3">
              info@veneno.ae
            </a>
          </div>
        </div>

        <!-- Google Map Studio Embed -->
        <div class="rounded-3xl overflow-hidden border border-zinc-800 h-80 relative glass-panel shadow-2xl">
          <iframe
            class="w-full h-full grayscale contrast-125 opacity-80"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d115634.34123512398!2d55.150000000000006!3d25.13333333333333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f690463c224b1%3A0xb3671f2518e95759!2sAl%20Quoz%20Industrial%20Area%203%20-%20Dubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2sae!4v1700000000000!5m2!1sen!2sae"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Veneno Auto Care Studio Location"
          ></iframe>
          <div class="absolute bottom-4 left-4 glass-panel p-3 rounded-2xl border border-zinc-700 text-xs text-zinc-200">
            <span class="font-bold text-white">📍 Veneno Auto Care Studio</span> — Mon to Sat: 9:00 AM – 8:00 PM
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <Footer />

    <!-- Quote Modal -->
    <QuoteModal
      :is-open="isQuoteModalOpen"
      :preselected-service="selectedServiceName"
      @close="isQuoteModalOpen = false"
    />

    <!-- Floating WhatsApp Widget -->
    <WhatsAppWidget />
  </div>
</template>
