  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-title-row">
        <div class="logo-title">عقارات</div>
        <button class="sidebar-toggle-top" type="button" aria-label="تصغير الشريط الجانبي" onclick="toggleSidebar()">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 4l-6 6 6 6"/>
          </svg>
        </button>
      </div>
      <div class="logo-sub">نظام إدارة الحصص العقارية</div>
    </div>

    <nav class="sidebar-nav">
      <button class="sidebar-toggle sidebar-toggle-inside" type="button" aria-label="تبديل القائمة الجانبية" onclick="toggleSidebar()">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
          <path d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        <span class="nav-text"></span>
      </button>

      <div class="nav-group">
        <button type="button" class="nav-item" data-nav-page="reports-home" onclick="goToPage('reports-home')">
          <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 2h12v14H3z" rx="1"/>
            <path d="M5 6h8M5 9h6M5 12h8"/>
          </svg>
          <span class="nav-text">التقارير</span>
        </button>
        <div class="nav-submenu" role="group" aria-label="قوائم التقارير">
          <button type="button" class="nav-subitem" data-nav-leaf="owners" onclick="event.stopPropagation(); goToPage('owners')" title="تقرير المالك">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="6" r="2.5"/><path d="M4 16v-1c0-2 2.5-3.5 5-3.5s5 1.5 5 3.5v1"/></svg>
            تقرير المالك
          </button>
          <button type="button" class="nav-subitem" data-nav-leaf="properties" onclick="event.stopPropagation(); goToPage('properties')" title="تقرير عقارات">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 16V7l7-5 7 5v9"/><rect x="6" y="10" width="3" height="6"/><rect x="9" y="10" width="3" height="6"/></svg>
            تقرير العقارات
          </button>
          <button type="button" class="nav-subitem" data-nav-leaf="consultations" onclick="event.stopPropagation(); goToPage('consultations')" title="تقرير الإشارات">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 2L3 7v9h12V7L9 2z"/><path d="M9 10v4"/></svg>
            تقرير الإشارات
          </button>
          <button type="button" class="nav-subitem" data-nav-leaf="attachments" onclick="event.stopPropagation(); goToPage('attachments')" title="تقرير الملحقات">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h10v10H4z"/><path d="M7 7h4M7 10h4M7 13h3"/></svg>
            تقرير الملحقات
          </button>
        </div>
      </div>

      <div class="nav-group">
        <button type="button" class="nav-item active" data-nav-page="stats-home" onclick="goToPage('stats-home')">
          <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M2 14V4h4v10H2zM7 14V8h4v6H7zM12 14V2h4v12h-4z"/>
          </svg>
          <span class="nav-text">الإحصاءات</span>
        </button>
        <div class="nav-submenu" role="group" aria-label="أقسام الإحصاءات">
          <button type="button" class="nav-subitem" data-stats-filter="financial" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'financial' })" title="إحصاءات مالية">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h12M3 10h12M6 14h6"/><circle cx="12" cy="6" r="1.2" fill="currentColor"/></svg>
            مالية
          </button>
          <button type="button" class="nav-subitem" data-stats-filter="administrative" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'administrative' })" title="إحصاءات إدارية">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="12" height="12" rx="2"/><path d="M6 7h6M6 10h4"/><circle cx="12" cy="5" r="1" fill="currentColor"/></svg>
            إدارية
          </button>
          <button type="button" class="nav-subitem" data-stats-filter="general" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'general' })" title="إحصاءات عامة">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="9" r="6.5"/><path d="M9 5v4l3 2"/></svg>
            عامة
          </button>
          <button type="button" class="nav-subitem" data-nav-leaf="stats-generator" onclick="event.stopPropagation(); goToPage('stats-generator')" title="مولد الاحصاءات">
            <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 14V8h3v6H3zm4 0V4h3v10H7zm4 0V10h3v4h-3z"/><path d="M2 16h14"/></svg>
            مولد الاحصاءات
          </button>
        </div>
      </div>

      <button type="button" class="nav-item" data-nav-page="activity" onclick="goToPage('activity')">
        <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M9 4v5l3 2"/>
          <circle cx="9" cy="9" r="7"/>
        </svg>
        <span class="nav-text">تقرير التتبع</span>
      </button>
    </nav>

    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">خ</div>
        <div>
          <div class="user-name">مستخدم </div>
          <div class="user-role">مستثمر رئيسي</div>
        </div>
        <div class="notif-dot" style="margin-right:auto"></div>
      </div>
    </div>
  </aside>
  <div class="sidebar-overlay" onclick="closeSidebarForMobile()"></div>
