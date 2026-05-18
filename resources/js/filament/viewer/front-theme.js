const PREF_KEYS = {
  theme: 'viewer_front_theme',
  fontSize: 'viewer_front_font_size',
  currency: 'viewer_front_currency',
  area: 'viewer_front_area',
  ownership: 'viewer_front_ownership',
  panelColor: 'viewer_front_panel_color',
  fontColor: 'viewer_front_font_color',
  navbarColor: 'viewer_front_navbar_color',
  headerColor: 'viewer_front_header_color',
  tableColor: 'viewer_front_table_color',
  lang: 'viewer_front_lang',
  fontFamily: 'viewer_front_font_family',
  sidebarCollapsed: 'viewer_front_sidebar_collapsed',
};

const DEFAULTS = {
  theme: 'dark',
  fontSize: 'normal',
  currency: 'USD',
  area: 'm2',
  ownership: 'sahm',
  panelColor: 'default',
  fontColor: 'default',
  navbarColor: 'default',
  headerColor: 'default',
  tableColor: 'default',
  lang: 'ar',
  fontFamily: 'Tajawal',
};

let topbarClockInterval = null;
let globalListenersBound = false;

function getViewerRoot() {
  return document.querySelector('.viewer-front');
}

function savePreference(key, value) {
  try { localStorage.setItem(key, value); } catch (_) {}
}

function getPreference(key, fallback = null) {
  try { return localStorage.getItem(key) ?? fallback; } catch (_) { return fallback; }
}

function setActiveButton(buttonId, isActive) {
  const el = document.getElementById(buttonId);
  if (!el) return;
  el.classList.toggle('active', !!isActive);
  el.setAttribute('aria-pressed', isActive ? 'true' : 'false');
}

function setActiveFromMap(value, map) {
  Object.entries(map).forEach(([option, id]) => setActiveButton(id, option === value));
}

function applyCssVars(root, vars = {}) {
  if (!root) return;
  Object.entries(vars).forEach(([name, value]) => {
    if (value === null || value === undefined || value === '') {
      root.style.removeProperty(name);
      return;
    }
    root.style.setProperty(name, value);
  });
}

function getThemeMode(root) {
  if (!root) return DEFAULTS.theme;
  const attr = root.getAttribute('data-theme');
  return attr === 'light' ? 'light' : 'dark';
}

function toggleQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trigger = document.getElementById('qs-fab-trigger');
  if (!fab) return;
  const isOpen = fab.classList.toggle('open');
  if (trigger) trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

function closeQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trigger = document.getElementById('qs-fab-trigger');
  if (fab) fab.classList.remove('open');
  if (trigger) trigger.setAttribute('aria-expanded', 'false');
}

function setThemePref(theme) {
  const root = getViewerRoot();
  const allowed = ['dark', 'light'];
  const finalTheme = allowed.includes(theme) ? theme : DEFAULTS.theme;
  if (root) {
    if (finalTheme === 'light') root.setAttribute('data-theme', 'light');
    else root.setAttribute('data-theme', 'dark');
  }
  savePreference(PREF_KEYS.theme, finalTheme);
  setActiveFromMap(finalTheme, { dark: 'theme-dark-btn', light: 'theme-light-btn' });
  const panelColor = getPreference(PREF_KEYS.panelColor, DEFAULTS.panelColor);
  const navColor = getPreference(PREF_KEYS.navbarColor, DEFAULTS.navbarColor);
  const headerColor = getPreference(PREF_KEYS.headerColor, DEFAULTS.headerColor);
  const tableColor = getPreference(PREF_KEYS.tableColor, DEFAULTS.tableColor);
  setPanelColor(panelColor);
  setNavbarColor(navColor);
  setHeaderColor(headerColor);
  setTableColor(tableColor);
}

function setFontSize(size) {
  const root = getViewerRoot();
  const map = { normal: '15px', large: '17px', xl: '20px', xxl: '22px' };
  const finalSize = map[size] ? size : DEFAULTS.fontSize;
  if (root) applyCssVars(root, { '--fs-base': map[finalSize] });
  savePreference(PREF_KEYS.fontSize, finalSize);
  setActiveFromMap(finalSize, { normal: 'fs-normal-btn', large: 'fs-large-btn', xl: 'fs-xl-btn', xxl: 'fs-xxl-btn' });
}

function setCurrency(currency) {
  const finalValue = ['USD', 'LBP', 'AED'].includes(currency) ? currency : DEFAULTS.currency;
  savePreference(PREF_KEYS.currency, finalValue);
  setActiveFromMap(finalValue, { USD: 'cur-usd-btn', LBP: 'cur-lbp-btn', AED: 'cur-aed-btn' });
}

function setArea(area) {
  const finalValue = ['m2', 'ft2'].includes(area) ? area : DEFAULTS.area;
  savePreference(PREF_KEYS.area, finalValue);
  setActiveFromMap(finalValue, { m2: 'area-m2-btn', ft2: 'area-ft2-btn' });
}

function setOwnership(ownership) {
  const finalValue = ['sahm', 'pct'].includes(ownership) ? ownership : DEFAULTS.ownership;
  savePreference(PREF_KEYS.ownership, finalValue);
  setActiveFromMap(finalValue, { sahm: 'own-sahm-btn', pct: 'own-pct-btn' });
}

const PANEL_COLORS = {
  default: null,
  plum: { '--qs-panel-bg': '#1E1428', '--qs-panel-border': '#3E2860', '--qs-panel-head-bg': '#180F22' },
  slate: { '--qs-panel-bg': '#1E2530', '--qs-panel-border': '#3A4558', '--qs-panel-head-bg': '#1A2030' },
  navy: { '--qs-panel-bg': '#111A2E', '--qs-panel-border': '#2A3F6A', '--qs-panel-head-bg': '#0D1526' },
  forest: { '--qs-panel-bg': '#111E18', '--qs-panel-border': '#26432E', '--qs-panel-head-bg': '#0D1A13' },
  stone: { '--qs-panel-bg': '#1E1C18', '--qs-panel-border': '#3D3830', '--qs-panel-head-bg': '#191712' },
  rose: { '--qs-panel-bg': '#241420', '--qs-panel-border': '#5C2845', '--qs-panel-head-bg': '#1C0D19' },
  teal: { '--qs-panel-bg': '#0F1E20', '--qs-panel-border': '#1E4A50', '--qs-panel-head-bg': '#0A1618' },
  gold: { '--qs-panel-bg': '#201A0A', '--qs-panel-border': '#5A4510', '--qs-panel-head-bg': '#181200' },
};

function setPanelColor(color) {
  const root = getViewerRoot();
  const finalValue = PANEL_COLORS[color] !== undefined ? color : DEFAULTS.panelColor;
  if (root) {
    const vars = PANEL_COLORS[finalValue];
    if (!vars) applyCssVars(root, { '--qs-panel-bg': null, '--qs-panel-border': null, '--qs-panel-head-bg': null });
    else applyCssVars(root, vars);
  }
  savePreference(PREF_KEYS.panelColor, finalValue);
  setActiveFromMap(finalValue, {
    default: 'panel-color-default-btn', plum: 'panel-color-plum-btn', slate: 'panel-color-slate-btn', navy: 'panel-color-navy-btn',
    forest: 'panel-color-forest-btn', stone: 'panel-color-stone-btn', rose: 'panel-color-rose-btn', teal: 'panel-color-teal-btn', gold: 'panel-color-gold-btn',
  });
}

const FONT_COLORS = {
  default: null,
  ivory: { '--text-primary': '#F5F0E8', '--text-secondary': '#D8CCBC', '--text-muted': '#BCAF9F' },
  gold: { '--text-primary': '#F5E9C0', '--text-secondary': '#E8C96A', '--text-muted': '#D4AF37' },
  silver: { '--text-primary': '#E5E7EB', '--text-secondary': '#CBD5E1', '--text-muted': '#94A3B8' },
  mint: { '--text-primary': '#D1FAE5', '--text-secondary': '#A7F3D0', '--text-muted': '#6EE7B7' },
  rose: { '--text-primary': '#FCE7F3', '--text-secondary': '#F9A8D4', '--text-muted': '#F472B6' },
};

function setFontColor(color) { const root = getViewerRoot(); const v = FONT_COLORS[color] !== undefined ? color : DEFAULTS.fontColor; if (root) { const vars = FONT_COLORS[v]; if (!vars) applyCssVars(root, { '--text-primary': null, '--text-secondary': null, '--text-muted': null }); else applyCssVars(root, vars); } savePreference(PREF_KEYS.fontColor, v); setActiveFromMap(v, { default: 'font-color-default-btn', ivory: 'font-color-ivory-btn', gold: 'font-color-gold-btn', silver: 'font-color-silver-btn', mint: 'font-color-mint-btn', rose: 'font-color-rose-btn' }); }

const NAV_COLOR_VARS = {
  default: null,
  obsidian: { '--nav-surface': '#111827', '--nav-border': '#334155', '--nav-hover-bg': 'rgba(96,165,250,.10)', '--nav-active-bg': 'rgba(96,165,250,.18)', '--nav-active-border': 'rgba(96,165,250,.35)', '--nav-active-text': '#BFDBFE', '--nav-accent-bar': '#60A5FA' },
  sand: { '--nav-surface': '#2A2016', '--nav-border': '#5B452E', '--nav-hover-bg': 'rgba(245,158,11,.10)', '--nav-active-bg': 'rgba(245,158,11,.17)', '--nav-active-border': 'rgba(245,158,11,.32)', '--nav-active-text': '#FDE68A', '--nav-accent-bar': '#F59E0B' },
  emerald: { '--nav-surface': '#162E25', '--nav-border': '#2C5848', '--nav-hover-bg': 'rgba(16,185,129,.10)', '--nav-active-bg': 'rgba(16,185,129,.17)', '--nav-active-border': 'rgba(16,185,129,.32)', '--nav-active-text': '#A7F3D0', '--nav-accent-bar': '#10B981' },
  royal: { '--nav-surface': '#211A38', '--nav-border': '#4A3C7C', '--nav-hover-bg': 'rgba(139,92,246,.10)', '--nav-active-bg': 'rgba(139,92,246,.17)', '--nav-active-border': 'rgba(167,139,250,.32)', '--nav-active-text': '#DDD6FE', '--nav-accent-bar': '#8B5CF6' },
  burgundy: { '--nav-surface': '#301924', '--nav-border': '#673548', '--nav-hover-bg': 'rgba(244,114,182,.10)', '--nav-active-bg': 'rgba(244,114,182,.17)', '--nav-active-border': 'rgba(244,114,182,.32)', '--nav-active-text': '#FBCFE8', '--nav-accent-bar': '#F472B6' },
};
function setNavbarColor(color) { const root = getViewerRoot(); const v = NAV_COLOR_VARS[color] !== undefined ? color : DEFAULTS.navbarColor; if (root) { const vars = NAV_COLOR_VARS[v]; if (!vars) applyCssVars(root, { '--nav-surface': null, '--nav-border': null, '--nav-hover-bg': null, '--nav-active-bg': null, '--nav-active-border': null, '--nav-active-text': null, '--nav-accent-bar': null }); else applyCssVars(root, vars); } savePreference(PREF_KEYS.navbarColor, v); setActiveFromMap(v, { default: 'nav-color-default-btn', obsidian: 'nav-color-obsidian-btn', sand: 'nav-color-sand-btn', emerald: 'nav-color-emerald-btn', royal: 'nav-color-royal-btn', burgundy: 'nav-color-burgundy-btn' }); }

const HEADER_COLOR_VARS = {
  default: null,
  obsidian: { '--header-surface': 'rgba(12,18,28,.9)', '--header-border': '#2B3A52', '--header-title-accent': '#93C5FD', '--header-eyebrow': '#7FB3F4' },
  sand: { '--header-surface': 'rgba(36,24,14,.9)', '--header-border': '#5A422A', '--header-title-accent': '#FCD34D', '--header-eyebrow': '#E7BC58' },
  emerald: { '--header-surface': 'rgba(14,34,28,.9)', '--header-border': '#2A584A', '--header-title-accent': '#6EE7B7', '--header-eyebrow': '#64D5A7' },
  royal: { '--header-surface': 'rgba(24,18,42,.9)', '--header-border': '#473A77', '--header-title-accent': '#C4B5FD', '--header-eyebrow': '#AE99F4' },
  burgundy: { '--header-surface': 'rgba(39,18,24,.9)', '--header-border': '#663043', '--header-title-accent': '#F9A8D4', '--header-eyebrow': '#F28DBF' },
};
function setHeaderColor(color) { const root = getViewerRoot(); const v = HEADER_COLOR_VARS[color] !== undefined ? color : DEFAULTS.headerColor; if (root) { const vars = HEADER_COLOR_VARS[v]; if (!vars) applyCssVars(root, { '--header-surface': null, '--header-border': null, '--header-title-accent': null, '--header-eyebrow': null }); else applyCssVars(root, vars); } savePreference(PREF_KEYS.headerColor, v); setActiveFromMap(v, { default: 'header-color-default-btn', obsidian: 'header-color-obsidian-btn', sand: 'header-color-sand-btn', emerald: 'header-color-emerald-btn', royal: 'header-color-royal-btn', burgundy: 'header-color-burgundy-btn' }); }

const TABLE_COLOR_VARS = {
  default: null,
  obsidian: { '--table-surface': '#111827', '--table-border': '#334155', '--table-head-bg': '#172033', '--table-head-text': '#94A3B8', '--table-head-hover': '#93C5FD', '--table-row-border': 'rgba(71,85,105,.65)', '--table-row-hover-bg': 'rgba(96,165,250,.08)', '--table-row-selected-bg': 'rgba(96,165,250,.14)', '--table-row-selected-border': 'rgba(96,165,250,.32)' },
  sand: { '--table-surface': '#1F1810', '--table-border': '#5B452E', '--table-head-bg': '#2A2016', '--table-head-text': '#BEA789', '--table-head-hover': '#F3C56C', '--table-row-border': 'rgba(121,94,61,.62)', '--table-row-hover-bg': 'rgba(245,158,11,.08)', '--table-row-selected-bg': 'rgba(245,158,11,.14)', '--table-row-selected-border': 'rgba(245,158,11,.3)' },
  emerald: { '--table-surface': '#10211B', '--table-border': '#2C5848', '--table-head-bg': '#162E25', '--table-head-text': '#8DB9A8', '--table-head-hover': '#6EE7B7', '--table-row-border': 'rgba(63,109,94,.62)', '--table-row-hover-bg': 'rgba(16,185,129,.08)', '--table-row-selected-bg': 'rgba(16,185,129,.14)', '--table-row-selected-border': 'rgba(16,185,129,.31)' },
  royal: { '--table-surface': '#19152C', '--table-border': '#4A3C7C', '--table-head-bg': '#211A38', '--table-head-text': '#AFA0D9', '--table-head-hover': '#C4B5FD', '--table-row-border': 'rgba(93,81,145,.62)', '--table-row-hover-bg': 'rgba(139,92,246,.08)', '--table-row-selected-bg': 'rgba(139,92,246,.14)', '--table-row-selected-border': 'rgba(167,139,250,.31)' },
  burgundy: { '--table-surface': '#25141B', '--table-border': '#673548', '--table-head-bg': '#301924', '--table-head-text': '#C39AAF', '--table-head-hover': '#F9A8D4', '--table-row-border': 'rgba(110,67,84,.62)', '--table-row-hover-bg': 'rgba(244,114,182,.08)', '--table-row-selected-bg': 'rgba(244,114,182,.14)', '--table-row-selected-border': 'rgba(244,114,182,.31)' },
};
function setTableColor(color) { const root = getViewerRoot(); const v = TABLE_COLOR_VARS[color] !== undefined ? color : DEFAULTS.tableColor; if (root) { const vars = TABLE_COLOR_VARS[v]; if (!vars) applyCssVars(root, { '--table-surface': null, '--table-border': null, '--table-head-bg': null, '--table-head-text': null, '--table-head-hover': null, '--table-row-border': null, '--table-row-hover-bg': null, '--table-row-selected-bg': null, '--table-row-selected-border': null }); else applyCssVars(root, vars); } savePreference(PREF_KEYS.tableColor, v); setActiveFromMap(v, { default: 'table-color-default-btn', obsidian: 'table-color-obsidian-btn', sand: 'table-color-sand-btn', emerald: 'table-color-emerald-btn', royal: 'table-color-royal-btn', burgundy: 'table-color-burgundy-btn' }); }

function setLang(lang) {
  const root = getViewerRoot();
  const v = ['ar', 'en'].includes(lang) ? lang : DEFAULTS.lang;
  if (root) {
    const direction = v === 'en' ? 'ltr' : 'rtl';
    root.setAttribute('dir', direction);
    root.style.setProperty('direction', direction);
    root.classList.toggle('is-ltr', direction === 'ltr');
    root.classList.toggle('is-rtl', direction === 'rtl');
  }
  savePreference(PREF_KEYS.lang, v);
  setActiveFromMap(v, { ar: 'lang-ar-btn', en: 'lang-en-btn' });
}

function setFontFamily(fontFamily) {
  const root = getViewerRoot();
  const map = { Tajawal: "'Tajawal', sans-serif", Cairo: "'Cairo', sans-serif", Amiri: "'Amiri', serif" };
  const v = map[fontFamily] ? fontFamily : DEFAULTS.fontFamily;
  if (root) applyCssVars(root, { '--font-body': map[v], '--font-ui': map[v] });
  savePreference(PREF_KEYS.fontFamily, v);
  document.querySelectorAll('input[name="fontFamily"]').forEach((input) => { input.checked = input.value === v; });
}

function toggleSidebar() {
  const root = getViewerRoot();
  if (!root) return;
  const isMobile = window.matchMedia('(max-width: 991.98px)').matches;
  if (isMobile) {
    root.classList.toggle('sidebar-open');
    return;
  }
  const collapsed = root.classList.toggle('sidebar-collapsed');
  savePreference(PREF_KEYS.sidebarCollapsed, collapsed ? '1' : '0');
}

function updateTopbarClock() {
  const now = new Date();
  const timeText = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  const dateText = now.toLocaleDateString('ar-SA', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
  const timeEl = document.getElementById('topbar-time');
  const dateEl = document.getElementById('topbar-date');
  const dateTimeEl = document.getElementById('topbar-datetime');
  if (timeEl) timeEl.textContent = timeText;
  if (dateEl) dateEl.textContent = dateText;
  if (dateTimeEl && !timeEl && !dateEl) dateTimeEl.textContent = `${dateText} • ${timeText}`;
}

function resetAllSettings() {
  const root = getViewerRoot();
  Object.values(PREF_KEYS).forEach((key) => { try { localStorage.removeItem(key); } catch (_) {} });
  setThemePref(DEFAULTS.theme);
  setFontSize(DEFAULTS.fontSize);
  setCurrency(DEFAULTS.currency);
  setArea(DEFAULTS.area);
  setOwnership(DEFAULTS.ownership);
  setPanelColor(DEFAULTS.panelColor);
  setFontColor(DEFAULTS.fontColor);
  setNavbarColor(DEFAULTS.navbarColor);
  setHeaderColor(DEFAULTS.headerColor);
  setTableColor(DEFAULTS.tableColor);
  setLang(DEFAULTS.lang);
  setFontFamily(DEFAULTS.fontFamily);
  if (root) {
    root.classList.remove('sidebar-collapsed');
    root.classList.remove('sidebar-open');
  }
}

function initViewerFrontTheme() {
  const root = getViewerRoot();
  if (!root) return;

  setThemePref(getPreference(PREF_KEYS.theme, DEFAULTS.theme));
  setFontSize(getPreference(PREF_KEYS.fontSize, DEFAULTS.fontSize));
  setCurrency(getPreference(PREF_KEYS.currency, DEFAULTS.currency));
  setArea(getPreference(PREF_KEYS.area, DEFAULTS.area));
  setOwnership(getPreference(PREF_KEYS.ownership, DEFAULTS.ownership));
  setPanelColor(getPreference(PREF_KEYS.panelColor, DEFAULTS.panelColor));
  setFontColor(getPreference(PREF_KEYS.fontColor, DEFAULTS.fontColor));
  setNavbarColor(getPreference(PREF_KEYS.navbarColor, DEFAULTS.navbarColor));
  setHeaderColor(getPreference(PREF_KEYS.headerColor, DEFAULTS.headerColor));
  setTableColor(getPreference(PREF_KEYS.tableColor, DEFAULTS.tableColor));
  setLang(getPreference(PREF_KEYS.lang, DEFAULTS.lang));
  setFontFamily(getPreference(PREF_KEYS.fontFamily, DEFAULTS.fontFamily));

  const isMobile = window.matchMedia('(max-width: 991.98px)').matches;
  if (!isMobile && getPreference(PREF_KEYS.sidebarCollapsed, '0') === '1') {
    root.classList.add('sidebar-collapsed');
  } else {
    root.classList.remove('sidebar-collapsed');
  }

  if (!isMobile) {
    root.classList.remove('sidebar-open');
  }

  if (!globalListenersBound) {
    document.addEventListener('change', (event) => {
      if (event.target && event.target.matches('input[name="fontFamily"]')) {
        setFontFamily(event.target.value);
      }
    });

    document.addEventListener('click', (event) => {
      const fab = document.getElementById('qs-fab');
      if (!fab || !fab.classList.contains('open')) return;
      if (!fab.contains(event.target)) closeQuickSettings();
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') closeQuickSettings();
    });
    globalListenersBound = true;
  }

  updateTopbarClock();
  if (topbarClockInterval) clearInterval(topbarClockInterval);
  topbarClockInterval = setInterval(updateTopbarClock, 1000);
}

window.toggleQuickSettings = toggleQuickSettings;
window.closeQuickSettings = closeQuickSettings;
window.resetAllSettings = resetAllSettings;
window.setThemePref = setThemePref;
window.setFontSize = setFontSize;
window.setCurrency = setCurrency;
window.setArea = setArea;
window.setOwnership = setOwnership;
window.setPanelColor = setPanelColor;
window.setFontColor = setFontColor;
window.setNavbarColor = setNavbarColor;
window.setHeaderColor = setHeaderColor;
window.setTableColor = setTableColor;
window.setLang = setLang;
window.toggleSidebar = toggleSidebar;
window.updateTopbarClock = updateTopbarClock;
window.initViewerFrontTheme = initViewerFrontTheme;

document.addEventListener('DOMContentLoaded', initViewerFrontTheme);
document.addEventListener('livewire:navigated', initViewerFrontTheme);
