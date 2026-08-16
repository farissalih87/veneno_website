<script setup>
import { Link } from '@inertiajs/vue3';
import { Phone, Mail, MapPin, Clock, ShieldCheck, Sparkles } from 'lucide-vue-next';
import { useI18n } from '../i18n';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
});

const { t, currentLocale } = useI18n();
</script>

<template>
  <footer class="bg-black border-t border-zinc-900 text-zinc-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
        
        <!-- Brand Info -->
        <div class="space-y-4">
          <Link href="/" class="inline-block">
            <img src="/images/logo.png" alt="Veneno Auto Care" class="h-10 w-auto object-contain" />
          </Link>
          <p class="text-xs text-zinc-400 leading-relaxed">
            {{ t('footer.description') }}
          </p>

          <div class="flex items-center gap-2 pt-1 text-xs text-zinc-300 font-mono">
            <ShieldCheck class="w-4 h-4 text-red-500 shrink-0" />
            <span>{{ t('footer.accredited') }}</span>
          </div>

          <!-- Official WhatsApp Link -->
          <div class="pt-2">
            <a
              href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20would%20like%20to%20inquire%20about%20your%20services."
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 hover:text-white text-xs font-bold transition-all shadow-md"
            >
              <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
              </svg>
              <span>{{ t('quote.whatsappTitle') }} (+971 2 634 4403)</span>
            </a>
          </div>
        </div>

        <!-- 9 Services Links (2 Columns) -->
        <div class="lg:col-span-2 space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">{{ t('footer.servicesTitle') }}</h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-xs">
            <Link
              v-for="srv in (services && services.length ? services : [])"
              :key="srv.slug"
              :href="`/services/${srv.slug}`"
              class="hover:text-red-400 transition-colors line-clamp-1"
            >
              • {{ srv.name }}
            </Link>
          </div>
        </div>

        <!-- Workshop Contact (2 Abu Dhabi Studios) -->
        <div class="space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">{{ t('footer.studiosTitle') }}</h4>
          <ul class="space-y-2.5 text-xs">
            <li class="flex items-start gap-2 text-zinc-400">
              <MapPin class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
              <div>
                <strong class="text-zinc-200 block">{{ t('branches.musaffahTitle') }}</strong>
                <span>{{ t('branches.musaffahAddress') }}</span>
              </div>
            </li>
            <li class="flex items-start gap-2 text-zinc-400 pt-1">
              <MapPin class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" />
              <div>
                <strong class="text-zinc-200 block">{{ t('branches.alQanaTitle') }}</strong>
                <span>{{ t('branches.alQanaAddress') }}</span>
              </div>
            </li>
            <li class="flex items-center gap-2 text-zinc-400 pt-1">
              <Phone class="w-4 h-4 text-red-500 shrink-0" />
              <a href="tel:+97126344403" class="hover:text-white transition-colors font-mono font-bold">+971 2 634 4403</a>
            </li>
            <li class="flex items-center gap-2 text-zinc-400">
              <Mail class="w-4 h-4 text-red-500 shrink-0" />
              <a href="mailto:info@veneno.ae" class="hover:text-white transition-colors font-mono font-bold">info@veneno.ae</a>
            </li>
            <li class="flex items-center gap-2 text-zinc-400">
              <Clock class="w-4 h-4 text-red-500 shrink-0" />
              <span>{{ t('branches.hours') }}</span>
            </li>
          </ul>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 border-t border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500 font-mono">
        <div>
          © {{ new Date().getFullYear() }} Veneno Auto Care Center. {{ t('footer.rights') }}
        </div>
        <div class="flex items-center gap-6">
          <a href="#about" class="text-zinc-400 hover:text-white">{{ t('nav.about') }}</a>
          <a href="#services" class="text-zinc-400 hover:text-white">{{ t('nav.services') }}</a>
          <a href="#certificates" class="text-zinc-400 hover:text-white">{{ t('nav.certificates') }}</a>
          <a href="#contact" class="text-zinc-400 hover:text-white">{{ t('nav.contact') }}</a>
        </div>
      </div>
    </div>
  </footer>
</template>
