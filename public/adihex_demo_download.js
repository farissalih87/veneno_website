/**
 * VENENO AUTO CARE CENTER × ADIHEX 2026
 * SCAN. SPIN. WIN. — Core Interactive Wizard Controller
 */

// ==========================================================================
// PRIZES & PROBABILITY SPECIFICATION
// ==========================================================================
const PRIZES = [
  { id: 'disc10', nameEn: '10% Discount Voucher', nameAr: 'قسيمة خصم 10%', weight: 25, value: 'AED 350', color: '#16161c', textColor: '#FFFFFF' },
  { id: 'slime_wash', nameEn: 'Free Slime Wash', nameAr: 'غسيل سلايم مجاني', weight: 20, value: 'AED 150', color: '#E31E24', textColor: '#FFFFFF' },
  { id: 'diamond_wash', nameEn: 'Free Diamond Car Wash', nameAr: 'غسيل دايموند مجاني', weight: 20, value: 'AED 250', color: '#C9A84C', textColor: '#000000' },
  { id: 'voucher100', nameEn: 'AED 100 Gift Voucher', nameAr: 'قسيمة بقيمة 100 درهم', weight: 15, value: 'AED 100', color: '#16161c', textColor: '#FFFFFF' },
  { id: 'tint10', nameEn: '10% Off Window Tinting', nameAr: 'خصم 10% على التظليل الحراري', weight: 10, value: 'AED 250', color: '#E31E24', textColor: '#FFFFFF' },
  { id: 'polish_detail', nameEn: 'Free Polish & Detailing', nameAr: 'تلميع وبوليش مجاني', weight: 7, value: 'AED 750', color: '#C9A84C', textColor: '#000000' },
  { id: 'platinum20', nameEn: '20% Off Platinum Package', nameAr: 'خصم 20% على الباقة البلاتينية', weight: 3, value: 'AED 3,000', color: '#E31E24', textColor: '#FFFFFF' }
];

// ==========================================================================
// ADIHEX EXCLUSIVE PACKAGES
// ==========================================================================
const PACKAGES = [
  {
    id: 'detail_tint',
    titleEn: 'Detailing + Window Tinting',
    titleAr: 'باقة التلميع الشامل + التظليل',
    wasPrice: 'AED 2,500',
    nowPrice: 'AED 1,699',
    badgeEn: '🔥 SHOW SPECIAL',
    badgeAr: '🔥 عرض خاص',
    badgeClass: 'badge-red',
    featuresEn: [
      '3-Stage Exterior Paint Correction & High Gloss Polish',
      'Deep Interior Leather & Fabric Antibacterial Cleansing',
      'Premium Ceramic Heat Rejection Window Tinting (5-Yr)'
    ],
    featuresAr: [
      'معالجة وتلميع الطلاء الخارجي 3 مراحل',
      'تنظيف وتعقيم الفرش والجلد والمقصورة الداخلية',
      'تظليل عازل حراري نانو سيراميك عالي الجودة (ضمان 5 سنوات)'
    ]
  },
  {
    id: 'silver_pkg',
    titleEn: 'Silver Package',
    titleAr: 'الباقة الفضية',
    wasPrice: 'AED 2,730',
    nowPrice: 'AED 1,899',
    badgeEn: 'SILVER TIER',
    badgeAr: 'المستوى الفضي',
    badgeClass: 'badge-silver',
    featuresEn: [
      'Full Multi-Stage Paint Correction',
      '9H Nano Ceramic Coating Protection (3-Year Warranty)',
      'Hydrophobic Windshield & Rim Ceramic Sealant'
    ],
    featuresAr: [
      'معالجة وإزالة الخدوش وتلميع شامل للطلاء',
      'طبقة نانو سيراميك 9H لحماية الهيكل (ضمان 3 سنوات)',
      'عزل مائي وطارد للمطر للزجاج والجنوط'
    ]
  },
  {
    id: 'golden_pkg',
    titleEn: 'Golden Package',
    titleAr: 'الباقة الذهبية',
    wasPrice: 'AED 5,775',
    nowPrice: 'AED 3,999',
    badgeEn: '⭐ BEST VALUE',
    badgeAr: '⭐ القيمة الأفضل',
    badgeClass: 'badge-gold',
    featuresEn: [
      'Full Front-End G100 Paint Protection Film (PPF)',
      '5-Year Dual-Layer Nano Ceramic Body Armor',
      'Full Interior Ceramic Leather Protection + 5-Yr Tint'
    ],
    featuresAr: [
      'حماية مقدمة السيارة كاملة بفيلم G100 (PPF)',
      'نانو سيراميك طبقتين عالي اللمعان (ضمان 5 سنوات)',
      'حماية نانو سيراميك للجلد والمقصورة + تظليل حراري 5 سنوات'
    ]
  },
  {
    id: 'platinum_pkg',
    titleEn: 'Platinum Package',
    titleAr: 'الباقة البلاتينية',
    wasPrice: 'AED 15,000',
    nowPrice: 'AED 9,999',
    badgeEn: '👑 ULTRA PRESTIGE',
    badgeAr: '👑 الفخامة القصوى',
    badgeClass: 'badge-red',
    isPlatinum: true,
    featuresEn: [
      'Full Vehicle G100 Self-Healing PPF (10-Year Warranty)',
      'Rock Ceramic Window Film (5-Year Warranty)',
      'Full Body, Rim, Caliper & Interior Ceramic Shield'
    ],
    featuresAr: [
      'تجليد كامل للسيارة بفيلم حماية G100 معالج ذاتياً (ضمان 10 سنوات)',
      'عازل حراري فائق Rock Ceramic (ضمان 5 سنوات)',
      'نانو سيراميك شامل للطلاء والجنوط والمكابح والفرش الداخلي'
    ]
  }
];

// ==========================================================================
// LOCALIZATION DICTIONARY
// ==========================================================================
const I18N = {
  en: {
    langBtn: 'العربية 🇦🇪',
    step: 'STEP',
    of: 'OF 7',
    spinCount: 'visitors have spun today at ADIHEX',
    // Step 1
    s1_tag: 'WELCOME TO VENENO × ADIHEX 2026',
    s1_title: 'SCAN. <span class="highlight-red">SPIN.</span> <span class="highlight-gold">WIN.</span>',
    s1_desc: 'Select your preferred language to begin your exclusive ADIHEX giveaway experience.',
    // Step 2
    s2_tag: 'FAST REGISTRATION',
    s2_title: 'Register to <span class="highlight-gold">Spin & Win</span>',
    s2_desc: 'Enter your contact details to unlock your guaranteed spin at our booth.',
    name_label: 'Full Name',
    name_ph: 'e.g. Sultan Al Mansoori',
    phone_label: 'Mobile Number (+971 UAE Format)',
    phone_ph: '050 123 4567',
    email_label: 'Email Address (Optional)',
    email_ph: 'name@example.com',
    services_label: 'Interested Services (Select all that apply):',
    srv_ppf: 'PPF Paint Protection',
    srv_ceramic: 'Ceramic Coating',
    srv_detailing: 'Detailing & Polish',
    srv_tint: 'Window Tinting',
    srv_paint: 'Peelable Paint',
    srv_pdr: 'PDR Dent Repair',
    btn_proceed_spin: 'PROCEED TO SPIN ➔',
    privacy_note: '🔒 100% Secure. Used strictly for prize verification & concierge service.',
    // Step 3
    s3_tag: 'LUCKY SPIN WHEEL',
    s3_title: 'Spin & Win <span class="highlight-gold">Exclusive Prizes</span>',
    s3_desc: 'Tap the wheel or button below. Guaranteed prize on every spin!',
    btn_tap_spin: 'TAP TO SPIN NOW 🎯',
    spinning: 'SPINNING...',
    // Step 4
    s4_tag: 'CONGRATULATIONS!',
    s4_title: 'MABROOK! <span class="highlight-gold">YOU WON</span>',
    s4_desc: 'Present this voucher at Veneno Auto Care Center or book via WhatsApp.',
    voucher_label: 'YOUR UNIQUE VOUCHER CODE',
    btn_copy: 'Copy Code',
    btn_copied: 'Copied! ✓',
    btn_download_pdf: 'Download Certificate (PDF)',
    btn_see_offers: 'SEE EXCLUSIVE ADIHEX OFFERS ➔',
    // Step 5
    s5_tag: 'ADIHEX 2026 EXCLUSIVE SHOW OFFERS',
    s5_title: 'Lock In <span class="highlight-gold">Historic Show Savings</span>',
    s5_desc: 'Reserve any show package today for only AED 50 (100% deductible from final invoice).',
    btn_skip: 'Skip to Confirmation ➔',
    btn_reserve: 'Reserve for AED 50',
    // Step 6
    s6_tag: 'SECURE RESERVATION',
    s6_title: 'Confirm <span class="highlight-gold">AED 50 Reservation</span>',
    s6_desc: 'Your AED 50 deposit is 100% deductible upon service and valid for 90 days.',
    pkg_reserved: 'Reserved Package:',
    deposit_label: 'Deposit Due Today:',
    balance_label: 'Balance Due Upon Service:',
    deductible_note: '✓ 100% deductible from final invoice upon vehicle check-in.',
    apple_pay_btn: 'Pay with Apple Pay',
    or_card: 'OR PAY WITH CREDIT / DEBIT CARD',
    card_num: 'Card Number',
    card_exp: 'MM / YY',
    card_cvc: 'CVC',
    btn_pay_50: 'CONFIRM & PAY AED 50 ➔',
    btn_back_offers: '← Change Package',
    // Step 7
    s7_tag: 'CONFIRMATION',
    s7_title: 'All Set! <span class="highlight-gold">Mabrook!</span>',
    s7_desc: 'Your prize and reservation details have been confirmed and sent to your phone.',
    summary_name: 'Customer Name:',
    summary_phone: 'Mobile Number:',
    summary_prize: 'Won Prize:',
    summary_code: 'Voucher Code:',
    summary_pkg: 'Show Package:',
    summary_paid: 'Deposit Paid:',
    summary_valid: 'Validity Window:',
    validity_90_days: '90 Days (Valid until 5 Dec 2026)',
    btn_whatsapp_concierge: 'Open WhatsApp Concierge 💬',
    btn_download_receipt: 'Download Receipt & Pass (PDF)',
    btn_directions: 'Directions to Workshop (Musaffah M37) 📍',
    btn_share: 'Share with a Friend 🔄'
  },
  ar: {
    langBtn: 'English 🇬🇧',
    step: 'الخطوة',
    of: 'من 7',
    spinCount: 'زائر قاموا بتدوير العجلة اليوم بالمعرض',
    // Step 1
    s1_tag: 'مرحباً بكم في جناح فينينو × معرض أبوظبي الدولي للصيد والفروسية',
    s1_title: 'امسح. <span class="highlight-red">دوّر.</span> <span class="highlight-gold">اربح.</span>',
    s1_desc: 'اختر لغتك المفضلة لبدء تجربة السحب الحصرية والجوائز الفورية.',
    // Step 2
    s2_tag: 'تسجيل سريع',
    s2_title: 'سجل بياناتك <span class="highlight-gold">لتدوير العجلة والفوز</span>',
    s2_desc: 'أدخل بيانات التواصل لتفعيل فرصتك المضمونة للفوز بجوائز فورية.',
    name_label: 'الاسم الكامل',
    name_ph: 'مثال: سلطان المنصوري',
    phone_label: 'رقم الهاتف المتحرك (+971 الإمارات)',
    phone_ph: '050 123 4567',
    email_label: 'البريد الإلكتروني (اختياري)',
    email_ph: 'name@example.com',
    services_label: 'الخدمات التي تهمك (اختر ما يناسبك):',
    srv_ppf: 'حماية الطلاء (PPF)',
    srv_ceramic: 'نانو سيراميك',
    srv_detailing: 'تلميع وعناية شاملة',
    srv_tint: 'تظليل وعازل حراري',
    srv_paint: 'طلاء قابل للإزالة',
    srv_pdr: 'تعديل صدمات بدون دهان (PDR)',
    btn_proceed_spin: 'الانتقال لتدوير العجلة ➔',
    privacy_note: '🔒 سرية تامة. تُستخدم البيانات لتسليم الجائزة وخدمة الحجز فقط.',
    // Step 3
    s3_tag: 'عجلة الحظ الذهبية',
    s3_title: 'دوّر العجلة واربح <span class="highlight-gold">جوائز حصرية</span>',
    s3_desc: 'اضغط على العجلة أو الزر بالأسفل. جائزة فاخرة مضمونة مع كل دورة!',
    btn_tap_spin: 'اضغط لتدوير العجلة الآن 🎯',
    spinning: 'جاري التدوير...',
    // Step 4
    s4_tag: 'مبروك الفوز!',
    s4_title: 'ألف مبروك! <span class="highlight-gold">لقد فزت بـ</span>',
    s4_desc: 'أظهر كود القسيمة عند زيارة مركز فينينو أو تواصل مباشرة عبر واتساب.',
    voucher_label: 'كود القسيمة الحصري الخاص بك',
    btn_copy: 'نسخ الكود',
    btn_copied: 'تم النسخ! ✓',
    btn_download_pdf: 'تحميل شهادة الجائزة (PDF)',
    btn_see_offers: 'عرض باقات المعرض الحصرية ➔',
    // Step 5
    s5_tag: 'عروض معرض أبوظبي الحصرية 2026',
    s5_title: 'احجز <span class="highlight-gold">خصومات المعرض التاريخية</span>',
    s5_desc: 'احجز أي باقة اليوم بعربون 50 درهم فقط (يُخصم بالكامل من فاتورة الخدمة).',
    btn_skip: 'تخطي إلى التأكيد ➔',
    btn_reserve: 'احجز بعربون 50 درهم',
    // Step 6
    s6_tag: 'حجز آمن وفوري',
    s6_title: 'تأكيد حجز الباقة <span class="highlight-gold">بعربون 50 درهم</span>',
    s6_desc: 'مبلغ الـ 50 درهم يُخصم 100% من الفاتورة النهائية وصالح لمدة 90 يوماً.',
    pkg_reserved: 'الباقة المختارة:',
    deposit_label: 'المبلغ المستحق الآن (عربون):',
    balance_label: 'المتبقي عند تقديم الخدمة:',
    deductible_note: '✓ يُخصم مبلغ 50 درهم بالكامل من فاتورة الخدمة عند إحضار السيارة.',
    apple_pay_btn: 'الدفع بواسطة Apple Pay',
    or_card: 'أو الدفع بواسطة البطاقة البنكية',
    card_num: 'رقم البطاقة',
    card_exp: 'الشهر / السنة',
    card_cvc: 'رمز الأمان CVC',
    btn_pay_50: 'تأكيد ودفع 50 درهم ➔',
    btn_back_offers: '← تغيير الباقة',
    // Step 7
    s7_tag: 'تأكيد الحجز والجائزة',
    s7_title: 'تم بنجاح! <span class="highlight-gold">ألف مبروك!</span>',
    s7_desc: 'تم تسجيل جائزتك وتأكيد حجزك وإرسال التفاصيل برسالة نصية إلى هاتفك.',
    summary_name: 'اسم العميل:',
    summary_phone: 'رقم الهاتف:',
    summary_prize: 'الجائزة المكتسبة:',
    summary_code: 'كود القسيمة:',
    summary_pkg: 'الباقة المحجوزة:',
    summary_paid: 'العربون المدفوع:',
    summary_valid: 'فترة الصلاحية:',
    validity_90_days: '90 يوماً (صالحة حتى 5 ديسمبر 2026)',
    btn_whatsapp_concierge: 'محادثة المساعد الفاخر عبر واتساب 💬',
    btn_download_receipt: 'تحميل إيصال وتصريح الحجز (PDF)',
    btn_directions: 'الاتجاهات إلى المركز (مصفح M37) 📍',
    btn_share: 'مشاركة التجربة مع صديق 🔄'
  }
};

// ==========================================================================
// APP STATE
// ==========================================================================
const state = {
  currentLang: 'en',
  currentStep: 1,
  userData: {
    name: '',
    phone: '',
    email: '',
    services: []
  },
  wonPrize: null,
  voucherCode: '',
  selectedPackage: null,
  depositPaid: false,
  isSpinning: false,
  hasSpun: false
};

// ==========================================================================
// INITIALIZATION
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {
  checkCampaignExpiration();
  initLanguage();
  initWheelCanvas();
  initEventListeners();
  initUrgencyPulse();
  renderPackages();
});

// Campaign Expiration Check (Valid through 6 Sept 2026)
function checkCampaignExpiration() {
  const expiryDate = new Date('2026-09-07T00:00:00+04:00');
  const now = new Date();
  if (now > expiryDate) {
    const overlay = document.getElementById('expiredOverlay');
    if (overlay) overlay.classList.add('active');
  }
}

// Language Switching
function initLanguage() {
  const savedLang = sessionStorage.getItem('veneno_adihex_lang') || 'en';
  setLanguage(savedLang);
}

function setLanguage(lang) {
  state.currentLang = lang;
  sessionStorage.setItem('veneno_adihex_lang', lang);
  
  const htmlRoot = document.documentElement;
  htmlRoot.setAttribute('lang', lang);
  htmlRoot.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');

  // Update button text
  const langBtn = document.getElementById('globalLangBtn');
  if (langBtn) {
    langBtn.textContent = I18N[lang].langBtn;
  }

  // Translate all DOM elements with data-i18n
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (I18N[lang] && I18N[lang][key]) {
      el.innerHTML = I18N[lang][key];
    }
  });

  // Translate placeholders
  document.querySelectorAll('[data-i18n-ph]').forEach(el => {
    const key = el.getAttribute('data-i18n-ph');
    if (I18N[lang] && I18N[lang][key]) {
      el.setAttribute('placeholder', I18N[lang][key]);
    }
  });

  // Redraw Wheel
  drawWheel();
  // Re-render packages for language
  renderPackages();
  // Update summaries if on step 4, 6, 7
  updateSummaryDisplays();
}

function toggleLanguage() {
  const nextLang = state.currentLang === 'en' ? 'ar' : 'en';
  setLanguage(nextLang);
}

// Navigation / Step Progression
function goToStep(stepNumber) {
  if (stepNumber < 1 || stepNumber > 7) return;

  state.currentStep = stepNumber;

  // Update Wizard Steps Visibility
  document.querySelectorAll('.wizard-step').forEach(stepEl => {
    stepEl.classList.remove('active');
  });

  const targetStep = document.getElementById(`step-${stepNumber}`);
  if (targetStep) {
    targetStep.classList.add('active');
  }

  // Update Progress Bar
  const progressFill = document.getElementById('progressFill');
  const stepIndicator = document.getElementById('stepIndicator');
  if (progressFill) {
    const pct = (stepNumber / 7) * 100;
    progressFill.style.width = `${pct}%`;
  }
  if (stepIndicator) {
    const t = I18N[state.currentLang];
    stepIndicator.textContent = `${t.step} ${stepNumber} ${t.of}`;
  }

  // Scroll to top
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ==========================================================================
// STEP 1: SELECT LANGUAGE
// ==========================================================================
function selectLanguageAndAdvance(lang) {
  setLanguage(lang);
  goToStep(2);
}

// ==========================================================================
// STEP 2: REGISTRATION
// ==========================================================================
function handleRegistrationSubmit(e) {
  e.preventDefault();

  const nameInput = document.getElementById('regName');
  const phoneInput = document.getElementById('regPhone');
  const emailInput = document.getElementById('regEmail');

  const name = nameInput.value.trim();
  const phone = phoneInput.value.trim();
  const email = emailInput.value.trim();

  if (!name || name.length < 2) {
    alert(state.currentLang === 'ar' ? 'يرجى إدخال الاسم كاملاً' : 'Please enter your full name');
    nameInput.focus();
    return;
  }

  if (!phone || phone.length < 8) {
    alert(state.currentLang === 'ar' ? 'يرجى إدخال رقم هاتف إماراتي صحيح' : 'Please enter a valid UAE mobile number');
    phoneInput.focus();
    return;
  }

  // Collect selected services
  const selectedServices = [];
  document.querySelectorAll('.service-check-item.selected').forEach(item => {
    selectedServices.push(item.getAttribute('data-service'));
  });

  state.userData = { name, phone, email, services: selectedServices };
  sessionStorage.setItem('veneno_user', JSON.stringify(state.userData));

  goToStep(3);
}

// Service checkbox toggle helper
function toggleServiceCheck(el) {
  el.classList.toggle('selected');
}

// ==========================================================================
// STEP 3: HTML5 CANVAS WHEEL ENGINE
// ==========================================================================
let currentWheelAngle = 0;

function initWheelCanvas() {
  drawWheel();
}

function drawWheel(angleOffset = 0) {
  const canvas = document.getElementById('wheelCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const dpr = window.devicePixelRatio || 1;
  
  canvas.width = 320 * dpr;
  canvas.height = 320 * dpr;
  ctx.scale(dpr, dpr);

  const cx = 160;
  const cy = 160;
  const radius = 150;
  const numSlices = PRIZES.length;
  const arc = (2 * Math.PI) / numSlices;

  ctx.clearRect(0, 0, 320, 320);

  // Outer Golden Rim
  ctx.save();
  ctx.beginPath();
  ctx.arc(cx, cy, radius + 4, 0, 2 * Math.PI);
  ctx.fillStyle = '#C9A84C';
  ctx.shadowColor = 'rgba(201, 168, 76, 0.4)';
  ctx.shadowBlur = 12;
  ctx.fill();
  ctx.restore();

  // Draw Segments
  for (let i = 0; i < numSlices; i++) {
    const prize = PRIZES[i];
    const angle = angleOffset + i * arc;

    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.arc(cx, cy, radius, angle, angle + arc);
    ctx.fillStyle = prize.color;
    ctx.fill();

    ctx.lineWidth = 1.5;
    ctx.strokeStyle = 'rgba(201, 168, 76, 0.5)';
    ctx.stroke();

    // Segment Text
    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(angle + arc / 2);
    ctx.textAlign = 'right';
    ctx.fillStyle = prize.textColor;
    ctx.font = 'bold 10.5px Outfit, Cairo, sans-serif';

    const text = state.currentLang === 'ar' ? prize.nameAr : prize.nameEn;
    // Truncate long text if needed
    const shortText = text.length > 22 ? text.substring(0, 20) + '..' : text;
    ctx.fillText(shortText, radius - 18, 4);
    ctx.restore();
  }

  // Draw Segment boundary studs (decorative luxury watch feel)
  for (let i = 0; i < numSlices; i++) {
    const angle = angleOffset + i * arc;
    const sx = cx + (radius - 5) * Math.cos(angle);
    const sy = cy + (radius - 5) * Math.sin(angle);
    ctx.beginPath();
    ctx.arc(sx, sy, 2.5, 0, 2 * Math.PI);
    ctx.fillStyle = '#F2DA96';
    ctx.fill();
  }
}

// Weighted Prize Selection Algorithm
function selectWeightedPrize() {
  const totalWeight = PRIZES.reduce((sum, p) => sum + p.weight, 0);
  let random = Math.random() * totalWeight;

  for (let i = 0; i < PRIZES.length; i++) {
    if (random < PRIZES[i].weight) {
      return { prize: PRIZES[i], index: i };
    }
    random -= PRIZES[i].weight;
  }
  return { prize: PRIZES[0], index: 0 };
}

function spinWheel() {
  if (state.isSpinning || state.hasSpun) return;

  state.isSpinning = true;
  const spinBtn = document.getElementById('spinActionBtn');
  if (spinBtn) {
    spinBtn.disabled = true;
    spinBtn.textContent = I18N[state.currentLang].spinning;
  }

  const { prize, index } = selectWeightedPrize();
  state.wonPrize = prize;
  state.voucherCode = generateVoucherCode();

  const numSlices = PRIZES.length;
  const sliceArc = 360 / numSlices;
  
  // The pointer is at the top (270 deg or -90 deg).
  // Target angle aligns the middle of the selected slice to the top pointer
  const targetSliceMiddle = (index * sliceArc) + (sliceArc / 2);
  const extraFullSpins = (5 + Math.floor(Math.random() * 3)) * 360; // 5 to 7 full rotations
  // Note: Canvas rotation moves clockwise, so we rotate (extra - target)
  const finalRotation = extraFullSpins + (360 - targetSliceMiddle) + 270;

  const canvas = document.getElementById('wheelCanvas');
  canvas.style.transform = `rotate(${finalRotation}deg)`;

  // After animation finishes (4.5s)
  setTimeout(() => {
    state.isSpinning = false;
    state.hasSpun = true;
    sessionStorage.setItem('veneno_prize', JSON.stringify(prize));
    sessionStorage.setItem('veneno_voucher', state.voucherCode);

    triggerConfetti();
    displayPrizeReveal();
    goToStep(4);
  }, 4700);
}

function generateVoucherCode() {
  const randNum = Math.floor(1000 + Math.random() * 9000);
  return `VEN-ADIHEX-${randNum}`;
}

// ==========================================================================
// STEP 4: PRIZE REVEAL & PDF CERTIFICATE
// ==========================================================================
function displayPrizeReveal() {
  if (!state.wonPrize) return;

  const prizeNameEl = document.getElementById('revealPrizeName');
  const prizeValEl = document.getElementById('revealPrizeVal');
  const voucherCodeEl = document.getElementById('revealVoucherCode');

  if (prizeNameEl) {
    prizeNameEl.textContent = state.currentLang === 'ar' ? state.wonPrize.nameAr : state.wonPrize.nameEn;
  }
  if (prizeValEl) {
    prizeValEl.textContent = `${state.currentLang === 'ar' ? 'القيمة التقديرية:' : 'Estimated Value:'} ${state.wonPrize.value}`;
  }
  if (voucherCodeEl) {
    voucherCodeEl.textContent = state.voucherCode;
  }
}

function copyVoucherCode() {
  if (!state.voucherCode) return;
  navigator.clipboard.writeText(state.voucherCode).then(() => {
    const copyBtn = document.getElementById('copyCodeBtn');
    if (copyBtn) {
      const originalText = copyBtn.innerHTML;
      copyBtn.textContent = I18N[state.currentLang].btn_copied;
      setTimeout(() => {
        copyBtn.innerHTML = originalText;
      }, 2000);
    }
  });
}

// Client-Side PDF Certificate Generator using Canvas / DataURI
function downloadPrizeCertificate() {
  const canvas = document.createElement('canvas');
  canvas.width = 1200;
  canvas.height = 700;
  const ctx = canvas.getContext('2d');

  // Luxury Background
  const grad = ctx.createLinearGradient(0, 0, 1200, 700);
  grad.addColorStop(0, '#09090B');
  grad.addColorStop(0.5, '#131317');
  grad.addColorStop(1, '#09090B');
  ctx.fillStyle = grad;
  ctx.fillRect(0, 0, 1200, 700);

  // Outer Golden Double Border
  ctx.strokeStyle = '#C9A84C';
  ctx.lineWidth = 4;
  ctx.strokeRect(30, 30, 1140, 640);
  ctx.lineWidth = 1;
  ctx.strokeRect(38, 38, 1124, 624);

  // Header Title
  ctx.textAlign = 'center';
  ctx.fillStyle = '#C9A84C';
  ctx.font = 'bold 20px sans-serif';
  ctx.fillText('VENENO AUTO CARE CENTER × ADIHEX 2026', 600, 95);

  ctx.fillStyle = '#FFFFFF';
  ctx.font = 'bold 36px sans-serif';
  ctx.fillText('OFFICIAL PRIZE CERTIFICATE', 600, 150);

  // Winner Information
  ctx.fillStyle = '#A0A0A0';
  ctx.font = '18px sans-serif';
  ctx.fillText('THIS CERTIFICATE IS PRESENTED TO', 600, 210);

  ctx.fillStyle = '#F2DA96';
  ctx.font = 'bold 32px sans-serif';
  ctx.fillText((state.userData.name || 'Valued ADIHEX Guest').toUpperCase(), 600, 260);

  // Prize Won Box
  ctx.fillStyle = 'rgba(227, 30, 36, 0.15)';
  ctx.fillRect(200, 300, 800, 100);
  ctx.strokeStyle = '#E31E24';
  ctx.lineWidth = 2;
  ctx.strokeRect(200, 300, 800, 100);

  ctx.fillStyle = '#FFFFFF';
  ctx.font = 'bold 28px sans-serif';
  const prizeTitle = state.wonPrize ? state.wonPrize.nameEn : 'VIP Service Discount';
  ctx.fillText(prizeTitle.toUpperCase(), 600, 358);

  // Voucher Code & Meta
  ctx.fillStyle = '#C9A84C';
  ctx.font = 'bold 22px monospace';
  ctx.fillText(`VOUCHER CODE: ${state.voucherCode}`, 600, 450);

  ctx.fillStyle = '#888888';
  ctx.font = '14px sans-serif';
  ctx.fillText('Valid for 90 Days (Until 5 December 2026) • Redeemable at Musaffah M37, Abu Dhabi', 600, 490);
  ctx.fillText(`Issued at ADNEC Centre Abu Dhabi on ${new Date().toLocaleDateString('en-GB')}`, 600, 520);

  // Security Seal Badge
  ctx.strokeStyle = '#C9A84C';
  ctx.beginPath();
  ctx.arc(600, 600, 30, 0, 2 * Math.PI);
  ctx.stroke();
  ctx.fillStyle = '#C9A84C';
  ctx.font = 'bold 10px sans-serif';
  ctx.fillText('VERIFIED', 600, 604);

  // Download Trigger
  const link = document.createElement('a');
  link.download = `Veneno_Prize_Certificate_${state.voucherCode}.png`;
  link.href = canvas.toDataURL('image/png');
  link.click();
}

// ==========================================================================
// STEP 5: EXCLUSIVE PACKAGES
// ==========================================================================
function renderPackages() {
  const container = document.getElementById('packagesContainer');
  if (!container) return;

  container.innerHTML = '';
  const isAr = state.currentLang === 'ar';

  PACKAGES.forEach((pkg, index) => {
    const card = document.createElement('div');
    card.className = `package-card ${pkg.isPlatinum ? 'platinum-card' : ''} ${state.selectedPackage && state.selectedPackage.id === pkg.id ? 'highlighted' : ''}`;
    card.setAttribute('data-pkg-id', pkg.id);
    card.onclick = () => selectPackage(pkg);

    const title = isAr ? pkg.titleAr : pkg.titleEn;
    const badge = isAr ? pkg.badgeAr : pkg.badgeEn;
    const features = isAr ? pkg.featuresAr : pkg.featuresEn;
    const reserveText = I18N[state.currentLang].btn_reserve;

    card.innerHTML = `
      <div class="package-top">
        <div class="package-title">${title}</div>
        <div class="package-badge ${pkg.badgeClass}">${badge}</div>
      </div>
      <ul class="package-features">
        ${features.map(f => `<li><i class="fa-solid fa-check"></i> <span>${f}</span></li>`).join('')}
      </ul>
      <div class="package-bottom">
        <div class="price-box">
          <div class="was-price">${pkg.wasPrice}</div>
          <div class="now-price">${pkg.nowPrice}</div>
        </div>
        <button type="button" class="btn-reserve-small">
          <i class="fa-solid fa-lock"></i> ${reserveText}
        </button>
      </div>
    `;

    container.appendChild(card);
  });
}

function selectPackage(pkg) {
  state.selectedPackage = pkg;
  sessionStorage.setItem('veneno_package', JSON.stringify(pkg));

  document.querySelectorAll('.package-card').forEach(c => {
    c.classList.remove('highlighted');
    if (c.getAttribute('data-pkg-id') === pkg.id) {
      c.classList.add('highlighted');
    }
  });

  updatePaymentSummary();
  goToStep(6);
}

function skipOffersToConfirmation() {
  state.selectedPackage = null;
  sessionStorage.removeItem('veneno_package');
  updateConfirmationSummary();
  goToStep(7);
}

// ==========================================================================
// STEP 6: STRIPE PAYMENT CHECKOUT MOCKUP
// ==========================================================================
function updatePaymentSummary() {
  if (!state.selectedPackage) return;
  const isAr = state.currentLang === 'ar';

  const pkgTitleEl = document.getElementById('paySummaryPkgTitle');
  const pkgPriceEl = document.getElementById('paySummaryPkgPrice');
  const balanceEl = document.getElementById('paySummaryBalance');

  if (pkgTitleEl) {
    pkgTitleEl.textContent = isAr ? state.selectedPackage.titleAr : state.selectedPackage.titleEn;
  }
  if (pkgPriceEl) {
    pkgPriceEl.textContent = state.selectedPackage.nowPrice;
  }
  if (balanceEl) {
    // Extract numerical value and subtract 50
    const rawNum = parseInt(state.selectedPackage.nowPrice.replace(/[^0-9]/g, ''), 10);
    const balance = isNaN(rawNum) ? '---' : `AED ${(rawNum - 50).toLocaleString()}`;
    balanceEl.textContent = balance;
  }
}

function processMockPayment(methodName = 'Card') {
  const payBtn = document.getElementById('confirmPayBtn');
  if (payBtn) {
    payBtn.disabled = true;
    payBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> ${state.currentLang === 'ar' ? 'جاري معالجة الدفع...' : 'Processing Secure Payment...'}`;
  }

  setTimeout(() => {
    state.depositPaid = true;
    sessionStorage.setItem('veneno_deposit_paid', 'true');
    updateConfirmationSummary();
    goToStep(7);
  }, 1800);
}

// ==========================================================================
// STEP 7: CONFIRMATION & WHATSAPP
// ==========================================================================
function updateConfirmationSummary() {
  const isAr = state.currentLang === 'ar';
  
  const nameEl = document.getElementById('confName');
  const phoneEl = document.getElementById('confPhone');
  const prizeEl = document.getElementById('confPrize');
  const codeEl = document.getElementById('confCode');
  const pkgRowEl = document.getElementById('confPkgRow');
  const pkgNameEl = document.getElementById('confPkgName');
  const paidRowEl = document.getElementById('confPaidRow');

  if (nameEl) nameEl.textContent = state.userData.name || '---';
  if (phoneEl) phoneEl.textContent = state.userData.phone || '---';
  if (prizeEl && state.wonPrize) {
    prizeEl.textContent = isAr ? state.wonPrize.nameAr : state.wonPrize.nameEn;
  }
  if (codeEl) codeEl.textContent = state.voucherCode || '---';

  if (state.selectedPackage) {
    if (pkgRowEl) pkgRowEl.style.display = 'flex';
    if (pkgNameEl) pkgNameEl.textContent = isAr ? state.selectedPackage.titleAr : state.selectedPackage.titleEn;
    if (paidRowEl) paidRowEl.style.display = 'flex';
  } else {
    if (pkgRowEl) pkgRowEl.style.display = 'none';
    if (paidRowEl) paidRowEl.style.display = 'none';
  }

  // Configure WhatsApp link
  const waBtn = document.getElementById('whatsappConciergeBtn');
  if (waBtn) {
    const prizeName = state.wonPrize ? (isAr ? state.wonPrize.nameAr : state.wonPrize.nameEn) : 'ADIHEX Prize';
    const pkgName = state.selectedPackage ? (isAr ? state.selectedPackage.titleAr : state.selectedPackage.titleEn) : 'No Package';
    const message = isAr
      ? `مرحباً مركز فينينو، لقد شاركت في سحب معرض أبوظبي الدولي للصيد والفروسية ADIHEX 2026.\nالاسم: ${state.userData.name}\nالهاتف: ${state.userData.phone}\nالجائزة: ${prizeName}\nكود القسيمة: ${state.voucherCode}\nالباقة: ${pkgName}`
      : `Hello Veneno Auto Care, I participated in your ADIHEX 2026 booth activation.\nName: ${state.userData.name}\nPhone: ${state.userData.phone}\nPrize Won: ${prizeName}\nVoucher Code: ${state.voucherCode}\nReserved Package: ${pkgName}`;

    waBtn.href = `https://wa.me/97126344403?text=${encodeURIComponent(message)}`;
  }
}

function updateSummaryDisplays() {
  if (state.currentStep === 4) displayPrizeReveal();
  if (state.currentStep === 6) updatePaymentSummary();
  if (state.currentStep === 7) updateConfirmationSummary();
}

// ==========================================================================
// PARTICLES CONFETTI ENGINE
// ==========================================================================
function triggerConfetti() {
  const canvas = document.getElementById('confettiCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const particles = [];
  const colors = ['#E31E24', '#C9A84C', '#FFFFFF', '#F2DA96', '#FFA3A6'];

  for (let i = 0; i < 120; i++) {
    particles.push({
      x: canvas.width / 2,
      y: canvas.height / 2,
      vx: (Math.random() - 0.5) * 16,
      vy: (Math.random() - 0.7) * 18,
      size: Math.random() * 8 + 4,
      color: colors[Math.floor(Math.random() * colors.length)],
      rotation: Math.random() * 360,
      vRot: (Math.random() - 0.5) * 10,
      opacity: 1
    });
  }

  let animationFrame;
  function render() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    let alive = false;

    particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;
      p.vy += 0.35; // gravity
      p.rotation += p.vRot;
      p.opacity -= 0.007;

      if (p.opacity > 0) {
        alive = true;
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate((p.rotation * Math.PI) / 180);
        ctx.globalAlpha = Math.max(0, p.opacity);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size);
        ctx.restore();
      }
    });

    if (alive) {
      animationFrame = requestAnimationFrame(render);
    } else {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      cancelAnimationFrame(animationFrame);
    }
  }

  render();
}

// ==========================================================================
// URGENCY PULSE SIMULATOR
// ==========================================================================
function initUrgencyPulse() {
  let count = 184 + Math.floor(Math.random() * 20);
  const countEl = document.getElementById('liveSpinCount');
  if (countEl) countEl.textContent = count;

  setInterval(() => {
    if (Math.random() > 0.4) {
      count += 1;
      if (countEl) countEl.textContent = count;
    }
  }, 12000);
}

// ==========================================================================
// EVENT LISTENERS BINDING
// ==========================================================================
function initEventListeners() {
  const regForm = document.getElementById('registrationForm');
  if (regForm) regForm.addEventListener('submit', handleRegistrationSubmit);

  const spinBtn = document.getElementById('spinActionBtn');
  if (spinBtn) spinBtn.addEventListener('click', spinWheel);

  const wheelCanvas = document.getElementById('wheelCanvas');
  if (wheelCanvas) wheelCanvas.addEventListener('click', spinWheel);
}
