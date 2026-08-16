<script setup>
import { Link } from '@inertiajs/vue3';
import { ShieldCheck, MapPin, Phone, Mail, Clock } from 'lucide-vue-next';

const services = [
  { name: 'Paint Protection Film (PPF)', slug: 'paint-protection-film' },
  { name: 'Diamond Ceramic Coating', slug: 'ceramic-coating' },
  { name: 'Detailing & Paint Correction', slug: 'detailing-paint-correction' },
  { name: 'Ceramic Window Tinting', slug: 'window-tinting' },
  { name: 'Vehicle Wrapping', slug: 'car-wrapping' },
  { name: 'Paintless Dent Repair (PDR)', slug: 'paintless-dent-repair' },
  { name: 'Rims Protection & Repair', slug: 'rims-protection-repair' },
  { name: 'Paint & Body Restoration', slug: 'paint-body-work' },
  { name: 'Signature Decon Car Wash', slug: 'premium-car-wash' },
];
</script>

<template>
  <footer class="bg-zinc-950 border-t border-zinc-900 text-zinc-400 pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
        
        <!-- Brand column -->
        <div class="lg:col-span-2 space-y-4">
          <Link :href="route('home')" class="inline-block group">
            <img 
              src="/images/logo.png" 
              alt="Veneno Auto Care" 
              title="Veneno Auto Care" 
              class="h-9 sm:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105" 
            />
          </Link>
          <p class="text-xs sm:text-sm text-zinc-400 max-w-sm leading-relaxed">
            UAE's premier luxury auto salon for self-healing paint protection film, 9H+ graphene ceramic coatings, and concourse-grade vehicle rejuvenation.
          </p>
          <div class="flex flex-wrap items-center gap-2 text-xs font-mono text-zinc-500 pt-2">
            <span class="px-2.5 py-1 rounded bg-zinc-900 border border-zinc-800 text-red-400 flex items-center gap-1.5">
              <ShieldCheck class="w-3.5 h-3.5" /> Certified Installers
            </span>
            <span class="px-2.5 py-1 rounded bg-zinc-900 border border-zinc-800 text-zinc-300">
              XPEL & Gyeon Accredited
            </span>
          </div>

          <!-- Official WhatsApp Direct Link -->
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
              <span>Chat on WhatsApp (+971 2 634 4403)</span>
            </a>
          </div>
        </div>

        <!-- 9 Services Links (2 Columns) -->
        <div class="lg:col-span-2 space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">Our 9 Services</h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-xs">
            <Link
              v-for="srv in services"
              :key="srv.slug"
              :href="route('service.detail', srv.slug)"
              class="hover:text-red-400 transition-colors line-clamp-1"
            >
              • {{ srv.name }}
            </Link>
          </div>
        </div>

        <!-- Workshop Contact -->
        <div class="space-y-3">
          <h4 class="text-xs font-mono uppercase tracking-widest text-zinc-300 font-bold">Abu Dhabi Studios</h4>
          <ul class="space-y-2.5 text-xs">
            <li class="flex items-start gap-2 text-zinc-400">
              <MapPin class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
              <div>
                <strong class="text-zinc-200 block">Musaffah (Main Branch)</strong>
                <span>Musaffah Industrial Area, Abu Dhabi, UAE</span>
              </div>
            </li>
            <li class="flex items-start gap-2 text-zinc-400 pt-1">
              <MapPin class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" />
              <div>
                <strong class="text-zinc-200 block">Al Qana (Branch)</strong>
                <span>Rabdan, Al Qana, Abu Dhabi, UAE</span>
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
              <span>Mon - Sat: 9:00 AM - 8:00 PM</span>
            </li>
          </ul>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 border-t border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500 font-mono">
        <div>
          © {{ new Date().getFullYear() }} Veneno Auto Care. All Rights Reserved.
        </div>
        <div class="flex items-center gap-6">
          <a href="/#about" class="text-zinc-400 hover:text-white">About Us</a>
          <a href="/#services" class="text-zinc-400 hover:text-white">Services</a>
          <a href="/#gallery" class="text-zinc-400 hover:text-white">Our Works</a>
          <a href="/#contact" class="text-zinc-400 hover:text-white">Contact Us</a>
        </div>
      </div>
    </div>
  </footer>
</template>

