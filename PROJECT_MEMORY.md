# Veneno Auto Care Platform — Comprehensive Architecture & Memory

## 1. Project Overview & Identity
- **Project Name:** Veneno Auto Care Center (Official Website & ADIHEX 2026 Platform)
- **Domain:** `https://veneno.ae`
- **Location:** Musaffah M37, Abu Dhabi, UAE (`📍 مصفح M37، أبوظبي` • `02 634 4403`)
- **Brand Aesthetic:** Sleek dark luxury theme (`#070709`, `#121216`), Veneno brushed gold (`#c5a059`, `#e5c07b`, `#9a7b38`), crimson red accents (`#ef4444`), glassmorphism, responsive micro-animations.

---

## 2. Server Infrastructure & Remote SSH Access
- **Host:** `91.134.84.187`
- **Port:** `22`
- **User:** `venenoae`
- **Password:** `Veneno@2023`
- **Remote Root:** `/home/venenoae/public_html`
- **Automated Deployment:** `python scripts/deploy_live.py`
- **Data Reset Tool:** `python scripts/wipe_test_data.py`

---

## 3. Tech Stack & Integration Ecosystem
- **Backend:** Laravel 11 (PHP 8.2+) with MySQL Database
- **Frontend:** Vue 3 (Composition API) + Inertia.js + TailwindCSS v4 + Vite 6
- **SMS Gateway:** SMSGlobal HTTP API (`app/Services/SmsGlobalService.php`) — Sender: `Veneno`
- **Payment Gateway:** Stripe Payments API (`app/Http/Controllers/AdihexController.php`)
- **Email Service:** Laravel Mail with blade templates (`resources/views/emails/adihex_voucher.blade.php`)

---

## 4. Core Features & Campaigns

### A. ADIHEX 2026 Interactive Experience (`/adihex`)
- 7-Step gamified lead capture with high-frame-rate canvas spin wheel.
- Generates dynamic unique voucher codes (`VEN-ADIHEX-XXXX`) with 60-day expiry.
- Automated instant SMS delivery via SMSGlobal.
- Strict 1-chance-per-phone validation to prevent duplicate entries.
- SMS voucher is the official proof of prize redemption.

### B. 22-Inch Portrait Digital Signage Kiosk (`/adihex/display`)
- 60 FPS gold & crimson embers canvas background engine.
- High-res QR code with embedded official red Veneno emblem and laser scanline animation.
- Bilingual typography (`SCAN • SPIN • WIN` / `امسح • أدِر • اربح`).
- Native Screen Wake Lock API and borderless fullscreen toggle.
- 4-Box live synchronized countdown to 6 September 2026.

### C. Admin CRM Hub (`/dashboard`)
- Full telemetry for live leads, prize winners, deposit payments, and voucher redemption tracking.

---

## 5. Standard Commands
```bash
npm run build
python scripts/deploy_live.py
python scripts/wipe_test_data.py
git add -A; git commit -m "feat: update"; git push origin main
```
