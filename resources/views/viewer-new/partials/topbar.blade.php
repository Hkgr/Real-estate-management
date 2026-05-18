<header class="vn-topbar">
    <div class="vn-topbar__main">
        <h1 class="vn-topbar__title">{{ $title ?: 'البوابة' }}</h1>

        @hasSection('breadcrumbs')
            @yield('breadcrumbs')
        @else
            @include('viewer-new.partials.breadcrumbs', ['items' => $breadcrumbs ?? []])
        @endif
    </div>

    <div class="vn-topbar__actions" role="group" aria-label="إجراءات الشريط العلوي">
        <div class="vn-topbar__action-group vn-topbar__action-group--meta" role="group" aria-label="معلومات النسخة والوقت">
            <span class="vn-topbar__badge">{{ $version ?? 'v0.2.1' }}</span>
            <span class="vn-topbar__badge vn-topbar__badge--muted" id="vnTopbarDate">--</span>
            <span class="vn-topbar__badge vn-topbar__badge--muted" id="vnTopbarClock">--:--:--</span>
        </div>

        <div class="vn-topbar__action-group vn-topbar__action-group--utility" role="group" aria-label="أدوات سريعة">
            <button type="button" class="vn-topbar__icon-btn" aria-label="بحث" title="بحث">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M10.5 3a7.5 7.5 0 1 1 4.692 13.352l4.228 4.227-1.414 1.414-4.227-4.228A7.5 7.5 0 0 1 10.5 3Zm0 2a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z"/></svg>
            </button>
            <button type="button" class="vn-topbar__icon-btn" aria-label="التنبيهات" title="التنبيهات">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 2a6 6 0 0 1 6 6v3.586l1.707 1.707A1 1 0 0 1 19 15H5a1 1 0 0 1-.707-1.707L6 11.586V8a6 6 0 0 1 6-6Zm0 20a3 3 0 0 1-2.83-2h5.66A3 3 0 0 1 12 22Z"/></svg>
            </button>
            <button type="button" class="vn-topbar__icon-btn" data-open-settings aria-label="الإعدادات" title="الإعدادات">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M19.14 12.94a7.5 7.5 0 0 0 .05-.94 7.5 7.5 0 0 0-.05-.94l2.03-1.58a.5.5 0 0 0 .12-.64l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.37 7.37 0 0 0-1.63-.94l-.36-2.54a.5.5 0 0 0-.5-.42h-3.84a.5.5 0 0 0-.5.42l-.36 2.54a7.37 7.37 0 0 0-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L2.71 8.84a.5.5 0 0 0 .12.64l2.03 1.58a7.5 7.5 0 0 0-.05.94c0 .32.02.63.05.94l-2.03 1.58a.5.5 0 0 0-.12.64l1.92 3.32a.5.5 0 0 0 .6.22l2.39-.96c.5.39 1.05.71 1.63.94l.36 2.54a.5.5 0 0 0 .5.42h3.84a.5.5 0 0 0 .5-.42l.36-2.54c.58-.23 1.13-.55 1.63-.94l2.39.96a.5.5 0 0 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.64l-2.03-1.58ZM12 15.25A3.25 3.25 0 1 1 12 8.75a3.25 3.25 0 0 1 0 6.5Z"/></svg>
            </button>
        </div>

        <div class="vn-topbar__action-group vn-topbar__action-group--primary" role="group" aria-label="إجراءات الحساب">
            <a href="{{ route('viewer-new.statistics') }}" class="vn-topbar__action-btn vn-topbar__action-btn--gold">الإحصاءات</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="vn-logout-btn">
                    <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path fill="currentColor" d="M10 3a1 1 0 0 1 1 1v4H9V5H5v14h4v-3h2v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6Zm5.293 4.293L20 12l-4.707 4.707-1.414-1.414L16.172 13H8v-2h8.172l-2.293-2.293 1.414-1.414Z"/></svg>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </div>
    </div>
</header>
