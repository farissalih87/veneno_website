<script setup>
import { ref, computed } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import {
  LayoutDashboard,
  DollarSign,
  TrendingUp,
  Users,
  Calendar,
  MessageSquare,
  Sparkles,
  Send,
  ShieldCheck,
  CheckCircle2,
  AlertCircle,
  Plus,
  Car,
  Printer,
  ChevronRight,
  Filter,
  BarChart3,
  Wrench,
  Trash2,
  Mail,
  Phone,
  Search,
  Clock,
  MapPin,
  ExternalLink,
  X
} from 'lucide-vue-next';

const props = defineProps({
  bookings: Array,
  clients: Array,
  inquiries: Array,
  campaigns: Array,
  staff: Array,
  stats: Object,
  revenueMetrics: Array,
  adihexLeads: { type: Array, default: () => [] },
  adihexStats: { type: Object, default: () => ({}) },
});

const currentTab = ref('overview'); // 'overview', 'adihex', 'bookings', 'clients', 'inquiries', 'campaigns', 'revenue'

// ADIHEX 2026 CRM Filters & Redemption State
const adihexTierFilter = ref('all');
const adihexStatusFilter = ref('all');
const adihexSearch = ref('');
const redeemCodeInput = ref('');
const redeemMessage = ref(null);
const isRedeeming = ref(false);

const filteredAdihexLeads = computed(() => {
  let list = props.adihexLeads || [];
  
  if (adihexTierFilter.value !== 'all') {
    list = list.filter(l => l.lead_tier === adihexTierFilter.value);
  }

  if (adihexStatusFilter.value !== 'all') {
    if (adihexStatusFilter.value === 'redeemed') {
      list = list.filter(l => l.is_redeemed);
    } else if (adihexStatusFilter.value === 'unredeemed') {
      list = list.filter(l => !l.is_redeemed);
    } else if (adihexStatusFilter.value === 'paid_deposit') {
      list = list.filter(l => l.deposit_status === 'paid');
    }
  }

  if (adihexSearch.value.trim()) {
    const q = adihexSearch.value.toLowerCase();
    list = list.filter(l =>
      (l.name && l.name.toLowerCase().includes(q)) ||
      (l.phone && l.phone.toLowerCase().includes(q)) ||
      (l.voucher_code && l.voucher_code.toLowerCase().includes(q)) ||
      (l.won_prize_label && l.won_prize_label.toLowerCase().includes(q)) ||
      (l.selected_package_name && l.selected_package_name.toLowerCase().includes(q))
    );
  }

  return list;
});

const handleRedeemVoucher = async () => {
  if (!redeemCodeInput.value.trim()) return;
  isRedeeming.value = true;
  redeemMessage.value = null;
  try {
    const res = await window.axios.post(route('api.adihex.redeem'), {
      voucher_code: redeemCodeInput.value.trim(),
    });
    redeemMessage.value = { type: 'success', text: res.data.message };
    redeemCodeInput.value = '';
    router.reload({ only: ['adihexLeads', 'adihexStats'] });
  } catch (err) {
    redeemMessage.value = {
      type: 'error',
      text: err.response?.data?.message || 'Failed to redeem voucher code.',
    };
  } finally {
    isRedeeming.value = false;
  }
};

// ==========================================
// ADIHEX WhatsApp 1-Click Outreach Modal
// ==========================================
const isWhatsAppModalOpen = ref(false);
const selectedLeadForWhatsApp = ref(null);
const customWhatsAppMessage = ref('');
const activeWhatsAppTemplate = ref('confirmation');

const openWhatsAppModal = (lead) => {
  selectedLeadForWhatsApp.value = lead;
  updateWhatsAppTemplate('confirmation');
  isWhatsAppModalOpen.value = true;
};

const updateWhatsAppTemplate = (templateType) => {
  activeWhatsAppTemplate.value = templateType;
  const lead = selectedLeadForWhatsApp.value;
  if (!lead) return;

  const isAr = (lead.locale === 'ar');
  const code = lead.voucher_code;
  const prize = lead.won_prize_label;
  const hasPackage = (lead.deposit_status === 'paid' && lead.selected_package_name);

  if (templateType === 'confirmation') {
    if (isAr) {
      customWhatsAppMessage.value = hasPackage
        ? `مرحباً ${lead.name}، شكراً لزيارتك جناح فينينو للعناية بالسيارات في أديهيكس 2026!\nنؤكد استلام عربون 500 درهم وحجز باقة "${lead.selected_package_name}".\nكود القسيمة: ${code}\nجائزتك: ${prize}\nيسعدنا التنسيق معك لتحديد موعد حضور سيارتك لمركزنا.`
        : `مرحباً ${lead.name}، شكراً لزيارتك جناح فينينو للعناية بالسيارات في أديهيكس 2026!\nنؤكد تسجيل جائزتك: "${prize}".\nكود القسيمة: ${code}\nالقسيمة صالحة لمدة 60 يوماً. متى يناسبك تشريفنا في المركز؟`;
    } else {
      customWhatsAppMessage.value = hasPackage
        ? `Hello ${lead.name}, thank you for visiting Veneno Auto Care at ADIHEX 2026!\nWe confirm your AED 500 deposit for "${lead.selected_package_name}".\nVoucher Code: ${code}\nWon Prize: ${prize}\nWhen would you like to schedule your workshop visit?`
        : `Hello ${lead.name}, thank you for visiting Veneno Auto Care at ADIHEX 2026!\nWe confirm your won prize: "${prize}".\nVoucher Code: ${code}\nValid for 60 days. When would you like to bring your vehicle in?`;
    }
  } else if (templateType === 'appointment') {
    if (isAr) {
      customWhatsAppMessage.value = `أهلاً بك ${lead.name}، نود التنسيق معك بخصوص موعد زيارتك لمركز فينينو للعناية بالسيارات لاستخدام قسيمتك (${code}).\nيرجى تزويدنا بنوع السيارة واليوم المناسب لك لنقوم بتجهيز مسار الخدمة الخاص بك.`;
    } else {
      customWhatsAppMessage.value = `Dear ${lead.name}, we would like to coordinate your upcoming appointment at Veneno Auto Care for voucher (${code}).\nPlease share your vehicle model and preferred day so our team can prepare your dedicated service bay.`;
    }
  } else if (templateType === 'exclusive_offer') {
    if (isAr) {
      customWhatsAppMessage.value = `مرحباً ${lead.name}، يسر فريق فينينو تقديم ترقية حصرية خاصة لزوار أديهيكس على باقات حماية النانو سيراميك وPPF بجانب جائزتك (${prize}). هل ترغب بالحصول على استشارة فنية مخصصة لسيارتك؟`;
    } else {
      customWhatsAppMessage.value = `Hello ${lead.name}, Veneno Auto Care is pleased to offer you an exclusive ADIHEX upgrade on our Nano-Ceramic and PPF protection packages alongside your prize (${prize}). Would you like a complimentary consultation for your car?`;
    }
  }
};

const getWhatsAppDirectUrl = computed(() => {
  if (!selectedLeadForWhatsApp.value) return '#';
  let phone = (selectedLeadForWhatsApp.value.phone || '').replace(/[^\d]/g, '');
  if (phone.startsWith('05')) phone = '971' + phone.substring(1);
  else if (phone.startsWith('5') && phone.length === 9) phone = '971' + phone;
  return `https://wa.me/${phone}?text=${encodeURIComponent(customWhatsAppMessage.value)}`;
});

// Inquiry Filters & Search
const inquiryStatusFilter = ref('all');
const inquirySearch = ref('');

const filteredInquiries = computed(() => {
  let list = props.inquiries || [];
  
  if (inquiryStatusFilter.value !== 'all') {
    list = list.filter(i => i.status === inquiryStatusFilter.value);
  }
  
  if (inquirySearch.value.trim()) {
    const q = inquirySearch.value.toLowerCase();
    list = list.filter(i =>
      (i.customer_name && i.customer_name.toLowerCase().includes(q)) ||
      (i.phone && i.phone.toLowerCase().includes(q)) ||
      (i.service_requested && i.service_requested.toLowerCase().includes(q)) ||
      (i.vehicle_details && i.vehicle_details.toLowerCase().includes(q)) ||
      (i.message_text && i.message_text.toLowerCase().includes(q))
    );
  }
  
  return list;
});

// New Marketing Campaign Form State
const newCampaign = ref({
  title: '',
  subject: '',
  type: 'email',
  audience: 'vip',
  discount_code: 'VIP' + Math.floor(Math.random() * 89 + 10),
  budget: 250.00,
  body_content: '',
});

const isCreatingCampaign = ref(false);

const handleCreateCampaign = () => {
  router.post(route('dashboard.campaigns.store'), newCampaign.value, {
    onSuccess: () => {
      isCreatingCampaign.value = false;
      newCampaign.value = {
        title: '',
        subject: '',
        type: 'email',
        audience: 'vip',
        discount_code: 'VIP' + Math.floor(Math.random() * 89 + 10),
        budget: 250.00,
        body_content: '',
      };
    },
  });
};

const handleUpdateInquiry = (inquiryId, status) => {
  router.patch(route('dashboard.inquiries.update', inquiryId), { status });
};

const handleDeleteInquiry = (inquiryId) => {
  if (confirm('Are you sure you want to delete this quote lead record?')) {
    router.delete(route('dashboard.inquiries.destroy', inquiryId));
  }
};
</script>

<template>
  <Head title="Staff CRM & Executive Dashboard - Veneno Auto Care" />

  <div class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 font-sans selection:bg-red-600 selection:text-white">
    <Navbar />

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <!-- Executive Summary Header -->
      <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-zinc-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl bg-red-600/20 text-red-500 border border-red-500/30 flex items-center justify-center shadow-lg">
            <LayoutDashboard class="w-7 h-7" />
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h1 class="text-2xl font-black text-white">Management CRM & Analytics</h1>
              <span class="px-2.5 py-0.5 rounded-full bg-red-600/20 text-red-400 border border-red-500/30 text-[10px] font-mono font-bold uppercase">
                Enterprise Active
              </span>
            </div>
            <p class="text-xs text-zinc-400 mt-0.5">Real-time studio revenue, customer garage records, technician bay tracking, and lead conversion</p>
          </div>
        </div>

        <Link
          :href="route('technician.portal')"
          class="px-5 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-amber-400 border border-zinc-800 text-xs font-mono font-bold uppercase flex items-center gap-2"
        >
          <Wrench class="w-4 h-4" />
          <span>Go to Bay Floor</span>
        </Link>
      </div>

      <!-- Key KPI Cards -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-panel p-5 rounded-2xl border border-zinc-800 space-y-2">
          <div class="flex items-center justify-between text-xs font-mono text-zinc-400">
            <span>Total YTD Revenue</span>
            <DollarSign class="w-4 h-4 text-emerald-400" />
          </div>
          <div class="text-3xl font-display italic text-white">${{ Number(stats?.totalRevenue || 360100).toLocaleString() }}</div>
          <div class="text-[11px] text-emerald-400 font-mono">+18.4% vs previous quarter</div>
        </div>

        <div class="glass-panel p-5 rounded-2xl border border-zinc-800 space-y-2">
          <div class="flex items-center justify-between text-xs font-mono text-zinc-400">
            <span>Active Bay Jobs</span>
            <Car class="w-4 h-4 text-red-400" />
          </div>
          <div class="text-3xl font-display italic text-red-400">{{ stats?.activeJobs || 4 }} Cars</div>
          <div class="text-[11px] text-zinc-500 font-mono">Bays operating at 92% capacity</div>
        </div>

        <div class="glass-panel p-5 rounded-2xl border border-zinc-800 space-y-2">
          <div class="flex items-center justify-between text-xs font-mono text-zinc-400">
            <span>Average Ticket Size</span>
            <TrendingUp class="w-4 h-4 text-amber-400" />
          </div>
          <div class="text-3xl font-display italic text-amber-400">${{ stats?.averageTicket || 1246 }}</div>
          <div class="text-[11px] text-zinc-500 font-mono">Ceramic & PPF high margin mix</div>
        </div>

        <div class="glass-panel p-5 rounded-2xl border border-zinc-800 space-y-2">
          <div class="flex items-center justify-between text-xs font-mono text-zinc-400">
            <span>New Leads & Inquiries</span>
            <MessageSquare class="w-4 h-4 text-blue-400" />
          </div>
          <div class="text-3xl font-display italic text-blue-400">{{ inquiries?.filter(i => i.status === 'new').length || 1 }} New</div>
          <div class="text-[11px] text-zinc-500 font-mono">WhatsApp instant channel</div>
        </div>
      </div>

      <!-- Navigation Tabs -->
      <div class="flex flex-wrap border-b border-zinc-800 text-xs font-mono uppercase tracking-wider">
        <button
          v-for="t in [
            { id: 'overview', label: 'Overview' },
            { id: 'adihex', label: `🔥 ADIHEX 2026 (${adihexLeads?.length || 0})` },
            { id: 'bookings', label: `Bookings (${bookings?.length || 0})` },
            { id: 'clients', label: `Clients (${clients?.length || 0})` },
            { id: 'inquiries', label: `Quote Leads (${inquiries?.length || 0})` },
            { id: 'campaigns', label: 'Marketing Studio' },
            { id: 'revenue', label: 'Revenue Analytics' },
          ]"
          :key="t.id"
          @click="currentTab = t.id"
          class="py-3 px-5 border-b-2 font-bold transition-colors flex items-center gap-1.5"
          :class="currentTab === t.id ? (t.id === 'adihex' ? 'text-amber-400 border-amber-400' : 'text-red-500 border-red-500') : 'text-zinc-400 border-transparent hover:text-zinc-200'"
        >
          <span>{{ t.label }}</span>
        </button>
      </div>

      <!-- TAB: ADIHEX 2026 ACTIVATION & CRM PIPELINE -->
      <div v-if="currentTab === 'adihex'" class="space-y-6 animate-in fade-in duration-200">
        <!-- Top ADIHEX Strategy & Action Bar -->
        <div class="glass-panel p-6 rounded-3xl border border-zinc-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shadow-lg">
              🎯
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h2 class="text-lg font-black text-white">ADIHEX 2026 Booth Activation Pipeline</h2>
                <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-mono font-bold uppercase">
                  ADNEC Hall 4 Live
                </span>
              </div>
              <p class="text-xs text-zinc-400 mt-0.5">Real-time telemetry, lead-to-reservation funnel, voucher redemptions, and VIP concierge dispatch</p>
            </div>
          </div>

          <div class="flex items-center gap-2.5">
            <a
              :href="route('dashboard.adihex.export')"
              class="px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-700 text-zinc-200 text-xs font-mono font-semibold flex items-center gap-2 transition-colors shadow-sm"
            >
              <Printer class="w-3.5 h-3.5" />
              <span>Export CSV</span>
            </a>

            <a
              href="/adihex"
              target="_blank"
              class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 text-white text-xs font-mono font-bold flex items-center gap-2 shadow-lg shadow-red-950 transition-transform active:scale-95"
            >
              <span>Open Booth Portal</span>
              <ExternalLink class="w-3.5 h-3.5" />
            </a>
          </div>
        </div>

        <!-- ADIHEX KPI Dashboard -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 font-mono text-xs">
          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Total Booth Spins</div>
            <div class="text-2xl font-black text-white">{{ adihexStats?.totalSpins || adihexLeads.length }}</div>
            <div class="text-[10px] text-zinc-500">Verified UAE numbers</div>
          </div>

          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Paid Reservations</div>
            <div class="text-2xl font-black text-emerald-400">{{ adihexStats?.paidReservations || 0 }}</div>
            <div class="text-[10px] text-emerald-500">AED 50 deposits</div>
          </div>

          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Deposit Cashflow</div>
            <div class="text-2xl font-black text-white">AED {{ Number(adihexStats?.depositCashflow || 0).toLocaleString() }}</div>
            <div class="text-[10px] text-zinc-500">100% upfront captured</div>
          </div>

          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Pipeline Value</div>
            <div class="text-2xl font-black text-amber-400">AED {{ Number(adihexStats?.pipelineRevenue || 0).toLocaleString() }}</div>
            <div class="text-[10px] text-zinc-500">Show package pipeline</div>
          </div>

          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Conversion Rate</div>
            <div class="text-2xl font-black text-purple-400">{{ adihexStats?.conversionRate || 0 }}%</div>
            <div class="text-[10px] text-zinc-500">Spins to paid deposits</div>
          </div>

          <div class="glass-panel p-4 rounded-2xl border border-zinc-800 space-y-1.5">
            <div class="text-[10px] text-zinc-400 uppercase">Redeemed Passes</div>
            <div class="text-2xl font-black text-blue-400">{{ adihexStats?.redeemedCount || 0 }}</div>
            <div class="text-[10px] text-zinc-500">Workshop check-ins</div>
          </div>
        </div>

        <!-- Fast Voucher Lookup & Redemption Engine -->
        <div class="glass-panel p-5 rounded-3xl border border-zinc-800 space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <Sparkles class="w-4 h-4 text-amber-400" />
              <h3 class="text-xs font-mono font-bold text-white uppercase">Fast Voucher Redemption & Pass Validator</h3>
            </div>
            <span class="text-[10px] font-mono text-zinc-500">Enter code from customer phone</span>
          </div>

          <form @submit.prevent="handleRedeemVoucher" class="flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-1">
              <input
                v-model="redeemCodeInput"
                type="text"
                required
                placeholder="VEN-ADIHEX-XXXX (e.g. VEN-ADIHEX-8492)"
                class="w-full px-4 py-2.5 rounded-xl bg-zinc-900/90 border border-zinc-800 text-white font-mono uppercase text-xs focus:outline-none focus:border-amber-400"
              />
            </div>
            <button
              type="submit"
              :disabled="isRedeeming"
              class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-zinc-950 font-mono font-bold text-xs uppercase flex items-center justify-center gap-1.5 transition-colors disabled:opacity-50"
            >
              <CheckCircle2 class="w-3.5 h-3.5" />
              <span>{{ isRedeeming ? 'Validating...' : 'Validate & Redeem Pass' }}</span>
            </button>
          </form>

          <div v-if="redeemMessage" :class="['p-3 rounded-xl text-xs font-mono flex items-center gap-2', redeemMessage.type === 'success' ? 'bg-emerald-950/40 border border-emerald-800 text-emerald-300' : 'bg-red-950/40 border border-red-800 text-red-300']">
            <CheckCircle2 v-if="redeemMessage.type === 'success'" class="w-4 h-4 text-emerald-400" />
            <AlertCircle v-else class="w-4 h-4 text-red-400" />
            <span>{{ redeemMessage.text }}</span>
          </div>
        </div>

        <!-- Filter Bar & Search -->
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
          <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <!-- Tier Filter -->
            <div class="flex items-center gap-1 bg-zinc-900/80 p-1 rounded-xl border border-zinc-800 text-xs font-mono">
              <button
                v-for="tier in [
                  { id: 'all', label: 'All Tiers' },
                  { id: 'VIP_RESERVED', label: 'VIP Reserved (Paid)' },
                  { id: 'HIGH_INTENT_PPF', label: 'High Intent (PPF)' },
                  { id: 'SPIN_PRIZE', label: 'Spin Prize' },
                ]"
                :key="tier.id"
                @click="adihexTierFilter = tier.id"
                :class="[
                  'px-3 py-1.5 rounded-lg transition-colors font-medium',
                  adihexTierFilter === tier.id ? 'bg-zinc-800 text-white font-bold' : 'text-zinc-400 hover:text-zinc-200'
                ]"
              >
                {{ tier.label }}
              </button>
            </div>

            <!-- Status Filter -->
            <select
              v-model="adihexStatusFilter"
              class="px-3 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-mono text-zinc-300 focus:outline-none focus:border-amber-400"
            >
              <option value="all">All Status</option>
              <option value="paid_deposit">Paid Deposit (AED 50)</option>
              <option value="unredeemed">Active (Unredeemed)</option>
              <option value="redeemed">Redeemed Vouchers</option>
            </select>
          </div>

          <!-- Search Input -->
          <div class="relative w-full sm:w-72">
            <Search class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3" />
            <input
              v-model="adihexSearch"
              type="text"
              placeholder="Search by name, phone, code..."
              class="w-full pl-10 pr-3.5 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-white placeholder-zinc-500 text-xs font-mono focus:outline-none focus:border-amber-400"
            />
          </div>
        </div>

        <!-- ADIHEX Leads Table -->
        <div class="glass-panel rounded-3xl border border-zinc-800 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
              <thead class="bg-zinc-900/90 text-zinc-400 uppercase tracking-wider text-[10px] border-b border-zinc-800">
                <tr>
                  <th class="py-3.5 px-4">Visitor / Contact</th>
                  <th class="py-3.5 px-4">Lead Classification</th>
                  <th class="py-3.5 px-4">Won Prize & Code</th>
                  <th class="py-3.5 px-4">Show Package & Deposit</th>
                  <th class="py-3.5 px-4">Service Intent</th>
                  <th class="py-3.5 px-4">Voucher Status</th>
                  <th class="py-3.5 px-4 text-right">Concierge Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-zinc-800/60 text-zinc-300">
                <tr
                  v-for="lead in filteredAdihexLeads"
                  :key="lead.id"
                  class="hover:bg-zinc-900/40 transition-colors"
                >
                  <!-- Contact -->
                  <td class="py-3.5 px-4">
                    <div class="font-bold text-white text-sm">{{ lead.name }}</div>
                    <div class="text-zinc-400 text-xs mt-0.5 flex items-center gap-1.5">
                      <span>{{ lead.phone }}</span>
                      <span v-if="lead.locale === 'ar'" class="text-[10px] px-1 rounded bg-zinc-800 text-zinc-400">AR</span>
                    </div>
                    <div v-if="lead.email" class="text-zinc-500 text-[10px]">{{ lead.email }}</div>
                  </td>

                  <!-- Lead Classification -->
                  <td class="py-3.5 px-4">
                    <span
                      v-if="lead.lead_tier === 'VIP_RESERVED'"
                      class="px-2.5 py-1 rounded-md bg-amber-950/80 text-amber-300 border border-amber-700/60 text-[10px] font-bold uppercase inline-flex items-center gap-1"
                    >
                      <span>👑 VIP RESERVED</span>
                    </span>
                    <span
                      v-else-if="lead.lead_tier === 'HIGH_INTENT_PPF'"
                      class="px-2.5 py-1 rounded-md bg-blue-950/80 text-blue-300 border border-blue-700/60 text-[10px] font-bold uppercase inline-flex items-center gap-1"
                    >
                      <span>🛡️ HIGH INTENT</span>
                    </span>
                    <span
                      v-else
                      class="px-2.5 py-1 rounded-md bg-zinc-900 text-zinc-400 border border-zinc-700 text-[10px] font-bold uppercase inline-flex items-center gap-1"
                    >
                      <span>🎁 SPIN PRIZE</span>
                    </span>
                  </td>

                  <!-- Prize & Code -->
                  <td class="py-3.5 px-4">
                    <div class="text-white font-semibold">{{ lead.won_prize_label }}</div>
                    <div class="text-red-400 font-mono text-xs font-bold tracking-wider mt-0.5">{{ lead.voucher_code }}</div>
                    <div class="text-[10px] text-zinc-500">Exp: {{ lead.voucher_expires_at ? lead.voucher_expires_at.split('T')[0] : '2026-12-05' }}</div>
                  </td>

                  <!-- Show Package -->
                  <td class="py-3.5 px-4">
                    <div v-if="lead.selected_package_name">
                      <div class="text-white font-semibold">{{ lead.selected_package_name }}</div>
                      <div v-if="lead.deposit_status === 'paid'" class="text-emerald-400 text-xs font-bold flex items-center gap-1 mt-0.5">
                        <CheckCircle2 class="w-3.5 h-3.5" />
                        <span>AED 50 Paid (100% Deductible)</span>
                      </div>
                      <div v-else class="text-zinc-500 text-[10px]">Deposit Pending</div>
                    </div>
                    <div v-else class="text-zinc-500 text-xs italic">No Package Selected (Free Spin Only)</div>
                  </td>

                  <!-- Service Intent Tags -->
                  <td class="py-3.5 px-4">
                    <div class="flex flex-wrap gap-1 max-w-xs">
                      <span
                        v-for="(svc, idx) in (Array.isArray(lead.service_intent) ? lead.service_intent : [])"
                        :key="idx"
                        class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-300"
                      >
                        {{ svc }}
                      </span>
                      <span v-if="!lead.service_intent || lead.service_intent.length === 0" class="text-zinc-500 text-xs">-</span>
                    </div>
                  </td>

                  <!-- Redemption Status -->
                  <td class="py-3.5 px-4">
                    <span
                      v-if="lead.is_redeemed"
                      class="px-2 py-0.5 rounded-full bg-emerald-950 text-emerald-300 border border-emerald-800 text-[10px] font-bold uppercase inline-flex items-center gap-1"
                    >
                      <CheckCircle2 class="w-3 h-3" />
                      <span>Redeemed</span>
                    </span>
                    <span
                      v-else
                      class="px-2 py-0.5 rounded-full bg-zinc-900 text-zinc-400 border border-zinc-800 text-[10px] font-bold uppercase inline-flex items-center gap-1"
                    >
                      <Clock class="w-3 h-3 text-amber-500" />
                      <span>Active</span>
                    </span>
                  </td>

                  <!-- Action -->
                  <td class="py-3.5 px-4 text-right">
                    <button
                      type="button"
                      @click="openWhatsAppModal(lead)"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-950 hover:bg-emerald-900 text-emerald-300 border border-emerald-800/60 text-xs font-bold transition-all shadow-sm active:scale-95 cursor-pointer"
                    >
                      <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"></path></svg>
                      <span>WhatsApp Lead</span>
                    </button>
                  </td>
                </tr>

                <tr v-if="filteredAdihexLeads.length === 0">
                  <td colspan="7" class="py-8 text-center text-zinc-500">
                    No ADIHEX leads matching your filter criteria.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- TAB 1: OVERVIEW -->
      <div v-if="currentTab === 'overview'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Recent Bookings Table -->
          <div class="lg:col-span-2 glass-panel p-6 rounded-3xl border border-zinc-800 space-y-4">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-bold text-white font-mono uppercase">Recent Workshop Bookings</h3>
              <button @click="currentTab = 'bookings'" class="text-xs text-red-400 hover:text-red-300 font-mono">View All →</button>
            </div>

            <div class="divide-y divide-zinc-800/80 text-xs font-mono">
              <div
                v-for="b in (bookings || []).slice(0, 5)"
                :key="b.id"
                class="py-3.5 flex items-center justify-between"
              >
                <div>
                  <div class="flex items-center gap-2">
                    <span class="text-white font-bold">{{ b.booking_code }}</span>
                    <span class="text-zinc-500">•</span>
                    <span class="text-zinc-300">{{ b.customer_name }}</span>
                  </div>
                  <div class="text-[11px] text-zinc-400">{{ b.vehicle_summary }}</div>
                </div>
                <div class="text-right">
                  <div class="text-white font-bold">${{ Number(b.total_amount) }}</div>
                  <span class="text-[10px] px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-red-400 uppercase">
                    {{ b.status }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick WhatsApp Leads Box -->
          <div class="glass-panel p-6 rounded-3xl border border-zinc-800 space-y-4">
            <h3 class="text-sm font-bold text-white font-mono uppercase">Latest Customer Inquiries</h3>

            <div class="space-y-3 text-xs">
              <div
                v-for="inq in (inquiries || []).slice(0, 3)"
                :key="inq.id"
                class="p-3.5 rounded-2xl bg-zinc-900/80 border border-zinc-800 space-y-2"
              >
                <div class="flex items-center justify-between">
                  <span class="font-bold text-white">{{ inq.customer_name }}</span>
                  <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-950 text-emerald-400 border border-emerald-800/40">
                    {{ inq.status }}
                  </span>
                </div>
                <div class="text-zinc-400 text-[11px]">{{ inq.vehicle_details }} • {{ inq.service_requested }}</div>
                <p class="text-zinc-300 text-[11px] italic line-clamp-2">"{{ inq.message_text }}"</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: ALL BOOKINGS -->
      <div v-if="currentTab === 'bookings'" class="glass-panel rounded-3xl border border-zinc-800 overflow-hidden">
        <div class="p-6 border-b border-zinc-800 flex items-center justify-between">
          <h3 class="text-base font-bold text-white">All Active & Past Bookings</h3>
          <span class="text-xs font-mono text-zinc-400">Total: {{ bookings?.length }}</span>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs font-mono">
            <thead class="bg-zinc-900/60 text-zinc-400 uppercase text-[10px] border-b border-zinc-800">
              <tr>
                <th class="p-4">Code</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Vehicle</th>
                <th class="p-4">Service</th>
                <th class="p-4">Date & Slot</th>
                <th class="p-4">Total</th>
                <th class="p-4">Status</th>
                <th class="p-4">Invoice</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/60">
              <tr v-for="b in bookings" :key="b.id" class="hover:bg-zinc-900/40 transition-colors">
                <td class="p-4 font-bold text-white">{{ b.booking_code }}</td>
                <td class="p-4">{{ b.customer_name }}<br><span class="text-zinc-500 text-[10px]">{{ b.customer_phone }}</span></td>
                <td class="p-4">{{ b.vehicle_summary }}</td>
                <td class="p-4 text-red-400">{{ b.service_package?.name || 'Ceramic Coating' }}</td>
                <td class="p-4">{{ b.booking_date }}<br><span class="text-zinc-500 text-[10px]">{{ b.time_slot }}</span></td>
                <td class="p-4 font-bold text-white">${{ Number(b.total_amount) }}</td>
                <td class="p-4">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-zinc-900 border border-zinc-700 text-amber-400">
                    {{ b.status }}
                  </span>
                </td>
                <td class="p-4">
                  <Link :href="route('bookings.confirmation', b.booking_code)" class="p-2 rounded bg-zinc-900 hover:bg-zinc-800 text-zinc-300 inline-flex">
                    <Printer class="w-3.5 h-3.5" />
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- TAB 3: CLIENT CRM -->
      <div v-if="currentTab === 'clients'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="client in (clients?.length ? clients : [
            { name: 'Alex Sterling', email: 'alex@example.com', phone: '+971 50 123 4567', loyalty_tier: 'VIP Platinum', loyalty_points: 3450, totalSpend: 1197.00 }
          ])"
          :key="client.email"
          class="glass-panel p-6 rounded-3xl border border-zinc-800 space-y-4"
        >
          <div class="flex items-center justify-between">
            <div>
              <h4 class="text-base font-bold text-white">{{ client.name }}</h4>
              <div class="text-xs text-zinc-400">{{ client.email }}</div>
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-mono font-bold uppercase">
              {{ client.loyalty_tier || 'VIP Platinum' }}
            </span>
          </div>

          <div class="grid grid-cols-2 gap-2 text-xs font-mono text-zinc-400 pt-2 border-t border-zinc-800">
            <div>
              <span class="text-zinc-500 text-[10px] block">Loyalty Points:</span>
              <span class="text-amber-400 font-bold">{{ client.loyalty_points || 3450 }} PTS</span>
            </div>
            <div>
              <span class="text-zinc-500 text-[10px] block">Phone:</span>
              <span class="text-white">{{ client.phone || '+971 50 123 4567' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 4: QUOTE LEADS & INQUIRIES CRM -->
      <div v-if="currentTab === 'inquiries'" class="space-y-6">
        <div class="glass-panel p-6 rounded-3xl border border-zinc-800 space-y-6">
          
          <!-- Header & Search Controls -->
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-800/80 pb-6">
            <div>
              <div class="flex items-center gap-2">
                <h3 class="text-lg font-bold text-white uppercase font-display">Quote Leads & Inquiries Inbox</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-red-600/20 text-red-400 border border-red-500/30 text-xs font-mono font-bold">
                  {{ filteredInquiries.length }} Leads
                </span>
              </div>
              <p class="text-xs text-zinc-400 mt-1">Real-time instant quotes from veneno.ae, dispatched to info@veneno.ae and recorded in CRM</p>
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-80">
              <Search class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
              <input
                v-model="inquirySearch"
                type="text"
                placeholder="Search name, phone, service, branch..."
                class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-red-500"
              />
            </div>
          </div>

          <!-- Status Filter Tabs -->
          <div class="flex flex-wrap items-center gap-2">
            <button
              @click="inquiryStatusFilter = 'all'"
              class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold uppercase transition-all"
              :class="inquiryStatusFilter === 'all' ? 'bg-white text-black shadow-lg' : 'bg-zinc-900 text-zinc-400 hover:text-white border border-zinc-800'"
            >
              All Leads ({{ inquiries?.length || 0 }})
            </button>
            <button
              @click="inquiryStatusFilter = 'new'"
              class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold uppercase transition-all flex items-center gap-1.5"
              :class="inquiryStatusFilter === 'new' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-zinc-900 text-zinc-400 hover:text-white border border-zinc-800'"
            >
              <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
              <span>New ({{ inquiries?.filter(i => i.status === 'new').length || 0 }})</span>
            </button>
            <button
              @click="inquiryStatusFilter = 'contacted'"
              class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold uppercase transition-all"
              :class="inquiryStatusFilter === 'contacted' ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/30' : 'bg-zinc-900 text-zinc-400 hover:text-white border border-zinc-800'"
            >
              Contacted ({{ inquiries?.filter(i => i.status === 'contacted').length || 0 }})
            </button>
            <button
              @click="inquiryStatusFilter = 'booked'"
              class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold uppercase transition-all"
              :class="inquiryStatusFilter === 'booked' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'bg-zinc-900 text-zinc-400 hover:text-white border border-zinc-800'"
            >
              Converted / Booked ({{ inquiries?.filter(i => i.status === 'booked').length || 0 }})
            </button>
            <button
              @click="inquiryStatusFilter = 'lost'"
              class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold uppercase transition-all"
              :class="inquiryStatusFilter === 'lost' ? 'bg-zinc-700 text-white' : 'bg-zinc-900 text-zinc-400 hover:text-white border border-zinc-800'"
            >
              Lost / Closed ({{ inquiries?.filter(i => i.status === 'lost').length || 0 }})
            </button>
          </div>

          <!-- Inquiries List -->
          <div v-if="filteredInquiries.length === 0" class="text-center py-12 text-zinc-500 font-mono text-xs">
            No quote leads found matching your criteria.
          </div>

          <div v-else class="space-y-3">
            <div
              v-for="inq in filteredInquiries"
              :key="inq.id"
              class="p-5 rounded-2xl bg-zinc-900/70 border border-zinc-800/80 hover:border-zinc-700 transition-all flex flex-col lg:flex-row lg:items-center justify-between gap-5 group"
            >
              <!-- Left Info -->
              <div class="space-y-2 flex-1">
                <div class="flex flex-wrap items-center gap-3">
                  <span class="text-base font-bold text-white">{{ inq.customer_name }}</span>
                  <span class="text-xs font-mono text-emerald-400 font-bold">{{ inq.phone }}</span>
                  
                  <span
                    class="text-[10px] font-mono px-2.5 py-0.5 rounded-full font-bold uppercase"
                    :class="{
                      'bg-blue-950 text-blue-400 border border-blue-800/60': inq.status === 'new',
                      'bg-amber-950 text-amber-400 border border-amber-800/60': inq.status === 'contacted',
                      'bg-emerald-950 text-emerald-400 border border-emerald-800/60': inq.status === 'booked',
                      'bg-zinc-800 text-zinc-400 border border-zinc-700': inq.status === 'lost',
                    }"
                  >
                    {{ inq.status }}
                  </span>

                  <span class="text-[10px] text-zinc-500 font-mono flex items-center gap-1 ml-auto lg:ml-0">
                    <Clock class="w-3 h-3" />
                    <span>#{{ inq.id }} • {{ new Date(inq.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }}</span>
                  </span>
                </div>

                <div class="text-xs flex flex-wrap items-center gap-x-4 gap-y-1 text-zinc-300">
                  <div class="flex items-center gap-1.5">
                    <span class="text-zinc-500 font-mono uppercase text-[10px]">Service:</span>
                    <span class="text-red-400 font-bold">{{ inq.service_requested }}</span>
                  </div>

                  <div v-if="inq.vehicle_details" class="flex items-center gap-1.5">
                    <MapPin class="w-3.5 h-3.5 text-zinc-500 shrink-0" />
                    <span class="text-zinc-300">{{ inq.vehicle_details }}</span>
                  </div>
                </div>

                <div v-if="inq.message_text" class="p-2.5 rounded-xl bg-zinc-950/60 border border-zinc-800/60 text-zinc-300 text-xs font-sans leading-relaxed whitespace-pre-line">
                  {{ inq.message_text }}
                </div>
              </div>

              <!-- Right Actions Hub -->
              <div class="flex flex-wrap items-center gap-2.5 shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-zinc-800/60">
                <!-- Status Dropdown -->
                <select
                  :value="inq.status"
                  @change="handleUpdateInquiry(inq.id, $event.target.value)"
                  class="px-3 py-2 rounded-xl bg-zinc-950 border border-zinc-700 text-zinc-200 text-xs font-mono focus:outline-none focus:border-red-500"
                >
                  <option value="new">🔵 Mark as New</option>
                  <option value="contacted">🟡 Contacted</option>
                  <option value="booked">🟢 Booked / Converted</option>
                  <option value="lost">⚪ Closed / Lost</option>
                </select>

                <!-- WhatsApp -->
                <a
                  :href="`https://wa.me/${inq.phone.replace(/[^0-9]/g, '')}?text=${encodeURIComponent('Hello ' + inq.customer_name + ', thank you for contacting Veneno Auto Care regarding your quote request for ' + inq.service_requested + '. How may we assist you?')}`"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold text-xs flex items-center gap-1.5 shadow-md transition-all"
                  title="WhatsApp Customer"
                >
                  <Send class="w-3.5 h-3.5" />
                  <span>WhatsApp</span>
                </a>

                <!-- Call -->
                <a
                  :href="`tel:${inq.phone}`"
                  class="p-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-200 hover:text-white border border-zinc-700 transition-colors"
                  title="Call Customer"
                >
                  <Phone class="w-4 h-4 text-red-400" />
                </a>

                <!-- Delete Lead -->
                <button
                  @click="handleDeleteInquiry(inq.id)"
                  class="p-2 rounded-xl bg-zinc-900 hover:bg-red-950/80 text-zinc-500 hover:text-red-400 border border-zinc-800 hover:border-red-500/50 transition-colors"
                  title="Delete Lead Record"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 5: MARKETING CAMPAIGN STUDIO -->
      <div v-if="currentTab === 'campaigns'" class="space-y-6">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-bold text-white">Automated Marketing Studio</h3>
          <button
            @click="isCreatingCampaign = !isCreatingCampaign"
            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase flex items-center gap-2"
          >
            <Plus class="w-4 h-4" />
            <span>Create Campaign</span>
          </button>
        </div>

        <!-- Campaign Creator Modal/Form -->
        <div v-if="isCreatingCampaign" class="glass-panel p-6 rounded-3xl border border-zinc-800 space-y-4 animate-in fade-in">
          <h4 class="text-sm font-bold text-white uppercase font-mono">Launch Targeted Campaign</h4>
          
          <form @submit.prevent="handleCreateCampaign" class="space-y-4 text-xs">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-zinc-400 mb-1">Campaign Title</label>
                <input
                  v-model="newCampaign.title"
                  type="text"
                  required
                  placeholder="e.g. VIP Ceramic Renewal Reminder"
                  class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
                />
              </div>

              <div>
                <label class="block text-zinc-400 mb-1">Email Subject Line</label>
                <input
                  v-model="newCampaign.subject"
                  type="text"
                  required
                  placeholder="✨ Special Offer for Your Porsche..."
                  class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
                />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-zinc-400 mb-1">Channel Type</label>
                <select
                  v-model="newCampaign.type"
                  class="w-full px-3 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
                >
                  <option value="email">Email Campaign</option>
                  <option value="sms">SMS Text</option>
                  <option value="whatsapp">WhatsApp Broadcast</option>
                </select>
              </div>

              <div>
                <label class="block text-zinc-400 mb-1">Target Audience</label>
                <select
                  v-model="newCampaign.audience"
                  class="w-full px-3 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white focus:outline-none focus:border-red-500"
                >
                  <option value="all">All Clients (2,500+)</option>
                  <option value="vip">VIP Platinum & Gold</option>
                  <option value="ceramic_due">Ceramic Maintenance Due (12 mo)</option>
                  <option value="inactive_90d">Inactive 90+ Days</option>
                </select>
              </div>

              <div>
                <label class="block text-zinc-400 mb-1">Discount Coupon Code</label>
                <input
                  v-model="newCampaign.discount_code"
                  type="text"
                  class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white uppercase font-mono"
                />
              </div>
            </div>

            <div>
              <label class="block text-zinc-400 mb-1">Campaign Body Copy</label>
              <textarea
                v-model="newCampaign.body_content"
                rows="3"
                required
                placeholder="Write campaign body text..."
                class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-white resize-none"
              ></textarea>
            </div>

            <div class="flex justify-end gap-3">
              <button
                type="button"
                @click="isCreatingCampaign = false"
                class="px-4 py-2.5 rounded-xl bg-zinc-800 text-zinc-300 font-semibold"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold uppercase"
              >
                Schedule & Dispatch
              </button>
            </div>
          </form>
        </div>

        <!-- Campaign Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div
            v-for="camp in campaigns"
            :key="camp.id"
            class="glass-panel p-6 rounded-3xl border border-zinc-800 space-y-4"
          >
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono uppercase text-red-400 font-bold">{{ camp.type }} Channel</span>
              <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-950 text-emerald-300 border border-emerald-800/40 uppercase font-mono font-bold">
                {{ camp.status }}
              </span>
            </div>

            <div>
              <h4 class="text-base font-bold text-white">{{ camp.title }}</h4>
              <div class="text-xs text-zinc-400 mt-0.5">{{ camp.subject }}</div>
            </div>

            <div class="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-zinc-900 border border-zinc-800 text-center font-mono text-xs">
              <div>
                <div class="text-[10px] text-zinc-500 uppercase">Sent</div>
                <div class="text-white font-bold">{{ camp.sent_count }}</div>
              </div>
              <div>
                <div class="text-[10px] text-zinc-500 uppercase">Open Rate</div>
                <div class="text-emerald-400 font-bold">{{ camp.open_rate }}%</div>
              </div>
              <div>
                <div class="text-[10px] text-zinc-500 uppercase">Revenue</div>
                <div class="text-amber-400 font-bold">${{ Number(camp.revenue_generated) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 6: REVENUE ANALYTICS -->
      <div v-if="currentTab === 'revenue'" class="space-y-6">
        <div class="glass-panel p-8 rounded-3xl border border-zinc-800 space-y-6">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-bold text-white">Monthly Revenue & Profit Growth</h3>
              <p class="text-xs text-zinc-400">Financial performance tracking and average ticket yield</p>
            </div>
            <span class="px-3 py-1 rounded-xl bg-emerald-950 text-emerald-300 border border-emerald-800/40 text-xs font-mono font-bold">
              67.3% Average Gross Margin
            </span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-6 gap-4 font-mono text-xs">
            <div
              v-for="m in revenueMetrics"
              :key="m.month"
              class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 space-y-2 text-center"
            >
              <div class="text-zinc-400 font-bold uppercase">{{ m.month }} 2026</div>
              <div class="text-base font-black text-white">${{ m.revenue.toLocaleString() }}</div>
              <div class="text-emerald-400 text-[11px] font-semibold">Profit: ${{ m.profit.toLocaleString() }}</div>
              <div class="text-zinc-500 text-[10px] pt-1 border-t border-zinc-800">{{ m.bookingsCount }} Jobs</div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- ADIHEX WhatsApp Outreach Modal -->
    <div
      v-if="isWhatsAppModalOpen && selectedLeadForWhatsApp"
      class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 animate-in fade-in duration-200"
    >
      <div class="glass-panel w-full max-w-lg rounded-3xl border border-zinc-700 bg-zinc-950 p-6 shadow-2xl space-y-4">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
              <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"></path></svg>
            </div>
            <div>
              <h3 class="text-sm font-black text-white">Direct WhatsApp Outreach</h3>
              <p class="text-[11px] text-zinc-400 font-mono">Recipient: {{ selectedLeadForWhatsApp.name }} ({{ selectedLeadForWhatsApp.phone }})</p>
            </div>
          </div>
          <button
            type="button"
            @click="isWhatsAppModalOpen = false"
            class="w-8 h-8 rounded-full bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white flex items-center justify-center transition-colors"
          >
            <X class="w-4 h-4" />
          </button>
        </div>

        <!-- Lead Summary Card -->
        <div class="p-3 rounded-2xl bg-zinc-900/90 border border-zinc-800 text-xs font-mono grid grid-cols-2 gap-2">
          <div>
            <span class="text-zinc-500 text-[10px] block uppercase">Won Prize</span>
            <span class="text-amber-400 font-bold truncate block">{{ selectedLeadForWhatsApp.won_prize_label }}</span>
          </div>
          <div>
            <span class="text-zinc-500 text-[10px] block uppercase">Voucher Code</span>
            <span class="text-red-400 font-bold block">{{ selectedLeadForWhatsApp.voucher_code }}</span>
          </div>
          <div v-if="selectedLeadForWhatsApp.selected_package_name">
            <span class="text-zinc-500 text-[10px] block uppercase">Show Package</span>
            <span class="text-white font-bold truncate block">{{ selectedLeadForWhatsApp.selected_package_name }}</span>
          </div>
          <div>
            <span class="text-zinc-500 text-[10px] block uppercase">Deposit / Status</span>
            <span :class="selectedLeadForWhatsApp.deposit_status === 'paid' ? 'text-emerald-400 font-bold' : 'text-zinc-400'">
              {{ selectedLeadForWhatsApp.deposit_status === 'paid' ? 'AED 500 Paid (VIP)' : 'Free Spin' }}
            </span>
          </div>
        </div>

        <!-- Preset Template Switcher -->
        <div class="space-y-1.5">
          <label class="text-[11px] font-mono font-bold text-zinc-300 uppercase tracking-wider block">Select Message Template</label>
          <div class="grid grid-cols-3 gap-1.5 text-xs font-mono">
            <button
              type="button"
              @click="updateWhatsAppTemplate('confirmation')"
              :class="['p-2 rounded-xl border text-center transition-all font-semibold', activeWhatsAppTemplate === 'confirmation' ? 'bg-emerald-950 border-emerald-600 text-emerald-300 shadow-md' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-white']"
            >
              Pass Confirmation
            </button>
            <button
              type="button"
              @click="updateWhatsAppTemplate('appointment')"
              :class="['p-2 rounded-xl border text-center transition-all font-semibold', activeWhatsAppTemplate === 'appointment' ? 'bg-emerald-950 border-emerald-600 text-emerald-300 shadow-md' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-white']"
            >
              Book Bay Date
            </button>
            <button
              type="button"
              @click="updateWhatsAppTemplate('exclusive_offer')"
              :class="['p-2 rounded-xl border text-center transition-all font-semibold', activeWhatsAppTemplate === 'exclusive_offer' ? 'bg-emerald-950 border-emerald-600 text-emerald-300 shadow-md' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-white']"
            >
              VIP Upgrade Deal
            </button>
          </div>
        </div>

        <!-- Editable Message Content -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between text-[11px] font-mono text-zinc-400">
            <span>Message Content (Editable)</span>
            <span :class="selectedLeadForWhatsApp.locale === 'ar' ? 'text-amber-400 font-bold' : 'text-zinc-500'">
              {{ selectedLeadForWhatsApp.locale === 'ar' ? 'Arabic (العربية)' : 'English' }}
            </span>
          </div>
          <textarea
            v-model="customWhatsAppMessage"
            rows="5"
            :dir="selectedLeadForWhatsApp.locale === 'ar' ? 'rtl' : 'ltr'"
            class="w-full p-3 rounded-2xl bg-zinc-900 border border-zinc-800 text-zinc-100 text-xs font-mono leading-relaxed focus:outline-none focus:border-emerald-500 transition-colors"
          ></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 pt-2">
          <a
            :href="getWhatsAppDirectUrl"
            target="_blank"
            @click="isWhatsAppModalOpen = false"
            class="flex-1 py-3 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-emerald-950 transition-transform active:scale-98"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.09 9.03 12.25C9.16 12.42 10.74 14.97 13.25 15.96C15.34 16.79 15.76 16.62 16.22 16.58C16.67 16.54 17.69 15.98 17.9 15.38C18.11 14.78 18.11 14.27 18.05 14.16C17.99 14.05 17.82 13.99 17.57 13.86C17.32 13.74 16.08 13.13 15.85 13.04C15.62 12.96 15.46 12.92 15.29 13.16C15.12 13.41 14.64 13.99 14.5 14.16C14.35 14.32 14.21 14.34 13.96 14.22C13.71 14.09 12.91 13.83 11.96 12.98C11.22 12.32 10.72 11.51 10.58 11.26C10.43 11.01 10.56 10.88 10.69 10.75C10.8 10.64 10.94 10.46 11.06 10.31C11.19 10.17 11.23 10.06 11.31 9.9C11.39 9.73 11.35 9.59 11.29 9.46C11.23 9.34 10.72 8.08 10.51 7.58C10.31 7.09 10.1 7.16 9.94 7.15C9.79 7.14 9.66 7.34 9.53 7.34Z"></path></svg>
            <span>Launch WhatsApp Web / App</span>
          </a>
          <button
            type="button"
            @click="isWhatsAppModalOpen = false"
            class="py-3 px-4 rounded-2xl bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white font-mono text-xs transition-colors"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>
