<aside class="sidebar" aria-label="التنقل الرئيسي">
    <div class="sidebar-logo">
        <div class="logo-title-row">
            <h1 class="logo-title">محفظة العقارات</h1>
            <button type="button" class="sidebar-toggle-top" aria-label="طي الشريط الجانبي">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
        <p class="logo-sub">لوحة التقارير والإحصاءات</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-group">
            <a href="{{ route('viewer-new.reports.index') }}" class="nav-item {{ ($active ?? '') === 'reports' ? 'active' : '' }}">
                <span class="nav-icon">▦</span>
                <span class="nav-text">التقارير</span>
            </a>
            <div class="nav-submenu">
                <a href="{{ route('viewer-new.reports.index') }}" class="nav-subitem"><span class="nav-subicon">•</span>الرئيسية</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>تقرير الملاك</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>تقرير العقارات</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>تقرير الإشارات</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>تقرير المرفقات</a>
            </div>
        </div>

        <div class="nav-group">
            <a href="{{ route('viewer-new.index') }}" class="nav-item {{ ($active ?? 'index') === 'index' ? 'active' : '' }}">
                <span class="nav-icon">◫</span>
                <span class="nav-text">الإحصاءات</span>
            </a>
            <div class="nav-submenu">
                <a href="{{ route('viewer-new.index') }}" class="nav-subitem"><span class="nav-subicon">•</span>الرئيسية</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>الإحصاءات المالية</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>إحصاءات العقارات</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>الإحصاءات القانونية</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>الإحصاءات الإدارية</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>الإحصاءات العامة</a>
                <a href="#" class="nav-subitem"><span class="nav-subicon">•</span>مولد الإحصاءات</a>
            </div>
        </div>

        <div class="nav-group">
            <a href="#" class="nav-item">
                <span class="nav-icon">◉</span>
                <span class="nav-text">النشاط</span>
                <span class="notif-dot" aria-hidden="true"></span>
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar" id="user-avatar-letter">م</div>
            <div>
                <div class="user-name" id="user-display-name">مستخدم</div>
                <div class="user-role" id="user-role-label">عارض</div>
            </div>
        </div>
    </div>
</aside>
