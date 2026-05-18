<header class="vn-topbar">
    <div class="vn-topbar__main">
        <h1 class="vn-topbar__title">{{ $title ?: 'البوابة' }}</h1>

        @hasSection('breadcrumbs')
            @yield('breadcrumbs')
        @else
            @include('viewer-new.partials.breadcrumbs', ['items' => $breadcrumbs ?? []])
        @endif
    </div>

    <div class="vn-topbar__actions">
        <span class="vn-topbar__badge">{{ $version ?? 'v0.2.1' }}</span>
        <span class="vn-topbar__badge vn-topbar__badge--muted" id="vnTopbarDate">--</span>
        <span class="vn-topbar__badge vn-topbar__badge--muted" id="vnTopbarClock">--:--:--</span>

        <button type="button" class="vn-topbar__icon-btn" aria-label="بحث" title="بحث">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M10.5 3a7.5 7.5 0 1 1 4.692 13.352l4.228 4.227-1.414 1.414-4.227-4.228A7.5 7.5 0 0 1 10.5 3Zm0 2a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z"/></svg>
        </button>
        <button type="button" class="vn-topbar__icon-btn" aria-label="التنبيهات" title="التنبيهات">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2a6 6 0 0 1 6 6v3.586l1.707 1.707A1 1 0 0 1 19 15H5a1 1 0 0 1-.707-1.707L6 11.586V8a6 6 0 0 1 6-6Zm0 20a3 3 0 0 1-2.83-2h5.66A3 3 0 0 1 12 22Z"/></svg>
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="vn-logout-btn">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M10 3a1 1 0 0 1 1 1v4H9V5H5v14h4v-3h2v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6Zm5.293 4.293L20 12l-4.707 4.707-1.414-1.414L16.172 13H8v-2h8.172l-2.293-2.293 1.414-1.414Z"/></svg>
                <span>تسجيل الخروج</span>
            </button>
        </form>
    </div>
</header>
