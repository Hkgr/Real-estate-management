    <header class="topbar">
      <!-- Desktop: just title on the right -->
      <div class="topbar-title topbar-title-desktop" id="topbar-title">بوابة <span>الإحصاءات</span></div>

      <!-- Mobile nav pills: replace sidebar on phones/tablets -->
      <nav class="topbar-mobile-nav" aria-label="تنقل رئيسي">
        <button type="button" class="topbar-nav-pill" id="mnav-properties" data-nav-page="reports-home"
          onclick="goToPage('reports-home')">
          <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M3 2h12v14H3z"/><path d="M5 6h8M5 9h6M5 12h8"/>
          </svg>
          <span class="pill-label">التقارير</span>
        </button>
        <button type="button" class="topbar-nav-pill active" id="mnav-dashboard" data-nav-page="stats-home"
          onclick="goToPage('stats-home')">
          <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M2 14V4h4v10H2zM7 14V8h4v6H7zM12 14V2h4v12h-4z"/>
          </svg>
          <span class="pill-label">الإحصاءات</span>
        </button>
        <button type="button" class="topbar-nav-pill" id="mnav-activity" data-nav-page="activity"
          onclick="goToPage('activity')">
          <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M9 4v5l3 2"/><circle cx="9" cy="9" r="7"/>
          </svg>
          <span class="pill-label">تتبع</span>
        </button>
      </nav>

      <div class="topbar-actions">
        <span class="app-version-badge" aria-label="Application version">v0.2.1</span>
        <div class="topbar-date topbar-datetime" id="topbar-datetime">
          <span id="topbar-time">--:--:--</span>
          <span class="topbar-datetime-sep">•</span>
          <span id="topbar-date">جارٍ التحميل…</span>
        </div>
        <button type="button" class="topbar-btn topbar-btn-props" id="topbar-hub-shortcut" onclick="goToPage('reports-home')" title="الانتقال إلى قسم التقارير">⊞ إلى التقارير</button>
        <button class="topbar-btn logout" onclick="handleLogout()">⎋ تسجيل الخروج</button>
      </div>
    </header>
