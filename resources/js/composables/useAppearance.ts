import { onMounted, ref } from 'vue';

type Appearance = 'light' | 'dark' | 'system';

export function updateTheme() {
  if (typeof window === 'undefined') {
    return;
  }
  // 永遠移除 dark class，強制淺色模式
  document.documentElement.classList.remove('dark');
}

const setCookie = (name: string, value: string, days = 365) => {
  if (typeof document === 'undefined') {
    return;
  }

  const maxAge = days * 24 * 60 * 60;

  document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const mediaQuery = () => {
  if (typeof window === 'undefined') {
    return null;
  }

  return window.matchMedia('(prefers-color-scheme: dark)');
};

const getStoredAppearance = () => {
  if (typeof window === 'undefined') {
    return null;
  }

  return localStorage.getItem('appearance') as Appearance | null;
};

const handleSystemThemeChange = () => {
  const currentAppearance = getStoredAppearance();

  updateTheme(currentAppearance || 'system');
};

export function initializeTheme() {
  if (typeof window === 'undefined') {
    return;
  }
  document.documentElement.classList.remove('dark'); // 強制移除
  // Initialize theme from saved preference or default to system...
  const savedAppearance = getStoredAppearance();
  updateTheme(savedAppearance || 'system');

  // Set up system theme change listener...
  mediaQuery()?.addEventListener('change', handleSystemThemeChange);
}

export function useAppearance() {
  const appearance = ref<Appearance>('system');

  onMounted(() => {
    initializeTheme();

    const savedAppearance = localStorage.getItem('appearance') as Appearance | null;

    if (savedAppearance) {
      appearance.value = savedAppearance;
    }
  });

  function updateAppearance(value: Appearance) {
    appearance.value = value;

    // Store in localStorage for client-side persistence...
    localStorage.setItem('appearance', value);

    // Store in cookie for SSR...
    setCookie('appearance', value);

    updateTheme(value);
  }

  return {
    appearance,
    updateAppearance,
  };
}
