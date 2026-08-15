<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { MessageSquare, Send, X, ShieldCheck, CheckCircle2, Loader2 } from 'lucide-vue-next';

const isOpen = ref(false);
const isSubmitting = ref(false);
const isSuccess = ref(false);

const form = ref({
  customer_name: '',
  phone: '',
  vehicle_details: 'Porsche 911 Turbo S',
  service_requested: 'Diamond Ceramic Coating',
  message_text: 'Hi Veneno Auto Care, I would like to inquire about booking availability and receiving a tailored appraisal.',
});

const handleWhatsAppSubmit = async () => {
  if (!form.value.customer_name || !form.value.phone) return;

  isSubmitting.value = true;
  try {
    // 1. Log lead into Laravel database
    await axios.post(route('api.inquiries.store'), form.value);

    isSuccess.value = true;

    // 2. Format pre-filled WhatsApp message
    const waNumber = '971501234567'; // Veneno official WhatsApp business number
    const encodedText = encodeURIComponent(
      `🏁 *VENENO AUTO CARE INQUIRY*\n\n` +
      `👤 *Name:* ${form.value.customer_name}\n` +
      `📞 *Phone:* ${form.value.phone}\n` +
      `🏎️ *Vehicle:* ${form.value.vehicle_details}\n` +
      `🛡️ *Service:* ${form.value.service_requested}\n\n` +
      `💬 *Message:* ${form.value.message_text}`
    );

    const waUrl = `https://wa.me/${waNumber}?text=${encodedText}`;

    setTimeout(() => {
      window.open(waUrl, '_blank');
      isSubmitting.value = false;
      isOpen.value = false;
      isSuccess.value = false;
    }, 800);
  } catch (error) {
    console.error('Failed to log inquiry:', error);
    isSubmitting.value = false;
  }
};
</script>

<template>
  <div class="fixed bottom-6 right-6 z-50">
    <!-- Floating Trigger Button -->
    <button
      v-if="!isOpen"
      @click="isOpen = true"
      class="group relative flex items-center gap-3 px-4 py-3 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-2xl shadow-emerald-900/60 border border-emerald-400/40 transition-all duration-300 transform hover:scale-105"
    >
      <div class="relative flex items-center justify-center">
        <MessageSquare class="w-5 h-5 text-white" />
        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-emerald-300 rounded-full animate-ping"></span>
      </div>
      <span class="hidden sm:inline font-sans">WhatsApp Concierge</span>
    </button>

    <!-- Floating Modal Dialog -->
    <div
      v-if="isOpen"
      class="w-[360px] sm:w-[400px] glass-panel rounded-3xl overflow-hidden shadow-2xl shadow-black border border-zinc-800 animate-in fade-in slide-in-from-bottom-4 duration-200"
    >
      <!-- Header -->
      <div class="bg-gradient-to-r from-emerald-950 via-zinc-900 to-zinc-950 p-4 border-b border-emerald-900/40 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center">
            <MessageSquare class="w-5 h-5 text-emerald-400" />
          </div>
          <div>
            <h3 class="text-sm font-bold text-white">Veneno Concierge</h3>
            <div class="flex items-center gap-1.5 text-[11px] text-emerald-400 font-mono">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              <span>Direct WhatsApp Channel</span>
            </div>
          </div>
        </div>
        <button @click="isOpen = false" class="p-1.5 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-white">
          <X class="w-5 h-5" />
        </button>
      </div>

      <!-- Form Body -->
      <form @submit.prevent="handleWhatsAppSubmit" class="p-5 space-y-3.5 text-xs">
        <div>
          <label class="block text-zinc-400 mb-1 font-medium">Your Name *</label>
          <input
            v-model="form.customer_name"
            type="text"
            required
            placeholder="e.g. Tariq Al-Hashimi"
            class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 transition-colors"
          />
        </div>

        <div>
          <label class="block text-zinc-400 mb-1 font-medium">Phone / WhatsApp Number *</label>
          <input
            v-model="form.phone"
            type="tel"
            required
            placeholder="+971 50 000 0000"
            class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 transition-colors"
          />
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div>
            <label class="block text-zinc-400 mb-1 font-medium">Vehicle Model</label>
            <input
              v-model="form.vehicle_details"
              type="text"
              placeholder="e.g. Porsche 911 GT3"
              class="w-full px-3.5 py-2 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 text-xs"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1 font-medium">Service Interest</label>
            <select
              v-model="form.service_requested"
              class="w-full px-3 py-2 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white focus:outline-none focus:border-emerald-500 text-xs"
            >
              <option value="Diamond Ceramic Coating">Ceramic Coating</option>
              <option value="Self-Healing PPF Film">Self-Healing PPF</option>
              <option value="Multi-Stage Paint Correction">Paint Correction</option>
              <option value="Interior Master Rejuvenation">Interior Detailing</option>
              <option value="Ceramic IR Window Tinting">Window Tinting</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-zinc-400 mb-1 font-medium">Specific Questions or Requirements</label>
          <textarea
            v-model="form.message_text"
            rows="2"
            class="w-full px-3.5 py-2 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 text-xs resize-none"
          ></textarea>
        </div>

        <button
          type="submit"
          :disabled="isSubmitting"
          class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-900/50 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="isSubmitting" class="w-4 h-4 animate-spin" />
          <Send v-else class="w-4 h-4" />
          <span>{{ isSuccess ? 'Launching WhatsApp...' : 'Start WhatsApp Chat' }}</span>
        </button>

        <p class="text-[10px] text-zinc-500 text-center flex items-center justify-center gap-1">
          <ShieldCheck class="w-3.5 h-3.5 text-emerald-400" />
          <span>Direct confidential lead logged to CRM</span>
        </p>
      </form>
    </div>
  </div>
</template>
