# Veneno Auto Care Platform — Project Memory & System Architecture

## 1. Project Overview & Identity
- **Project Name:** Veneno Auto Care Center (Official Website & ADIHEX 2026 Platform)
- **Production URL:** `https://veneno.ae`
- **Location:** Musaffah M37, Abu Dhabi, UAE (`📍 مصفح M37، أبوظبي` • `02 634 4403`)
- **Brand Palette:**
  - Veneno Brushed Gold: `#c5a059`, Highlight Gold: `#e5c07b`, Deep Gold: `#9a7b38`
  - Veneno Red / Crimson: `#ef4444`, Deep Maroon: `#990000`, Glowing Aura: `rgba(239,68,68,0.4)`
  - Obsidian Carbon Background: `#070709`, Dark Titanium: `#121216`, Pure White Contrast: `#ffffff`

---

## 2. Server Infrastructure & SSH Deployment
- **Live Server Host:** `91.134.84.187`
- **SSH Port:** `22`
- **SSH User:** `venenoae`
- **SSH Password:** `Veneno@2023`
- **Remote Web Root:** `/home/venenoae/public_html`
- **Deployment Automation:** `python scripts/deploy_live.py` (Deploys PHP controllers, Vue pages, build chunks, images, runs artisan optimizations & remote migrations)
- **Data Maintenance Script:** `python scripts/wipe_test_data.py` (Truncates test leads/vouchers from `adihex_leads`)

---

## 3. Tech Stack
- **Backend:** Laravel 11 (PHP 8.2+) with MySQL Database
- **Frontend:** Vue 3 (Composition API) + Inertia.js + TailwindCSS v4 + Vite 6
- **SMS Gateway:** SMSGlobal API via `app/Services/SmsGlobalService.php` (Sender ID: `Veneno`, Key: `291932f32f3fcf2f42a9b31952e46b0a`)
- **Payment Processing:** Stripe Payments API (`app/Http/Controllers/AdihexController.php`)
- **Email Service:** Laravel Mail with blade templates (`resources/views/emails/adihex_voucher.blade.php`)

---

## 4. Key Campaign Features & Routes

### A. ADIHEX 2026 Interactive Experience (`/adihex`)
- **Route:** `https://veneno.ae/adihex` (and `/{locale}/adihex`)
- **7-Step Gamified Lead Capture Flow:**
  - Step 1: Language Selection (Arabic / English)
  - Step 2: Customer Registration (Name, Phone, Service Interest)
  - Step 3: Luxury 60 FPS Canvas Spin Wheel (`drawWheel()`)
  - Step 4: Instant Win Reveal & Voucher Code Generation (`VEN-ADIHEX-XXXX`)
  - Step 5: Exhibition Show Packages Carousel (PPF, Ceramic, Tint, Detailing)
  - Step 6: 500 AED Deposit Lock-in with Stripe Apple Pay / Card
  - Step 7: VIP Pass Confirmation + SMS & WhatsApp Concierge
- **Security & Fraud Prevention:**
  - **1 Chance Per Phone Policy:** Existing phone numbers are strictly blocked from re-spinning (returns 422 `already_participated: true` with SMS proof modal).
  - **SMS Proof of Redemption:** The official SMS delivered to the customer's phone is required at the booth/workshop to claim prizes.

### B. 22-Inch Portrait Digital Signage Kiosk (`/adihex/display` & `/adihex/screen`)
- **Route:** `https://veneno.ae/adihex/display`
- **Features:**
  - 60 FPS floating champagne gold & crimson embers particle canvas engine
  - Scannable Level H QR code with embedded official Veneno red square emblem and laser scanline sweep
  - Dual-language typography (`SCAN • SPIN • WIN` / `امسح • أدِر • اربح`)
  - Double-click / double-tap anywhere on screen for true borderless fullscreen
  - Native Screen Wake Lock API (`navigator.wakeLock.request('screen')`) to keep 22" booth display awake 24/7
  - 4-Box live synchronized countdown to 6 September 2026

### C. Admin CRM & Dashboard (`/dashboard`)
- **Controller:** `app/Http/Controllers/DashboardController.php`
- **Model:** `app/Models/AdihexLead.php` (`adihex_leads` table)
- Tracks live visitors, spin winners, package reservations, deposits paid, and voucher redemption status.

---

## 5. Development & Deployment Cheatsheet
```bash
# 1. Build Production Assets
npm run build

# 2. Deploy Live to Production Server
python scripts/deploy_live.py

# 3. Wipe Test Customers & Reset Leads Database
python scripts/wipe_test_data.py

# 4. Git Synchronize
git add -A; git commit -m "update message"; git push origin main
```
