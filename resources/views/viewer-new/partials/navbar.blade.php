<nav class="topbar">
  <div class="topbar-left">
    <a class="topbar-brand" href="{{ route('viewer-new.index') }}">
      <div class="topbar-brand-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20.25a.75.75 0 01-.75.75H3.75a.75.75 0 01-.75-.75V9.75z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 20.25V12h6v8.25"/></svg>
      </div>
      <div><div class="topbar-brand-name">محفظة العقارات</div></div>
    </a>
  </div>
  <div class="topbar-center">
    <a href="{{ route('viewer-new.index') }}" class="topbar-nav-pill {{ ($active ?? 'index') === 'index' ? 'active' : '' }}">الرئيسية</a>
    <a href="{{ route('viewer-new.properties.index') }}" class="topbar-nav-pill {{ ($active ?? '') === 'properties' ? 'active' : '' }}">العقارات</a>
    <a href="{{ route('viewer-new.owners.index') }}" class="topbar-nav-pill {{ ($active ?? '') === 'owners' ? 'active' : '' }}">الملاك</a>
    <a href="{{ route('viewer-new.signals.index') }}" class="topbar-nav-pill {{ ($active ?? '') === 'signals' ? 'active' : '' }}">الإشارات</a>
    <a href="{{ route('viewer-new.reports.index') }}" class="topbar-nav-pill {{ ($active ?? '') === 'reports' ? 'active' : '' }}">التقارير</a>
  </div>
  <div class="topbar-right">
    <div class="topbar-user-chip">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" width="14" height="14" style="color:var(--gold-mid)"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a8.25 8.25 0 0114.998 0"/></svg>
      <div class="topbar-user-avatar" id="user-avatar-letter">م</div>
      <div><div class="topbar-user-name" id="user-display-name">مستخدم</div><div class="topbar-user-role" id="user-role-label">عارض</div></div>
    </div>
    <button class="topbar-btn logout" onclick="handleLogout()">
      <span style="display:flex;align-items:center;gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3.75"/></svg>
        <span>خروج</span>
      </span>
    </button>
  </div>
</nav>
