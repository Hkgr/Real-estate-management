<nav class="topbar">
    <div class="topbar-left">
        <a class="topbar-brand" href="{{ route('viewer-new.hub') }}">
            <div class="topbar-brand-icon">🏠</div>
            <div>
                <div class="topbar-brand-name">محفظة العقارات</div>
                <div class="topbar-brand-sub">REAL ESTATE PORTFOLIO</div>
            </div>
        </a>
    </div>

    <div class="topbar-center">
        <span class="topbar-status">لوحة التحكم الرئيسية • v0.2.1</span>
        <div class="topbar-clock" id="topbar-clock">--:--:--</div>
    </div>

    <div class="topbar-right">
        <button class="topbar-btn" id="lang-en-btn" type="button">🇬🇧 English (مؤجل)</button>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button class="topbar-btn logout" type="submit">خروج</button>
        </form>
    </div>
</nav>
