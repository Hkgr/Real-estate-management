<header class="topbar">
    <div class="topbar-title">
        <span>لوحة العرض</span>
    </div>

    <div class="topbar-actions">
        <div class="topbar-mobile-nav">
            <button type="button" class="topbar-nav-pill" aria-label="فتح القائمة">القائمة</button>
        </div>

        <span class="topbar-nav-pill">v2.0</span>
        <span class="topbar-nav-pill">{{ now()->format('Y-m-d H:i') }}</span>

        <button type="button" class="topbar-nav-pill" aria-label="الاختصارات">اختصار</button>
        <button type="button" class="topbar-nav-pill" onclick="handleLogout?.()">خروج</button>
    </div>
</header>
