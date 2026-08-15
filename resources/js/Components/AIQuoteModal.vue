<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Sparkles, X, Loader2, CheckCircle2, ShieldAlert, ArrowRight, DollarSign, Clock, ShieldCheck } from 'lucide-vue-next';

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(['close', 'start-booking']);

const isLoading = ref(false);
const estimateResult = ref(null);

const vehicleData = ref({
  vehicleMake: 'Porsche',
  vehicleModel: '911 Turbo S',
  vehicleYear: 2024,
  vehicleType: 'coupe',
  paintCondition: 'Moderate swirl marks and light clear-coat wash scratches',
  interiorCondition: 'Leather needs conditioning, light seat creasing',
});

const generateAiAppraisal = async () => {
  isLoading.value = true;
  try {
    const res = await axios.post(route('api.gemini.quote'), vehicleData.value);
    estimateResult.value = res.data;
  } catch (err) {
    console.error('AI Appraisal failed:', err);
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
    <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto glass-panel rounded-3xl border border-zinc-800 shadow-2xl p-6 relative animate-in fade-in zoom-in-95 duration-200">
      
      <!-- Close Button -->
      <button
        @click="emit('close')"
        class="absolute top-5 right-5 p-2 rounded-xl bg-zinc-900/80 hover:bg-zinc-800 text-zinc-400 hover:text-white transition-colors"
      >
        <X class="w-5 h-5" />
      </button>

      <!-- Header -->
      <div class="flex items-center gap-3 mb-6 pb-4 border-b border-zinc-800">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-600/20 to-red-950/40 border border-red-500/30 flex items-center justify-center">
          <Sparkles class="w-6 h-6 text-red-500 animate-pulse" />
        </div>
        <div>
          <h2 class="text-xl font-black text-white flex items-center gap-2">
            <span>AI Vehicle Appraisal & Detailing Estimator</span>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-600/20 text-red-400 border border-red-500/30 font-mono">Gemini 3.7 Flash</span>
          </h2>
          <p class="text-xs text-zinc-400">Get an instant, customized multi-stage detailing prescription for your automobile.</p>
        </div>
      </div>

      <!-- Input Form -->
      <div v-if="!estimateResult" class="space-y-4 text-xs">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-zinc-400 mb-1 font-medium">Make</label>
            <input
              v-model="vehicleData.vehicleMake"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1 font-medium">Model</label>
            <input
              v-model="vehicleData.vehicleModel"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1 font-medium">Year & Body Type</label>
            <div class="grid grid-cols-2 gap-1.5">
              <input
                v-model="vehicleData.vehicleYear"
                type="number"
                class="w-full px-2 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
              />
              <select
                v-model="vehicleData.vehicleType"
                class="w-full px-2 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
              >
                <option value="coupe">Coupe</option>
                <option value="sedan">Sedan</option>
                <option value="suv">SUV</option>
                <option value="truck">Truck</option>
                <option value="exotic">Exotic</option>
              </select>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-zinc-400 mb-1 font-medium">Current Paint Surface Condition</label>
          <input
            v-model="vehicleData.paintCondition"
            type="text"
            class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
          />
        </div>

        <div>
          <label class="block text-zinc-400 mb-1 font-medium">Interior Cabin Condition</label>
          <input
            v-model="vehicleData.interiorCondition"
            type="text"
            class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
          />
        </div>

        <button
          @click="generateAiAppraisal"
          :disabled="isLoading"
          class="w-full mt-4 py-3.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="isLoading" class="w-4 h-4 animate-spin" />
          <Sparkles v-else class="w-4 h-4" />
          <span>{{ isLoading ? 'Analyzing Paint Depth & Formulating Prescription...' : 'Generate Expert AI Appraisal' }}</span>
        </button>
      </div>

      <!-- Result Card -->
      <div v-else class="space-y-5 animate-in fade-in slide-in-from-bottom-2 duration-200">
        <!-- Top Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div class="p-3.5 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <div class="text-[10px] font-mono uppercase text-zinc-500 flex items-center gap-1.5">
              <Sparkles class="w-3.5 h-3.5 text-red-500" />
              <span>Recommended Package</span>
            </div>
            <div class="text-sm font-extrabold text-white mt-1">{{ estimateResult.recommendedPackage }}</div>
          </div>

          <div class="p-3.5 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <div class="text-[10px] font-mono uppercase text-zinc-500 flex items-center gap-1.5">
              <DollarSign class="w-3.5 h-3.5 text-emerald-400" />
              <span>Estimated Price</span>
            </div>
            <div class="text-sm font-extrabold text-emerald-400 mt-1">{{ estimateResult.estimatedPriceRange }}</div>
          </div>

          <div class="p-3.5 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <div class="text-[10px] font-mono uppercase text-zinc-500 flex items-center gap-1.5">
              <Clock class="w-3.5 h-3.5 text-amber-400" />
              <span>Execution Time</span>
            </div>
            <div class="text-sm font-extrabold text-amber-400 mt-1">~{{ estimateResult.estimatedHours }} Hours Required</div>
          </div>
        </div>

        <!-- Summary -->
        <div class="p-4 rounded-2xl bg-red-950/20 border border-red-900/30 text-xs text-zinc-300 leading-relaxed">
          <span class="font-bold text-white block mb-1">Master Detailer Verdict:</span>
          {{ estimateResult.summary }}
        </div>

        <!-- Stages Required -->
        <div class="space-y-2">
          <h4 class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-bold">Recommended Treatment Stages</h4>
          <div class="space-y-1.5">
            <div
              v-for="(stage, idx) in estimateResult.stages"
              :key="idx"
              class="flex items-center gap-3 p-2.5 rounded-xl bg-zinc-900/60 border border-zinc-800 text-xs text-zinc-200"
            >
              <div class="w-5 h-5 rounded-full bg-red-600/20 text-red-400 flex items-center justify-center font-mono font-bold text-[10px]">
                {{ idx + 1 }}
              </div>
              <span>{{ stage }}</span>
            </div>
          </div>
        </div>

        <!-- Addons -->
        <div class="space-y-2">
          <h4 class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-bold">Suggested Complementary Shields</h4>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(addon, idx) in estimateResult.recommendedAddons"
              :key="idx"
              class="px-3 py-1.5 rounded-xl bg-zinc-900 border border-zinc-700 text-zinc-300 text-xs flex items-center gap-1.5"
            >
              <ShieldCheck class="w-3.5 h-3.5 text-red-400" />
              <span>{{ addon }}</span>
            </span>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-2">
          <button
            @click="estimateResult = null"
            class="px-4 py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 font-semibold text-xs border border-zinc-800 transition-colors"
          >
            Adjust Vehicle Specs
          </button>

          <button
            @click="emit('start-booking'); emit('close');"
            class="flex-1 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 flex items-center justify-center gap-2"
          >
            <span>Proceed to Reservation</span>
            <ArrowRight class="w-4 h-4" />
          </button>
        </div>
      </div>

    </div>
  </div>
</template>
