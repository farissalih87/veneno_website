<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, LayoutDashboard, UserCheck, Wrench, Car, Loader2, ArrowLeft } from 'lucide-vue-next';

const form = useForm({
  email: '',
  password: '',
  remember: true,
});

const submit = () => {
  form.post(route('login'));
};

const handleQuickLogin = (role) => {
  window.location.href = route('quick-login', role);
};
</script>

<template>
  <Head title="Sign In - Veneno Auto Care" />

  <div class="min-h-screen flex items-center justify-center p-4 bg-zinc-950 text-zinc-100 font-sans">
    <div class="w-full max-w-md glass-panel p-8 rounded-3xl border border-zinc-800 shadow-2xl space-y-6">
      
      <!-- Back Link -->
      <Link :href="route('home')" class="inline-flex items-center gap-2 text-xs font-mono text-zinc-400 hover:text-white transition-colors">
        <ArrowLeft class="w-4 h-4" />
        <span>Back to Storefront</span>
      </Link>

      <!-- Header -->
      <div class="text-center">
        <div class="w-12 h-12 mx-auto rounded-2xl bg-gradient-to-br from-red-600 to-red-950 p-0.5 shadow-lg flex items-center justify-center mb-3">
          <div class="w-full h-full bg-zinc-950 rounded-[10px] flex items-center justify-center">
            <span class="text-red-500 font-black text-xl">V</span>
          </div>
        </div>
        <h1 class="text-2xl font-black text-white">VENENO AUTO CARE</h1>
        <p class="text-xs text-zinc-400 mt-1">Sign in to access VIP Garage, Bay Floor, or Management CRM</p>
      </div>

      <!-- Quick One-Click Demo Logins -->
      <div class="p-4 rounded-2xl bg-zinc-900/90 border border-zinc-800 space-y-2">
        <div class="text-[10px] font-mono uppercase tracking-wider text-zinc-400 font-bold flex items-center justify-between">
          <span>⚡ One-Click Demo Role Switcher</span>
          <span class="text-red-400">Instant Access</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <button
            @click="handleQuickLogin('admin')"
            class="p-2.5 rounded-xl bg-zinc-950/80 hover:bg-red-950/40 border border-zinc-800 hover:border-red-500/50 text-left transition-all group"
          >
            <div class="flex items-center gap-1.5 text-xs font-bold text-white group-hover:text-red-400">
              <LayoutDashboard class="w-3.5 h-3.5 text-red-500" />
              <span>Super Admin</span>
            </div>
            <div class="text-[10px] text-zinc-500">Full CRM & Revenue</div>
          </button>

          <button
            @click="handleQuickLogin('manager')"
            class="p-2.5 rounded-xl bg-zinc-950/80 hover:bg-blue-950/40 border border-zinc-800 hover:border-blue-500/50 text-left transition-all group"
          >
            <div class="flex items-center gap-1.5 text-xs font-bold text-white group-hover:text-blue-400">
              <UserCheck class="w-3.5 h-3.5 text-blue-400" />
              <span>Manager</span>
            </div>
            <div class="text-[10px] text-zinc-500">Staff & Campaigns</div>
          </button>

          <button
            @click="handleQuickLogin('technician')"
            class="p-2.5 rounded-xl bg-zinc-950/80 hover:bg-amber-950/40 border border-zinc-800 hover:border-amber-500/50 text-left transition-all group"
          >
            <div class="flex items-center gap-1.5 text-xs font-bold text-white group-hover:text-amber-400">
              <Wrench class="w-3.5 h-3.5 text-amber-400" />
              <span>Technician</span>
            </div>
            <div class="text-[10px] text-zinc-500">Live Bay Workflow</div>
          </button>

          <button
            @click="handleQuickLogin('customer')"
            class="p-2.5 rounded-xl bg-zinc-950/80 hover:bg-emerald-950/40 border border-zinc-800 hover:border-emerald-500/50 text-left transition-all group"
          >
            <div class="flex items-center gap-1.5 text-xs font-bold text-white group-hover:text-emerald-400">
              <Car class="w-3.5 h-3.5 text-emerald-400" />
              <span>VIP Client</span>
            </div>
            <div class="text-[10px] text-zinc-500">Alex (Porsche 911)</div>
          </button>
        </div>
      </div>

      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-4 text-xs">
        <div>
          <label class="block text-zinc-400 mb-1">Email Address</label>
          <div class="relative">
            <Mail class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3" />
            <input
              v-model="form.email"
              type="email"
              required
              placeholder="admin@venenoautocare.com"
              class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-red-500"
            />
          </div>
          <div v-if="form.errors.email" class="text-red-400 text-[11px] mt-1">{{ form.errors.email }}</div>
        </div>

        <div>
          <label class="block text-zinc-400 mb-1">Password</label>
          <div class="relative">
            <Lock class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3" />
            <input
              v-model="form.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-red-500"
            />
          </div>
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full py-3.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold uppercase tracking-wider text-xs shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin" />
          <span>Sign In</span>
        </button>
      </form>
    </div>
  </div>
</template>
