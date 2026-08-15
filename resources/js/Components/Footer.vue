<script setup>
import { Link } from '@inertiajs/vue3';
import { ShieldCheck, MapPin, Phone, Mail, Clock, Instagram, Youtube, Facebook } from 'lucide-vue-next';
</script>

<template>
  <footer class="bg-zinc-950 border-t border-zinc-900 text-zinc-400 pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
        
        <!-- Brand column -->
        <div class="lg:col-span-2 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-red-600 to-red-950 p-0.5 shadow-lg flex items-center justify-center">
              <div class="w-full h-full bg-zinc-950 rounded-[10px] flex items-center justify-center">
                <span class="text-red-500 font-black text-lg">V</span>
              </div>
            </div>
            <div>
              <span class="font-extrabold text-lg tracking-wider text-white">VENENO AUTO CARE</span>
              <span class="text-[10px] tracking-widest text-zinc-500 font-mono block -mt-1 uppercase">Exotic & Luxury Detailing</span>
            </div>
          </div>
          <p class="text-sm text-zinc-400 max-w-sm leading-relaxed">
            Dubai & Abu Dhabi's premier destination for self-healing paint protection film, 9H+ graphene ceramic coatings, and concourse-level automotive rejuvenation.
          </p>
          <div class="flex items-center gap-3 text-xs font-mono text-zinc-500 pt-2">
            <span class="px-2.5 py-1 rounded bg-zinc-900 border border-zinc-800 text-red-400 flex items-center gap-1.5">
              <ShieldCheck class="w-3.5 h-3.5" /> Certified Installers
            </span>
            <span class="px-2.5 py-1 rounded bg-zinc-900 border border-zinc-800 text-zinc-300">
              XPEL & Gyeon Accredited
            </span>
          </div>
        </div>

        <!-- Services Links -->
        <div class="space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">Services</h4>
          <ul class="space-y-2 text-sm">
            <li><Link :href="route('service.detail', 'ceramic-coating')" class="hover:text-red-400 transition-colors">Ceramic Coating</Link></li>
            <li><Link :href="route('service.detail', 'paint-protection-film')" class="hover:text-red-400 transition-colors">Self-Healing PPF</Link></li>
            <li><Link :href="route('service.detail', 'paint-correction')" class="hover:text-red-400 transition-colors">Paint Correction</Link></li>
            <li><Link :href="route('service.detail', 'interior-detailing')" class="hover:text-red-400 transition-colors">Interior Restoration</Link></li>
            <li><Link :href="route('service.detail', 'window-tinting')" class="hover:text-red-400 transition-colors">Ceramic Window Tinting</Link></li>
          </ul>
        </div>

        <!-- Portals Links -->
        <div class="space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">System Portals</h4>
          <ul class="space-y-2 text-sm">
            <li><Link :href="route('customer.portal')" class="hover:text-red-400 transition-colors">VIP Client Garage</Link></li>
            <li><Link :href="route('technician.portal')" class="hover:text-amber-400 transition-colors">Technician Bay Board</Link></li>
            <li><Link :href="route('dashboard')" class="hover:text-red-400 transition-colors">Management CRM</Link></li>
            <li><Link :href="route('login')" class="hover:text-white transition-colors">Staff Login</Link></li>
          </ul>
        </div>

        <!-- Workshop Contact -->
        <div class="space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">Studio Hub</h4>
          <ul class="space-y-2.5 text-xs">
            <li class="flex items-start gap-2 text-zinc-400">
              <MapPin class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
              <span>Al Quoz Industrial Area 3, Street 18B, Dubai, United Arab Emirates</span>
            </li>
            <li class="flex items-center gap-2 text-zinc-400">
              <Phone class="w-4 h-4 text-red-500 shrink-0" />
              <span>+971 4 800 VENENO (836366)</span>
            </li>
            <li class="flex items-center gap-2 text-zinc-400">
              <Mail class="w-4 h-4 text-red-500 shrink-0" />
              <span>concierge@venenoautocare.ae</span>
            </li>
            <li class="flex items-center gap-2 text-zinc-400">
              <Clock class="w-4 h-4 text-red-500 shrink-0" />
              <span>Mon - Sat: 8:00 AM - 8:00 PM</span>
            </li>
          </ul>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 border-t border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500 font-mono">
        <div>
          © {{ new Date().getFullYear() }} Veneno Auto Care Platform. All Rights Reserved.
        </div>
        <div class="flex items-center gap-6">
          <span class="text-zinc-400">Privacy Policy</span>
          <span class="text-zinc-400">Terms of Warranty</span>
          <span class="text-zinc-400">CarFax Detailing Registry</span>
        </div>
      </div>
    </div>
  </footer>
</template>
