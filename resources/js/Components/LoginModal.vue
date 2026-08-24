<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { X, ShieldCheck, UserCheck, Wrench, LayoutDashboard, Car, Lock, Mail, ArrowRight, Loader2 } from 'lucide-vue-next';
import InternationalPhoneInput from './InternationalPhoneInput.vue';

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(['close']);

const isRegisterMode = ref(false);

const loginForm = useForm({
  email: '',
  password: '',
  remember: true,
});

const registerForm = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
});

const handleLogin = () => {
  loginForm.post(route('login'), {
    onSuccess: () => emit('close'),
  });
};

const handleRegister = () => {
  registerForm.post(route('register'), {
    onSuccess: () => emit('close'),
  });
};

const handleQuickLogin = (role) => {
  window.location.href = route('quick-login', role);
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
    <div class="w-full max-w-md glass-panel rounded-3xl border border-zinc-800 shadow-2xl p-6 relative animate-in fade-in zoom-in-95 duration-200">
      
      <!-- Close Button -->
      <button
        @click="emit('close')"
        class="absolute top-5 right-5 p-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white transition-colors"
      >
        <X class="w-5 h-5" />
      </button>

      <!-- Header -->
      <div class="text-center mb-6">
        <img 
          src="/images/logo.png" 
          alt="Veneno Auto Care" 
          title="Veneno Auto Care" 
          class="h-11 w-auto mx-auto object-contain mb-3" 
        />
        <p class="text-xs text-zinc-400">Sign in to access VIP Garage, Technician Bay, or Management CRM</p>
      </div>

      <!-- Quick Demo Switcher Panel -->
      <div class="mb-6 p-3.5 rounded-2xl bg-zinc-900/90 border border-zinc-800 space-y-2">
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
              <span>Operations Manager</span>
            </div>
            <div class="text-[10px] text-zinc-500">Staff & Campaigns</div>
          </button>

          <button
            @click="handleQuickLogin('technician')"
            class="p-2.5 rounded-xl bg-zinc-950/80 hover:bg-amber-950/40 border border-zinc-800 hover:border-amber-500/50 text-left transition-all group"
          >
            <div class="flex items-center gap-1.5 text-xs font-bold text-white group-hover:text-amber-400">
              <Wrench class="w-3.5 h-3.5 text-amber-400" />
              <span>Lead Technician</span>
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
            <div class="text-[10px] text-zinc-500">Alex Sterling (Porsche)</div>
          </button>
        </div>
      </div>

      <!-- Mode Switcher -->
      <div class="flex border-b border-zinc-800 mb-4 text-xs font-semibold">
        <button
          @click="isRegisterMode = false"
          class="flex-1 py-2 text-center transition-colors border-b-2"
          :class="!isRegisterMode ? 'text-red-500 border-red-500' : 'text-zinc-400 border-transparent hover:text-zinc-200'"
        >
          Sign In
        </button>
        <button
          @click="isRegisterMode = true"
          class="flex-1 py-2 text-center transition-colors border-b-2"
          :class="isRegisterMode ? 'text-red-500 border-red-500' : 'text-zinc-400 border-transparent hover:text-zinc-200'"
        >
          Create VIP Account
        </button>
      </div>

      <!-- Login Form -->
      <form v-if="!isRegisterMode" @submit.prevent="handleLogin" class="space-y-3.5 text-xs">
        <div>
          <label class="block text-zinc-400 mb-1">Email Address</label>
          <div class="relative">
            <Mail class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3" />
            <input
              v-model="loginForm.email"
              type="email"
              required
              placeholder="admin@venenoautocare.com"
              class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-red-500"
            />
          </div>
          <div v-if="loginForm.errors.email" class="text-red-400 text-[11px] mt-1">{{ loginForm.errors.email }}</div>
        </div>

        <div>
          <label class="block text-zinc-400 mb-1">Password</label>
          <div class="relative">
            <Lock class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3" />
            <input
              v-model="loginForm.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white placeholder-zinc-600 focus:outline-none focus:border-red-500"
            />
          </div>
        </div>

        <button
          type="submit"
          :disabled="loginForm.processing"
          class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="loginForm.processing" class="w-4 h-4 animate-spin" />
          <span>Sign In</span>
        </button>
      </form>

      <!-- Register Form -->
      <form v-else @submit.prevent="handleRegister" class="space-y-3 text-xs">
        <div>
          <label class="block text-zinc-400 mb-1">Full Name</label>
          <input
            v-model="registerForm.name"
            type="text"
            required
            placeholder="John Doe"
            class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
          />
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div>
            <label class="block text-zinc-400 mb-1">Email</label>
            <input
              v-model="registerForm.email"
              type="email"
              required
              placeholder="john@example.com"
              class="w-full px-3 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1">Phone Number</label>
            <InternationalPhoneInput
              v-model="registerForm.phone"
              :required="true"
              input-class="text-xs"
            />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div>
            <label class="block text-zinc-400 mb-1">Password</label>
            <input
              v-model="registerForm.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full px-3 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
            />
          </div>
          <div>
            <label class="block text-zinc-400 mb-1">Confirm</label>
            <input
              v-model="registerForm.password_confirmation"
              type="password"
              required
              placeholder="••••••••"
              class="w-full px-3 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500 text-xs"
            />
          </div>
        </div>

        <button
          type="submit"
          :disabled="registerForm.processing"
          class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition-all disabled:opacity-50"
        >
          <Loader2 v-if="registerForm.processing" class="w-4 h-4 animate-spin" />
          <span>Register & Claim 100 VIP Points</span>
        </button>
      </form>

    </div>
  </div>
</template>
