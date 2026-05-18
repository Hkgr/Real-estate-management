<aside class="sidebar" aria-label="التنقل الجانبي">
    <div class="sidebar-logo">
        <div class="logo-title-row">
            <div class="logo-title">عقارات</div>
            <button class="sidebar-toggle-top" type="button" aria-label="تصغير الشريط الجانبي" data-sidebar-toggle>
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4l-6 6 6 6"/>
                </svg>
            </button>
        </div>
        <div class="logo-sub">نظام إدارة الحصص العقارية</div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('viewer-new.reports.index') }}" class="nav-item active" aria-current="page">
            <span class="nav-text">التقارير</span>
        </a>
        <a href="{{ route('viewer-new.index') }}" class="nav-item">
            <span class="nav-text">البوابة</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">خ</div>
            <div>
                <div class="user-name">مستخدم</div>
                <div class="user-role">مستثمر رئيسي</div>
            </div>
            <div class="notif-dot" style="margin-right:auto"></div>
        </div>
    </div>
</aside>
