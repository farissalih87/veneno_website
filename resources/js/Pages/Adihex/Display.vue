<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import QRCode from 'qrcode';
import { 
  Sparkles, 
  Maximize2, 
  Minimize2, 
  Globe, 
  ShieldCheck, 
  Flame, 
  Trophy, 
  Camera, 
  Zap 
} from 'lucide-vue-next';

const props = defineProps({
  initialLocale: { type: String, default: 'ar' },
  prizes: { type: Array, default: () => [] },
  packages: { type: Array, default: () => [] },
  targetUrl: { type: String, default: 'https://veneno.ae/adihex' },
  stats: { type: Object, default: () => ({ displaySpinCount: 184 }) },
});

// Current Locale & Auto-Cycle (Every 8 seconds)
const currentLocale = ref(props.initialLocale || 'ar');
let localeInterval = null;
const isAutoCycling = ref(true);

const toggleLanguage = () => {
  currentLocale.value = currentLocale.value === 'ar' ? 'en' : 'ar';
};

// Fullscreen State
const isFullscreen = ref(false);
const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(() => {});
    isFullscreen.value = true;
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen().catch(() => {});
      isFullscreen.value = false;
    }
  }
};

// Screen Wake Lock API (Keep display awake indefinitely)
let wakeLock = null;
const requestWakeLock = async () => {
  try {
    if ('wakeLock' in navigator) {
      wakeLock = await navigator.wakeLock.request('screen');
    }
  } catch (err) {
    console.log('Wake Lock Error:', err);
  }
};

// Active Rotating Prize Index
const activePrizeIndex = ref(0);
let prizeInterval = null;

// Countdown to ADIHEX Close (6 Sept 2026 22:00:00 GST)
const countdown = ref({ days: '00', hours: '00', minutes: '00', seconds: '00' });
let countdownTimer = null;

const calculateCountdown = () => {
  const now = new Date().getTime();
  const targetDate = new Date('2026-09-06T22:00:00+04:00').getTime();
  const diff = Math.max(0, targetDate - now);

  const pad = (n) => String(n).padStart(2, '0');
  countdown.value = {
    days: pad(Math.floor(diff / (1000 * 60 * 60 * 24))),
    hours: pad(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))),
    minutes: pad(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))),
    seconds: pad(Math.floor((diff % (1000 * 60)) / 1000)),
  };
};

// Canvas References
const qrCanvasRef = ref(null);
const bgCanvasRef = ref(null);
let bgAnimationId = null;

// Generate Ultra-Sharp Luxury QR Code with Embedded Veneno Official Emblem
const generateLuxuryQR = async () => {
  if (!qrCanvasRef.value) return;
  const canvas = qrCanvasRef.value;
  const qrSize = 560; // High-res for crisp mobile camera scanning from distance
  canvas.width = qrSize;
  canvas.height = qrSize;

  try {
    // Generate QR with High Error Correction
    await QRCode.toCanvas(canvas, props.targetUrl, {
      width: qrSize,
      margin: 2,
      color: {
        dark: '#000000',
        light: '#ffffff',
      },
      errorCorrectionLevel: 'H',
    });

    const ctx = canvas.getContext('2d');
    const center = qrSize / 2;
    const emblemSize = 104;
    const emblemRadius = 22;
    const halfSize = emblemSize / 2;
    const x = center - halfSize;
    const y = center - halfSize;

    // Load the official Veneno square badge icon
    const emblemImg = new Image();
    emblemImg.crossOrigin = 'anonymous';
    emblemImg.src = '/images/adihex/veneno-qr-emblem.png';

    await new Promise((resolve) => {
      emblemImg.onload = () => {
        ctx.save();
        
        // White outer backing with gold border for crisp QR matrix isolation
        ctx.beginPath();
        if (typeof ctx.roundRect === 'function') {
          ctx.roundRect(x - 5, y - 5, emblemSize + 10, emblemSize + 10, emblemRadius + 3);
        } else {
          ctx.rect(x - 5, y - 5, emblemSize + 10, emblemSize + 10);
        }
        ctx.fillStyle = '#ffffff';
        ctx.fill();
        ctx.lineWidth = 3;
        ctx.strokeStyle = '#c5a059'; // Luxury gold stroke
        ctx.stroke();

        // Clip and draw official red Veneno icon
        ctx.beginPath();
        if (typeof ctx.roundRect === 'function') {
          ctx.roundRect(x, y, emblemSize, emblemSize, emblemRadius);
        } else {
          ctx.rect(x, y, emblemSize, emblemSize);
        }
        ctx.clip();
        ctx.drawImage(emblemImg, x, y, emblemSize, emblemSize);
        ctx.restore();

        resolve();
      };
      emblemImg.onerror = resolve;
    });
  } catch (err) {
    console.error('QR Generation failed:', err);
  }
};

// 60 FPS Particle & Gold Embers Background Engine
const initParticleBackground = () => {
  if (!bgCanvasRef.value) return;
  const canvas = bgCanvasRef.value;
  const ctx = canvas.getContext('2d');

  let width = (canvas.width = window.innerWidth);
  let height = (canvas.height = window.innerHeight);

  window.addEventListener('resize', () => {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  });

  const particles = [];
  const numParticles = 65;

  for (let i = 0; i < numParticles; i++) {
    particles.push({
      x: Math.random() * width,
      y: Math.random() * height,
      radius: Math.random() * 2.2 + 0.8,
      speedY: Math.random() * 0.7 + 0.3,
      speedX: (Math.random() - 0.5) * 0.4,
      alpha: Math.random() * 0.7 + 0.3,
      fadeSpeed: Math.random() * 0.01 + 0.005,
      isGold: Math.random() > 0.3, // 70% Gold embers, 30% Crimson embers
    });
  }

  const render = () => {
    ctx.clearRect(0, 0, width, height);

    // Deep Luxury Vignette
    const radialGrad = ctx.createRadialGradient(
      width / 2,
      height * 0.45,
      100,
      width / 2,
      height * 0.45,
      Math.max(width, height) * 0.75
    );
    radialGrad.addColorStop(0, 'rgba(185, 28, 28, 0.12)'); // Central Crimson Aura
    radialGrad.addColorStop(0.4, 'rgba(197, 160, 89, 0.06)'); // Gold halo
    radialGrad.addColorStop(1, 'rgba(5, 5, 7, 0.95)'); // Deep Titanium/Black edges
    ctx.fillStyle = radialGrad;
    ctx.fillRect(0, 0, width, height);

    // Draw and update rising embers
    for (let p of particles) {
      p.y -= p.speedY;
      p.x += p.speedX;
      p.alpha += p.fadeSpeed;

      if (p.alpha > 0.9 || p.alpha < 0.2) {
        p.fadeSpeed = -p.fadeSpeed;
      }

      if (p.y < -10) {
        p.y = height + 10;
        p.x = Math.random() * width;
      }

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      ctx.fillStyle = p.isGold
        ? `rgba(245, 208, 115, ${p.alpha})`
        : `rgba(239, 68, 68, ${p.alpha})`;
      ctx.shadowColor = p.isGold ? '#c5a059' : '#ef4444';
      ctx.shadowBlur = p.radius * 4;
      ctx.fill();
    }

    bgAnimationId = requestAnimationFrame(render);
  };

  render();
};

onMounted(() => {
  generateLuxuryQR();
  initParticleBackground();
  requestWakeLock();

  // Auto-cycle language every 8s
  localeInterval = setInterval(() => {
    if (isAutoCycling.value) {
      currentLocale.value = currentLocale.value === 'ar' ? 'en' : 'ar';
    }
  }, 8000);

  // Rotate featured prize every 3.5s
  prizeInterval = setInterval(() => {
    activePrizeIndex.value = (activePrizeIndex.value + 1) % (props.prizes.length || 7);
  }, 3500);

  // Countdown timer tick
  calculateCountdown();
  countdownTimer = setInterval(calculateCountdown, 1000);

  document.addEventListener('fullscreenchange', () => {
    isFullscreen.value = !!document.fullscreenElement;
  });
});

onUnmounted(() => {
  if (localeInterval) clearInterval(localeInterval);
  if (prizeInterval) clearInterval(prizeInterval);
  if (countdownTimer) clearInterval(countdownTimer);
  if (bgAnimationId) cancelAnimationFrame(bgAnimationId);
  if (wakeLock) {
    wakeLock.release().catch(() => {});
  }
});
</script>

<template>
  <Head>
    <title>Veneno Auto Care × ADIHEX 2026 — Digital Kiosk Display</title>
  </Head>

  <div 
    class="relative w-screen h-screen overflow-hidden select-none bg-[#070709] text-white flex flex-col justify-between p-6 sm:p-10 font-sans"
    :dir="currentLocale === 'ar' ? 'rtl' : 'ltr'"
  >
    <!-- Background Canvas Engine (60 FPS Gold Embers & Ambient Aura) -->
    <canvas ref="bgCanvasRef" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Subtle Carbon Fiber Mesh Texture Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(#1f1f23_1px,transparent_1px)] [background-size:16px_16px] opacity-25 pointer-events-none z-0"></div>

    <!-- Hidden / Floating Kiosk Toolbar (Top Controls) -->
    <div class="absolute top-4 inset-x-6 sm:inset-x-10 flex items-center justify-between z-30 pointer-events-auto">
      <!-- Live Status Pill -->
      <div class="flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-zinc-950/80 border border-zinc-800/80 backdrop-blur-xl shadow-lg">
        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
        <span class="text-xs font-mono font-bold tracking-widest text-zinc-300 uppercase">
          {{ currentLocale === 'ar' ? 'جناح فينينو • أديهيكس 2026' : 'VENENO BOOTH • ADIHEX 2026' }}
        </span>
      </div>

      <!-- Quick Action Controls -->
      <div class="flex items-center gap-2">
        <button
          type="button"
          @click="toggleLanguage"
          class="px-3.5 py-1.5 rounded-xl bg-zinc-900/80 hover:bg-zinc-800 border border-zinc-700/80 text-amber-300 font-bold text-xs flex items-center gap-1.5 transition-all shadow-md active:scale-95 cursor-pointer backdrop-blur-md"
        >
          <Globe class="w-3.5 h-3.5" />
          <span>{{ currentLocale === 'ar' ? 'English' : 'العربية' }}</span>
        </button>

        <button
          type="button"
          @click="toggleFullscreen"
          class="p-2 rounded-xl bg-zinc-900/80 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 hover:text-white transition-all shadow-md active:scale-95 cursor-pointer backdrop-blur-md"
          :title="isFullscreen ? 'Exit Fullscreen' : 'Enter Fullscreen (22-inch Kiosk)'"
        >
          <Minimize2 v-if="isFullscreen" class="w-4 h-4" />
          <Maximize2 v-else class="w-4 h-4" />
        </button>
      </div>
    </div>

    <!-- ==========================================================
         TOP HEADER: DUAL BRAND BADGES
         ========================================================== -->
    <header class="relative z-10 pt-10 sm:pt-12 flex flex-col items-center text-center space-y-4">
      <!-- Dual Glowing Badges -->
      <div class="flex items-center justify-center gap-6 sm:gap-10">
        <!-- Veneno Logo -->
        <div class="flex items-center gap-3">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-zinc-950 border border-red-500/40 p-2.5 flex items-center justify-center shadow-xl shadow-red-950/40">
            <img src="/images/adihex/veneno-badge.png" alt="Veneno" class="w-full h-full object-contain drop-shadow-[0_0_12px_rgba(239,68,68,0.6)]" />
          </div>
          <div class="text-start">
            <span class="block text-lg sm:text-2xl font-black text-red-500 tracking-wider">VENENO</span>
            <span class="block text-[10px] sm:text-xs font-bold text-zinc-400 tracking-widest uppercase">AUTO CARE CENTER</span>
          </div>
        </div>

        <!-- Vertical Gold Divider -->
        <div class="h-10 w-[1.5px] bg-gradient-to-b from-transparent via-amber-500/80 to-transparent"></div>

        <!-- ADIHEX Logo -->
        <div class="flex items-center gap-3">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-zinc-950 border border-amber-500/40 p-2.5 flex items-center justify-center shadow-xl shadow-amber-950/40">
            <img src="/images/adihex/adihex-logo.png" alt="ADIHEX 2026" class="w-full h-full object-contain" />
          </div>
          <div class="text-start">
            <span class="block text-lg sm:text-2xl font-black text-amber-400 tracking-wider">ADIHEX 2026</span>
            <span class="block text-[10px] sm:text-xs font-bold text-zinc-400 tracking-widest uppercase">ADNEC ABU DHABI</span>
          </div>
        </div>
      </div>

      <!-- Main Exhibition Hook Title -->
      <div class="space-y-1.5 max-w-xl">
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white uppercase drop-shadow-md">
          <span class="bg-gradient-to-r from-red-500 via-amber-400 to-amber-200 bg-clip-text text-transparent">
            {{ currentLocale === 'ar' ? 'امسح • دوّر • اربح' : 'SCAN • SPIN • WIN' }}
          </span>
        </h1>
        <p class="text-xs sm:text-sm text-zinc-300 font-medium tracking-wide">
          {{ currentLocale === 'ar' 
            ? 'اربح جوائز فورية وقسائم خدمات مجانية تصل إلى 3,000 درهم في جناح فينينو' 
            : 'Win Instant VIP Detailing Vouchers & Complimentary Services Up to AED 3,000' }}
        </p>
      </div>
    </header>

    <!-- ==========================================================
         HERO CENTERPIECE: ULTRA LUXURY SCANNABLE QR CODE
         ========================================================== -->
    <main class="relative z-10 flex flex-col items-center justify-center my-auto py-2">
      <!-- Luxury Gold & Crimson Frame with Corner Accents -->
      <div class="relative group p-4 sm:p-5 rounded-[2.5rem] bg-gradient-to-b from-[#18181c] via-[#0d0d10] to-[#121216] border-2 border-[#c5a059] shadow-[0_0_60px_rgba(239,68,68,0.25)] flex flex-col items-center">
        
        <!-- Corner Gold / Red Brackets -->
        <div class="absolute -top-2 -left-2 w-7 h-7 border-t-4 border-l-4 border-red-500 rounded-tl-xl pointer-events-none"></div>
        <div class="absolute -top-2 -right-2 w-7 h-7 border-t-4 border-r-4 border-red-500 rounded-tr-xl pointer-events-none"></div>
        <div class="absolute -bottom-2 -left-2 w-7 h-7 border-b-4 border-l-4 border-amber-400 rounded-bl-xl pointer-events-none"></div>
        <div class="absolute -bottom-2 -right-2 w-7 h-7 border-b-4 border-r-4 border-amber-400 rounded-br-xl pointer-events-none"></div>

        <!-- Ambient Breathing Halo Glow Behind QR -->
        <div class="absolute inset-4 rounded-3xl bg-gradient-to-r from-red-600/20 via-amber-500/20 to-red-600/20 blur-xl animate-pulse pointer-events-none"></div>

        <!-- The White High-Contrast Canvas QR Mount with Laser Scanline -->
        <div class="relative p-3.5 sm:p-4 rounded-3xl bg-white shadow-2xl overflow-hidden flex items-center justify-center">
          <canvas ref="qrCanvasRef" class="w-[260px] h-[260px] sm:w-[340px] sm:h-[340px] block"></canvas>

          <!-- Laser Scanline Animation Sweep -->
          <div class="absolute inset-x-0 h-1.5 bg-gradient-to-r from-transparent via-red-500 to-transparent shadow-[0_0_15px_#ef4444] animate-scanline pointer-events-none"></div>
        </div>

        <!-- Scannable Instruction Banner -->
        <div class="mt-4 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-red-950/80 via-zinc-900 to-amber-950/80 border border-amber-500/40 text-center shadow-lg flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-red-600/30 border border-red-500/50 text-amber-300 flex items-center justify-center shrink-0">
            <Camera class="w-4 h-4" />
          </div>
          <div class="text-start">
            <span class="block text-xs sm:text-sm font-black text-amber-300 uppercase tracking-wider">
              {{ currentLocale === 'ar' ? 'امسح بكاميرا هاتفك للمشاركة' : 'POINT YOUR CAMERA TO PLAY' }}
            </span>
            <span class="block text-[10px] sm:text-[11px] font-mono text-zinc-300">
              {{ props.targetUrl }}
            </span>
          </div>
        </div>

      </div>

      <!-- Live Dynamic Prize Carousel Ticker -->
      <div class="mt-5 w-full max-w-md">
        <div class="p-3.5 rounded-2xl bg-zinc-950/90 border border-zinc-800/90 shadow-xl backdrop-blur-xl flex items-center justify-between gap-3">
          <div class="flex items-center gap-2.5">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center shrink-0">
              <Trophy class="w-5 h-5" />
            </div>
            <div class="text-start">
              <span class="text-[10px] font-mono uppercase tracking-widest text-zinc-400 font-bold block">
                {{ currentLocale === 'ar' ? '🎁 جوائز السحب الفوري:' : '🎁 FEATURED PRIZE:' }}
              </span>
              <span class="text-xs sm:text-sm font-black text-white block transition-all duration-300">
                {{ props.prizes[activePrizeIndex] 
                  ? (currentLocale === 'ar' ? props.prizes[activePrizeIndex].label_ar : props.prizes[activePrizeIndex].label_en)
                  : (currentLocale === 'ar' ? 'غسيل دايموند مجاني بقيمة 250 درهم' : 'Free Diamond Car Wash (Worth AED 250)') }}
              </span>
            </div>
          </div>

          <div class="px-2.5 py-1 rounded-lg bg-red-600/20 border border-red-500/40 text-[10.5px] font-mono font-black text-red-400 shrink-0">
            {{ currentLocale === 'ar' ? '100% مجاناً' : '100% FREE' }}
          </div>
        </div>
      </div>
    </main>

    <!-- ==========================================================
         FOOTER: EXHIBITION COUNTDOWN & VENENO LOCATOR
         ========================================================== -->
    <footer class="relative z-10 flex flex-col items-center text-center space-y-3 pb-2">
      <!-- 4-Box Countdown Timer Card (Ends in 6 SEPT 2026 10:00pm) -->
      <div class="w-full max-w-sm px-4 py-2.5 rounded-2xl bg-zinc-950/90 border border-zinc-800/90 backdrop-blur-xl shadow-xl flex flex-col items-center">
        <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5 font-mono">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
          <span>{{ currentLocale === 'ar' ? 'اختتام فعاليات المعرض في 6 سبتمبر 2026' : 'EXHIBITION CONCLUDES 6 SEPT 2026' }}</span>
        </div>

        <div class="grid grid-cols-4 gap-2 w-full max-w-[260px]">
          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.days }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">{{ currentLocale === 'ar' ? 'أيام' : 'DAYS' }}</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.hours }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">{{ currentLocale === 'ar' ? 'ساعات' : 'HOURS' }}</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.minutes }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">{{ currentLocale === 'ar' ? 'دقائق' : 'MINS' }}</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-red-500 font-mono">{{ countdown.seconds }}</span>
            </div>
            <span class="text-[8px] font-bold text-red-400 mt-0.5">{{ currentLocale === 'ar' ? 'ثواني' : 'SECS' }}</span>
          </div>
        </div>
      </div>

      <!-- Workshop Location & Website Pill -->
      <div class="flex items-center justify-center gap-3 text-[11px] font-mono text-zinc-400">
        <span>📍 مصفح M37، أبوظبي</span>
        <span>•</span>
        <span class="text-amber-400 font-bold">veneno.ae</span>
        <span>•</span>
        <span>02 634 4403</span>
      </div>
    </footer>

  </div>
</template>

<style scoped>
@keyframes scanline {
  0% {
    top: 0%;
    opacity: 0.8;
  }
  50% {
    top: 100%;
    opacity: 1;
  }
  100% {
    top: 0%;
    opacity: 0.8;
  }
}

.animate-scanline {
  animation: scanline 3.2s ease-in-out infinite;
}
</style>
