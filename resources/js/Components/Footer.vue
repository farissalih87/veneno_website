<script setup>
import { Link } from '@inertiajs/vue3';
import {
  Phone,
  Mail,
  MapPin,
  Clock,
  ShieldCheck,
  Sparkles,
  ArrowUpRight,
  ChevronUp,
  Award,
  Gem,
  CheckCircle2,
  Car,
  Wrench,
  Layers,
  Building2,
  ExternalLink
} from 'lucide-vue-next';
import { useI18n } from '../i18n';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['open-quote']);

const { t, currentLocale } = useI18n();

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  });
};
</script>

<template>
  <footer class="bg-zinc-950 border-t border-zinc-800/80 text-zinc-400 relative overflow-hidden font-sans select-none">
    
    <!-- 1. PRE-FOOTER CORPORATE CONSULTATION SUITE -->
    <div class="relative bg-gradient-to-b from-zinc-900/90 via-zinc-950/95 to-zinc-950 border-b border-zinc-800/90 py-10 sm:py-14 overflow-hidden">
      <!-- Ambient Red Glow in Background -->
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-red-600/10 rounded-full blur-3xl pointer-events-none animate-glow-pulse"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6 lg:gap-10 text-center lg:text-start rtl:lg:text-right">
          
          <!-- Corporate Consultation Headline -->
          <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/15 border border-red-500/30 text-red-400 text-xs font-mono uppercase tracking-widest mb-3">
              <Sparkles class="w-3.5 h-3.5" />
              <span>VENENO VIP CONCIERGE</span>
            </div>
            <h3 class="text-xl sm:text-3xl font-display font-semibold text-white uppercase tracking-wide">
              {{ t('footer.preTitle') }}
            </h3>
            <p class="mt-2 text-xs sm:text-sm text-zinc-300 font-light leading-relaxed">
              {{ t('footer.preSubtitle') }}
            </p>
          </div>

          <!-- Action Triggers -->
          <div class="flex flex-wrap items-center justify-center lg:justify-end gap-3 sm:gap-4 shrink-0 w-full sm:w-auto">
            <!-- Request Official Proposal -->
            <button
              @click="$emit('open-quote')"
              class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-display font-semibold text-xs uppercase tracking-wider shadow-xl shadow-red-600/30 transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2.5"
            >
              <Sparkles class="w-4 h-4" />
              <span>{{ t('footer.ctaQuote') }}</span>
            </button>

            <!-- WhatsApp Concierge -->
            <a
              href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20would%20like%20to%20inquire%20about%20your%20services."
              target="_blank"
              rel="noopener noreferrer"
              class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-500/50 text-emerald-300 hover:text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2.5 transition-all shadow-lg"
            >
              <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
              </svg>
              <span>{{ t('footer.ctaWhatsApp') }}</span>
            </a>

            <!-- Direct Hotline -->
            <a
              href="tel:+97126344403"
              class="w-full sm:w-auto px-5 py-3.5 rounded-xl bg-zinc-900 hover:bg-zinc-850 border border-zinc-700/80 text-zinc-200 hover:text-white font-mono font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-colors"
            >
              <Phone class="w-3.5 h-3.5 text-red-500" />
              <span>+971 2 634 4403</span>
            </a>
          </div>

        </div>
      </div>
    </div>

    <!-- 2. MAIN CORPORATE DIRECTORY GRID -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 sm:gap-12">
        
        <!-- Column 1: Brand Authority & Accreditations (Span 4) -->
        <div class="lg:col-span-4 space-y-4">
          <Link href="/" class="inline-block group">
            <img src="/images/logo.png" alt="Veneno Auto Care Center" class="h-10 sm:h-12 w-auto object-contain brightness-110 drop-shadow-md group-hover:scale-105 transition-transform" />
          </Link>
          
          <div class="text-[11px] font-mono tracking-widest text-red-500 uppercase font-bold">
            THE ULTIMATE ART OF CARE • UAE
          </div>

          <p class="text-xs text-zinc-400 leading-relaxed max-w-sm">
            {{ t('footer.description') }}
          </p>

          <!-- 4 Official Accreditation Micro-Badges -->
          <div class="grid grid-cols-2 gap-2 pt-2">
            <div class="glass-panel p-2.5 rounded-xl border border-zinc-800 flex items-center gap-2">
              <div class="w-6 h-6 rounded-lg bg-red-600/20 text-red-500 flex items-center justify-center shrink-0 font-bold text-[10px]">3M</div>
              <span class="text-[10px] font-mono text-zinc-300 font-medium line-clamp-1">Pro Shop Dealer</span>
            </div>

            <div class="glass-panel p-2.5 rounded-xl border border-zinc-800 flex items-center gap-2">
              <Gem class="w-4 h-4 text-white shrink-0" />
              <span class="text-[10px] font-mono text-zinc-300 font-medium line-clamp-1">GYEON Certified</span>
            </div>

            <div class="glass-panel p-2.5 rounded-xl border border-zinc-800 flex items-center gap-2">
              <ShieldCheck class="w-4 h-4 text-emerald-400 shrink-0" />
              <span class="text-[10px] font-mono text-zinc-300 font-medium line-clamp-1">ISO 9001:2015</span>
            </div>

            <div class="glass-panel p-2.5 rounded-xl border border-zinc-800 flex items-center gap-2">
              <Award class="w-4 h-4 text-amber-400 shrink-0" />
              <span class="text-[10px] font-mono text-zinc-300 font-medium line-clamp-1">ISO 45001:2018</span>
            </div>
          </div>

          <!-- Official Social Media Channel Links -->
          <div class="pt-2">
            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider mb-2">
              {{ currentLocale === 'ar' ? 'تابعنا على المنصات الرسمية' : 'Official Social Channels' }}
            </div>
            <div class="flex flex-wrap items-center gap-1.5">
              <!-- Instagram -->
              <a
                href="https://www.instagram.com/veneno.ae"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-lg bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 hover:border-pink-500/40 text-zinc-300 hover:text-white text-[11px] font-mono flex items-center gap-1.5 transition-all"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span>
                <span>Instagram</span>
              </a>

              <!-- TikTok -->
              <a
                href="https://www.tiktok.com/@veneno.ae"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-lg bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 hover:border-zinc-600 text-zinc-300 hover:text-white text-[11px] font-mono flex items-center gap-1.5 transition-all"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                <span>TikTok</span>
              </a>

              <!-- Snapchat -->
              <a
                href="https://www.snapchat.com/add/veneno.ae"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-lg bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 hover:border-amber-400/40 text-zinc-300 hover:text-amber-300 text-[11px] font-mono flex items-center gap-1.5 transition-all"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span>Snapchat</span>
              </a>

              <!-- Facebook -->
              <a
                href="https://www.facebook.com/p/Veneno-Auto-Care-Center-61552358964209/"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-lg bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 hover:border-blue-500/40 text-zinc-300 hover:text-blue-400 text-[11px] font-mono flex items-center gap-1.5 transition-all"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                <span>Facebook</span>
              </a>

              <!-- YouTube -->
              <a
                href="https://www.youtube.com/@venenoautocare"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-lg bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 hover:border-red-500/40 text-zinc-300 hover:text-red-400 text-[11px] font-mono flex items-center gap-1.5 transition-all"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                <span>YouTube</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Column 2: Surface Armor & PPF Solutions (Span 2) -->
        <div class="lg:col-span-2 space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-200 font-bold flex items-center gap-2 border-b border-zinc-800 pb-2">
            <ShieldCheck class="w-3.5 h-3.5 text-red-500" />
            <span>{{ t('footer.armorTitle') }}</span>
          </h4>
          <ul class="space-y-2 text-xs">
            <li>
              <Link href="/services/paint-protection-film" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">3M PPF Film</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/ceramic-coating" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">GYEON Ceramic</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/window-tinting" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">3M Window Tinting</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/car-wrapping" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Peelable Car Wrap</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/leather-protection" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Leather Protection</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
          </ul>
        </div>

        <!-- Column 3: Specialized Restoration & Precision (Span 2) -->
        <div class="lg:col-span-2 space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-200 font-bold flex items-center gap-2 border-b border-zinc-800 pb-2">
            <Wrench class="w-3.5 h-3.5 text-amber-400" />
            <span>{{ t('footer.restorationTitle') }}</span>
          </h4>
          <ul class="space-y-2 text-xs">
            <li>
              <Link href="/services/car-detailing" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Concours Detailing</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/dent-removal" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Paintless Dent (PDR)</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/wheel-repair" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">CNC Diamond Wheels</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <Link href="/services/paint-protection" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Body Restoration</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </Link>
            </li>
            <li>
              <a href="#lab" class="hover:text-red-400 transition-colors flex items-center justify-between group">
                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">Before / After Lab</span>
                <ArrowUpRight class="w-3 h-3 opacity-0 group-hover:opacity-100 text-red-500 transition-opacity" />
              </a>
            </li>
          </ul>
        </div>

        <!-- Column 4: Abu Dhabi Corporate Studios & Contacts (Span 4) -->
        <div class="lg:col-span-4 space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-200 font-bold flex items-center gap-2 border-b border-zinc-800 pb-2">
            <Building2 class="w-3.5 h-3.5 text-red-500" />
            <span>{{ t('footer.facilitiesTitle') }}</span>
          </h4>

          <div class="space-y-3 text-xs">
            <!-- Musaffah Facility -->
            <div class="glass-panel p-3 rounded-xl border border-zinc-800/80 hover:border-zinc-700 transition-colors">
              <div class="flex items-center justify-between">
                <strong class="text-zinc-200 font-mono text-[11px] uppercase flex items-center gap-1.5">
                  <MapPin class="w-3.5 h-3.5 text-red-500 shrink-0" />
                  <span>{{ t('footer.musaffahLabel') }}</span>
                </strong>
                <a
                  href="https://maps.google.com/maps?q=VENENO+AUTO+CARE+CENTER+Musaffah+Abu+Dhabi"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="text-[10px] text-red-400 hover:text-white font-mono flex items-center gap-0.5"
                >
                  <span>Maps</span>
                  <ExternalLink class="w-2.5 h-2.5" />
                </a>
              </div>
              <p class="text-[11px] text-zinc-400 mt-1 leading-relaxed">{{ t('footer.musaffahLoc') }}</p>
            </div>

            <!-- Al Qana Studio -->
            <div class="glass-panel p-3 rounded-xl border border-zinc-800/80 hover:border-zinc-700 transition-colors">
              <div class="flex items-center justify-between">
                <strong class="text-zinc-200 font-mono text-[11px] uppercase flex items-center gap-1.5">
                  <MapPin class="w-3.5 h-3.5 text-amber-400 shrink-0" />
                  <span>{{ t('footer.alQanaLabel') }}</span>
                </strong>
                <a
                  href="https://maps.google.com/maps?q=VENENO+AUTO+CARE+CENTER+AL+QANA+Abu+Dhabi"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="text-[10px] text-amber-400 hover:text-white font-mono flex items-center gap-0.5"
                >
                  <span>Maps</span>
                  <ExternalLink class="w-2.5 h-2.5" />
                </a>
              </div>
              <p class="text-[11px] text-zinc-400 mt-1 leading-relaxed">{{ t('footer.alQanaLoc') }}</p>
            </div>

            <!-- Operational Details -->
            <div class="pt-1 flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] font-mono text-zinc-400">
              <div class="flex items-center gap-1.5">
                <Clock class="w-3.5 h-3.5 text-red-500 shrink-0" />
                <span>{{ t('footer.hours') }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <Mail class="w-3.5 h-3.5 text-red-500 shrink-0" />
                <a href="mailto:info@veneno.ae" class="hover:text-white transition-colors font-bold">info@veneno.ae</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- 3. OFFICIAL GLOBAL BRAND PARTNERS STRIP -->
    <div class="border-t border-zinc-900 bg-zinc-950 py-5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4 sm:gap-6 text-zinc-500">
          
          <!-- Partner Logos Inline -->
          <div class="flex flex-wrap items-center gap-6 sm:gap-10">
            <!-- 3M Badge -->
            <div class="flex items-center gap-2 text-zinc-400 font-mono text-xs">
              <span class="font-bold text-red-500">3M™</span>
              <span class="text-[11px] uppercase tracking-wider">Authorized Pro Shop Dealer</span>
            </div>

            <!-- GYEON Badge -->
            <div class="flex items-center gap-2 text-zinc-400 font-mono text-xs">
              <span class="font-bold text-white tracking-widest">GYEON®</span>
              <span class="text-[11px] uppercase tracking-wider">Certified Quartz Detailer</span>
            </div>

            <!-- ISO Badges -->
            <div class="flex items-center gap-2 text-zinc-400 font-mono text-xs">
              <span class="px-1.5 py-0.5 rounded bg-red-600 text-white font-bold text-[10px]">ISO</span>
              <span class="text-[11px] uppercase tracking-wider">9001:2015 & 45001:2018</span>
            </div>
          </div>

          <!-- Clean-Room VIP Assurance -->
          <div class="text-[11px] font-mono text-zinc-400 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>100% Dust-Free Clean-Rooms • 150+ Craftsmen</span>
          </div>

        </div>
      </div>
    </div>

    <!-- 4. CORPORATE SUB-FOOTER (Legal, Socials & Back to Top) -->
    <div class="border-t border-zinc-900 bg-black py-6 text-xs text-zinc-500 font-mono">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-start rtl:md:text-right">
        
        <!-- Legal Entity Notice -->
        <div class="text-[11px] text-zinc-400">
          <strong class="text-white block sm:inline">{{ t('footer.legalName') }}</strong>
          <span class="hidden sm:inline"> • </span>
          <span>{{ t('footer.rights') }}</span>
        </div>

        <!-- Social Media Icons & Channels (Complete Official Social Accounts) -->
        <div class="flex flex-wrap items-center justify-center gap-2 text-zinc-400">
          <!-- Instagram -->
          <a
            href="https://www.instagram.com/veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-gradient-to-tr hover:from-amber-600 hover:via-pink-600 hover:to-purple-600 hover:text-white border border-zinc-800 hover:border-pink-500/40 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno Instagram"
            title="Instagram: @veneno.ae"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>

          <!-- TikTok -->
          <a
            href="https://www.tiktok.com/@veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-zinc-800 hover:text-white border border-zinc-800 hover:border-zinc-600 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno TikTok"
            title="TikTok: @veneno.ae"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.48 6.3 6.3 0 0 0 1.88-4.48V8.65a8.21 8.21 0 0 0 4.89 1.58V6.78c-.34-.02-.68-.05-1-.09z"/>
            </svg>
          </a>

          <!-- Snapchat -->
          <a
            href="https://www.snapchat.com/add/veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-amber-400 hover:text-black border border-zinc-800 hover:border-amber-400/50 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno Snapchat"
            title="Snapchat: veneno.ae"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.5c3.2 0 5.4 2.2 5.4 5.6 0 1.1-.1 2-.2 2.7.4 0 .8-.1 1.2-.3.2-.1.4-.1.6.1.2.2.2.5 0 .7-.5.3-1.1.5-1.7.7 0 .1.1.2.2.4.5 1.2 1.5 1.9 2.8 2.2.4.1.5.5.3.8-.4.6-1.3.9-2.1 1.1-.1.2-.1.5-.2.6-.1.2-.3.3-.5.3-.5-.1-1-.1-1.5 0-.5.1-.9.3-1.5.7-.8.5-1.7 1.1-2.9 1.1s-2.1-.6-2.9-1.1c-.5-.4-1-.6-1.5-.7-.5-.1-1.1-.1-1.5 0-.2 0-.5-.1-.5-.3-.1-.2-.1-.4-.2-.6-.8-.2-1.7-.5-2.1-1.1-.2-.3-.1-.7.3-.8 1.3-.3 2.3-1 2.8-2.2.1-.2.2-.3.2-.4-.6-.2-1.2-.4-1.7-.7-.2-.2-.2-.5 0-.7.2-.2.4-.2.6-.1.4.2.8.3 1.2.3-.1-.7-.2-1.6-.2-2.7C6.6 4.7 8.8 2.5 12 2.5z"/>
            </svg>
          </a>

          <!-- Facebook -->
          <a
            href="https://www.facebook.com/p/Veneno-Auto-Care-Center-61552358964209/"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-blue-600 hover:text-white border border-zinc-800 hover:border-blue-500/40 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno Facebook"
            title="Facebook: Veneno Auto Care Center"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M22 12.07C22 6.51 17.52 2 12 2S2 6.5 2 12.07c0 5 3.66 9.15 8.44 9.93v-7.02H7.9v-2.9h2.54V9.85c0-2.52 1.49-3.92 3.78-3.92 1.1 0 2.24.2 2.24.2v2.47h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.45 2.9h-2.33V22c4.78-.78 8.43-4.93 8.43-9.93Z"/>
            </svg>
          </a>

          <!-- YouTube -->
          <a
            href="https://www.youtube.com/@venenoautocare"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-red-600 hover:text-white border border-zinc-800 hover:border-red-500/40 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno YouTube"
            title="YouTube: @venenoautocare"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>

          <!-- WhatsApp -->
          <a
            href="https://wa.me/97126344403"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-[#25D366] hover:text-white border border-zinc-800 hover:border-emerald-500/40 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno WhatsApp"
            title="WhatsApp: +971 2 634 4403"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
            </svg>
          </a>

          <!-- Google Maps -->
          <a
            href="https://maps.app.goo.gl/8zBqZ3f9oUC5Md437"
            target="_blank"
            rel="noopener noreferrer"
            class="w-8 h-8 rounded-xl bg-zinc-900 hover:bg-red-500 hover:text-white border border-zinc-800 hover:border-red-500/40 flex items-center justify-center transition-all hover:scale-110"
            aria-label="Veneno Google Maps"
            title="Google Maps Location"
          >
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
          </a>
        </div>

        <!-- Back to Top Button -->
        <button
          @click="scrollToTop"
          class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 hover:border-red-500/50 text-zinc-300 hover:text-white transition-all text-[11px] group"
        >
          <span>{{ t('footer.backToTop') }}</span>
          <ChevronUp class="w-3.5 h-3.5 text-red-500 group-hover:-translate-y-0.5 transition-transform" />
        </button>

      </div>
    </div>

  </footer>
</template>
