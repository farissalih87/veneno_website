<script setup>
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import confetti from 'canvas-confetti';
import {
  X,
  Car,
  ShieldCheck,
  Calendar,
  CreditCard,
  CheckCircle2,
  ChevronRight,
  ChevronLeft,
  Sparkles,
  DollarSign,
  Droplets,
  Disc,
  Sun,
  Truck,
  Loader2,
  Printer,
  Download
} from 'lucide-vue-next';

const props = defineProps({
  isOpen: Boolean,
  services: {
    type: Array,
    default: () => [],
  },
  addons: {
    type: Array,
    default: () => [],
  },
  preselectedServiceId: {
    type: [Number, String],
    default: null,
  },
});

const emit = defineEmits(['close']);

const step = ref(1);
const isSubmitting = ref(false);
const confirmedBooking = ref(null);

// Form Data
const form = ref({
  customer_name: 'Alex Sterling',
  customer_email: 'alex@example.com',
  customer_phone: '+971 50 123 4567',
  vehicle_make: 'Porsche',
  vehicle_model: '911 Turbo S',
  vehicle_year: 2024,
  vehicle_color: 'Guards Red',
  vehicle_type: 'coupe',
  license_plate: 'VEN911',
  service_package_id: null,
  addon_ids: [],
  booking_date: new Date(Date.now() + 86400000 * 2).toISOString().split('T')[0],
  time_slot: '09:00 AM',
  payment_choice: 'deposit', // 'deposit' or 'full'
  notes: 'Focus on front bumper rock chips and swirl removal.',
});

// Set default service
watch(
  () => props.services,
  (newServices) => {
    if (newServices.length && !form.value.service_package_id) {
      form.value.service_package_id = props.preselectedServiceId || newServices[0].id;
    }
  },
  { immediate: true }
);

watch(
  () => props.preselectedServiceId,
  (newId) => {
    if (newId) form.value.service_package_id = newId;
  }
);

const selectedService = computed(() => {
  return props.services.find((s) => s.id == form.value.service_package_id) || props.services[0] || {};
});

// Calculate Dynamic Pricing
const calculatedBasePrice = computed(() => {
  if (!selectedService.value) return 0;
  const type = form.value.vehicle_type;
  const key = `price_${type}`;
  return Number(selectedService.value[key] || selectedService.value.price_sedan || 799);
});

const calculatedAddonsTotal = computed(() => {
  return form.value.addon_ids.reduce((sum, id) => {
    const addon = props.addons.find((a) => a.id == id);
    return sum + (addon ? Number(addon.price) : 0);
  }, 0);
});

const calculatedTotalPrice = computed(() => {
  return calculatedBasePrice.value + calculatedAddonsTotal.value;
});

const depositDueNow = computed(() => {
  if (form.value.payment_choice === 'full') return calculatedTotalPrice.value;
  return Math.min(250, calculatedTotalPrice.value);
});

const balanceAtWorkshop = computed(() => {
  return calculatedTotalPrice.value - depositDueNow.value;
});

const toggleAddon = (addonId) => {
  const index = form.value.addon_ids.indexOf(addonId);
  if (index > -1) {
    form.value.addon_ids.splice(index, 1);
  } else {
    form.value.addon_ids.push(addonId);
  }
};

const handleFinalBooking = async () => {
  isSubmitting.value = true;
  try {
    const res = await axios.post(route('bookings.store'), form.value);
    confirmedBooking.value = {
      booking_code: res.data.booking_code,
      total: calculatedTotalPrice.value,
      deposit: depositDueNow.value,
      service_name: selectedService.value.name,
      vehicle: `${form.value.vehicle_year} ${form.value.vehicle_make} ${form.value.vehicle_model}`,
      date: form.value.booking_date,
      time: form.value.time_slot,
    };
    step.value = 5;

    // Trigger celebration confetti
    try {
      confetti({
        particleCount: 120,
        spread: 70,
        origin: { y: 0.6 },
        colors: ['#dc2626', '#f59e0b', '#ffffff'],
      });
    } catch (e) {}
  } catch (err) {
    console.error('Booking submission failed:', err);
  } finally {
    isSubmitting.value = false;
  }
};

const resetWizard = () => {
  step.value = 1;
  confirmedBooking.value = null;
  emit('close');
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/85 backdrop-blur-md">
    <div class="w-full max-w-3xl max-h-[92vh] overflow-y-auto glass-panel rounded-3xl border border-zinc-800 shadow-2xl p-6 relative animate-in fade-in zoom-in-95 duration-200">
      
      <!-- Close Button -->
      <button
        @click="resetWizard"
        class="absolute top-5 right-5 p-2 rounded-xl bg-zinc-900/80 hover:bg-zinc-800 text-zinc-400 hover:text-white transition-colors"
      >
        <X class="w-5 h-5" />
      </button>

      <!-- Step Indicator Bar -->
      <div v-if="step < 5" class="mb-6 pb-4 border-b border-zinc-800">
        <div class="flex items-center justify-between text-xs font-mono mb-2">
          <span class="text-zinc-400 font-bold">RESERVATION WIZARD</span>
          <span class="text-red-400">Step {{ step }} of 4</span>
        </div>
        <div class="grid grid-cols-4 gap-2">
          <div
            v-for="s in 4"
            :key="s"
            class="h-1.5 rounded-full transition-all duration-300"
            :class="step >= s ? 'bg-gradient-to-r from-red-600 to-red-500' : 'bg-zinc-800'"
          ></div>
        </div>
      </div>

      <!-- STEP 1: Vehicle Specs -->
      <div v-if="step === 1" class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-red-600/20 text-red-500 flex items-center justify-center">
            <Car class="w-5 h-5" />
          </div>
          <div>
            <h3 class="text-lg font-bold text-white">Step 1: Vehicle Specifications</h3>
            <p class="text-xs text-zinc-400">Select body classification for precise calibrated pricing</p>
          </div>
        </div>

        <!-- Vehicle Type Selector -->
        <div>
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-2">Vehicle Body Classification</label>
          <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
            <button
              v-for="t in [
                { id: 'sedan', label: 'Sedan / Saloon' },
                { id: 'coupe', label: 'Coupe / GT' },
                { id: 'suv', label: 'SUV / 4x4' },
                { id: 'truck', label: 'Truck / Van' },
                { id: 'exotic', label: 'Hyper / Exotic' },
              ]"
              :key="t.id"
              type="button"
              @click="form.vehicle_type = t.id"
              class="p-3 rounded-2xl border text-center transition-all"
              :class="form.vehicle_type === t.id ? 'bg-red-950/40 border-red-500 text-white font-bold shadow-lg shadow-red-950/50' : 'bg-zinc-900/60 border-zinc-800 text-zinc-400 hover:border-zinc-700'"
            >
              <div class="text-xs">{{ t.label }}</div>
            </button>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
          <div>
            <label class="block text-zinc-400 mb-1">Make</label>
            <input
              v-model="form.vehicle_make"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1">Model</label>
            <input
              v-model="form.vehicle_model"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1">Year & Color</label>
            <div class="grid grid-cols-2 gap-1.5">
              <input
                v-model="form.vehicle_year"
                type="number"
                class="w-full px-2 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
              />
              <input
                v-model="form.vehicle_color"
                type="text"
                class="w-full px-2 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
              />
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-2">
          <div>
            <label class="block text-zinc-400 mb-1">Owner / Client Name</label>
            <input
              v-model="form.customer_name"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1">Phone Number / WhatsApp</label>
            <input
              v-model="form.customer_phone"
              type="tel"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
        </div>

        <div class="flex justify-end pt-4">
          <button
            @click="step = 2"
            class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-red-600/30"
          >
            <span>Continue to Service Selection</span>
            <ChevronRight class="w-4 h-4" />
          </button>
        </div>
      </div>

      <!-- STEP 2: Service & Addons -->
      <div v-if="step === 2" class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-red-600/20 text-red-500 flex items-center justify-center">
            <ShieldCheck class="w-5 h-5" />
          </div>
          <div>
            <h3 class="text-lg font-bold text-white">Step 2: Service Package & Add-Ons</h3>
            <p class="text-xs text-zinc-400">Pricing adjusts automatically for {{ form.vehicle_year }} {{ form.vehicle_make }} ({{ form.vehicle_type }})</p>
          </div>
        </div>

        <!-- Service Package Grid -->
        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
          <div
            v-for="service in services"
            :key="service.id"
            @click="form.service_package_id = service.id"
            class="p-4 rounded-2xl border cursor-pointer transition-all flex items-center justify-between"
            :class="form.service_package_id == service.id ? 'bg-red-950/30 border-red-500 shadow-lg' : 'bg-zinc-900/60 border-zinc-800 hover:border-zinc-700'"
          >
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-white">{{ service.name }}</span>
                <span v-if="service.badge" class="text-[10px] px-2 py-0.5 rounded bg-red-900/60 text-red-300 font-mono">{{ service.badge }}</span>
              </div>
              <div class="text-xs text-zinc-400 mt-0.5 line-clamp-1">{{ service.tagline }}</div>
            </div>
            <div class="text-right">
              <div class="text-base font-extrabold text-white">
                ${{ Number(service[`price_${form.vehicle_type}`] || service.price_sedan) }}
              </div>
              <div class="text-[10px] font-mono text-zinc-500">~{{ service.duration_hours }} hrs</div>
            </div>
          </div>
        </div>

        <!-- Addons -->
        <div class="pt-2">
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-2">Enhance with Specialized Shields</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div
              v-for="addon in addons"
              :key="addon.id"
              @click="toggleAddon(addon.id)"
              class="p-3 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
              :class="form.addon_ids.includes(addon.id) ? 'bg-zinc-800 border-red-500 text-white' : 'bg-zinc-900/50 border-zinc-800 text-zinc-400 hover:border-zinc-700'"
            >
              <div class="flex items-center gap-2">
                <CheckCircle2 class="w-4 h-4" :class="form.addon_ids.includes(addon.id) ? 'text-red-500' : 'text-zinc-600'" />
                <span class="text-xs font-medium text-zinc-200">{{ addon.name }}</span>
              </div>
              <span class="text-xs font-bold text-white">+${{ Number(addon.price) }}</span>
            </div>
          </div>
        </div>

        <!-- Live Price Footer -->
        <div class="p-4 rounded-2xl bg-zinc-900/90 border border-zinc-800 flex items-center justify-between text-xs">
          <div>
            <span class="text-zinc-400">Total Calculated Estimate:</span>
            <div class="text-lg font-black text-white">${{ calculatedTotalPrice }}</div>
          </div>
          <div class="flex items-center gap-2">
            <button
              @click="step = 1"
              class="px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold"
            >
              Back
            </button>
            <button
              @click="step = 3"
              class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold uppercase tracking-wider flex items-center gap-2"
            >
              <span>Choose Date & Time</span>
              <ChevronRight class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>

      <!-- STEP 3: Date & Slot -->
      <div v-if="step === 3" class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-red-600/20 text-red-500 flex items-center justify-center">
            <Calendar class="w-5 h-5" />
          </div>
          <div>
            <h3 class="text-lg font-bold text-white">Step 3: Preferred Bay Appointment</h3>
            <p class="text-xs text-zinc-400">Select arrival slot for drop-off at our Al Quoz Studio</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-mono uppercase text-zinc-400 mb-2">Preferred Drop-Off Date</label>
            <input
              v-model="form.booking_date"
              type="date"
              class="w-full px-4 py-3 rounded-2xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-sm"
            />
          </div>

          <div>
            <label class="block text-xs font-mono uppercase text-zinc-400 mb-2">Studio Bay Time Slot</label>
            <div class="grid grid-cols-2 gap-2">
              <button
                v-for="slot in ['08:30 AM', '10:30 AM', '01:00 PM', '03:30 PM']"
                :key="slot"
                type="button"
                @click="form.time_slot = slot"
                class="py-3 rounded-xl border text-center text-xs font-semibold transition-all"
                :class="form.time_slot === slot ? 'bg-red-950/60 border-red-500 text-white' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:border-zinc-700'"
              >
                {{ slot }}
              </button>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-2">Special Concierge Instructions / Requests</label>
          <textarea
            v-model="form.notes"
            rows="2"
            placeholder="e.g. Enclosed transport required, extra attention on windshield coating..."
            class="w-full px-4 py-2.5 rounded-2xl bg-zinc-900 border border-zinc-800 text-white text-xs resize-none focus:outline-none focus:border-red-500"
          ></textarea>
        </div>

        <div class="flex items-center justify-between pt-4">
          <button
            @click="step = 2"
            class="px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs"
          >
            Back
          </button>
          <button
            @click="step = 4"
            class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold uppercase tracking-wider text-xs flex items-center gap-2 shadow-lg shadow-red-600/30"
          >
            <span>Proceed to Stripe Checkout</span>
            <ChevronRight class="w-4 h-4" />
          </button>
        </div>
      </div>

      <!-- STEP 4: Stripe Payment -->
      <div v-if="step === 4" class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center">
            <CreditCard class="w-5 h-5" />
          </div>
          <div>
            <h3 class="text-lg font-bold text-white">Step 4: Secure Stripe Checkout</h3>
            <p class="text-xs text-zinc-400">Choose flexible hybrid payment option</p>
          </div>
        </div>

        <!-- Payment Option Selector -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div
            @click="form.payment_choice = 'deposit'"
            class="p-4 rounded-2xl border cursor-pointer transition-all"
            :class="form.payment_choice === 'deposit' ? 'bg-red-950/40 border-red-500 shadow-lg' : 'bg-zinc-900/60 border-zinc-800 hover:border-zinc-700'"
          >
            <div class="text-xs font-bold text-white mb-1">Pay $250 Deposit Now</div>
            <div class="text-xs text-zinc-400 leading-relaxed">
              Secures your reserved studio bay slot. Balance (${{ balanceAtWorkshop }}) payable upon vehicle inspection and completion.
            </div>
          </div>

          <div
            @click="form.payment_choice = 'full'"
            class="p-4 rounded-2xl border cursor-pointer transition-all"
            :class="form.payment_choice === 'full' ? 'bg-red-950/40 border-red-500 shadow-lg' : 'bg-zinc-900/60 border-zinc-800 hover:border-zinc-700'"
          >
            <div class="text-xs font-bold text-white mb-1">Pay Full Amount (${{ calculatedTotalPrice }})</div>
            <div class="text-xs text-zinc-400 leading-relaxed">
              Fast-track contactless pickup with 100% upfront digital receipt and instant confirmation.
            </div>
          </div>
        </div>

        <!-- Stripe Mock Card Component -->
        <div class="p-4 rounded-2xl bg-zinc-900 border border-zinc-800 space-y-3 text-xs">
          <div class="flex items-center justify-between text-zinc-400 font-mono text-[11px]">
            <span>TEST STRIPE SECURE PAYMENT</span>
            <span class="text-emerald-400">256-Bit SSL Encrypted</span>
          </div>

          <div class="p-3 rounded-xl bg-zinc-950 border border-zinc-700 flex items-center justify-between text-white font-mono">
            <span>•••• •••• •••• 4242</span>
            <span class="text-zinc-500">12/28 | 123</span>
          </div>

          <div class="flex items-center justify-between text-zinc-400 pt-2 border-t border-zinc-800">
            <span>Amount to Authorize:</span>
            <span class="text-base font-extrabold text-white">${{ depositDueNow }} USD</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-2">
          <button
            @click="step = 3"
            class="px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs"
          >
            Back
          </button>
          <button
            @click="handleFinalBooking"
            :disabled="isSubmitting"
            class="px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold uppercase tracking-wider text-xs shadow-lg shadow-red-600/30 flex items-center gap-2 disabled:opacity-50"
          >
            <Loader2 v-if="isSubmitting" class="w-4 h-4 animate-spin" />
            <Sparkles v-else class="w-4 h-4" />
            <span>{{ isSubmitting ? 'Authorizing Payment...' : `Authorize $${depositDueNow} & Confirm Booking` }}</span>
          </button>
        </div>
      </div>

      <!-- STEP 5: Instant Booking Confirmation -->
      <div v-if="step === 5 && confirmedBooking" class="text-center py-4 space-y-5 animate-in fade-in zoom-in-95 duration-300">
        <div class="w-16 h-16 mx-auto rounded-full bg-emerald-600/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center shadow-2xl shadow-emerald-900/50">
          <CheckCircle2 class="w-8 h-8" />
        </div>

        <div>
          <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 font-bold">RESERVATION SECURED</span>
          <h2 class="text-2xl font-black text-white mt-1">Booking {{ confirmedBooking.booking_code }} Confirmed!</h2>
          <p class="text-xs text-zinc-400 mt-1 max-w-md mx-auto">
            A confirmation receipt and bay checklist has been generated for {{ confirmedBooking.vehicle }}.
          </p>
        </div>

        <!-- Receipt Card -->
        <div class="max-w-md mx-auto p-4 rounded-2xl bg-zinc-900/90 border border-zinc-800 text-left text-xs space-y-2 font-mono">
          <div class="flex justify-between text-zinc-400">
            <span>Service Package:</span>
            <span class="text-white font-bold">{{ confirmedBooking.service_name }}</span>
          </div>
          <div class="flex justify-between text-zinc-400">
            <span>Vehicle:</span>
            <span class="text-white">{{ confirmedBooking.vehicle }}</span>
          </div>
          <div class="flex justify-between text-zinc-400">
            <span>Scheduled Date:</span>
            <span class="text-white">{{ confirmedBooking.date }} ({{ confirmedBooking.time }})</span>
          </div>
          <div class="flex justify-between text-zinc-400 pt-2 border-t border-zinc-800">
            <span>Deposit Paid:</span>
            <span class="text-emerald-400 font-bold">${{ confirmedBooking.deposit }}</span>
          </div>
        </div>

        <div class="flex items-center justify-center gap-3 pt-2">
          <button
            @click="resetWizard"
            class="px-6 py-3 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold transition-colors"
          >
            Done & Return to Site
          </button>
        </div>
      </div>

    </div>
  </div>
</template>
