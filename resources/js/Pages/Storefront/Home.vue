<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import BeforeAfterSlider from '@/Components/BeforeAfterSlider.vue';
import WhatsAppWidget from '@/Components/WhatsAppWidget.vue';
import AIQuoteModal from '@/Components/AIQuoteModal.vue';
import LoginModal from '@/Components/LoginModal.vue';
import BookingWizardModal from '@/Components/BookingWizardModal.vue';
import {
  Sparkles,
  ShieldCheck,
  Calendar,
  Award,
  ChevronRight,
  Star,
  CheckCircle2,
  Droplets,
  Disc,
  Sun,
  Flame,
  ArrowUpRight
} from 'lucide-vue-next';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
  addons: {
    type: Array,
    default: () => [],
  },
});

const isBookingModalOpen = ref(false);
const isAiQuoteModalOpen = ref(false);
const isLoginModalOpen = ref(false);
const selectedServiceId = ref(null);

const openBookingWithService = (serviceId) => {
  selectedServiceId.value = serviceId;
  isBookingModalOpen.value = true;
};
</script>

<template>
  <Head title="Luxury Car Detailing, Ceramic Coating & PPF in Dubai & UAE" />

  <div class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 font-sans selection:bg-red-600 selection:text-white">
    <!-- Navbar -->
    <Navbar
      @open-booking="isBookingModalOpen = true"
      @open-ai-quote="isAiQuoteModalOpen = true"
      @open-login="isLoginModalOpen = true"
    />

    <!-- CINEMATIC VIDEO HERO SECTION -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-zinc-950">
      <!-- Background Video Overlay & Media -->
      <div class="absolute inset-0 z-0">
        <img
          src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=2000&q=85"
          alt="Luxury Supercar Detailing"
          class="w-full h-full object-cover object-center scale-105 filter brightness-50 contrast-125"
        />
        <!-- Cinematic Dark Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/40 to-transparent"></div>
        <!-- Radial Spotlight Glow -->
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>
      </div>

      <!-- Hero Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <!-- Floating Accreditation Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-red-500/30 text-xs font-mono text-zinc-300 mb-6 shadow-xl shadow-black/60 animate-in fade-in slide-in-from-top-4 duration-300">
          <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
          <span class="text-red-400 font-bold uppercase tracking-wider">Accredited Luxury Auto Salon</span>
          <span class="text-zinc-600">|</span>
          <span>Certified XPEL & Gyeon Installers</span>
        </div>

        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white max-w-5xl mx-auto uppercase leading-[1.08] font-sans">
          The Apex of Automotive <br class="hidden sm:inline" />
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-white to-red-400">
            Detailing & Protection
          </span>
        </h1>

        <p class="mt-6 text-base sm:text-lg text-zinc-300 max-w-2xl mx-auto font-light leading-relaxed">
          Preserve museum-grade reflections with military-grade 8mil self-healing PPF, 9H+ graphene ceramic coatings, and precision paint rejuvenation.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
          <button
            @click="isBookingModalOpen = true"
            class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-extrabold text-sm uppercase tracking-wider shadow-2xl shadow-red-600/40 transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3"
          >
            <Calendar class="w-5 h-5" />
            <span>Book Studio Bay Slot</span>
          </button>

          <button
            @click="isAiQuoteModalOpen = true"
            class="w-full sm:w-auto px-8 py-4 rounded-2xl glass-panel hover:bg-zinc-800/80 text-zinc-100 font-bold text-sm uppercase tracking-wider border border-zinc-700/80 hover:border-red-500/50 transition-all flex items-center justify-center gap-3 shadow-xl"
          >
            <Sparkles class="w-5 h-5 text-red-400 animate-pulse" />
            <span>Instant AI Appraisal</span>
          </button>
        </div>

        <!-- Trust Stats Banner -->
        <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-4xl mx-auto">
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-black text-white">2,500+</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Exotics Protected</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-black text-red-400">9H+</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Graphene Matrix</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-black text-white">10-Yr</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Certified Warranty</div>
          </div>
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 text-center">
            <div class="text-2xl sm:text-3xl font-black text-amber-400">4.99 ★</div>
            <div class="text-[11px] font-mono uppercase text-zinc-400 mt-1">Client Satisfaction</div>
          </div>
        </div>
      </div>
    </section>

    <!-- BEFORE / AFTER INTERACTIVE SHOWCASE -->
    <section class="py-20 bg-zinc-950 relative border-t border-zinc-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
          <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Transformation Laboratory</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-1 uppercase">
            Concourse Mirror Clarity
          </h2>
          <p class="text-sm text-zinc-400 mt-2">
            Interact with our laser depth leveling before & after slider to observe true micro-abrasive swirl removal.
          </p>
        </div>

        <BeforeAfterSlider
          beforeImage="https://images.unsplash.com/photo-1607860108855-64acf2078ed9?auto=format&fit=crop&w=1400&q=85"
          afterImage="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1400&q=85"
          title="Porsche 911 Turbo S — Multi-Stage Correction & Dual Graphene Ceramic"
          subtitle="Drag the center handle to see 95%+ swirl reduction and mirror depth."
        />
      </div>
    </section>

    <!-- FLAGSHIP SERVICES GRID -->
    <section class="py-24 bg-zinc-950 relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
          <div>
            <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">Services & Treatments</span>
            <h2 class="text-3xl sm:text-5xl font-black text-white mt-2 uppercase tracking-tight">
              Flagship Protection Suites
            </h2>
          </div>
          <button
            @click="isBookingModalOpen = true"
            class="inline-flex items-center gap-2 text-xs font-mono text-red-400 hover:text-red-300 uppercase tracking-widest"
          >
            <span>View All Packages</span>
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
            <div class="relative h-56 overflow-hidden">
              <img
                :src="service.after_image || service.before_image"
                :alt="service.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
              
              <div class="absolute top-4 left-4 flex gap-2">
                <span v-if="service.badge" class="px-3 py-1 rounded-full bg-red-600 text-white font-mono text-[10px] font-bold uppercase tracking-wider shadow-lg">
                  {{ service.badge }}
                </span>
                <span v-if="service.warranty" class="px-3 py-1 rounded-full bg-zinc-900/90 text-zinc-300 font-mono text-[10px] border border-zinc-700">
                  {{ service.warranty }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
              <div>
                <h3 class="text-xl font-bold text-white group-hover:text-red-400 transition-colors">
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
                  <span class="line-clamp-1">{{ feat }}</span>
                </div>
              </div>

              <!-- Price & CTA -->
              <div class="pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                <div>
                  <span class="text-[10px] font-mono uppercase text-zinc-500 block">Starting From</span>
                  <div class="text-xl font-black text-white">
                    ${{ Number(service.price_sedan) }} <span class="text-xs text-zinc-500 font-normal">USD</span>
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  <Link
                    :href="route('service.detail', service.slug)"
                    class="p-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 border border-zinc-800 transition-colors"
                    title="Service Details"
                  >
                    <ArrowUpRight class="w-4 h-4" />
                  </Link>

                  <button
                    @click="openBookingWithService(service.id)"
                    class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all"
                  >
                    Reserve Bay
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <Footer />

    <!-- Modals & Floating Lead Widgets -->
    <BookingWizardModal
      :is-open="isBookingModalOpen"
      :services="services"
      :addons="addons"
      :preselected-service-id="selectedServiceId"
      @close="isBookingModalOpen = false"
    />

    <AIQuoteModal
      :is-open="isAiQuoteModalOpen"
      @close="isAiQuoteModalOpen = false"
      @start-booking="isBookingModalOpen = true"
    />

    <LoginModal
      :is-open="isLoginModalOpen"
      @close="isLoginModalOpen = false"
    />

    <WhatsAppWidget />
  </div>
</template>
