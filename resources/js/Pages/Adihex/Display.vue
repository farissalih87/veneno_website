<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import QRCode from 'qrcode';
import { Camera } from 'lucide-vue-next';

const props = defineProps({
  targetUrl: { type: String, default: 'https://veneno.ae/adihex' },
});

// Fullscreen State (Double click anywhere on screen)
const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(() => {});
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen().catch(() => {});
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
  const numParticles = 75;

  for (let i = 0; i < numParticles; i++) {
    particles.push({
      x: Math.random() * width,
      y: Math.random() * height,
      radius: Math.random() * 2.4 + 0.8,
      speedY: Math.random() * 0.7 + 0.3,
      speedX: (Math.random() - 0.5) * 0.4,
      alpha: Math.random() * 0.7 + 0.3,
      fadeSpeed: Math.random() * 0.01 + 0.005,
      isGold: Math.random() > 0.3,
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
    radialGrad.addColorStop(0, 'rgba(185, 28, 28, 0.14)');
    radialGrad.addColorStop(0.4, 'rgba(197, 160, 89, 0.07)');
    radialGrad.addColorStop(1, 'rgba(5, 5, 7, 0.96)');
    ctx.fillStyle = radialGrad;
    ctx.fillRect(0, 0, width, height);

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

  calculateCountdown();
  countdownTimer = setInterval(calculateCountdown, 1000);
});

onUnmounted(() => {
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
    @dblclick="toggleFullscreen"
    class="relative w-screen h-screen overflow-hidden select-none bg-[#070709] text-white flex flex-col justify-between items-center p-6 sm:p-10 font-sans"
  >
    <!-- Background Canvas Engine (60 FPS Gold Embers & Ambient Aura) -->
    <canvas ref="bgCanvasRef" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Subtle Carbon Fiber Mesh Texture Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(#1f1f23_1px,transparent_1px)] [background-size:16px_16px] opacity-25 pointer-events-none z-0"></div>

    <!-- ==========================================================
         TOP HEADER: MULTILINGUAL BOLD TITLES (MATCHES QR WIDTH)
         ========================================================== -->
    <header class="relative z-10 pt-4 sm:pt-6 flex flex-col items-center text-center w-full max-w-sm sm:max-w-md md:max-w-lg space-y-1.5">
      <!-- English Title -->
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight uppercase leading-tight drop-shadow-xl">
        <span class="bg-gradient-to-r from-red-500 via-amber-400 to-amber-200 bg-clip-text text-transparent">
          SCAN • SPIN • WIN
        </span>
      </h1>

      <!-- Arabic Title -->
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-normal leading-tight drop-shadow-xl" dir="rtl">
        <span class="bg-gradient-to-r from-amber-200 via-amber-400 to-red-500 bg-clip-text text-transparent font-['Cairo',sans-serif]">
          امسح • دوّر • اربح
        </span>
      </h2>
    </header>

    <!-- ==========================================================
         HERO CENTERPIECE: ULTRA LUXURY SCANNABLE QR CODE
         ========================================================== -->
    <main class="relative z-10 flex flex-col items-center justify-center my-auto w-full max-w-sm sm:max-w-md md:max-w-lg">
      <!-- Luxury Gold & Crimson Frame with Corner Accents -->
      <div class="w-full relative group p-4 sm:p-5 rounded-[2.5rem] bg-gradient-to-b from-[#18181c] via-[#0d0d10] to-[#121216] border-2 border-[#c5a059] shadow-[0_0_60px_rgba(239,68,68,0.25)] flex flex-col items-center">
        
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
        <div class="mt-3.5 w-full px-4 py-2.5 rounded-2xl bg-gradient-to-r from-red-950/80 via-zinc-900 to-amber-950/80 border border-amber-500/40 text-center shadow-lg flex items-center justify-center gap-2.5">
          <div class="w-7 h-7 rounded-xl bg-red-600/30 border border-red-500/50 text-amber-300 flex items-center justify-center shrink-0">
            <Camera class="w-4 h-4" />
          </div>
          <div class="text-start">
            <span class="block text-xs sm:text-sm font-black text-amber-300 uppercase tracking-wider">
              POINT YOUR CAMERA TO PLAY • امسح بالكاميرا للمشاركة
            </span>
          </div>
        </div>

      </div>

      <!-- Multilingual Replaced Subtitle Container (Replaces Prize Carousel) -->
      <div class="mt-4 w-full p-4 rounded-2xl bg-zinc-950/90 border border-zinc-800/90 shadow-xl backdrop-blur-xl text-center space-y-2">
        <p class="text-xs sm:text-sm md:text-base font-bold text-amber-300 leading-snug tracking-wide">
          Win Instant VIP Detailing Vouchers & Complimentary Services Up to AED 3,000
        </p>
        <div class="h-[1px] w-3/4 mx-auto bg-gradient-to-r from-transparent via-amber-500/40 to-transparent"></div>
        <p class="text-xs sm:text-sm md:text-base font-bold text-zinc-100 leading-snug tracking-normal font-['Cairo',sans-serif]" dir="rtl">
          اربح جوائز فورية وقسائم خدمات مجانية تصل إلى 3,000 درهم في جناح فينينو
        </p>
      </div>
    </main>

    <!-- ==========================================================
         FOOTER: EXHIBITION COUNTDOWN ONLY
         ========================================================== -->
    <footer class="relative z-10 flex flex-col items-center text-center pb-2 w-full">
      <!-- 4-Box Countdown Timer Card Only -->
      <div class="w-full max-w-sm px-4 py-2.5 rounded-2xl bg-zinc-950/90 border border-zinc-800/90 backdrop-blur-xl shadow-xl flex flex-col items-center">
        <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5 font-mono">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
          <span>ADIHEX 2026 • اختتام الفعاليات في 6 سبتمبر</span>
        </div>

        <div class="grid grid-cols-4 gap-2 w-full max-w-[260px]">
          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.days }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">DAYS / أيام</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.hours }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">HOURS / ساعات</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-white font-mono">{{ countdown.minutes }}</span>
            </div>
            <span class="text-[8px] font-bold text-amber-400 mt-0.5">MINS / دقائق</span>
          </div>

          <div class="flex flex-col items-center">
            <div class="w-full h-10 rounded-lg bg-[#1a1a1d] border border-zinc-700/70 flex items-center justify-center">
              <span class="text-base font-black text-red-500 font-mono">{{ countdown.seconds }}</span>
            </div>
            <span class="text-[8px] font-bold text-red-400 mt-0.5">SECS / ثواني</span>
          </div>
        </div>
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
