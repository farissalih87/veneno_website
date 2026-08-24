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
  ExternalLink
} from 'lucide-vue-next';

const props = defineProps({
  bookings: Array,
  clients: Array,
  inquiries: Array,
  campaigns: Array,
  staff: Array,
  stats: Object,
  revenueMetrics: Array,
});

const currentTab = ref('overview'); // 'overview', 'bookings', 'clients', 'inquiries', 'campaigns', 'revenue'

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
            { id: 'bookings', label: `Bookings (${bookings?.length || 0})` },
            { id: 'clients', label: `Clients (${clients?.length || 0})` },
            { id: 'inquiries', label: `Quote Leads (${inquiries?.length || 0})` },
            { id: 'campaigns', label: 'Marketing Studio' },
            { id: 'revenue', label: 'Revenue Analytics' },
          ]"
          :key="t.id"
          @click="currentTab = t.id"
          class="py-3 px-5 border-b-2 font-bold transition-colors"
          :class="currentTab === t.id ? 'text-red-500 border-red-500' : 'text-zinc-400 border-transparent hover:text-zinc-200'"
        >
          {{ t.label }}
        </button>
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

    <Footer />
  </div>
</template>
