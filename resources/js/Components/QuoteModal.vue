<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { X, Send, CheckCircle2, Phone, User, Sparkles, ShieldCheck } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  preselectedService: {
    type: String,
    default: '3M Paint Protection Film (PPF)',
  },
});

const emit = defineEmits(['close']);

const { t, currentLocale } = useI18n();

const form = ref({
  name: '',
  phone: '',
  service: props.preselectedService || '3M Paint Protection Film (PPF)',
});

const isSubmitting = ref(false);
const isSuccess = ref(false);
const errorMessage = ref('');

const servicesOptions = [
  '3M Paint Protection Film (PPF)',
  'GYEON Diamond Ceramic Coating',
  'Detailing & Paint Correction',
  '3M Ceramic Window Tinting',
  'Vehicle Wrapping & Color Change',
  'Paintless Dent Repair (PDR)',
  'Rims Protection & Wheel Repair',
  'Paint & Body Restoration',
  'Signature Decontamination Car Wash',
];

watch(
  () => props.preselectedService,
  (newVal) => {
    if (newVal) {
      form.value.service = newVal;
    }
  }
);

const handleSubmit = async () => {
  isSubmitting.value = true;
  errorMessage.value = '';

  try {
    const res = await axios.post('/api/quote', {
      name: form.value.name,
      phone: form.value.phone,
      service: form.value.service,
      locale: currentLocale.value,
    });
    if (res.data.success) {
      isSuccess.value = true;
    }
  } catch (err) {
    console.error('Quote submit error:', err);
    errorMessage.value = err.response?.data?.message || 'Unable to submit quote. Please contact us directly via WhatsApp or +971 2 634 4403.';
  } finally {
    isSubmitting.value = false;
  }
};

const handleClose = () => {
  isSuccess.value = false;
  errorMessage.value = '';
  emit('close');
};
</script>

<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
  >
    <!-- Backdrop -->
    <div
      class="fixed inset-0 bg-black/85 backdrop-blur-md transition-opacity"
      @click="handleClose"
    ></div>

    <!-- Modal Card -->
    <div
      class="relative w-full max-w-lg glass-panel rounded-3xl border border-zinc-700/80 shadow-2xl p-6 sm:p-8 z-10 my-8 animate-in fade-in zoom-in-95 duration-200"
    >
      <!-- Close Button -->
      <button
        @click="handleClose"
        class="absolute top-5 right-5 p-2 rounded-full bg-zinc-900 text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors"
      >
        <X class="w-5 h-5" />
      </button>

      <!-- SUCCESS STATE -->
      <div v-if="isSuccess" class="text-center py-6 space-y-4">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-red-600/20 text-red-500 border border-red-500/40 flex items-center justify-center shadow-xl">
          <CheckCircle2 class="w-8 h-8" />
        </div>

        <div>
          <h3 class="text-2xl font-display uppercase tracking-wider text-white">{{ t('quote.successTitle') }}</h3>
          <p class="text-xs text-zinc-300 mt-2 leading-relaxed">
            {{ t('quote.successDesc', { name: form.name }) }}
          </p>
        </div>

        <div class="pt-2 flex flex-col gap-2.5">
          <a
            :href="`https://wa.me/97126344403?text=Hi%20Veneno%20Auto%20Care,%20I%20just%20requested%20an%20instant%20quote%20for%20${encodeURIComponent(form.service)}.%20My%20name%20is%20${encodeURIComponent(form.name)}.`"
            target="_blank"
            rel="noopener noreferrer"
            class="w-full py-3.5 rounded-xl bg-emerald-950/90 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-lg"
          >
            <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
            </svg>
            <span>{{ t('quote.fastTrackWhatsApp') }}</span>
          </a>

          <button
            @click="handleClose"
            class="w-full py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 text-xs font-semibold"
          >
            {{ t('quote.close') }}
          </button>
        </div>
      </div>

      <!-- STREAMLINED 3-FIELD FORM -->
      <form v-else @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <div class="flex items-center gap-2 text-red-500 text-xs font-mono uppercase tracking-widest font-bold">
            <Sparkles class="w-3.5 h-3.5" />
            <span>{{ t('quote.modalHeader') }}</span>
          </div>
          <h2 class="text-2xl font-display font-semibold uppercase tracking-wide text-white mt-1">{{ t('quote.modalTitle') }}</h2>
        </div>

        <div v-if="errorMessage" class="p-3 rounded-xl bg-red-950/60 border border-red-500/50 text-red-300 text-xs">
          {{ errorMessage }}
        </div>

        <!-- 1. Desired Service -->
        <div>
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.desiredService') }}</label>
          <select
            v-model="form.service"
            class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-sm transition-colors"
          >
            <option v-for="srv in servicesOptions" :key="srv" :value="srv">{{ srv }}</option>
          </select>
        </div>

        <!-- 2. Full Name -->
        <div>
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.fullName') }}</label>
          <div class="relative">
            <input
              v-model="form.name"
              type="text"
              required
              :placeholder="currentLocale === 'ar' ? 'الاسم الكريم' : 'Your Full Name'"
              class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors"
            />
          </div>
        </div>

        <!-- 3. Mobile / WhatsApp -->
        <div>
          <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.phone') }}</label>
          <div class="relative">
            <input
              v-model="form.phone"
              type="tel"
              required
              placeholder="+971 50 123 4567"
              class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors font-mono"
            />
          </div>
        </div>

        <!-- Instant Submit Button -->
        <button
          type="submit"
          :disabled="isSubmitting"
          class="w-full py-4 mt-2 rounded-xl bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-xl shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Send v-if="!isSubmitting" class="w-4 h-4" />
          <span>{{ isSubmitting ? t('quote.submitting') : t('quote.modalSubmitBtn') }}</span>
        </button>

        <p class="text-[10px] text-zinc-500 text-center font-mono pt-1">
          {{ t('quote.privacy') }}
        </p>
      </form>
    </div>
  </div>
</template>
