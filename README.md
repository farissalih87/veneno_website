# 🏎️ Veneno Auto Care Platform

> **Luxury & Exotic Automotive Detailing, Ceramic Coating & PPF Enterprise Platform**
> Built with **Laravel 11 (PHP 8.2+)**, **Inertia.js**, **Vue 3 (Composition API)**, **TailwindCSS**, and **MySQL**.

---

## ✨ Features & Architecture

### 🌟 1. Public Luxury Storefront
- **Cinematic Video Hero:** High-impact supercar backdrop with dynamic CTA buttons and accreditation badges.
- **Interactive Before/After Slider:** Touch and mouse drag slider demonstrating swirl removal and 9H graphene reflection depth.
- **Dynamic Pricing Calculator:** Prices adjust automatically based on body type (`sedan`, `coupe`, `suv`, `truck`, `exotic`).

### 📅 2. 5-Step Interactive Booking Engine
- **Step 1:** Vehicle body classification and client information.
- **Step 2:** Dynamic service selection + add-on toggles (Glass shield, wheel ceramic, engine bay).
- **Step 3:** Drop-off calendar & studio bay time slot selection.
- **Step 4:** Stripe Hybrid Checkout ($250 deposit or full payment option with card simulation).
- **Step 5:** Instant reservation confirmation with printable receipt (`VEN-XXXX`) and celebration confetti.

### 💬 3. WhatsApp Lead Capture & CRM Sync
- Floating luxury concierge widget capturing customer leads directly into MySQL `inquiries` table while generating a pre-filled WhatsApp chat link with formatted message parameters.

### 🚗 4. Customer VIP Garage & Live Bay Tracker
- Vehicle registry with loyalty points balance (`Silver`, `Gold`, `VIP Platinum`).
- Live 6-stage milestone tracker (`Bay Booked` ➔ `Decon Wash` ➔ `Paint Correction` ➔ `9H Ceramic Cure` ➔ `50-Point QC` ➔ `Handover`).
- Digital invoice history and CarFax detailing records.

### 🔧 5. Technician Bay Operations Board
- Kanban-style bay floor allowing technicians to advance jobs through workflow stages, with instant status synchronization to customer tracking timelines.

### 📊 6. Staff CRM & Executive Analytics
- Key financial KPIs (YTD Revenue: $360K+, Average Ticket Size: $1,246, 67.3% Gross Margin).
- Automated Marketing Campaign Studio with target segmentation (`VIP`, `Ceramic Due`, `Inactive 90d`).
- WhatsApp customer lead inbox with status converter (`New` ➔ `Contacted` ➔ `Converted to Booking`).

---

## 🛠️ Tech Stack & Requirements

- **PHP:** 8.2 or higher
- **Composer:** 2.x
- **Node.js:** 18+ & NPM
- **Database:** MySQL 8.0+ or MariaDB (e.g. XAMPP)
- **Frameworks:** Laravel 11, Inertia.js, Vue 3, TailwindCSS v4, Lucide Icons, Canvas Confetti

---

## 🚀 Quick Start & Installation

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/veneno-auto-care.git
cd veneno-auto-care
```

### 2. Install PHP & Node Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with your MySQL database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veneno_autocare_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 5. Build Assets & Start Local Server
```bash
# Build Vue frontend assets
npm run build

# Start Laravel backend server
php artisan serve --port=8000
```
Open **`http://127.0.0.1:8000`** in your browser.

---

## 🔑 Demo Role Accounts

| Role | Email | Password | Access Area |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@venenoautocare.com` | `password` | Full CRM & Revenue Analytics |
| **Operations Manager** | `manager@venenoautocare.com` | `password` | Staff & Campaigns Management |
| **Lead Technician** | `marcus@venenoautocare.com` | `password` | Live Bay Workflow Board |
| **VIP Customer** | `alex@example.com` | `password` | VIP Garage & Live Bay Tracker |

*Tip: You can also use the One-Click Demo Role Switcher in the top right user icon on the navbar.*

---

## 📄 License
Proprietary luxury automotive software. Built for **Veneno Auto Care**.
