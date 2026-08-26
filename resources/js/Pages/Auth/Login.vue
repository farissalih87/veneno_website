<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Eye, EyeOff, Loader2, ArrowLeft, ShieldCheck } from 'lucide-vue-next';

const showPassword = ref(false);

const form = useForm({
  email: '',
  password: '',
  remember: true,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Executive Sign In - Veneno Auto Care" />

  <div class="min-h-screen flex items-center justify-center p-4 bg-[#070709] text-zinc-100 font-sans selection:bg-red-500 selection:text-white relative overflow-hidden">
    
    <!-- Background Ambient Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-br from-red-600/10 via-[#c5a059]/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 p-8 sm:p-10 rounded-[2.5rem] bg-[#121216]/95 border-2 border-[#c5a059]/40 shadow-[0_0_60px_rgba(0,0,0,0.8)] backdrop-blur-2xl space-y-6">
      
      <!-- Back Link -->
      <div class="flex items-center justify-between">
        <Link :href="route('home')" class="inline-flex items-center gap-2 text-xs font-mono text-zinc-400 hover:text-[#e5c07b] transition-colors group">
          <ArrowLeft class="w-4 h-4 transition-transform group-hover:-translate-x-1" />
          <span>Back to Storefront</span>
        </Link>

        <div class="flex items-center gap-1 text-[11px] font-mono text-[#c5a059]">
          <ShieldCheck class="w-3.5 h-3.5" />
          <span>256-bit Encrypted</span>
        </div>
      </div>

      <!-- Header & Branding -->
      <div class="text-center space-y-2 pt-2">
        <Link :href="route('home')" class="inline-block group">
          <img 
            src="/images/logo.png" 
            alt="Veneno Auto Care" 
            title="Veneno Auto Care" 
            class="h-14 w-auto mx-auto object-contain transition-transform duration-300 group-hover:scale-105" 
          />
        </Link>
        <h1 class="text-lg font-black tracking-wider uppercase text-white font-mono">
          Executive Portal Access
        </h1>
        <p class="text-xs text-zinc-400">
          Sign in to access VIP CRM, Lead Telemetry & Operations
        </p>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="submit" class="space-y-4 pt-2">
        
        <!-- Email Input -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold text-zinc-300 uppercase tracking-wider font-mono">Email Address</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
              <Mail class="w-4 h-4" />
            </div>
            <input
              v-model="form.email"
              type="email"
              required
              autocomplete="email"
              placeholder="admin@veneno.ae"
              class="w-full pl-10 pr-4 py-3 rounded-2xl bg-zinc-950/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-[#c5a059] focus:ring-1 focus:ring-[#c5a059] transition-all text-sm"
            />
          </div>
          <div v-if="form.errors.email" class="text-red-400 text-xs font-medium pl-1">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password Input -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label class="block text-xs font-bold text-zinc-300 uppercase tracking-wider font-mono">Password</label>
          </div>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
              <Lock class="w-4 h-4" />
            </div>
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              required
              autocomplete="current-password"
              placeholder="••••••••••••"
              class="w-full pl-10 pr-11 py-3 rounded-2xl bg-zinc-950/90 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-[#c5a059] focus:ring-1 focus:ring-[#c5a059] transition-all text-sm"
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-500 hover:text-zinc-300 transition-colors"
            >
              <EyeOff v-if="showPassword" class="w-4 h-4" />
              <Eye v-else class="w-4 h-4" />
            </button>
          </div>
          <div v-if="form.errors.password" class="text-red-400 text-xs font-medium pl-1">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center gap-2 cursor-pointer select-none">
            <input
              v-model="form.remember"
              type="checkbox"
              class="w-4 h-4 rounded border-zinc-700 bg-zinc-900 text-red-600 focus:ring-red-500 focus:ring-offset-0"
            />
            <span class="text-xs text-zinc-400 hover:text-zinc-300">Keep me signed in</span>
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="form.processing"
          class="w-full mt-2 py-3.5 rounded-2xl bg-gradient-to-r from-red-600 via-[#c5a059] to-red-600 hover:from-red-500 hover:to-red-500 text-white font-black uppercase tracking-widest text-xs shadow-[0_0_25px_rgba(239,68,68,0.4)] flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin" />
          <span>Authenticate & Access Dashboard</span>
        </button>

      </form>

      <!-- Footer Info -->
      <div class="pt-4 border-t border-zinc-800/80 text-center">
        <p class="text-[11px] font-mono text-zinc-500">
          Veneno Auto Care Center • Musaffah M37, Abu Dhabi
        </p>
      </div>

    </div>
  </div>
</template>
