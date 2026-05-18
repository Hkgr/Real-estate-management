<header class="vn-topbar">
    <div>
        <h1>{{ $title ?: 'البوابة' }}</h1>
        <p>منصة استعراض بواجهة عربية RTL</p>
    </div>
    <div class="vn-topbar__meta">
        <span class="vn-badge">{{ $version }}</span>
        <span id="vnTopbarClock">--:--:--</span>
        <a class="vn-back-link" href="{{ $backUrl }}">{{ $backLabel }}</a>
        <button type="button" class="vn-settings-btn" data-open-settings>الإعدادات</button>
    </div>
</header>
