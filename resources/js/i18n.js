import { ref, computed } from 'vue';
import en from './locales/en.json';
import ar from './locales/ar.json';

// Supported locales dictionary registry (plug-and-play for future languages)
export const messages = {
  en,
  ar,
};

export const supportedLocales = ['en', 'ar'];
export const defaultLocale = 'en';

export const currentLocale = ref(defaultLocale);

export const isRTL = computed(() => currentLocale.value === 'ar');

/**
 * Detect initial locale based on stored user preference or browser/device language
 */
export function detectInitialLocale() {
  if (typeof window === 'undefined') return defaultLocale;

  // 1. Check user's previous preference in localStorage
  const saved = localStorage.getItem('veneno_locale');
  if (saved && supportedLocales.includes(saved)) {
    return saved;
  }

  // 2. Check device / browser language
  const browserLang = navigator.language || navigator.userLanguage || '';
  if (browserLang.toLowerCase().startsWith('ar')) {
    return 'ar';
  }

  return defaultLocale;
}

/**
 * Switch active locale, update localStorage, and configure document dir & lang
 */
export function setLocale(lang) {
  if (!supportedLocales.includes(lang)) {
    lang = defaultLocale;
  }

  currentLocale.value = lang;

  if (typeof window !== 'undefined') {
    localStorage.setItem('veneno_locale', lang);
    document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
    document.documentElement.lang = lang;
  }
}

/**
 * Translation helper with nested key support and param interpolation:
 * e.g., t('nav.home'), t('services.hoursApplication', { hours: 8 })
 */
export function t(key, params = {}) {
  const lang = currentLocale.value || defaultLocale;
  const dict = messages[lang] || messages[defaultLocale];

  const keys = key.split('.');
  let value = dict;

  for (const k of keys) {
    if (value && typeof value === 'object' && k in value) {
      value = value[k];
    } else {
      // Fallback to English dictionary
      let fallback = messages[defaultLocale];
      for (const fk of keys) {
        if (fallback && typeof fallback === 'object' && fk in fallback) {
          fallback = fallback[fk];
        } else {
          fallback = key;
          break;
        }
      }
      value = fallback;
      break;
    }
  }

  if (typeof value !== 'string') {
    return key;
  }

  // Replace parameters {paramName}
  return value.replace(/\{(\w+)\}/g, (match, paramName) => {
    return params[paramName] !== undefined ? params[paramName] : match;
  });
}

/**
 * Converts a current URL/path to the equivalent URL in targetLocale:
 * e.g. /en/services/ppf -> /ar/services/ppf
 */
export function getLocalizedPath(pathname, targetLocale) {
  if (!pathname) return `/${targetLocale}`;

  const cleanPath = pathname.startsWith('/') ? pathname : `/${pathname}`;
  const parts = cleanPath.split('/').filter(Boolean);

  if (parts.length > 0 && supportedLocales.includes(parts[0])) {
    parts[0] = targetLocale;
    return `/${parts.join('/')}`;
  }

  return `/${targetLocale}${cleanPath}`;
}

export function useI18n() {
  return {
    t,
    currentLocale,
    isRTL,
    setLocale,
    supportedLocales,
    getLocalizedPath,
  };
}
