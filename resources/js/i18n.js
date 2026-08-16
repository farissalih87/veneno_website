import { ref, computed } from 'vue';
import enMessages from './locales/en.json';
import arMessages from './locales/ar.json';

export const supportedLocales = ['en', 'ar'];
export const defaultLocale = 'en';

const messages = {
  en: enMessages,
  ar: arMessages,
};

// Detect initial locale from LocalStorage or Browser Language
export function detectInitialLocale() {
  if (typeof window !== 'undefined') {
    const saved = localStorage.getItem('veneno_locale');
    if (saved && supportedLocales.includes(saved)) {
      return saved;
    }

    const browserLang = (navigator.language || navigator.userLanguage || '').toLowerCase();
    if (browserLang.startsWith('ar')) {
      return 'ar';
    }
  }

  return defaultLocale;
}

export const currentLocaleRef = ref(detectInitialLocale());

export function setLocale(lang) {
  if (!supportedLocales.includes(lang)) return;

  currentLocaleRef.value = lang;

  if (typeof window !== 'undefined') {
    localStorage.setItem('veneno_locale', lang);
    document.documentElement.dir = (lang === 'ar' ? 'rtl' : 'ltr');
    document.documentElement.lang = lang;
  }
}

export function getLocalizedPath(pathname, targetLocale) {
  return pathname || '/';
}

export function t(keyPath, params = {}) {
  const locale = currentLocaleRef.value;
  const localeDict = messages[locale] || messages[defaultLocale];
  const fallbackDict = messages[defaultLocale];

  const keys = keyPath.split('.');
  let result = localeDict;

  for (const key of keys) {
    if (result && result[key] !== undefined) {
      result = result[key];
    } else {
      result = undefined;
      break;
    }
  }

  // Fallback if key is missing in active locale
  if (result === undefined) {
    result = fallbackDict;
    for (const key of keys) {
      if (result && result[key] !== undefined) {
        result = result[key];
      } else {
        result = keyPath;
        break;
      }
    }
  }

  if (typeof result !== 'string') {
    return keyPath;
  }

  // Replace interpolation params: {name}, {hours}, etc.
  let text = result;
  for (const [paramKey, paramVal] of Object.entries(params)) {
    text = text.replaceAll(`{${paramKey}}`, paramVal);
  }

  return text;
}

export function useI18n() {
  const currentLocale = computed(() => currentLocaleRef.value);
  const isRTL = computed(() => currentLocaleRef.value === 'ar');

  return {
    currentLocale,
    isRTL,
    setLocale,
    t,
    getLocalizedPath,
  };
}
