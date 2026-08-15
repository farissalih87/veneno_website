<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import BeforeAfterSlider from '@/Components/BeforeAfterSlider.vue';
import BookingWizardModal from '@/Components/BookingWizardModal.vue';
import AIQuoteModal from '@/Components/AIQuoteModal.vue';
import LoginModal from '@/Components/LoginModal.vue';
import WhatsAppWidget from '@/Components/WhatsAppWidget.vue';
import {
  ShieldCheck,
  Calendar,
  Clock,
  Award,
  CheckCircle2,
  Car,
  Sparkles,
  ChevronRight,
  ArrowLeft
} from 'lucide-vue-next';

const props = defineProps({
  service: Object,
  allServices: Array,
  addons: Array,
});

const selectedType = ref('coupe');
const isBookingModalOpen = ref(false);
const isAiQuoteModalOpen = ref(false);
const isLoginModalOpen = ref(false);

const priceForSelectedType = computed(() => {
  if (!props.service) return 0;
  return Number(props.service[`price_${selectedType.value}`] || props.service.price_sedan || 799);
});
</script>

<template>
  <Head :title="`${service.name} - Veneno Auto Care`" />

  <div class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 font-sans selection:bg-red-600 selection:text-white">
    <Navbar
      @open-booking="isBookingModalOpen = true"
      @open-ai-quote="isAiQuoteModalOpen = true"
      @open-login="isLoginModalOpen = true"
    />

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
      <!-- Breadcrumb & Back -->
      <div class="flex items-center justify-between">
        <Link :href="route('home')" class="inline-flex items-center gap-2 text-xs font-mono text-zinc-400 hover:text-white transition-colors">
          <ArrowLeft class="w-4 h-4" />
          <span>Back to All Services</span>
        </Link>

        <div class="flex items-center gap-2 text-xs font-mono text-zinc-500">
          <span>VENENO</span>
          <span>/</span>
          <span class="text-red-400 uppercase">{{ service.category }}</span>
        </div>
      </div>

      <!-- Service Title Banner -->
      <div class="glass-panel p-8 rounded-3xl border border-zinc-800 space-y-4">
        <div class="flex flex-wrap items-center gap-3">
          <span v-if="service.badge" class="px-3 py-1 rounded-full bg-red-600 text-white font-mono text-xs font-bold uppercase">
            {{ service.badge }}
          </span>
          <span v-if="service.warranty" class="px-3 py-1 rounded-full bg-zinc-900 border border-zinc-700 text-zinc-300 font-mono text-xs">
            {{ service.warranty }}
          </span>
          <span class="px-3 py-1 rounded-full bg-zinc-900 border border-zinc-700 text-amber-400 font-mono text-xs flex items-center gap-1.5">
            <Clock class="w-3.5 h-3.5" />
            <span>~{{ service.duration_hours }} Hours Application</span>
          </span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight">
          {{ service.name }}
        </h1>
        <p class="text-base text-zinc-300 max-w-3xl leading-relaxed">
          {{ service.description }}
        </p>
      </div>

      <!-- Comparison Slider Section -->
      <div v-if="service.before_image && service.after_image" class="space-y-4">
        <BeforeAfterSlider
          :beforeImage="service.before_image"
          :afterImage="service.after_image"
          :title="`${service.name} — Optical Clarity & Reflection Benchmark`"
        />
      </div>

      <!-- Pricing Calculator by Vehicle Classification -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Specifications & Features List -->
        <div class="lg:col-span-2 glass-panel p-8 rounded-3xl border border-zinc-800 space-y-6">
          <h3 class="text-xl font-bold text-white flex items-center gap-2">
            <ShieldCheck class="w-5 h-5 text-red-500" />
            <span>Certified Treatment Protocol</span>
          </h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div
              v-for="(feat, idx) in (service.features || [])"
              :key="idx"
              class="flex items-start gap-3 p-3.5 rounded-2xl bg-zinc-900/60 border border-zinc-800 text-xs text-zinc-200"
            >
              <CheckCircle2 class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
              <span>{{ feat }}</span>
            </div>
          </div>
        </div>

        <!-- Right: Dynamic Price Card & Booking Trigger -->
        <div class="glass-panel p-6 rounded-3xl border border-zinc-800 flex flex-col justify-between space-y-6">
          <div>
            <span class="text-xs font-mono uppercase tracking-widest text-zinc-400 font-bold block mb-3">
              1. Select Vehicle Body Type
            </span>
            <div class="grid grid-cols-3 gap-1.5 mb-6 text-xs">
              <button
                v-for="t in ['sedan', 'coupe', 'suv', 'truck', 'exotic']"
                :key="t"
                @click="selectedType = t"
                class="py-2.5 px-2 rounded-xl border text-center font-bold capitalize transition-all text-xs"
                :class="selectedType === t ? 'bg-red-950/60 border-red-500 text-white' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:border-zinc-700'"
              >
                {{ t }}
              </button>
            </div>

            <div class="p-4 rounded-2xl bg-zinc-900/90 border border-zinc-800 space-y-2">
              <div class="text-xs text-zinc-400 flex justify-between">
                <span>Vehicle Body:</span>
                <span class="text-white font-bold capitalize">{{ selectedType }}</span>
              </div>
              <div class="text-xs text-zinc-400 flex justify-between">
                <span>Base Investment:</span>
                <span class="text-2xl font-black text-white">${{ priceForSelectedType }}</span>
              </div>
              <div class="text-[11px] text-zinc-500 pt-2 border-t border-zinc-800">
                Deposit required to reserve bay: $250. Balance upon completion.
              </div>
            </div>
          </div>

          <button
            @click="isBookingModalOpen = true"
            class="w-full py-4 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider shadow-xl shadow-red-600/30 flex items-center justify-center gap-2 transition-all"
          >
            <Calendar class="w-4 h-4" />
            <span>Book This Service (${{ priceForSelectedType }})</span>
          </button>
        </div>
      </div>
    </main>

    <Footer />

    <BookingWizardModal
      :is-open="isBookingModalOpen"
      :services="[service]"
      :addons="addons"
      :preselected-service-id="service.id"
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
