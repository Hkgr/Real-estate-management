<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>محفظة العقارات — لوحة التحكم</title>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

<div class="app-wrapper">

  <!-- ═══ SIDEBAR ═══ -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-badge">محفظة الاستثمار</div>
      <div class="logo-title">عقارات الفخامة</div>
      <div class="logo-sub">نظام إدارة الحصص العقارية</div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">الرئيسية</div>

      <button class="nav-item active" onclick="switchPage('dashboard', this)">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <rect x="1" y="1" width="7" height="7" rx="1.5"/>
          <rect x="10" y="1" width="7" height="7" rx="1.5"/>
          <rect x="1" y="10" width="7" height="7" rx="1.5"/>
          <rect x="10" y="10" width="7" height="7" rx="1.5"/>
        </svg>
        لوحة التحكم
      </button>

      <button class="nav-item" onclick="switchPage('properties', this)">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M2 16V7l7-5 7 5v9"/>
          <rect x="6" y="10" width="3" height="6"/>
          <rect x="9" y="10" width="3" height="6"/>
        </svg>
        بطاقات العقار
      </button>

      <div class="nav-section-label">التقارير</div>

      <button class="nav-item" onclick="alert('قريباً')">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M3 13l4-4 3 3 5-6"/>
          <rect x="1" y="1" width="16" height="16" rx="2"/>
        </svg>
        التحليلات
      </button>

      <button class="nav-item" onclick="alert('قريباً')">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M9 1v16M1 9h16"/>
          <circle cx="9" cy="9" r="8"/>
        </svg>
        توزيع الأرباح
      </button>

      <button class="nav-item" onclick="alert('قريباً')">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 4h10v10H4z" rx="1"/>
          <path d="M7 8h4M7 11h4M7 5h4"/>
        </svg>
        المستندات
      </button>
    </nav>

    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">خ</div>
        <div>
          <div class="user-name">خالد العمراني</div>
          <div class="user-role">مستثمر رئيسي</div>
        </div>
        <div class="notif-dot" style="margin-right:auto"></div>
      </div>
    </div>
  </aside>

  <!-- ═══ MAIN ═══ -->
  <div class="main-content">

    <!-- TOP BAR -->
    <header class="topbar">
      <div class="topbar-title" id="topbar-title">لوحة <span>التحكم</span></div>
      <div class="topbar-actions">
        <div class="topbar-date topbar-datetime" id="topbar-datetime">
          <span id="topbar-time">--:--:--</span>
          <span class="topbar-datetime-sep">•</span>
          <span id="topbar-date">جارٍ التحميل…</span>
        </div>
        <button class="topbar-btn" onclick="switchPage('properties', document.querySelector('.nav-item:nth-child(2)'))">⊞ بطاقات العقار</button>
        <button class="topbar-btn logout" onclick="handleLogout()">⎋ تسجيل الخروج</button>
      </div>
    </header>

    <!-- ══════════════════════
         PAGE 1: DASHBOARD
    ══════════════════════ -->
    <div class="page active" id="page-dashboard">
      <div style="max-width: 1400px; margin: 0 auto;">

        <div class="page-header page-header-dashboard">
          <div>
            <div class="page-eyebrow">نظرة عامة على المحفظة</div>
            <div class="page-title">مرحباً، <em>خالد</em></div>
            <div class="page-subtitle">إجمالي محفظتك العقارية ومؤشرات الأداء الرئيسية</div>
          </div>
          <div class="page-hero-icon" aria-hidden="true" id="dashboard-hero">
            <svg viewBox="0 0 160 90">
              <defs>
                <linearGradient id="heroSky" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#1a1306"/>
                  <stop offset="60%" stop-color="#0c0904"/>
                  <stop offset="100%" stop-color="#050403"/>
                </linearGradient>
                <linearGradient id="heroTowerFront" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#D4AF37"/>
                  <stop offset="60%" stop-color="#8B6914"/>
                  <stop offset="100%" stop-color="#111111"/>
                </linearGradient>
                <linearGradient id="heroTowerSide" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#C49A2A"/>
                  <stop offset="80%" stop-color="#3D3D3D"/>
                </linearGradient>
                <radialGradient id="heroGlow" cx="50%" cy="10%" r="70%">
                  <stop offset="0%" stop-color="rgba(212,175,55,0.85)"/>
                  <stop offset="100%" stop-color="rgba(212,175,55,0)"/>
                </radialGradient>
              </defs>
              <!-- السماء والخلفية -->
              <g class="page-hero-layer" data-depth="1">
                <rect x="8" y="8" width="144" height="72" rx="12" fill="url(#heroSky)" />
                <ellipse cx="80" cy="82" rx="60" ry="6" fill="rgba(0,0,0,0.9)"/>
              </g>
              <!-- ناطحة سحاب ذهبية أمامية ثلاثية الأبعاد -->
              <g class="page-hero-layer" data-depth="4">
                <!-- جانب يمين للبرج -->
                <polygon points="88,12 104,16 104,72 88,68"
                         fill="url(#heroTowerSide)" />
                <!-- الواجهة الأمامية الطويلة -->
                <polygon points="64,16 88,12 88,68 64,72"
                         fill="url(#heroTowerFront)" />
                <!-- قاعدة عريضة -->
                <polygon points="52,72 92,66 120,72 80,78"
                         fill="#050403"
                         stroke="rgba(212,175,55,0.45)"
                         stroke-width="1.1"/>
                <!-- صفوف نوافذ كثيرة تعطي إحساس ناطحة سحاب -->
                <g fill="rgba(15,11,4,0.96)" stroke="#F5E9C0" stroke-width="0.6">
                  <!-- العمود الأيسر -->
                  <rect x="68" y="20" width="4" height="8" rx="1.2"/>
                  <rect x="68" y="32" width="4" height="8" rx="1.2"/>
                  <rect x="68" y="44" width="4" height="8" rx="1.2"/>
                  <rect x="68" y="56" width="4" height="8" rx="1.2"/>
                  <!-- العمود الأوسط -->
                  <rect x="78" y="18" width="4" height="9" rx="1.2"/>
                  <rect x="78" y="31" width="4" height="9" rx="1.2"/>
                  <rect x="78" y="44" width="4" height="9" rx="1.2"/>
                  <rect x="78" y="57" width="4" height="9" rx="1.2"/>
                  <!-- العمود الأيمن -->
                  <rect x="88" y="21" width="4" height="8" rx="1.2"/>
                  <rect x="88" y="33" width="4" height="8" rx="1.2"/>
                  <rect x="88" y="45" width="4" height="8" rx="1.2"/>
                  <rect x="88" y="57" width="4" height="8" rx="1.2"/>
                </g>
                <!-- قمة ناطحة السحاب -->
                <polygon points="72,12 88,8 100,12 88,16"
                         fill="#FACC6B" opacity="0.96" />
                <!-- هوائي علوي -->
                <rect x="87" y="4" width="2" height="6" fill="#FCD34D"/>
                <circle cx="88" cy="4" r="1.2" fill="#FDE68A"/>
              </g>
            </svg>
          </div>
        </div>

        <!-- STAT CARDS -->
        <div class="stats-grid">
          <div class="stat-card gold-card">
            <div class="stat-bg-icon">
              <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                <rect x="8" y="26" width="16" height="26" rx="2" fill="none" stroke="rgba(212,175,55,.4)" stroke-width="2"/>
                <rect x="24" y="18" width="16" height="34" rx="2" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2"/>
                <rect x="40" y="12" width="16" height="40" rx="2" fill="none" stroke="rgba(212,175,55,.2)" stroke-width="2"/>
              </svg>
            </div>
            <div class="stat-label">
              إجمالي المبلغ
              <div class="stat-icon">
                <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                  <path d="M3 11h14M5 5h10M7 15h6" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
              </div>
            </div>
            <div class="stat-value"><small>﷼</small>65.0<small>م</small></div>
            <div class="stat-sub">إجمالي قيمة المحفظة العقارية</div>
            <div class="stat-mini-graph">
              <svg viewBox="0 0 100 40">
                <!-- grid -->
                <defs>
                  <pattern id="miniGrid1" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid1)" />
                <!-- axis -->
                <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <!-- line -->
                <polyline
                  fill="none"
                  stroke="var(--gold-bright)"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="8,30 28,18 48,22 68,14 88,10"/>
                <!-- points -->
                <circle cx="8" cy="30" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                <circle cx="28" cy="18" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                <circle cx="48" cy="22" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                <circle cx="68" cy="14" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                <circle cx="88" cy="10" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
              </svg>
            </div>
            <div class="stat-badge badge-up">↑ نمو ١٢٪ عن العام الماضي</div>
          </div>

          <div class="stat-card">
            <div class="stat-bg-icon">
              <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                <path d="M10 26c0-8 6-14 18-14h8c12 0 18 6 18 14s-6 14-18 14h-4" fill="none" stroke="rgba(212,175,55,.35)" stroke-width="2" stroke-linecap="round"/>
                <path d="M24 40c0 4 3 7 8 7s8-3 8-7-3-7-8-7" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="stat-label">
              إجمالي المدفوعات
              <div class="stat-icon">
                <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                  <rect x="3" y="4" width="14" height="10" rx="2" fill="none" stroke="var(--gold-bright)" stroke-width="1.4"/>
                  <path d="M3 9h14" fill="none" stroke="var(--gold-bright)" stroke-width="1.2"/>
                </svg>
              </div>
            </div>
            <div class="stat-value"><small>﷼</small>48.7<small>م</small></div>
            <div class="stat-sub">إجمالي المدفوعات المستلمة حتى الآن</div>
            <div class="stat-mini-graph">
              <svg viewBox="0 0 100 40">
                <defs>
                  <pattern id="miniGrid2" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid2)" />
                <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <polyline
                  fill="none"
                  stroke="var(--gold-mid)"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="8,32 28,24 48,26 68,18 88,14"/>
                <circle cx="8" cy="32" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                <circle cx="28" cy="24" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                <circle cx="48" cy="26" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                <circle cx="68" cy="18" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                <circle cx="88" cy="14" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
              </svg>
            </div>
            <div class="stat-badge badge-up">↑ ١٤.٢٪ منذ بداية العام</div>
          </div>

          <div class="stat-card">
            <div class="stat-bg-icon">
              <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                <path d="M12 30l20-16 20 16v18a4 4 0 0 1-4 4H16a4 4 0 0 1-4-4V30z" fill="none" stroke="rgba(212,175,55,.35)" stroke-width="2" stroke-linejoin="round"/>
                <rect x="26" y="32" width="12" height="16" rx="2" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2"/>
              </svg>
            </div>
            <div class="stat-label">
              إجمالي الباقي
              <div class="stat-icon">
                <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                  <circle cx="8" cy="8" r="3" fill="none" stroke="var(--gold-bright)" stroke-width="1.4"/>
                  <path d="M11 9l3 3m0-2.5l1.5 1.5" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
              </div>
            </div>
            <div class="stat-value"><small>﷼</small>16.3<small>م</small></div>
            <div class="stat-sub">المبالغ المتبقية على المستثمرين</div>
            <div class="stat-mini-graph">
              <svg viewBox="0 0 100 40">
                <defs>
                  <pattern id="miniGrid3" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid3)" />
                <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <polyline
                  fill="none"
                  stroke="#f87171"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="8,10 28,14 48,18 68,24 88,28"/>
                <circle cx="8" cy="10" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                <circle cx="28" cy="14" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                <circle cx="48" cy="18" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                <circle cx="68" cy="24" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                <circle cx="88" cy="28" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
              </svg>
            </div>
            <div class="stat-badge badge-neutral">● تحت المتابعة والتحصيل</div>
          </div>

          <div class="stat-card">
            <div class="stat-bg-icon">
              <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                <path d="M12 44h40" fill="none" stroke="rgba(212,175,55,.3)" stroke-width="2" stroke-linecap="round"/>
                <path d="M16 40l6-10 8 6 10-14 8 12" fill="none" stroke="rgba(212,175,55,.45)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="22" cy="30" r="2" fill="rgba(212,175,55,.5)"/>
                <circle cx="30" cy="36" r="2" fill="rgba(212,175,55,.5)"/>
                <circle cx="40" cy="22" r="2" fill="rgba(212,175,55,.5)"/>
                <circle cx="48" cy="34" r="2" fill="rgba(212,175,55,.5)"/>
              </svg>
            </div>
            <div class="stat-label">
              إجمالي الأسهم
              <div class="stat-icon">
                <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                  <path d="M6 5a3 3 0 0 1 3-3m2 3a3 3 0 0 1-3 3m5 5a3 3 0 0 1-3 3m-2-3a3 3 0 0 1 3-3M6 5l8 10" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
              </div>
            </div>
            <div class="stat-value">3,420<small>سهم</small></div>
            <div class="stat-sub">إجمالي عدد الأسهم في جميع العقارات</div>
            <div class="stat-mini-graph">
              <svg viewBox="0 0 100 40">
                <defs>
                  <pattern id="miniGrid4" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid4)" />
                <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                <polyline
                  fill="none"
                  stroke="var(--gold-light)"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="8,26 28,24 48,20 68,16 88,12"/>
                <circle cx="8" cy="26" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                <circle cx="28" cy="24" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                <circle cx="48" cy="20" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                <circle cx="68" cy="16" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                <circle cx="88" cy="12" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
              </svg>
            </div>
            <div class="stat-badge badge-up">↑ إضافة أسهم جديدة هذا العام</div>
          </div>
        </div>

        <div class="ornament">
          <div class="ornament-line"></div>
          <div class="ornament-dot"></div>
          <div class="ornament-diamond"></div>
          <div class="ornament-dot"></div>
          <div class="ornament-line rev"></div>
        </div>

        <!-- CHARTS ROW -->
        <div class="charts-row">

          <!-- Line chart: portfolio by years -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">تطور المحفظة عبر السنوات</div>
                <div class="chart-sub">القيمة الإجمالية للمحفظة بالريال لكل سنة</div>
              </div>
              <div class="chart-badge">٢٠٢٠ - ٢٠٢٥</div>
            </div>
            <div style="margin-top:8px;">
              <svg viewBox="0 0 140 88">
                <!-- grid background -->
                <defs>
                  <pattern id="yearGrid" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="rgba(148,163,184,0.16)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="14" y="10" width="108" height="56" fill="url(#yearGrid)" />

                <!-- axes -->
                <line x1="18" y1="14" x2="18" y2="70" stroke="rgba(148,163,184,0.7)" stroke-width="1"/>
                <line x1="18" y1="70" x2="122" y2="70" stroke="rgba(148,163,184,0.7)" stroke-width="1"/>

                <!-- y ticks -->
                <g font-size="6" fill="#9ca3af">
                  <text x="14" y="68" text-anchor="end">0</text>
                  <text x="14" y="58" text-anchor="end">5</text>
                  <text x="14" y="48" text-anchor="end">10</text>
                  <text x="14" y="38" text-anchor="end">15</text>
                  <text x="14" y="28" text-anchor="end">20</text>
                </g>

                <!-- line: إجمالي المبلغ (ذهبي أساسي) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-bright)"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,62 38,28 54,36 70,30 86,22 102,32"/>
                <!-- line: إجمالي المدفوعات (ذهبي متوسط) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-mid)"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,66 38,38 54,44 70,38 86,32 102,42"/>
                <!-- line: إجمالي الباقي (ذهبي داكن) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-deep)"
                  stroke-width="1.4"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,68 38,56 54,58 70,48 86,40 102,52"/>

                <!-- نقاط البيانات -->
                <g fill="#050505">
                  <!-- الذهبي -->
                  <circle cx="22" cy="62" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="38" cy="28" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="54" cy="36" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="70" cy="30" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="86" cy="22" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="102" cy="32" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <!-- المتوسط -->
                  <circle cx="22" cy="66" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="38" cy="38" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="54" cy="44" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="70" cy="38" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="86" cy="32" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="102" cy="42" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <!-- الداكن -->
                  <circle cx="22" cy="68" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="38" cy="56" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="54" cy="58" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="70" cy="48" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="86" cy="40" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="102" cy="52" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                </g>

                <!-- x labels -->
                <g font-size="7" fill="#9ca3af">
                  <text x="22" y="80" text-anchor="middle">٢٠٢٠</text>
                  <text x="38" y="80" text-anchor="middle">٢٠٢١</text>
                  <text x="54" y="80" text-anchor="middle">٢٠٢٢</text>
                  <text x="70" y="80" text-anchor="middle">٢٠٢٣</text>
                  <text x="86" y="80" text-anchor="middle">٢٠٢٤</text>
                  <text x="102" y="80" text-anchor="middle">٢٠٢٥</text>
                </g>

              </svg>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:4px;font-size:11px;color:#e5e7eb;">
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-deep);border-radius:999px;display:inline-block;"></span>
                الباقي
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-mid);border-radius:999px;display:inline-block;"></span>
                المدفوعات
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-bright);border-radius:999px;display:inline-block;"></span>
                المبلغ
              </span>
            </div>
          </div>

          <!-- Donut: share distribution -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">توزيع المناطق العقارية</div>
                <div class="chart-sub">حسب المناطق الأكثر استثماراً في المحفظة</div>
              </div>
              <div class="chart-badge">٦ مناطق رئيسية</div>
            </div>
            <div class="donut-wrap">
              <svg class="donut-svg" width="110" height="110" viewBox="0 0 110 110">
                <circle cx="55" cy="55" r="40" fill="none" stroke="#1A1A1A" stroke-width="20"/>
                <!-- Segments: total = 251.3 -->
                <circle cx="55" cy="55" r="40" fill="none" stroke="#D4AF37" stroke-width="20"
                  stroke-dasharray="110.6 140.7" stroke-dashoffset="0"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#C49A2A" stroke-width="20"
                  stroke-dasharray="75.4 175.9" stroke-dashoffset="-110.6"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#8B6914" stroke-width="20"
                  stroke-dasharray="50.3 201" stroke-dashoffset="-186"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#3D3D3D" stroke-width="20"
                  stroke-dasharray="15 236.3" stroke-dashoffset="-236.3"
                  transform="rotate(-90 55 55)"/>
                <text x="55" y="52" text-anchor="middle" font-family="Amiri" font-size="16" fill="#D4AF37" font-weight="700">6</text>
                <text x="55" y="65" text-anchor="middle" font-family="Tajawal" font-size="9" fill="#6B6560">مناطق</text>
              </svg>
              <div class="donut-legend">
                <div class="legend-item">
                  <div class="legend-dot" style="background:#D4AF37"></div>
                  الرياض
                  <span class="legend-pct">٣٥٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#C49A2A"></div>
                  جدة
                  <span class="legend-pct">٢٥٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#8B6914"></div>
                  الدمام
                  <span class="legend-pct">٢٠٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#3D3D3D"></div>
                  أبوظبي / دبي
                  <span class="legend-pct">٢٠٪</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Sparklines -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">أبرز العقارات من حيث التكلفة</div>
                <div class="chart-sub">أعلى المباني من حيث قيمة الاستثمار</div>
              </div>
            </div>
            <div class="sparkline-grid">
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">برج النخيل</div>
                  <div class="spark-val">٨.٤م ﷼</div>
                  <div class="spark-chg up">↑ ٨.٢٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,28 12,22 24,18 36,14 48,10 60,6 70,4" fill="none" stroke="#D4AF37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">مجمع الواحة</div>
                  <div class="spark-val">٦.١م ﷼</div>
                  <div class="spark-chg up">↑ ٥.١٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,26 12,22 24,24 36,18 48,14 60,12 70,8" fill="none" stroke="#C49A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">أبراج المدينة</div>
                  <div class="spark-val">٥.٧م ﷼</div>
                  <div class="spark-chg down">↓ ١.٣٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,8 12,10 24,9 36,14 48,18 60,20 70,24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">برج الفيصلية</div>
                  <div class="spark-val">٤.٢م ﷼</div>
                  <div class="spark-chg up">↑ ١١.٦٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,30 12,26 24,20 36,16 48,10 60,6 70,2" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>
          </div>

        </div>

        <!-- RECENT TABLE -->
        <div class="recent-card">
          <div class="recent-header">
            <div class="recent-title">آخر التحديثات العقارية</div>
            <button class="btn-link" onclick="switchPage('properties', document.querySelectorAll('.nav-item')[1])">عرض الكل ← </button>
          </div>
          <div class="table-overflow">
            <table class="mini-table">
              <thead>
                <tr>
                  <th>رقم العقار</th>
                  <th>المحافظة</th>
                  <th>المنطقة العقارية</th>
                  <th>مساحة العقار الكلية</th>
                  <th>الحالة</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-name">١٠٢٤/أ</td>
                  <td>الرياض</td>
                  <td>حي العليا</td>
                  <td class="td-gold">١٢,٤٠٠ م²</td>
                  <td><span class="status-badge status-active">● نشط</span></td>
                </tr>
                <tr>
                  <td class="td-name">٢١١٩/ب</td>
                  <td>جدة</td>
                  <td>حي الحمراء</td>
                  <td class="td-gold">٢٨,٦٠٠ م²</td>
                  <td><span class="status-badge status-active">● نشط</span></td>
                </tr>
                <tr>
                  <td class="td-name">٣٠٥٨/ج</td>
                  <td>الرياض</td>
                  <td>حي النزهة</td>
                  <td class="td-gold">٩,٢٠٠ م²</td>
                  <td><span class="status-badge status-partial">◑ جزئي</span></td>
                </tr>
                <tr>
                  <td class="td-name">٤١٠٧/د</td>
                  <td>الدمام</td>
                  <td>حي الشاطئ</td>
                  <td class="td-gold">٦,٨٠٠ م²</td>
                  <td><span class="status-badge status-active">● نشط</span></td>
                </tr>
                <tr>
                  <td class="td-name">٥٢٣٠/هـ</td>
                  <td>أبوظبي</td>
                  <td>منطقة الكورنيش</td>
                  <td class="td-gold">١٨,٠٠٠ م²</td>
                  <td><span class="status-badge status-pending">○ قيد المراجعة</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- ══════════════════════════════
         PAGE 2: BUILDING TABLE
    ══════════════════════════════ -->
    <div class="page" id="page-properties">
      <div style="max-width: 1400px; margin: 0 auto;">

        <div class="page-header">
          <div class="page-header-row">
            <div>
              <div class="page-eyebrow">سجل العقارات الكامل</div>
              <div class="page-title"><em>بطاقات</em> العقار</div>
              <div class="page-subtitle">جميع المباني والوحدات التي تمتلك فيها حصصاً — مع تصفية متقدمة وتصدير</div>
            </div>
            <div class="selection-card">
              <div class="selection-title">ملخص الاختيار الحالي</div>
              <div class="selection-main-value" id="selection-area">-- م²</div>
              <div class="selection-subvalue" id="selection-count">-- عقار</div>
              <div class="selection-bar">
                <div class="selection-bar-fill" id="selection-bar-fill"></div>
              </div>
              <div class="selection-meta">
                <span id="selection-mode">جميع العقارات</span>
                <span id="selection-share">0٪ من المساحة الكلية</span>
              </div>
            </div>
          </div>
        </div>

        <!-- TOOLBAR -->
        <div class="table-toolbar">
          <div class="search-wrap">
            <input class="search-input" type="text" placeholder="ابحث برقم العقار، المحضر، المحافظة أو المنطقة…" id="table-search" oninput="filterTable()">
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleCityMenu()" id="filter-city-label">
              كل المحافظات
            </button>
            <div class="col-menu" id="city-menu">
              <div class="col-menu-item" onclick="toggleCityFilter('الرياض')"><div class="col-toggle" id="city-riyadh">✓</div> الرياض</div>
              <div class="col-menu-item" onclick="toggleCityFilter('جدة')"><div class="col-toggle" id="city-jeddah">✓</div> جدة</div>
              <div class="col-menu-item" onclick="toggleCityFilter('الدمام')"><div class="col-toggle" id="city-dammam">✓</div> الدمام</div>
              <div class="col-menu-item" onclick="toggleCityFilter('أبوظبي')"><div class="col-toggle" id="city-abu">✓</div> أبوظبي</div>
              <div class="col-menu-item" onclick="toggleCityFilter('دبي')"><div class="col-toggle" id="city-dubai">✓</div> دبي</div>
            </div>
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleTypeMenu()" id="filter-type-label">
              كل المناطق العقارية
            </button>
            <div class="col-menu" id="type-menu">
              <div class="col-menu-item" onclick="toggleTypeFilter('حي العليا')"><div class="col-toggle" id="type-highrise">✓</div> حي العليا</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الحمراء')"><div class="col-toggle" id="type-hamra">✓</div> حي الحمراء</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي النزهة')"><div class="col-toggle" id="type-nuzha">✓</div> حي النزهة</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الشاطئ')"><div class="col-toggle" id="type-shate">✓</div> حي الشاطئ</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('منطقة الكورنيش')"><div class="col-toggle" id="type-corniche">✓</div> منطقة الكورنيش</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('طريق الملك فهد')"><div class="col-toggle" id="type-kingroad">✓</div> طريق الملك فهد</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الرويس')"><div class="col-toggle" id="type-ruwais">✓</div> حي الرويس</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الياسمين')"><div class="col-toggle" id="type-yasmin">✓</div> حي الياسمين</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('منطقة الخليج التجاري')"><div class="col-toggle" id="type-bay">✓</div> منطقة الخليج التجاري</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي المنار')"><div class="col-toggle" id="type-manar">✓</div> حي المنار</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('المنطقة المالية')"><div class="col-toggle" id="type-financial">✓</div> المنطقة المالية</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الشاطئ الذهبي')"><div class="col-toggle" id="type-golden">✓</div> حي الشاطئ الذهبي</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الروضة')"><div class="col-toggle" id="type-rawda">✓</div> حي الروضة</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('واجهة الخليج')"><div class="col-toggle" id="type-waterfront">✓</div> واجهة الخليج</div>
            </div>
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleAreaMenu()" id="filter-area-label">
              كل المساحات
            </button>
            <div class="col-menu" id="area-menu">
              <div class="col-menu-item" onclick="toggleAreaFilter('small')"><div class="col-toggle" id="area-small">✓</div> أقل من ١٠٬٠٠٠ م²</div>
              <div class="col-menu-item" onclick="toggleAreaFilter('medium')"><div class="col-toggle" id="area-medium">✓</div> ١٠٬٠٠٠ - ٢٠٬٠٠٠ م²</div>
              <div class="col-menu-item" onclick="toggleAreaFilter('large')"><div class="col-toggle" id="area-large">✓</div> أكثر من ٢٠٬٠٠٠ م²</div>
            </div>
          </div>

          <div class="toolbar-separator"></div>

          <div style="position:relative">
            <button class="toolbar-btn toolbar-btn-outline" onclick="toggleColMenu()">
              ⊟ إخفاء أعمدة
            </button>
            <div class="col-menu" id="col-menu">
              <div class="col-menu-item" onclick="toggleCol('col-city')"><div class="col-toggle" id="tog-city">✓</div> المحافظة</div>
              <div class="col-menu-item" onclick="toggleCol('col-type')"><div class="col-toggle" id="tog-type">✓</div> المنطقة العقارية</div>
              <div class="col-menu-item" onclick="toggleCol('col-division')"><div class="col-toggle" id="tog-division">✓</div> المقسم / الوصف</div>
              <div class="col-menu-item" onclick="toggleCol('col-payments')"><div class="col-toggle" id="tog-payments">✓</div> الدفعات</div>
            </div>
          </div>

          <button class="toolbar-btn toolbar-btn-outline" onclick="alert('يمكنك إعادة ترتيب الأعمدة بالسحب والإفلات')">
            ⇅ إعادة الترتيب
          </button>

          <div class="toolbar-separator"></div>

          <button class="toolbar-btn toolbar-btn-gold" onclick="toggleMultiSelect()" id="multi-select-btn">
            اختيار متعدد
          </button>
        </div>

        <!-- ACTIVE FILTERS + EXPORT -->
        <div class="filter-chips" id="filter-chips">
          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <span class="filter-label">التصفية الحالية:</span>
            <span class="chip active">الكل <span class="chip-remove">×</span></span>
          </div>
          <div class="export-btns">
            <button class="btn-export btn-excel" onclick="exportExcel()">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 4l6 6M10 4L4 10" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير Excel
            </button>
            <button class="btn-export btn-pdf" onclick="exportPDF()">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 7h6M4 4h6M4 10h4" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير PDF
            </button>
          </div>
        </div>

        <!-- TABLE -->
        <div class="table-card">
          <div class="table-overflow">
            <table class="big-table" id="main-table">
              <thead>
                <tr>
                  <th class="select-col">
                    <div class="th-inner">
                      <input type="checkbox" id="select-all" onclick="toggleSelectAll()" />
                    </div>
                  </th>
                  <th onclick="sortBySeq()" style="cursor:pointer">
                    <div class="th-inner">
                      تسلسل
                      <span class="sort-icon" id="sort-seq">↕</span>
                    </div>
                  </th>
                  <th><div class="th-inner">رقم العقار</div></th>
                  <th><div class="th-inner">المحضر</div></th>
                  <th class="col-city"><div class="th-inner">المحافظة</div></th>
                  <th class="col-type"><div class="th-inner">المنطقة العقارية</div></th>
                  <th class="col-division"><div class="th-inner">المقسم</div></th>
                  <th onclick="sortByArea()" style="cursor:pointer">
                    <div class="th-inner">
                      مساحة العقار الكلية
                      <span class="sort-icon" id="sort-area">↕</span>
                    </div>
                  </th>
                  <th><div class="th-inner">الموقع الجغرافي</div></th>
                  <th><div class="th-inner">الحالة</div></th>
                  <th><div class="th-inner">العمليات</div></th>
                  <th class="col-payments"><div class="th-inner">الدفعات</div></th>
                  <th><div class="th-inner">عرض</div></th>
                </tr>
              </thead>
              <tbody id="table-body">
                <!-- rows injected by JS -->
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <div class="pagination" id="pagination">
            <div class="export-info">
              إجمالي الصفوف: <strong id="row-count">14</strong> عقار
              | المحدَّد: <strong id="selected-count">0</strong>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
              <button class="page-btn" onclick="changePage(-1)">‹</button>
              <span class="filter-label" id="page-info">صفحة ١ من ١</span>
              <button class="page-btn" onclick="changePage(1)">›</button>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
              <span class="filter-label">عدد الصفوف المعروضة:</span>
              <input type="number" min="1" class="rows-input" id="rows-input" value="14" onchange="handleRowsInput(this.value)" />
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
</body>
</html>
