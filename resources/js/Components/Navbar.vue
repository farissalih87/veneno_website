<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
  ChevronDown,
  Menu,
  X,
  Globe,
  Check
} from 'lucide-vue-next';
import { useI18n } from '../i18n';
import { getServicesByLocale } from '../data/services';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['open-quote']);

const { t, currentLocale, setLocale } = useI18n();

const isMobileMenuOpen = ref(false);
const isServicesDropdownOpen = ref(false);
const isLangDropdownOpen = ref(false);

const dropdownRef = ref(null);

const activeServices = computed(() => {
  return getServicesByLocale(currentLocale.value);
});

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isLangDropdownOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

const switchLanguage = (lang) => {
  isLangDropdownOpen.value = false;
  if (currentLocale.value === lang) return;
  setLocale(lang);
};

const scrollTo = (elementId) => {
  isMobileMenuOpen.value = false;
  const el = document.getElementById(elementId);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  } else {
    window.location.href = `/#${elementId}`;
  }
};
</script>

<template>
  <header class="sticky top-0 z-40 bg-zinc-950/95 backdrop-blur-xl border-b border-zinc-800/80 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        
        <!-- Logo -->
        <Link href="/" class="flex items-center group cursor-pointer">
          <img 
            src="/images/logo.png" 
            alt="Veneno Auto Care Center" 
            title="Veneno Auto Care Center" 
            class="h-9 sm:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105" 
          />
        </Link>

        <!-- Desktop Traditional Navigation -->
        <nav class="hidden xl:flex items-center gap-7">
          <Link href="/" class="text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors cursor-pointer">
            {{ t('nav.home') }}
          </Link>

          <a href="#about" @click.prevent="scrollTo('about')" class="text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors cursor-pointer">
            {{ t('nav.about') }}
          </a>

          <a href="#why-us" @click.prevent="scrollTo('why-us')" class="text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors cursor-pointer">
            {{ t('nav.whyUs') }}
          </a>

          <!-- Services Dropdown -->
          <div class="relative" @mouseenter="isServicesDropdownOpen = true" @mouseleave="isServicesDropdownOpen = false">
            <a href="#services" @click.prevent="scrollTo('services')" class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors py-2 cursor-pointer">
              <span>{{ t('nav.services') }}</span>
              <ChevronDown class="w-3.5 h-3.5 text-zinc-400 transition-transform" :class="{ 'rotate-180': isServicesDropdownOpen }" />
            </a>

            <div v-if="isServicesDropdownOpen" class="absolute top-full -left-10 w-96 py-2 glass-panel rounded-2xl shadow-2xl shadow-black/90 border border-zinc-800 animate-in fade-in slide-in-from-top-2 duration-150 grid grid-cols-1 divide-y divide-zinc-800/60 max-h-[460px] overflow-y-auto">
              <Link
                v-for="service in activeServices"
                :key="service.slug"
                :href="`/services/${service.slug}`"
                class="flex items-center justify-between px-4 py-2.5 hover:bg-zinc-800/70 transition-colors group"
              >
                <div>
                  <div class="text-xs font-semibold text-zinc-200 group-hover:text-red-400 transition-colors">{{ service.name }}</div>
                  <div class="text-[10px] text-zinc-500 font-mono">{{ service.tagline }}</div>
                </div>
                <span class="text-[9px] px-2 py-0.5 rounded-full bg-red-950/60 text-red-300 border border-red-800/40 font-mono">{{ service.badge }}</span>
              </Link>
            </div>
          </div>

          <a href="#certificates" @click.prevent="scrollTo('certificates')" class="text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors cursor-pointer">
            {{ t('nav.certificates') }}
          </a>

          <a href="#contact" @click.prevent="scrollTo('contact')" class="text-xs font-semibold uppercase tracking-wider text-zinc-300 hover:text-white transition-colors cursor-pointer">
            {{ t('nav.contact') }}
          </a>
        </nav>

        <!-- Right Side: Social Media Icons + Language Switcher & Get a Quote CTA -->
        <div class="hidden sm:flex items-center gap-3">
          
          <!-- Desktop Social Icons Strip (Professional Luxury Styling) -->
          <div class="hidden lg:flex items-center gap-1.5 px-2 py-1 rounded-xl bg-zinc-900/60 border border-zinc-800/80">
            <!-- Instagram -->
            <a
              href="https://www.instagram.com/veneno.ae"
              target="_blank"
              rel="noopener noreferrer"
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="Instagram"
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
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="TikTok"
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
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-amber-300 hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="Snapchat"
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
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-blue-400 hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="Facebook"
              title="Facebook"
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
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-red-500 hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="YouTube"
              title="YouTube"
            >
              <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
              </svg>
            </a>

            <!-- Directions / Map -->
            <a
              href="https://maps.app.goo.gl/8zBqZ3f9oUC5Md437"
              target="_blank"
              rel="noopener noreferrer"
              class="w-7 h-7 rounded-lg text-zinc-400 hover:text-red-400 hover:bg-zinc-800 flex items-center justify-center transition-all hover:scale-105"
              aria-label="Google Maps Directions"
              title="Google Maps"
            >
              <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
              </svg>
            </a>
          </div>

          <!-- Modern Dropdown Globe Selector -->
          <div ref="dropdownRef" class="relative">
            <button
              @click="isLangDropdownOpen = !isLangDropdownOpen"
              class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-zinc-900/90 hover:bg-zinc-800 border border-zinc-800 text-zinc-200 hover:text-white text-xs font-semibold transition-all shadow-sm"
              title="Select Language / اختر اللغة"
            >
              <Globe class="w-4 h-4 text-red-500" />
              <span>{{ currentLocale === 'ar' ? 'العربية' : 'English' }}</span>
              <ChevronDown class="w-3.5 h-3.5 text-zinc-400 transition-transform" :class="{ 'rotate-180': isLangDropdownOpen }" />
            </button>

            <!-- Dropdown Menu -->
            <div
              v-if="isLangDropdownOpen"
              class="absolute right-0 rtl:right-auto rtl:left-0 mt-2 w-44 rounded-2xl glass-panel border border-zinc-800 p-1.5 shadow-2xl shadow-black/80 z-50 animate-in fade-in slide-in-from-top-2 duration-150"
            >
              <button
                @click="switchLanguage('en')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-colors"
                :class="currentLocale === 'en' ? 'bg-red-600/20 text-white font-bold border border-red-500/30' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white'"
              >
                <span>English</span>
                <Check v-if="currentLocale === 'en'" class="w-3.5 h-3.5 text-red-400" />
              </button>

              <button
                @click="switchLanguage('ar')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-colors mt-1"
                :class="currentLocale === 'ar' ? 'bg-red-600/20 text-white font-bold border border-red-500/30' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white'"
              >
                <span>العربية</span>
                <Check v-if="currentLocale === 'ar'" class="w-3.5 h-3.5 text-red-400" />
              </button>
            </div>
          </div>

          <!-- Get a Quote CTA -->
          <button
            @click="emit('open-quote')"
            class="px-4 py-2 rounded-xl text-xs font-display font-semibold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 shadow-lg shadow-red-600/30 transition-all duration-300 transform hover:-translate-y-0.5"
          >
            <span>{{ t('nav.getQuote') }}</span>
          </button>
        </div>

        <!-- Mobile Language & Menu Toggle -->
        <div class="xl:hidden flex items-center gap-2">
          <!-- Mobile Dropdown Selector -->
          <div class="flex items-center p-1 rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-mono">
            <button
              @click="switchLanguage('en')"
              class="px-2 py-1 rounded-lg text-xs"
              :class="currentLocale === 'en' ? 'bg-red-600 text-white font-bold' : 'text-zinc-400'"
            >
              EN
            </button>
            <button
              @click="switchLanguage('ar')"
              class="px-2 py-1 rounded-lg text-xs"
              :class="currentLocale === 'ar' ? 'bg-red-600 text-white font-bold' : 'text-zinc-400'"
            >
              عربي
            </button>
          </div>

          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="p-2 rounded-xl bg-zinc-900 text-zinc-300 border border-zinc-800"
            aria-label="Toggle Navigation Menu"
          >
            <Menu v-if="!isMobileMenuOpen" class="w-5 h-5" />
            <X v-else class="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div v-if="isMobileMenuOpen" class="xl:hidden glass-panel border-b border-zinc-800 px-6 py-6 space-y-4 animate-in fade-in slide-in-from-top-4 duration-200">
      <Link href="/" @click="isMobileMenuOpen = false" class="block text-base font-semibold text-zinc-200">{{ t('nav.home') }}</Link>
      <a href="#about" @click.prevent="scrollTo('about')" class="block text-base font-semibold text-zinc-200">{{ t('nav.about') }}</a>
      <a href="#why-us" @click.prevent="scrollTo('why-us')" class="block text-base font-semibold text-zinc-200">{{ t('nav.whyUs') }}</a>
      <a href="#services" @click.prevent="scrollTo('services')" class="block text-base font-semibold text-zinc-200">{{ t('nav.services') }}</a>
      <a href="#certificates" @click.prevent="scrollTo('certificates')" class="block text-base font-semibold text-zinc-200">{{ t('nav.certificates') }}</a>
      <a href="#contact" @click.prevent="scrollTo('contact')" class="block text-base font-semibold text-zinc-200">{{ t('nav.contact') }}</a>
      
      <div class="py-2 border-y border-zinc-800/80 space-y-2">
        <div class="text-xs font-mono uppercase text-zinc-500 tracking-wider">{{ t('nav.allServices') }}</div>
        <div class="grid grid-cols-1 gap-1">
          <Link
            v-for="service in activeServices"
            :key="service.slug"
            :href="`/services/${service.slug}`"
            @click="isMobileMenuOpen = false"
            class="block text-xs text-zinc-300 hover:text-red-400 py-1 pl-2"
          >
            • {{ service.name }}
          </Link>
        </div>
      </div>

      <!-- Mobile Social Channels Strip -->
      <div class="py-2 space-y-2">
        <div class="text-xs font-mono uppercase text-zinc-500 tracking-wider">
          {{ currentLocale === 'ar' ? 'تابعنا على وسائل التواصل' : 'Follow Veneno Official' }}
        </div>
        <div class="flex items-center gap-2">
          <!-- Instagram -->
          <a
            href="https://www.instagram.com/veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-red-500/40 flex items-center justify-center text-zinc-300 hover:text-white"
            aria-label="Instagram"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>

          <!-- TikTok -->
          <a
            href="https://www.tiktok.com/@veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-zinc-700 flex items-center justify-center text-zinc-300 hover:text-white"
            aria-label="TikTok"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.48 6.3 6.3 0 0 0 1.88-4.48V8.65a8.21 8.21 0 0 0 4.89 1.58V6.78c-.34-.02-.68-.05-1-.09z"/>
            </svg>
          </a>

          <!-- Snapchat -->
          <a
            href="https://www.snapchat.com/add/veneno.ae"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-amber-500/40 flex items-center justify-center text-zinc-300 hover:text-amber-300"
            aria-label="Snapchat"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.5c3.2 0 5.4 2.2 5.4 5.6 0 1.1-.1 2-.2 2.7.4 0 .8-.1 1.2-.3.2-.1.4-.1.6.1.2.2.2.5 0 .7-.5.3-1.1.5-1.7.7 0 .1.1.2.2.4.5 1.2 1.5 1.9 2.8 2.2.4.1.5.5.3.8-.4.6-1.3.9-2.1 1.1-.1.2-.1.5-.2.6-.1.2-.3.3-.5.3-.5-.1-1-.1-1.5 0-.5.1-.9.3-1.5.7-.8.5-1.7 1.1-2.9 1.1s-2.1-.6-2.9-1.1c-.5-.4-1-.6-1.5-.7-.5-.1-1.1-.1-1.5 0-.2 0-.5-.1-.5-.3-.1-.2-.1-.4-.2-.6-.8-.2-1.7-.5-2.1-1.1-.2-.3-.1-.7.3-.8 1.3-.3 2.3-1 2.8-2.2.1-.2.2-.3.2-.4-.6-.2-1.2-.4-1.7-.7-.2-.2-.2-.5 0-.7.2-.2.4-.2.6-.1.4.2.8.3 1.2.3-.1-.7-.2-1.6-.2-2.7C6.6 4.7 8.8 2.5 12 2.5z"/>
            </svg>
          </a>

          <!-- Facebook -->
          <a
            href="https://www.facebook.com/p/Veneno-Auto-Care-Center-61552358964209/"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-blue-500/40 flex items-center justify-center text-zinc-300 hover:text-blue-400"
            aria-label="Facebook"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M22 12.07C22 6.51 17.52 2 12 2S2 6.5 2 12.07c0 5 3.66 9.15 8.44 9.93v-7.02H7.9v-2.9h2.54V9.85c0-2.52 1.49-3.92 3.78-3.92 1.1 0 2.24.2 2.24.2v2.47h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.45 2.9h-2.33V22c4.78-.78 8.43-4.93 8.43-9.93Z"/>
            </svg>
          </a>

          <!-- YouTube -->
          <a
            href="https://www.youtube.com/@venenoautocare"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-red-500/40 flex items-center justify-center text-zinc-300 hover:text-red-500"
            aria-label="YouTube"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>

          <!-- Google Maps -->
          <a
            href="https://maps.app.goo.gl/8zBqZ3f9oUC5Md437"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-xl bg-zinc-900/90 border border-zinc-800 hover:border-red-500/40 flex items-center justify-center text-zinc-300 hover:text-red-400"
            aria-label="Google Maps"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="pt-2 flex flex-col gap-2.5">
        <button
          @click="emit('open-quote'); isMobileMenuOpen = false;"
          class="w-full py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-display font-semibold text-center uppercase tracking-wider text-xs shadow-lg shadow-red-600/30"
        >
          {{ t('nav.getQuote') }}
        </button>

        <a
          href="https://wa.me/97126344403?text=Hello%20Veneno%20Auto%20Care,%20I%20would%20like%20to%20inquire%20about%20your%20services."
          target="_blank"
          rel="noopener noreferrer"
          class="w-full py-3 rounded-xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 font-bold text-xs flex items-center justify-center gap-2"
        >
          <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"/>
          </svg>
          <span>{{ t('nav.whatsapp') }}</span>
        </a>
      </div>
    </div>
  </header>
</template>
