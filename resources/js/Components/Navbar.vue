<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import {
  Sparkles,
  ShieldCheck,
  Calendar,
  User,
  Wrench,
  LayoutDashboard,
  Menu,
  X,
  Phone,
  ChevronDown,
  LogOut,
  Car
} from 'lucide-vue-next';

const emit = defineEmits(['open-booking', 'open-ai-quote', 'open-login']);

const page = usePage();
const authUser = computed(() => page.props.auth?.user);

const isMobileMenuOpen = ref(false);
const isServicesDropdownOpen = ref(false);

const servicesList = [
  { name: 'Diamond Ceramic Coating', slug: 'ceramic-coating', badge: '5-Yr Warranty' },
  { name: 'Self-Healing PPF Film', slug: 'paint-protection-film', badge: '10-Yr Shield' },
  { name: 'Multi-Stage Paint Correction', slug: 'paint-correction', badge: 'Showroom Gloss' },
  { name: 'Interior Master Rejuvenation', slug: 'interior-detailing', badge: 'Steam Extract' },
  { name: 'Ceramic IR Window Tinting', slug: 'window-tinting', badge: '98% Heat Block' },
];

const handleLogout = () => {
  router.post(route('logout'));
};
</script>

<template>
  <header class="sticky top-0 z-40 bg-zinc-950/85 backdrop-blur-xl border-b border-zinc-800/80 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        
        <!-- Logo -->
        <Link :href="route('home')" class="flex items-center group">
          <img 
            src="/images/logo.png" 
            alt="Veneno Auto Care" 
            title="Veneno Auto Care" 
            class="h-9 sm:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105" 
          />
        </Link>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-8">
          <Link :href="route('home')" class="text-sm font-medium text-zinc-300 hover:text-white transition-colors">
            Home
          </Link>

          <!-- Services Dropdown -->
          <div class="relative" @mouseenter="isServicesDropdownOpen = true" @mouseleave="isServicesDropdownOpen = false">
            <button class="flex items-center gap-1.5 text-sm font-medium text-zinc-300 hover:text-white transition-colors py-2">
              <span>Services</span>
              <ChevronDown class="w-4 h-4 text-zinc-400 transition-transform" :class="{ 'rotate-180': isServicesDropdownOpen }" />
            </button>

            <div v-if="isServicesDropdownOpen" class="absolute top-full left-0 w-80 py-2 glass-panel rounded-2xl shadow-2xl shadow-black/80 border border-zinc-800 animate-in fade-in slide-in-from-top-2 duration-150">
              <Link
                v-for="service in servicesList"
                :key="service.slug"
                :href="route('service.detail', service.slug)"
                class="flex items-center justify-between px-4 py-3 hover:bg-zinc-800/60 transition-colors group"
              >
                <div>
                  <div class="text-sm font-medium text-zinc-200 group-hover:text-red-400 transition-colors">{{ service.name }}</div>
                  <div class="text-xs text-zinc-500">Certified Luxury Application</div>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-950/60 text-red-300 border border-red-800/40 font-mono">{{ service.badge }}</span>
              </Link>
            </div>
          </div>

          <!-- Portals / Quick Links -->
          <Link :href="route('customer.portal')" class="text-sm font-medium text-zinc-300 hover:text-white transition-colors flex items-center gap-1.5">
            <Car class="w-4 h-4 text-zinc-400" />
            <span>VIP Garage</span>
          </Link>

          <Link :href="route('technician.portal')" class="text-sm font-medium text-zinc-300 hover:text-white transition-colors flex items-center gap-1.5">
            <Wrench class="w-4 h-4 text-amber-400" />
            <span>Bay Tracker</span>
          </Link>

          <Link :href="route('dashboard')" class="text-sm font-medium text-zinc-300 hover:text-white transition-colors flex items-center gap-1.5">
            <LayoutDashboard class="w-4 h-4 text-red-500" />
            <span>Staff CRM</span>
          </Link>
        </nav>

        <!-- CTA Actions -->
        <div class="hidden sm:flex items-center gap-3">
          <!-- AI Quote Trigger -->
          <button
            @click="emit('open-ai-quote')"
            class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-zinc-900 hover:bg-zinc-800 text-zinc-200 border border-zinc-700/80 transition-all hover:border-red-500/50 shadow-sm"
          >
            <Sparkles class="w-3.5 h-3.5 text-red-400 animate-pulse" />
            <span>AI Detailing Quote</span>
          </button>

          <!-- Book Now Trigger -->
          <button
            @click="emit('open-booking')"
            class="relative group overflow-hidden px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 shadow-lg shadow-red-600/30 transition-all duration-300 transform hover:-translate-y-0.5"
          >
            <span class="relative z-10 flex items-center gap-2">
              <Calendar class="w-3.5 h-3.5" />
              <span>Book Service</span>
            </span>
          </button>

          <!-- Auth Status / Login -->
          <div v-if="authUser" class="relative flex items-center gap-2 pl-2 border-l border-zinc-800">
            <div class="text-right">
              <div class="text-xs font-bold text-zinc-200">{{ authUser.name }}</div>
              <div class="text-[10px] text-red-400 font-mono uppercase">{{ authUser.role }}</div>
            </div>
            <button
              @click="handleLogout"
              title="Logout"
              class="p-2 rounded-lg bg-zinc-900 hover:bg-red-950/60 text-zinc-400 hover:text-red-300 border border-zinc-800 transition-colors"
            >
              <LogOut class="w-4 h-4" />
            </button>
          </div>
          <button
            v-else
            @click="emit('open-login')"
            class="p-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 transition-colors"
            title="Sign In / Demo Switcher"
          >
            <User class="w-4 h-4" />
          </button>
        </div>

        <!-- Mobile Menu Toggle -->
        <button
          @click="isMobileMenuOpen = !isMobileMenuOpen"
          class="lg:hidden p-2 rounded-xl bg-zinc-900 text-zinc-300 border border-zinc-800"
        >
          <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
          <X v-else class="w-6 h-6" />
        </button>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div v-if="isMobileMenuOpen" class="lg:hidden glass-panel border-b border-zinc-800 px-6 py-6 space-y-4">
      <Link :href="route('home')" class="block text-base font-semibold text-zinc-200">Home</Link>
      
      <div class="py-2 border-y border-zinc-800/80 space-y-2">
        <div class="text-xs font-mono uppercase text-zinc-500 tracking-wider">Services</div>
        <Link
          v-for="service in servicesList"
          :key="service.slug"
          :href="route('service.detail', service.slug)"
          class="block text-sm text-zinc-300 hover:text-red-400 pl-2"
        >
          {{ service.name }}
        </Link>
      </div>

      <div class="grid grid-cols-3 gap-2 pt-2">
        <Link :href="route('customer.portal')" class="p-3 text-center rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-medium text-zinc-300">
          <Car class="w-4 h-4 mx-auto mb-1 text-zinc-400" />
          Garage
        </Link>
        <Link :href="route('technician.portal')" class="p-3 text-center rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-medium text-zinc-300">
          <Wrench class="w-4 h-4 mx-auto mb-1 text-amber-400" />
          Bay
        </Link>
        <Link :href="route('dashboard')" class="p-3 text-center rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-medium text-zinc-300">
          <LayoutDashboard class="w-4 h-4 mx-auto mb-1 text-red-500" />
          CRM
        </Link>
      </div>

      <div class="pt-2 flex flex-col gap-2">
        <button
          @click="emit('open-booking'); isMobileMenuOpen = false;"
          class="w-full py-3 rounded-xl bg-red-600 text-white font-bold text-center uppercase tracking-wider text-sm shadow-lg shadow-red-600/30"
        >
          Book Service Now
        </button>
        <button
          @click="emit('open-ai-quote'); isMobileMenuOpen = false;"
          class="w-full py-3 rounded-xl bg-zinc-900 border border-zinc-700 text-zinc-200 font-semibold text-sm flex items-center justify-center gap-2"
        >
          <Sparkles class="w-4 h-4 text-red-400" />
          AI Quote Appraisal
        </button>
      </div>
    </div>
  </header>
</template>
