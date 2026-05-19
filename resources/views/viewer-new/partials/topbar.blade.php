@php
    $currentUser = auth()->user();
    $userName = trim((string) ($currentUser?->name ?? ''));
    $displayName = $userName !== '' ? $userName : 'مستخدم';
    $avatarLetter = mb_substr($displayName, 0, 1, 'UTF-8') ?: 'م';
    $roleLabel = $currentUser?->role?->name
        ?? $currentUser?->role_name
        ?? (($currentUser && method_exists($currentUser, 'getRoleNames')) ? ($currentUser->getRoleNames()->first() ?: null) : null)
        ?? ($currentUser ? 'مستخدم النظام' : 'عارض');
@endphp

<header class="vn-app-header" role="banner" aria-label="الشريط العلوي">
    <div class="vn-app-header__inner">
        <a href="{{ route('viewer-new.hub') }}" class="vn-app-header__brand" aria-label="العودة إلى الرئيسية">
            <span class="vn-app-header__brand-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2 3 7v15h18V7l-9-5Zm-4 9h2v8H8v-8Zm3-3h2v11h-2V8Zm3 5h2v6h-2v-6Z"/></svg>
            </span>
            <span>
                <strong class="vn-app-header__brand-title">عقارات</strong>
                <small class="vn-app-header__brand-subtitle">نظام إدارة العقارات</small>
            </span>
        </a>

        <span class="vn-app-header__version">{{ $version ?? 'v0.2.1' }}</span>

        <div class="vn-app-header__search">
            <label for="vnQuickSearch" class="sr-only">بحث سريع</label>
            <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M10.5 3a7.5 7.5 0 1 1 4.69 13.35l4.23 4.23-1.42 1.41-4.22-4.22A7.5 7.5 0 0 1 10.5 3Zm0 2a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z"/></svg>
            <input id="vnQuickSearch" type="search" placeholder="بحث سريع..." autocomplete="off" spellcheck="false" aria-label="بحث سريع" />
            <kbd aria-hidden="true">Ctrl/K</kbd>
        </div>

        <div class="vn-app-header__left">
            <button type="button" class="vn-app-header__icon-btn" id="vnToggleFullscreen" aria-label="توسيع الشاشة" title="توسيع الشاشة">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M4 10V4h6v2H6v4H4Zm14 0V6h-4V4h6v6h-2ZM4 20v-6h2v4h4v2H4Zm14-2v-4h2v6h-6v-2h4Z"/></svg>
            </button>

            <div class="vn-app-header__date" aria-live="polite">
                <svg viewBox="0 0 24 24" width="15" height="15" aria-hidden="true"><path fill="currentColor" d="M7 2h2v2h6V2h2v2h3v18H4V4h3V2Zm11 8H6v10h12V10Z"/></svg>
                <span id="vnTopbarDate">--</span>
                <span id="vnTopbarClock">--:--</span>
            </div>

            <button type="button" class="vn-app-header__icon-btn" aria-label="التنبيهات" title="التنبيهات">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 2a6 6 0 0 1 6 6v3.59l1.7 1.7A1 1 0 0 1 19 15H5a1 1 0 0 1-.7-1.71L6 11.6V8a6 6 0 0 1 6-6Zm0 20a3 3 0 0 1-2.83-2h5.66A3 3 0 0 1 12 22Z"/></svg>
                <span class="vn-app-header__notif-badge" aria-hidden="true">3</span>
            </button>

            <button type="button" class="vn-app-header__icon-btn" data-open-settings aria-label="المساعدة والإعدادات" title="المساعدة والإعدادات">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 17h-2v-2h2Zm1.86-7.75-.9.92A3.25 3.25 0 0 0 13 14h-2v-.5a2.5 2.5 0 0 1 .74-1.78l1.24-1.26a1.5 1.5 0 1 0-2.56-1.06H8.42a3.5 3.5 0 1 1 6.44 1.85Z"/></svg>
            </button>

            <div class="vn-app-header__user" aria-label="معلومات المستخدم">
                <span class="vn-app-header__avatar" aria-hidden="true">{{ $avatarLetter }}</span>
                <span class="vn-app-header__user-copy">
                    <strong>{{ $displayName }}</strong>
                    <small>{{ $roleLabel }}</small>
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="vn-app-header__logout" aria-label="تسجيل الخروج" title="تسجيل الخروج">
                    <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M10 3a1 1 0 0 1 1 1v4H9V5H5v14h4v-3h2v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6Zm5.29 4.29L20 12l-4.71 4.71-1.41-1.42L16.17 13H8v-2h8.17l-2.29-2.29 1.41-1.42Z"/></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="vn-app-breadcrumb-row" aria-label="مسار التنقل">
        @hasSection('breadcrumbs')
            @yield('breadcrumbs')
        @else
            @include('viewer-new.partials.breadcrumbs', ['items' => $breadcrumbs ?? []])
        @endif
    </div>
</header>
