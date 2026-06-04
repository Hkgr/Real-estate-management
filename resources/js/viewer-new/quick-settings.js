/* ===================================================================
   Quick Settings — viewer-new
   =================================================================== */

const QS_PREF_KEY = 'realestate_prefs';

function qsGetPrefs() {
  try { return JSON.parse(localStorage.getItem(QS_PREF_KEY)) || {}; } catch { return {}; }
}
function qsSavePrefs(p) {
  try { localStorage.setItem(QS_PREF_KEY, JSON.stringify(p)); } catch (_) {}
}

/*
 * getVnEl — returns body.viewer-new.
 * Setting CSS custom properties as INLINE STYLES here always beats class rules,
 * fixing the cascade-shadowing bug where .viewer-new{} class rules
 * would block values set on document.documentElement.
 */
function getVnEl() {
  return document.querySelector('body.viewer-new') || document.documentElement;
}

/* ── FAB toggle ── */
export function toggleQuickSettings() {
  const fab  = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  if (!fab) return;
  fab.classList.toggle('open');
  trig?.setAttribute('aria-expanded', fab.classList.contains('open') ? 'true' : 'false');
}
export function closeQuickSettings() {
  const fab  = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  fab?.classList.remove('open');
  trig?.setAttribute('aria-expanded', 'false');
}

/* ── Theme ── */
export function setThemePref(t) {
  document.documentElement.setAttribute('data-theme', t);
  document.body.setAttribute('data-theme', t);
  try { localStorage.setItem('themeMode', t); } catch (_) {}
  const p = qsGetPrefs(); p.theme = t; qsSavePrefs(p);
  document.getElementById('theme-dark-btn') ?.classList.toggle('active', t === 'dark');
  document.getElementById('theme-light-btn')?.classList.toggle('active', t === 'light');
  /* Re-apply colour settings so they recalculate for the new theme palette */
  const pp = qsGetPrefs();
  setFontColor(pp.fontColor    || 'default');
  setNavbarColor(pp.navbarColor  || 'default');
  setHeaderColor(pp.headerColor  || 'default');
  setTableColor(pp.tableColor   || 'default');
  setPanelColor(pp.panelColor   || 'plum');
}

/* ── Font size ── */
export function setFontSize(s) {
  /*
   * viewer-new CSS uses rem units — scaling requires changing
   * document.documentElement.style.fontSize (the root font size).
   * 'normal' resets to browser default (removes override).
   * --fs-scale drives the QS panel's own px-calc rules.
   */
  const htmlMap  = { normal: null,    large: '18px', xl: '20px', xxl: '22px' };
  const scaleMap = { normal: '1',     large: '1.133', xl: '1.333', xxl: '1.467' };
  const htmlSz   = htmlMap[s];
  if (htmlSz) {
    document.documentElement.style.fontSize = htmlSz;
  } else {
    document.documentElement.style.removeProperty('font-size');
  }
  document.documentElement.style.setProperty('--fs-base',  htmlSz || '16px');
  document.documentElement.style.setProperty('--fs-scale', scaleMap[s] || '1');

  const p = qsGetPrefs(); p.fontSize = s; qsSavePrefs(p);
  ['normal','large','xl','xxl'].forEach(k => {
    document.getElementById(`fs-${k}-btn`)?.classList.toggle('active', s === k);
  });
}

/* ── Font family ── */
export function applyFont(f) {
  const fm = { Tajawal: "'Tajawal',sans-serif", Cairo: "'Cairo',sans-serif", Amiri: "'Amiri',serif" };
  const stack = fm[f] || fm.Tajawal;
  document.documentElement.style.setProperty('--font-body',    stack);
  document.documentElement.style.setProperty('--font-ui',      stack);
  document.documentElement.style.setProperty('--font-display', stack);
  /* viewer-new body has font-family hardcoded in CSS class — apply directly */
  const vnEl = document.querySelector('body.viewer-new');
  if (vnEl) vnEl.style.fontFamily = stack;
}

/* ── Currency (save preference — no data re-render in viewer-new) ── */
export function setCurrency(c) {
  const p = qsGetPrefs(); p.currency = c; qsSavePrefs(p);
  document.getElementById('cur-usd-btn')?.classList.toggle('active', c === 'USD');
  document.getElementById('cur-lbp-btn')?.classList.toggle('active', c === 'LBP');
  document.getElementById('cur-aed-btn')?.classList.toggle('active', c === 'AED');
}

/* ── Area ── */
export function setArea(a) {
  const p = qsGetPrefs(); p.area = a; qsSavePrefs(p);
  document.getElementById('area-m2-btn') ?.classList.toggle('active', a === 'm2');
  document.getElementById('area-ft2-btn')?.classList.toggle('active', a === 'ft2');
}

/* ── Ownership ── */
export function setOwnership(o) {
  const p = qsGetPrefs(); p.ownership = o; qsSavePrefs(p);
  document.getElementById('own-sahm-btn')?.classList.toggle('active', o === 'sahm');
  document.getElementById('own-pct-btn') ?.classList.toggle('active', o === 'pct');
}

/* ── Language ── */
export function setLang(l) {
  const p = qsGetPrefs(); p.lang = l; qsSavePrefs(p);
  document.getElementById('lang-ar-btn')?.classList.toggle('active', l === 'ar');
  document.getElementById('lang-en-btn')?.classList.toggle('active', l === 'en');
  const isEn = l === 'en';
  document.documentElement.setAttribute('lang', isEn ? 'en' : 'ar');
  document.documentElement.setAttribute('dir',  isEn ? 'ltr' : 'rtl');
  document.body.setAttribute('dir', isEn ? 'ltr' : 'rtl');
}

/* ── Font colour ── */
export function setFontColor(colorMode) {
  const p = qsGetPrefs(); p.fontColor = colorMode; qsSavePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    ivory:  { dark:{ primary:'#F5F0E8',secondary:'#DCCFB7',muted:'#B6A98E' }, light:{ primary:'#2D2418',secondary:'#645845',muted:'#867864' } },
    gold:   { dark:{ primary:'#E8C96A',secondary:'#D8B44F',muted:'#A48A46' }, light:{ primary:'#7A5B16',secondary:'#9B7522',muted:'#B08A3B' } },
    silver: { dark:{ primary:'#E6EBF2',secondary:'#C6CEDB',muted:'#95A0B2' }, light:{ primary:'#2C3748',secondary:'#4C5A6F',muted:'#6B788B' } },
    mint:   { dark:{ primary:'#DDF8EE',secondary:'#AEE7D1',muted:'#79B79D' }, light:{ primary:'#1E5E4B',secondary:'#2F7861',muted:'#4A9078' } },
    rose:   { dark:{ primary:'#F8E5EC',secondary:'#E7BBCB',muted:'#B98297' }, light:{ primary:'#6A3245',secondary:'#8A4760',muted:'#A26179' } },
  };
  const root = getVnEl();
  if (colorMode === 'default') {
    /* Remove all font-color overrides — CSS defaults take over */
    ['--text', '--muted', '--text-primary', '--text-secondary', '--text-muted', '--qs-font-color'].forEach(v => root.style.removeProperty(v));
    root.style.removeProperty('color');
  } else if (palettes[colorMode]) {
    const ap = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    /* --qs-font-color is the key var: all light-mode !important color overrides read
       it via var(--qs-font-color, fallback), so they respond even with !important */
    root.style.setProperty('--qs-font-color',  ap.primary);
    root.style.setProperty('--text',           ap.primary);
    root.style.setProperty('--muted',          ap.secondary);
    root.style.setProperty('--text-primary',   ap.primary);
    root.style.setProperty('--text-secondary', ap.secondary);
    root.style.setProperty('--text-muted',     ap.muted);
    root.style.color = ap.primary;
  }
  ['default','ivory','gold','silver','mint','rose'].forEach(m =>
    document.getElementById(`font-color-${m}-btn`)?.classList.toggle('active', colorMode === m)
  );
}

/* ── Sidebar colour ── */
export function setNavbarColor(colorMode) {
  const p = qsGetPrefs(); p.navbarColor = colorMode; qsSavePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: {
      dark:  { surface:'#0F131A',border:'#283140',hoverBg:'rgba(96,165,250,.10)',hoverBorder:'rgba(96,165,250,.28)',activeBg:'linear-gradient(135deg,rgba(96,165,250,.22),rgba(59,130,246,.10))',activeBorder:'rgba(96,165,250,.42)',activeText:'#BFDBFE',bar:'#60A5FA' },
      light: { surface:'#EEF4FF',border:'#C4D7F5',hoverBg:'rgba(59,130,246,.11)',hoverBorder:'rgba(59,130,246,.27)',activeBg:'linear-gradient(135deg,rgba(59,130,246,.18),rgba(96,165,250,.08))',activeBorder:'rgba(59,130,246,.38)',activeText:'#1D4ED8',bar:'#2563EB' },
    },
    sand: {
      dark:  { surface:'#21170F',border:'#4B3621',hoverBg:'rgba(245,158,11,.10)',hoverBorder:'rgba(245,158,11,.27)',activeBg:'linear-gradient(135deg,rgba(245,158,11,.22),rgba(180,83,9,.09))',activeBorder:'rgba(245,158,11,.4)',activeText:'#FCD34D',bar:'#F59E0B' },
      light: { surface:'#FFF6E7',border:'#E8D5B6',hoverBg:'rgba(245,158,11,.11)',hoverBorder:'rgba(217,119,6,.25)',activeBg:'linear-gradient(135deg,rgba(245,158,11,.18),rgba(217,119,6,.08))',activeBorder:'rgba(217,119,6,.36)',activeText:'#9A580A',bar:'#B45309' },
    },
    emerald: {
      dark:  { surface:'#10231D',border:'#285246',hoverBg:'rgba(52,211,153,.10)',hoverBorder:'rgba(52,211,153,.27)',activeBg:'linear-gradient(135deg,rgba(16,185,129,.22),rgba(4,120,87,.09))',activeBorder:'rgba(52,211,153,.38)',activeText:'#86EFAC',bar:'#10B981' },
      light: { surface:'#EAFBF4',border:'#BFE8D5',hoverBg:'rgba(16,185,129,.10)',hoverBorder:'rgba(5,150,105,.24)',activeBg:'linear-gradient(135deg,rgba(16,185,129,.16),rgba(5,150,105,.08))',activeBorder:'rgba(5,150,105,.33)',activeText:'#065F46',bar:'#047857' },
    },
    royal: {
      dark:  { surface:'#1A1430',border:'#3E3370',hoverBg:'rgba(167,139,250,.10)',hoverBorder:'rgba(167,139,250,.28)',activeBg:'linear-gradient(135deg,rgba(139,92,246,.22),rgba(79,70,229,.10))',activeBorder:'rgba(167,139,250,.42)',activeText:'#DDD6FE',bar:'#A78BFA' },
      light: { surface:'#F3F0FF',border:'#D6CCFA',hoverBg:'rgba(139,92,246,.10)',hoverBorder:'rgba(124,58,237,.24)',activeBg:'linear-gradient(135deg,rgba(124,58,237,.17),rgba(99,102,241,.08))',activeBorder:'rgba(124,58,237,.35)',activeText:'#5B21B6',bar:'#6D28D9' },
    },
    burgundy: {
      dark:  { surface:'#2A141A',border:'#5C2936',hoverBg:'rgba(244,114,182,.10)',hoverBorder:'rgba(244,114,182,.28)',activeBg:'linear-gradient(135deg,rgba(244,114,182,.22),rgba(190,24,93,.10))',activeBorder:'rgba(244,114,182,.42)',activeText:'#FBCFE8',bar:'#F472B6' },
      light: { surface:'#FFF0F5',border:'#EDC9D6',hoverBg:'rgba(236,72,153,.10)',hoverBorder:'rgba(219,39,119,.24)',activeBg:'linear-gradient(135deg,rgba(236,72,153,.17),rgba(190,24,93,.08))',activeBorder:'rgba(219,39,119,.35)',activeText:'#9D174D',bar:'#BE185D' },
    },
  };
  const root = getVnEl();
  if (colorMode === 'default') {
    ['--nav-surface','--nav-border','--nav-hover-bg','--nav-hover-border',
     '--nav-active-bg','--nav-active-border','--nav-active-text','--nav-accent-bar'].forEach(v => root.style.removeProperty(v));
  } else if (palettes[colorMode]) {
    const nav = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    root.style.setProperty('--nav-surface',       nav.surface);
    root.style.setProperty('--nav-border',        nav.border);
    root.style.setProperty('--nav-hover-bg',      nav.hoverBg);
    root.style.setProperty('--nav-hover-border',  nav.hoverBorder);
    root.style.setProperty('--nav-active-bg',     nav.activeBg);
    root.style.setProperty('--nav-active-border', nav.activeBorder);
    root.style.setProperty('--nav-active-text',   nav.activeText);
    root.style.setProperty('--nav-accent-bar',    nav.bar);
  }
  ['default','obsidian','sand','emerald','royal','burgundy'].forEach(m =>
    document.getElementById(`nav-color-${m}-btn`)?.classList.toggle('active', colorMode === m)
  );
}

/* ── Header colour ── */
export function setHeaderColor(colorMode) {
  const p = qsGetPrefs(); p.headerColor = colorMode; qsSavePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: { dark:{ surface:'rgba(12,18,28,.95)',border:'#2B3A52',accent:'#93C5FD',eyebrow:'#7FB3F4' }, light:{ surface:'rgba(239,247,255,.95)',border:'#C8DAF3',accent:'#2563EB',eyebrow:'#346FC9' } },
    sand:     { dark:{ surface:'rgba(36,24,14,.95)',border:'#5A422A',accent:'#FCD34D',eyebrow:'#E7BC58' }, light:{ surface:'rgba(255,246,233,.95)',border:'#E8D2B2',accent:'#B45309',eyebrow:'#9B640F' } },
    emerald:  { dark:{ surface:'rgba(14,34,28,.95)',border:'#2A584A',accent:'#6EE7B7',eyebrow:'#64D5A7' }, light:{ surface:'rgba(235,250,243,.95)',border:'#C1E7D4',accent:'#047857',eyebrow:'#0B8A66' } },
    royal:    { dark:{ surface:'rgba(24,18,42,.95)',border:'#473A77',accent:'#C4B5FD',eyebrow:'#AE99F4' }, light:{ surface:'rgba(244,240,255,.95)',border:'#D8CCFA',accent:'#6D28D9',eyebrow:'#7B36E0' } },
    burgundy: { dark:{ surface:'rgba(39,18,24,.95)',border:'#663043',accent:'#F9A8D4',eyebrow:'#F28DBF' }, light:{ surface:'rgba(255,241,247,.95)',border:'#EDCCDA',accent:'#BE185D',eyebrow:'#C02D68' } },
  };
  const root = getVnEl();
  if (colorMode === 'default') {
    ['--header-surface','--header-border','--header-title-accent','--header-divider','--header-eyebrow'].forEach(v => root.style.removeProperty(v));
  } else if (palettes[colorMode]) {
    const h = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    root.style.setProperty('--header-surface',      h.surface);
    root.style.setProperty('--header-border',       h.border);
    root.style.setProperty('--header-title-accent', h.accent);
    root.style.setProperty('--header-eyebrow',      h.eyebrow);
  }
  ['default','obsidian','sand','emerald','royal','burgundy'].forEach(m =>
    document.getElementById(`header-color-${m}-btn`)?.classList.toggle('active', colorMode === m)
  );
}

/* ── Table colour ── */
export function setTableColor(colorMode) {
  const p = qsGetPrefs(); p.tableColor = colorMode; qsSavePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: { dark:{ surface:'#111827',border:'#334155',headBg:'#172033',headText:'#94A3B8',headHover:'#93C5FD',rowBorder:'rgba(71,85,105,.65)',rowHoverBg:'rgba(96,165,250,.08)' }, light:{ surface:'#F8FBFF',border:'#CBDDF6',headBg:'#EAF2FF',headText:'#4F6688',headHover:'#2563EB',rowBorder:'rgba(151,174,209,.62)',rowHoverBg:'rgba(59,130,246,.08)' } },
    sand:     { dark:{ surface:'#1F1810',border:'#5B452E',headBg:'#2A2016',headText:'#BEA789',headHover:'#F3C56C',rowBorder:'rgba(121,94,61,.62)',rowHoverBg:'rgba(245,158,11,.08)' }, light:{ surface:'#FFF9EE',border:'#E8D7BC',headBg:'#FBF1DD',headText:'#876B42',headHover:'#B45309',rowBorder:'rgba(205,180,141,.62)',rowHoverBg:'rgba(180,83,9,.08)' } },
    emerald:  { dark:{ surface:'#10211B',border:'#2C5848',headBg:'#162E25',headText:'#8DB9A8',headHover:'#6EE7B7',rowBorder:'rgba(63,109,94,.62)',rowHoverBg:'rgba(16,185,129,.08)' }, light:{ surface:'#F1FBF6',border:'#C8E6D9',headBg:'#E2F5EC',headText:'#4F7D6D',headHover:'#047857',rowBorder:'rgba(137,186,167,.62)',rowHoverBg:'rgba(5,150,105,.08)' } },
    royal:    { dark:{ surface:'#19152C',border:'#4A3C7C',headBg:'#211A38',headText:'#AFA0D9',headHover:'#C4B5FD',rowBorder:'rgba(93,81,145,.62)',rowHoverBg:'rgba(139,92,246,.08)' }, light:{ surface:'#F7F2FF',border:'#DDCEF9',headBg:'#EFE6FF',headText:'#74639F',headHover:'#6D28D9',rowBorder:'rgba(177,157,218,.62)',rowHoverBg:'rgba(109,40,217,.08)' } },
    burgundy: { dark:{ surface:'#25141B',border:'#673548',headBg:'#301924',headText:'#C39AAF',headHover:'#F9A8D4',rowBorder:'rgba(110,67,84,.62)',rowHoverBg:'rgba(244,114,182,.08)' }, light:{ surface:'#FFF4F8',border:'#EDCFDB',headBg:'#FDEAF1',headText:'#8C5D70',headHover:'#BE185D',rowBorder:'rgba(205,154,177,.62)',rowHoverBg:'rgba(190,24,93,.08)' } },
  };
  const root = getVnEl();
  if (colorMode === 'default') {
    ['--table-surface','--table-border','--table-head-bg','--table-head-text',
     '--table-head-hover','--table-row-border','--table-row-hover-bg'].forEach(v => root.style.removeProperty(v));
  } else if (palettes[colorMode]) {
    const tb = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    root.style.setProperty('--table-surface',      tb.surface);
    root.style.setProperty('--table-border',       tb.border);
    root.style.setProperty('--table-head-bg',      tb.headBg);
    root.style.setProperty('--table-head-text',    tb.headText);
    root.style.setProperty('--table-head-hover',   tb.headHover);
    root.style.setProperty('--table-row-border',   tb.rowBorder);
    root.style.setProperty('--table-row-hover-bg', tb.rowHoverBg);
  }
  ['default','obsidian','sand','emerald','royal','burgundy'].forEach(m =>
    document.getElementById(`table-color-${m}-btn`)?.classList.toggle('active', colorMode === m)
  );
}

/* ── Panel colour ── */
export function setPanelColor(colorMode) {
  const p = qsGetPrefs(); p.panelColor = colorMode; qsSavePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    slate:  { dark:{ bg:'#1E2530',border:'#3A4558',head:'#1A2030' }, light:{ bg:'#EEF2F8',border:'#BCC8DC',head:'#E4EAF4' } },
    navy:   { dark:{ bg:'#111A2E',border:'#2A3F6A',head:'#0D1526' }, light:{ bg:'#DDE8F8',border:'#96B8E8',head:'#C8D9F4' } },
    forest: { dark:{ bg:'#111E18',border:'#26432E',head:'#0D1A13' }, light:{ bg:'#D8F0E0',border:'#88C49A',head:'#C2E6CE' } },
    plum:   { dark:{ bg:'#1E1428',border:'#3E2860',head:'#180F22' }, light:{ bg:'#EDE0F8',border:'#C4A0E0',head:'#E0CDF4' } },
    stone:  { dark:{ bg:'#1E1C18',border:'#3D3830',head:'#191712' }, light:{ bg:'#EDE8DE',border:'#C0AE90',head:'#E2D9C8' } },
    rose:   { dark:{ bg:'#241420',border:'#5C2845',head:'#1C0D19' }, light:{ bg:'#F8E4EE',border:'#DDA0BF',head:'#F2D0E4' } },
    teal:   { dark:{ bg:'#0F1E20',border:'#1E4A50',head:'#0A1618' }, light:{ bg:'#D8F0EE',border:'#80C8C4',head:'#C0E6E4' } },
    gold:   { dark:{ bg:'#201A0A',border:'#5A4510',head:'#181200' }, light:{ bg:'#FDF3D8',border:'#D4AF5A',head:'#F8E8B8' } },
  };
  /* Panel vars on documentElement are fine — qs-panel is a descendant of body */
  const root = document.documentElement;
  if (colorMode === 'default') {
    ['--qs-panel-bg','--qs-panel-border','--qs-panel-head-bg'].forEach(v => root.style.removeProperty(v));
  } else if (palettes[colorMode]) {
    const c = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    root.style.setProperty('--qs-panel-bg',      c.bg);
    root.style.setProperty('--qs-panel-border',  c.border);
    root.style.setProperty('--qs-panel-head-bg', c.head);
  }
  ['default','slate','navy','forest','plum','stone','rose','teal','gold'].forEach(m =>
    document.getElementById(`panel-color-${m}-btn`)?.classList.toggle('active', colorMode === m)
  );
}

/* ── Reset all ── */
export function resetAllSettings() {
  const d = { theme:'dark', fontSize:'normal', currency:'USD', area:'m2', ownership:'sahm',
              fontFamily:'Tajawal', lang:'ar', fontColor:'default', navbarColor:'default',
              headerColor:'default', tableColor:'default', panelColor:'plum' };
  qsSavePrefs(d);
  setThemePref(d.theme);
  setFontSize(d.fontSize);
  setCurrency(d.currency);
  setArea(d.area);
  setOwnership(d.ownership);
  applyFont(d.fontFamily);
  document.querySelectorAll('[name="fontFamily"]').forEach(r => { r.checked = r.value === d.fontFamily; });
  setFontColor(d.fontColor);
  setNavbarColor(d.navbarColor);
  setHeaderColor(d.headerColor);
  setTableColor(d.tableColor);
  setPanelColor(d.panelColor);
  setLang(d.lang);
}

/* ── Bind font radio buttons ── */
function bindFontRadios() {
  if (window.__qsFontBound) return;
  window.__qsFontBound = true;
  document.querySelectorAll('[name="fontFamily"]').forEach(r => {
    r.addEventListener('change', function () {
      applyFont(this.value);
      const p = qsGetPrefs(); p.fontFamily = this.value; qsSavePrefs(p);
    });
  });
}

/* ── Load saved preferences ── */
function loadPrefs() {
  bindFontRadios();
  const p = qsGetPrefs();
  const t = localStorage.getItem('themeMode') || p.theme || 'dark';
  setThemePref(t);
  setFontSize(p.fontSize    || 'normal');
  setCurrency(p.currency    || 'USD');
  setArea(p.area            || 'm2');
  setOwnership(p.ownership  || 'sahm');
  if (p.fontFamily) {
    applyFont(p.fontFamily);
    document.querySelectorAll('[name="fontFamily"]').forEach(r => { r.checked = r.value === p.fontFamily; });
  }
  if (p.lang) setLang(p.lang);
  setFontColor(p.fontColor     || 'default');
  setNavbarColor(p.navbarColor || 'default');
  setHeaderColor(p.headerColor || 'default');
  setTableColor(p.tableColor   || 'default');
  setPanelColor(p.panelColor   || 'plum');
}

/* ── Init ── */
function initQuickSettings() {
  document.addEventListener('click', () => closeQuickSettings());

  document.querySelectorAll('[data-open-settings]').forEach(btn => {
    btn.addEventListener('click', e => { e.stopPropagation(); toggleQuickSettings(); });
  });

  /* Expose globally for inline onclick handlers in the blade partial */
  Object.assign(window, {
    toggleQuickSettings, closeQuickSettings,
    setThemePref, setFontSize, setCurrency, setArea, setOwnership,
    applyFont, setLang, setFontColor, setNavbarColor, setHeaderColor,
    setTableColor, setPanelColor, resetAllSettings,
  });

  loadPrefs();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initQuickSettings);
} else {
  initQuickSettings();
}
