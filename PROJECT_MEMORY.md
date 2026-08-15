# Veneno Auto Care Platform - Comprehensive Architecture & Memory

## 1. Project Overview & Identity
- **Project Name:** Veneno Auto Care Platform
- **Domain:** Luxury & Exotic Automotive Detailing, Ceramic Coating, PPF, Paint Correction, Interior Restoration & Window Tinting.
- **Brand Aesthetic:** Sleek, high-end dark luxury theme (`zinc-950`, gold/red accents `red-600`, glassmorphism, responsive micro-animations, interactive before/after comparison sliders).

---

## 2. Tech Stack & Infrastructure
- **Frontend Framework:** React 19 + TypeScript + Vite 6
- **Styling:** TailwindCSS v4 + Lucide React Icons + Framer Motion (`motion`)
- **Effects & UI:** `canvas-confetti`, custom interactive SVG sliders, responsive modal dialogs
- **Backend / API Engine:** Express 4 on Node.js running via `tsx`
- **AI Integration:** `@google/genai` (Gemini 3.7 Flash) for AI Vehicle Inspection, Detailing Quote Estimation, and AI Luxury Marketing Copy Generation.
- **State Management:** React Context API (`AppContext`, `AuthContext`) with persistent state patterns and real-time reactive updates.

---

## 3. Core Modules & User Flows

### A. Customer-Facing Storefront & Portal
1. **Hero & Dynamic Showcase (`HomePage.tsx`):**
   - Interactive service cards, before/after interactive image sliders, pricing calculator teaser, client testimonials, and workshop stats.
2. **Detailed Service Pages (`ServiceLandingPage.tsx`):**
   - Deep-dive into service categories (Diamond Ceramic, Self-Healing PPF, Multi-Stage Correction, Interior Rejuvenation, Ceramic Tinting, Engine Bay).
   - Dynamic price adjustment based on vehicle type (`sedan`, `coupe`, `suv`, `truck`, `exotic`).
3. **5-Step Booking Wizard (`BookingWizard.tsx`):**
   - Step 1: Vehicle selection (Make, Model, Year, Color, Type, License Plate).
   - Step 2: Service & Add-ons selection with real-time dynamic pricing calculation.
   - Step 3: Date, Time slot selection & Special handling instructions.
   - Step 4: Stripe Checkout simulation & Authorization ($250 deposit or full payment).
   - Step 5: Instant Booking Confirmation with printable receipt, reservation code (`VEN-XXXX`), and confetti animation.
4. **AI Detailing Quote & Inspection Advisor (`AIQuoteAdvisor.tsx`):**
   - Intelligent analysis using Gemini AI: predicts required detailing stages, hours, price range, urgency level, and custom add-on recommendations.
5. **Customer VIP Portal (`CustomerPortal.tsx`):**
   - Vehicle registry, active detailing job tracking, inspection reports, invoice downloads, loyalty tier status (`Silver`, `Gold`, `VIP Platinum`), and booking history.
6. **WhatsApp Chat & Inquiry Widget (`WhatsAppWidget.tsx`):**
   - Direct lead generation floating widget; logs inquiries directly to the CRM database backend.

### B. Workshop & Business Operations
1. **Technician Bay Portal (`TechnicianPortal.tsx`):**
   - Live bay status tracker with interactive workflow stages:
     - `Bay Booked & Check-In` -> `Paint Correction & Polish` -> `Ceramic / PPF Application` -> `Heat Curing & Final QC` -> `Ready for Customer Pickup`
   - Upload inspection notes, add stage milestones, and track technician ratings.
2. **Staff & Admin CRM Hub (`DashboardLayout.tsx`):**
   - **Bay Jobs & Bookings (`BookingsManagement.tsx`):** Kanban pipeline board + list view with stage movement and status filtering.
   - **Client Database & CRM (`ClientManagement.tsx`):** Customer records, spend metrics, loyalty tiers, vehicle profiles, and direct customer communication triggers.
   - **Inquiries Management (`InquiriesManagement.tsx`):** WhatsApp/web inquiries inbox with lead conversion directly into bookings.
   - **Marketing Campaign Studio (`MarketingCampaigns.tsx`):** AI-powered luxury copywriter for SMS/Email/WhatsApp campaigns with discount generator, audience segmentation, and ROI metrics.
   - **Revenue & Financial Analytics (`RevenueAnalytics.tsx`):** Monthly revenue charts, profit margins, average ticket value, and category-level breakdown.
   - **Staff & Team Management (`StaffManagement.tsx`):** Role-based access control (`super_admin`, `manager`, `technician`, `receptionist`), granular permissions, and job allocations.

---

## 4. API & Backend Endpoints (`server.ts`)
- `GET /api/health` - Server health check & Gemini API key status
- `POST /api/gemini/quote-estimate` - AI Vehicle appraisal & package recommender
- `POST /api/gemini/marketing-copy` - AI luxury promotional copy generator
- `POST /api/stripe/create-checkout-session` - Stripe card payment authorization & session creation
- `POST /api/inquiries` - CRM lead logger for WhatsApp & Web inquiries

---

## 5. Development & Testing Commands
- `npm run dev` - Runs `tsx server.ts` (backend Express + Vite dev middleware)
- `npm run lint` - Runs `tsc --noEmit`
- `npm run build` - Builds production Vite bundle & Node server bundle (`dist/server.cjs`)
