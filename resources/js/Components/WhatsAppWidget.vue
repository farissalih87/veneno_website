<script setup>
import { ref, computed } from 'vue';
import { useI18n } from '../i18n';

const { t, currentLocale } = useI18n();

const phone = '97126344403';
const showTooltip = ref(true);

const whatsappUrl = computed(() => {
  const message = currentLocale.value === 'ar'
    ? 'مرحباً مركز فينينو للعناية بالسيارات، أود الاستفسار عن خدمات العناية والحماية الفاخرة لسيارتي.'
    : 'Hello Veneno Auto Care, I would like to inquire about your luxury detailing and protection services.';
  return `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
});
</script>

<template>
  <div class="fixed bottom-6 right-6 rtl:right-auto rtl:left-6 z-50 flex items-center gap-3 rtl:flex-row-reverse">
    <!-- Quick Tooltip (Translated) -->
    <div
      v-if="showTooltip"
      class="hidden md:flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-zinc-900/95 backdrop-blur-md border border-zinc-800 text-xs font-semibold text-zinc-200 shadow-2xl shadow-black/80 animate-in fade-in slide-in-from-right-3 rtl:slide-in-from-left-3 duration-300"
    >
      <span class="w-2 h-2 rounded-full bg-[#25D366] animate-ping"></span>
      <span>{{ t('whatsapp.chatWithConcierge') }}</span>
      <button @click="showTooltip = false" class="text-zinc-500 hover:text-white mx-1 text-xs">×</button>
    </div>

    <!-- Official Floating WhatsApp Button -->
    <a
      :href="whatsappUrl"
      target="_blank"
      rel="noopener noreferrer"
      class="relative group w-14 h-14 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white flex items-center justify-center shadow-2xl shadow-[#25D366]/40 transform hover:scale-110 transition-all duration-300 focus:outline-none"
      title="WhatsApp"
      aria-label="WhatsApp"
    >
      <!-- Pulse Ring -->
      <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-30 animate-ping pointer-events-none"></span>

      <!-- Official WhatsApp SVG Icon -->
      <svg class="w-7 h-7 fill-current relative z-10" viewBox="0 0 24 24">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
      </svg>
    </a>
  </div>
</template>
