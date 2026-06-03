
const PREF_KEY = 'realestate_prefs';
const RATE = 124;

function getPrefs() { try { return JSON.parse(localStorage.getItem(PREF_KEY)) || {}; } catch { return {}; } }
function savePrefs(p) { localStorage.setItem(PREF_KEY, JSON.stringify(p)); }

function toggleQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  if (!fab) return;
  fab.classList.toggle('open');
  if (trig) trig.setAttribute('aria-expanded', fab.classList.contains('open') ? 'true' : 'false');
}

function closeQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  if (fab) fab.classList.remove('open');
  if (trig) trig.setAttribute('aria-expanded', 'false');
}

document.addEventListener('click', function() {
  closeQuickSettings();
});

function setThemePref(t) {
  document.documentElement.setAttribute('data-theme', t);
  localStorage.setItem('themeMode', t);
  const p = getPrefs();
  p.theme = t;
  savePrefs(p);
  const d = document.getElementById('theme-dark-btn');
  const l = document.getElementById('theme-light-btn');
  if (d) d.classList.toggle('active', t === 'dark');
  if (l) l.classList.toggle('active', t === 'light');
  setFontColor(p.fontColor || 'default');
  setNavbarColor(p.navbarColor || 'default');
  setHeaderColor(p.headerColor || 'default');
  setTableColor(p.tableColor || 'default');
  setPanelColor(p.panelColor || 'plum');
}

function setFontSize(s) {
  const sizeMap = { normal: '15px', large: '17px', xl: '20px', xxl: '22px' };
  const sz = sizeMap[s] || '15px';
  document.documentElement.style.setProperty('--fs-base', sz);
  const p = getPrefs();
  p.fontSize = s;
  savePrefs(p);
  ['normal','large','xl','xxl'].forEach(k => {
    const btn = document.getElementById(`fs-${k}-btn`);
    if (btn) btn.classList.toggle('active', s === k);
  });
}

function setCurrency(c) {
  const p = getPrefs();
  p.currency = c;
  savePrefs(p);
  const u = document.getElementById('cur-usd-btn');
  const lb = document.getElementById('cur-lbp-btn');
  const rd = document.getElementById('rate-display');
  if (u) u.classList.toggle('active', c === 'USD');
  if (lb) lb.classList.toggle('active', c === 'LBP');
  if (rd) rd.textContent = RATE.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function setArea(a) {
  const p = getPrefs();
  p.area = a;
  savePrefs(p);
  const m = document.getElementById('area-m2-btn');
  const f = document.getElementById('area-ft2-btn');
  if (m) m.classList.toggle('active', a === 'm2');
  if (f) f.classList.toggle('active', a === 'ft2');
}

function setOwnership(o) {
  const p = getPrefs();
  p.ownership = o;
  savePrefs(p);
  const s = document.getElementById('own-sahm-btn');
  const pc = document.getElementById('own-pct-btn');
  if (s) s.classList.toggle('active', o === 'sahm');
  if (pc) pc.classList.toggle('active', o === 'pct');
}

function applyFont(f) {
  const fm = {
    Tajawal: "'Tajawal', sans-serif",
    Cairo: "'Cairo', sans-serif",
    Amiri: "'Amiri', serif"
  };
  const stack = fm[f] || fm.Tajawal;
  document.documentElement.style.setProperty('--font-body', stack);
  document.documentElement.style.setProperty('--font-ui', stack);
  document.documentElement.style.setProperty('--font-display', stack);
}

function setLang(l) {
  const p = getPrefs();
  p.lang = l;
  savePrefs(p);

  const ar = document.getElementById('lang-ar-btn');
  const en = document.getElementById('lang-en-btn');
  if (ar) ar.classList.toggle('active', l === 'ar');
  if (en) en.classList.toggle('active', l === 'en');
  document.documentElement.setAttribute('lang', 'ar');
  document.documentElement.setAttribute('dir', 'rtl');
  document.body.setAttribute('dir', 'rtl');
}

function setFontColor(colorMode) {
  const p = getPrefs();
  p.fontColor = colorMode;
  savePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    ivory: { dark: { primary: '#F5F0E8', secondary: '#DCCFB7', muted: '#B6A98E' }, light: { primary: '#2D2418', secondary: '#645845', muted: '#867864' } },
    gold: { dark: { primary: '#E8C96A', secondary: '#D8B44F', muted: '#A48A46' }, light: { primary: '#7A5B16', secondary: '#9B7522', muted: '#B08A3B' } },
    silver: { dark: { primary: '#E6EBF2', secondary: '#C6CEDB', muted: '#95A0B2' }, light: { primary: '#2C3748', secondary: '#4C5A6F', muted: '#6B788B' } },
    mint: { dark: { primary: '#DDF8EE', secondary: '#AEE7D1', muted: '#79B79D' }, light: { primary: '#1E5E4B', secondary: '#2F7861', muted: '#4A9078' } },
    rose: { dark: { primary: '#F8E5EC', secondary: '#E7BBCB', muted: '#B98297' }, light: { primary: '#6A3245', secondary: '#8A4760', muted: '#A26179' } }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--text-primary');
    document.documentElement.style.removeProperty('--text-secondary');
    document.documentElement.style.removeProperty('--text-muted');
  } else if (palettes[colorMode]) {
    const active = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--text-primary', active.primary);
    document.documentElement.style.setProperty('--text-secondary', active.secondary);
    document.documentElement.style.setProperty('--text-muted', active.muted);
  }
  ['default', 'ivory', 'gold', 'silver', 'mint', 'rose'].forEach(mode => {
    const btn = document.getElementById(`font-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
}

function setNavbarColor(colorMode) {
  const p = getPrefs();
  p.navbarColor = colorMode;
  savePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: { dark: { surface: '#111827', border: '#334155', hoverBg: 'rgba(96,165,250,.1)', hoverBorder: 'rgba(96,165,250,.28)', activeBg: 'linear-gradient(135deg, rgba(96,165,250,.22), rgba(59,130,246,.10))', activeBorder: 'rgba(96,165,250,.42)', activeText: '#BFDBFE' }, light: { surface: '#F8FBFF', border: '#CBDDF6', hoverBg: 'rgba(59,130,246,.09)', hoverBorder: 'rgba(59,130,246,.25)', activeBg: 'linear-gradient(135deg, rgba(59,130,246,.16), rgba(96,165,250,.08))', activeBorder: 'rgba(59,130,246,.35)', activeText: '#1D4ED8' } },
    sand: { dark: { surface: '#20170F', border: '#5B452E', hoverBg: 'rgba(245,158,11,.1)', hoverBorder: 'rgba(245,158,11,.28)', activeBg: 'linear-gradient(135deg, rgba(245,158,11,.22), rgba(180,83,9,.10))', activeBorder: 'rgba(245,158,11,.42)', activeText: '#FCD34D' }, light: { surface: '#FFF9EE', border: '#E8D7BC', hoverBg: 'rgba(180,83,9,.09)', hoverBorder: 'rgba(180,83,9,.25)', activeBg: 'linear-gradient(135deg, rgba(180,83,9,.16), rgba(245,158,11,.08))', activeBorder: 'rgba(180,83,9,.35)', activeText: '#9A580A' } },
    emerald: { dark: { surface: '#10211B', border: '#2C5848', hoverBg: 'rgba(16,185,129,.1)', hoverBorder: 'rgba(16,185,129,.28)', activeBg: 'linear-gradient(135deg, rgba(16,185,129,.22), rgba(4,120,87,.10))', activeBorder: 'rgba(16,185,129,.4)', activeText: '#86EFAC' }, light: { surface: '#F1FBF6', border: '#C8E6D9', hoverBg: 'rgba(5,150,105,.09)', hoverBorder: 'rgba(5,150,105,.25)', activeBg: 'linear-gradient(135deg, rgba(5,150,105,.16), rgba(16,185,129,.08))', activeBorder: 'rgba(5,150,105,.35)', activeText: '#065F46' } },
    royal: { dark: { surface: '#19152C', border: '#4A3C7C', hoverBg: 'rgba(139,92,246,.1)', hoverBorder: 'rgba(167,139,250,.28)', activeBg: 'linear-gradient(135deg, rgba(139,92,246,.22), rgba(79,70,229,.10))', activeBorder: 'rgba(167,139,250,.42)', activeText: '#DDD6FE' }, light: { surface: '#F7F2FF', border: '#DDCEF9', hoverBg: 'rgba(109,40,217,.09)', hoverBorder: 'rgba(109,40,217,.25)', activeBg: 'linear-gradient(135deg, rgba(109,40,217,.16), rgba(139,92,246,.08))', activeBorder: 'rgba(109,40,217,.35)', activeText: '#5B21B6' } },
    burgundy: { dark: { surface: '#25141B', border: '#673548', hoverBg: 'rgba(244,114,182,.1)', hoverBorder: 'rgba(244,114,182,.28)', activeBg: 'linear-gradient(135deg, rgba(244,114,182,.22), rgba(190,24,93,.10))', activeBorder: 'rgba(244,114,182,.42)', activeText: '#FBCFE8' }, light: { surface: '#FFF4F8', border: '#EDCFDB', hoverBg: 'rgba(190,24,93,.09)', hoverBorder: 'rgba(190,24,93,.25)', activeBg: 'linear-gradient(135deg, rgba(190,24,93,.16), rgba(244,114,182,.08))', activeBorder: 'rgba(190,24,93,.35)', activeText: '#9D174D' } }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--nav-surface');
    document.documentElement.style.removeProperty('--nav-border');
    document.documentElement.style.removeProperty('--nav-hover-bg');
    document.documentElement.style.removeProperty('--nav-hover-border');
    document.documentElement.style.removeProperty('--nav-active-bg');
    document.documentElement.style.removeProperty('--nav-active-border');
    document.documentElement.style.removeProperty('--nav-active-text');
  } else if (palettes[colorMode]) {
    const nav = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--nav-surface', nav.surface);
    document.documentElement.style.setProperty('--nav-border', nav.border);
    document.documentElement.style.setProperty('--nav-hover-bg', nav.hoverBg);
    document.documentElement.style.setProperty('--nav-hover-border', nav.hoverBorder);
    document.documentElement.style.setProperty('--nav-active-bg', nav.activeBg);
    document.documentElement.style.setProperty('--nav-active-border', nav.activeBorder);
    document.documentElement.style.setProperty('--nav-active-text', nav.activeText);
  }
  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`nav-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
}

function setHeaderColor(colorMode) {
  const p = getPrefs();
  p.headerColor = colorMode;
  savePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: { dark: { accent: '#93C5FD', eyebrow: '#7FB3F4' }, light: { accent: '#2563EB', eyebrow: '#346FC9' } },
    sand: { dark: { accent: '#FCD34D', eyebrow: '#E7BC58' }, light: { accent: '#B45309', eyebrow: '#9B640F' } },
    emerald: { dark: { accent: '#6EE7B7', eyebrow: '#64D5A7' }, light: { accent: '#047857', eyebrow: '#0B8A66' } },
    royal: { dark: { accent: '#C4B5FD', eyebrow: '#AE99F4' }, light: { accent: '#6D28D9', eyebrow: '#7B36E0' } },
    burgundy: { dark: { accent: '#F9A8D4', eyebrow: '#F28DBF' }, light: { accent: '#BE185D', eyebrow: '#C02D68' } }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--header-title-accent');
    document.documentElement.style.removeProperty('--header-eyebrow');
  } else if (palettes[colorMode]) {
    const h = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--header-title-accent', h.accent);
    document.documentElement.style.setProperty('--header-eyebrow', h.eyebrow);
  }
  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`header-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
}

function setTableColor(colorMode) {
  const p = getPrefs();
  p.tableColor = colorMode;
  savePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: { dark: { surface: '#111827', border: '#334155', headBg: '#172033', headText: '#94A3B8', headHover: '#93C5FD', rowBorder: 'rgba(71,85,105,.65)', rowHoverBg: 'rgba(96,165,250,.08)', rowSelectedBg: 'rgba(96,165,250,.14)', rowSelectedBorder: 'rgba(96,165,250,.32)' }, light: { surface: '#F8FBFF', border: '#CBDDF6', headBg: '#EAF2FF', headText: '#4F6688', headHover: '#2563EB', rowBorder: 'rgba(151,174,209,.62)', rowHoverBg: 'rgba(59,130,246,.08)', rowSelectedBg: 'rgba(59,130,246,.14)', rowSelectedBorder: 'rgba(59,130,246,.28)' } },
    sand: { dark: { surface: '#1F1810', border: '#5B452E', headBg: '#2A2016', headText: '#BEA789', headHover: '#F3C56C', rowBorder: 'rgba(121,94,61,.62)', rowHoverBg: 'rgba(245,158,11,.08)', rowSelectedBg: 'rgba(245,158,11,.14)', rowSelectedBorder: 'rgba(245,158,11,.3)' }, light: { surface: '#FFF9EE', border: '#E8D7BC', headBg: '#FBF1DD', headText: '#876B42', headHover: '#B45309', rowBorder: 'rgba(205,180,141,.62)', rowHoverBg: 'rgba(180,83,9,.08)', rowSelectedBg: 'rgba(180,83,9,.14)', rowSelectedBorder: 'rgba(180,83,9,.28)' } },
    emerald: { dark: { surface: '#10211B', border: '#2C5848', headBg: '#162E25', headText: '#8DB9A8', headHover: '#6EE7B7', rowBorder: 'rgba(63,109,94,.62)', rowHoverBg: 'rgba(16,185,129,.08)', rowSelectedBg: 'rgba(16,185,129,.14)', rowSelectedBorder: 'rgba(16,185,129,.31)' }, light: { surface: '#F1FBF6', border: '#C8E6D9', headBg: '#E2F5EC', headText: '#4F7D6D', headHover: '#047857', rowBorder: 'rgba(137,186,167,.62)', rowHoverBg: 'rgba(5,150,105,.08)', rowSelectedBg: 'rgba(5,150,105,.14)', rowSelectedBorder: 'rgba(5,150,105,.28)' } },
    royal: { dark: { surface: '#19152C', border: '#4A3C7C', headBg: '#211A38', headText: '#AFA0D9', headHover: '#C4B5FD', rowBorder: 'rgba(93,81,145,.62)', rowHoverBg: 'rgba(139,92,246,.08)', rowSelectedBg: 'rgba(139,92,246,.14)', rowSelectedBorder: 'rgba(167,139,250,.31)' }, light: { surface: '#F7F2FF', border: '#DDCEF9', headBg: '#EFE6FF', headText: '#74639F', headHover: '#6D28D9', rowBorder: 'rgba(177,157,218,.62)', rowHoverBg: 'rgba(109,40,217,.08)', rowSelectedBg: 'rgba(109,40,217,.14)', rowSelectedBorder: 'rgba(109,40,217,.28)' } },
    burgundy: { dark: { surface: '#25141B', border: '#673548', headBg: '#301924', headText: '#C39AAF', headHover: '#F9A8D4', rowBorder: 'rgba(110,67,84,.62)', rowHoverBg: 'rgba(244,114,182,.08)', rowSelectedBg: 'rgba(244,114,182,.14)', rowSelectedBorder: 'rgba(244,114,182,.31)' }, light: { surface: '#FFF4F8', border: '#EDCFDB', headBg: '#FDEAF1', headText: '#8C5D70', headHover: '#BE185D', rowBorder: 'rgba(205,154,177,.62)', rowHoverBg: 'rgba(190,24,93,.08)', rowSelectedBg: 'rgba(190,24,93,.14)', rowSelectedBorder: 'rgba(190,24,93,.28)' } }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--table-surface');
    document.documentElement.style.removeProperty('--table-border');
    document.documentElement.style.removeProperty('--table-head-bg');
    document.documentElement.style.removeProperty('--table-head-text');
    document.documentElement.style.removeProperty('--table-head-hover');
    document.documentElement.style.removeProperty('--table-row-border');
    document.documentElement.style.removeProperty('--table-row-hover-bg');
    document.documentElement.style.removeProperty('--table-row-selected-bg');
    document.documentElement.style.removeProperty('--table-row-selected-border');
  } else if (palettes[colorMode]) {
    const tb = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--table-surface', tb.surface);
    document.documentElement.style.setProperty('--table-border', tb.border);
    document.documentElement.style.setProperty('--table-head-bg', tb.headBg);
    document.documentElement.style.setProperty('--table-head-text', tb.headText);
    document.documentElement.style.setProperty('--table-head-hover', tb.headHover);
    document.documentElement.style.setProperty('--table-row-border', tb.rowBorder);
    document.documentElement.style.setProperty('--table-row-hover-bg', tb.rowHoverBg);
    document.documentElement.style.setProperty('--table-row-selected-bg', tb.rowSelectedBg);
    document.documentElement.style.setProperty('--table-row-selected-border', tb.rowSelectedBorder);
  }
  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`table-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
}

function setPanelColor(colorMode) {
  const p = getPrefs();
  p.panelColor = colorMode;
  savePrefs(p);
  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    slate:  { dark: { bg:'#1E2530', border:'#3A4558', head:'#1A2030' }, light: { bg:'#EEF2F8', border:'#BCC8DC', head:'#E4EAF4' } },
    navy:   { dark: { bg:'#111A2E', border:'#2A3F6A', head:'#0D1526' }, light: { bg:'#DDE8F8', border:'#96B8E8', head:'#C8D9F4' } },
    forest: { dark: { bg:'#111E18', border:'#26432E', head:'#0D1A13' }, light: { bg:'#D8F0E0', border:'#88C49A', head:'#C2E6CE' } },
    plum:   { dark: { bg:'#1E1428', border:'#3E2860', head:'#180F22' }, light: { bg:'#EDE0F8', border:'#C4A0E0', head:'#E0CDF4' } },
    stone:  { dark: { bg:'#1E1C18', border:'#3D3830', head:'#191712' }, light: { bg:'#EDE8DE', border:'#C0AE90', head:'#E2D9C8' } },
    rose:   { dark: { bg:'#241420', border:'#5C2845', head:'#1C0D19' }, light: { bg:'#F8E4EE', border:'#DDA0BF', head:'#F2D0E4' } },
    teal:   { dark: { bg:'#0F1E20', border:'#1E4A50', head:'#0A1618' }, light: { bg:'#D8F0EE', border:'#80C8C4', head:'#C0E6E4' } },
    gold:   { dark: { bg:'#201A0A', border:'#5A4510', head:'#181200' }, light: { bg:'#FDF3D8', border:'#D4AF5A', head:'#F8E8B8' } }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--qs-panel-bg');
    document.documentElement.style.removeProperty('--qs-panel-border');
    document.documentElement.style.removeProperty('--qs-panel-head-bg');
  } else if (palettes[colorMode]) {
    const c = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--qs-panel-bg', c.bg);
    document.documentElement.style.setProperty('--qs-panel-border', c.border);
    document.documentElement.style.setProperty('--qs-panel-head-bg', c.head);
  }
  ['default','slate','navy','forest','plum','stone','rose','teal','gold'].forEach(mode => {
    const btn = document.getElementById(`panel-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
}

function resetAllSettings() {
  const defaults = {
    theme: 'dark', fontSize: 'normal', currency: 'USD', area: 'm2',
    ownership: 'sahm', fontFamily: 'Tajawal', lang: 'ar',
    fontColor: 'default', navbarColor: 'default', headerColor: 'default',
    tableColor: 'default', panelColor: 'plum'
  };
  savePrefs(defaults);
  setThemePref(defaults.theme);
  setFontSize(defaults.fontSize);
  setCurrency(defaults.currency);
  setArea(defaults.area);
  setOwnership(defaults.ownership);
  applyFont(defaults.fontFamily);
  document.querySelectorAll('[name="fontFamily"]').forEach(r => { r.checked = r.value === defaults.fontFamily; });
  setFontColor(defaults.fontColor);
  setNavbarColor(defaults.navbarColor);
  setHeaderColor(defaults.headerColor);
  setTableColor(defaults.tableColor);
  setPanelColor(defaults.panelColor);
  if (typeof setLang === 'function') setLang(defaults.lang);
}

function loadPrefs() {
  const p = getPrefs();
  const t = localStorage.getItem('themeMode') || p.theme || 'dark';
  setThemePref(t);
  if (p.fontSize) setFontSize(p.fontSize);
  if (p.currency) setCurrency(p.currency);
  else setCurrency('USD');
  if (p.area) setArea(p.area);
  else setArea('m2');
  if (p.ownership) setOwnership(p.ownership);
  else setOwnership('sahm');
  if (p.fontFamily) {
    applyFont(p.fontFamily);
    document.querySelectorAll('[name="fontFamily"]').forEach(r => { r.checked = r.value === p.fontFamily; });
  }
  if (p.lang) setLang(p.lang);
  if (p.fontColor) setFontColor(p.fontColor); else setFontColor('default');
  if (p.navbarColor) setNavbarColor(p.navbarColor); else setNavbarColor('default');
  if (p.headerColor) setHeaderColor(p.headerColor); else setHeaderColor('default');
  if (p.tableColor) setTableColor(p.tableColor); else setTableColor('default');
  if (p.panelColor) setPanelColor(p.panelColor); else setPanelColor('plum');
}

document.querySelectorAll('[name="fontFamily"]').forEach(r => {
  r.addEventListener('change', function() {
    applyFont(this.value);
    const p = getPrefs();
    p.fontFamily = this.value;
    savePrefs(p);
  });
});

const togglePassBtn = document.getElementById('toggle-pass');
if (togglePassBtn) {
  togglePassBtn.addEventListener('click', function() {
    const inp = document.getElementById('password');
    const open = document.getElementById('eye-open');
    const closed = document.getElementById('eye-closed');
    if (inp.type === 'password') {
      inp.type = 'text';
      open.style.display = 'none';
      closed.style.display = '';
    } else {
      inp.type = 'password';
      open.style.display = '';
      closed.style.display = 'none';
    }
  });
}


loadPrefs();
