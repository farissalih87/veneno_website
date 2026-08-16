<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Send, CheckCircle2, Phone, Mail, User, ShieldCheck, Sparkles, MapPin } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const { t, currentLocale } = useI18n();

const form = ref({
  name: '',
  phone: '',
  email: '',
  branch: 'Musaffah — Main Branch',
  service: 'Paint Protection Film (PPF)',
  message: '',
});

const isSubmitting = ref(false);
const isSuccess = ref(false);
const errorMessage = ref('');

const servicesOptions = [
  'Paint Protection Film (PPF)',
  'Diamond Ceramic Coating',
  'Detailing & Paint Correction',
  'Ceramic Window Tinting',
  'Vehicle Wrapping & Color Change',
  'Paintless Dent Repair (PDR)',
  'Rims Protection & Wheel Repair',
  'Paint & Body Restoration',
  'Signature Decontamination Car Wash',
  'Full Exotic Concourse Package',
];

const handleSubmit = async () => {
  isSubmitting.value = true;
  errorMessage.value = '';

  try {
    const res = await axios.post('/api/quote', {
      ...form.value,
      locale: currentLocale.value,
    });
    if (res.data.success) {
      isSuccess.value = true;
    }
  } catch (err) {
    console.error('Quote submission error:', err);
    errorMessage.value = err.response?.data?.message || 'Something went wrong. Please reach us directly at info@veneno.ae or +971 2 634 4403.';
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <section id="quote" class="py-24 bg-zinc-950 relative border-t border-zinc-900 overflow-hidden">
    <!-- Ambient Red Glow -->
    <div class="absolute -top-40 right-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- Left Column: Value Prop & Contact Info -->
        <div class="lg:col-span-5 space-y-6">
          <div>
            <span class="text-xs font-mono uppercase tracking-widest text-red-500 font-bold">{{ t('quote.tag') }}</span>
            <h2 class="text-3xl sm:text-4xl font-display font-semibold uppercase tracking-wider text-white mt-1">
              {{ t('quote.title') }}
            </h2>
            <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
              {{ t('quote.subtitle') }}
            </p>
          </div>

          <div class="space-y-4 pt-2">
            <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800/80">
              <div class="p-2.5 rounded-xl bg-red-600/20 text-red-400 border border-red-500/30 shrink-0">
                <ShieldCheck class="w-5 h-5" />
              </div>
              <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">{{ t('quote.warrantyTitle') }}</h4>
                <p class="text-xs text-zinc-400 mt-0.5">{{ t('quote.warrantyDesc') }}</p>
              </div>
            </div>

            <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800/80">
              <div class="p-2.5 rounded-xl bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 shrink-0">
                <!-- WhatsApp SVG -->
                <svg class="w-5 h-5 fill-current text-[#25D366]" viewBox="0 0 24 24">
                  <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">{{ t('quote.whatsappTitle') }}</h4>
                <p class="text-xs text-zinc-400 mt-0.5">{{ t('quote.whatsappDesc') }}</p>
              </div>
            </div>

            <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800/80">
              <div class="p-2.5 rounded-xl bg-blue-600/20 text-blue-400 border border-blue-500/30 shrink-0">
                <Mail class="w-5 h-5" />
              </div>
              <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">{{ t('quote.emailTitle') }}</h4>
                <p class="text-xs text-zinc-400 mt-0.5">{{ t('quote.emailDesc') }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: Simple 4-Field Form -->
        <div class="lg:col-span-7">
          <div class="glass-panel rounded-3xl border border-zinc-800/90 shadow-2xl p-6 sm:p-10 relative">
            
            <!-- SUCCESS STATE -->
            <div v-if="isSuccess" class="text-center py-8 space-y-5">
              <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center shadow-xl">
                <CheckCircle2 class="w-8 h-8" />
              </div>

              <div>
                <h3 class="text-2xl font-display uppercase tracking-wider text-white">{{ t('quote.successTitle') }}</h3>
                <p class="text-xs text-zinc-300 mt-2 max-w-md mx-auto leading-relaxed">
                  {{ t('quote.successDesc', { name: form.name }) }}
                </p>
              </div>

              <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                <a
                  :href="`https://wa.me/97126344403?text=Hi%20Veneno%20Auto%20Care,%20I%20just%20submitted%20a%20quote%20request%20for%20${encodeURIComponent(form.service)}.%20My%20name%20is%20${encodeURIComponent(form.name)}.`"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="px-6 py-3.5 rounded-xl bg-emerald-950/90 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition-all"
                >
                  <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
                  </svg>
                  <span>{{ t('quote.fastTrackWhatsApp') }}</span>
                </a>

                <button
                  @click="isSuccess = false"
                  class="px-5 py-3.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 text-xs font-semibold"
                >
                  {{ t('quote.submitAnother') }}
                </button>
              </div>
            </div>

            <!-- FORM STATE -->
            <form v-else @submit.prevent="handleSubmit" class="space-y-4">
              <div v-if="errorMessage" class="p-3 rounded-xl bg-red-950/60 border border-red-500/50 text-red-300 text-xs">
                {{ errorMessage }}
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Field 1: Name -->
                <div>
                  <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.fullName') }}</label>
                  <div class="relative">
                    <input
                      v-model="form.name"
                      type="text"
                      required
                      placeholder="e.g. Sheikh Rashid / Alexander"
                      class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors"
                    />
                  </div>
                </div>

                <!-- Field 2: Phone -->
                <div>
                  <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.phone') }}</label>
                  <div class="relative">
                    <input
                      v-model="form.phone"
                      type="tel"
                      required
                      placeholder="e.g. +971 50 123 4567"
                      class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors"
                    />
                  </div>
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Field 3: Email -->
                <div>
                  <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.email') }}</label>
                  <div class="relative">
                    <input
                      v-model="form.email"
                      type="email"
                      required
                      placeholder="e.g. client@example.ae"
                      class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors"
                    />
                  </div>
                </div>

                <!-- Preferred Branch -->
                <div>
                  <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.preferredBranch') }}</label>
                  <select
                    v-model="form.branch"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-sm transition-colors font-semibold"
                  >
                    <option value="Musaffah — Main Branch">{{ t('branches.musaffahTitle') }}</option>
                    <option value="Al Qana — Branch">{{ t('branches.alQanaTitle') }}</option>
                  </select>
                </div>
              </div>

              <!-- Desired Service Selector -->
              <div>
                <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.desiredService') }}</label>
                <select
                  v-model="form.service"
                  class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-sm transition-colors"
                >
                  <option v-for="srv in servicesOptions" :key="srv" :value="srv">{{ srv }}</option>
                </select>
              </div>

              <!-- Field 4: Message -->
              <div>
                <label class="block text-xs font-mono uppercase text-zinc-400 mb-1.5">{{ t('quote.message') }}</label>
                <textarea
                  v-model="form.message"
                  rows="4"
                  required
                  :placeholder="t('quote.messagePlaceholder')"
                  class="w-full px-4 py-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 text-sm transition-colors resize-none"
                ></textarea>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full py-4 rounded-xl bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-xl shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
              >
                <Send v-if="!isSubmitting" class="w-4 h-4" />
                <span>{{ isSubmitting ? t('quote.submitting') : t('quote.submitBtn') }}</span>
              </button>

              <div class="flex items-center justify-between text-[10px] text-zinc-500 font-mono pt-1">
                <span>🔒 SSL 256-bit</span>
                <span>info@veneno.ae</span>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>
</template>
