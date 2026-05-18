@props([
    'pageTitle' => 'لوحة العرض',
])

@php
    $user = auth()->user();
    $displayName = $user?->name ?: 'مستخدم';
@endphp

<header class="topbar">
    <div class="topbar-title">{{ $pageTitle }}</div>

    <div class="topbar-actions">
        <span class="app-version-badge" aria-label="Application version">v0.2.1</span>

        <div class="topbar-date topbar-datetime" id="topbar-datetime">
            <span id="topbar-time">--:--:--</span>
            <span class="topbar-datetime-sep">•</span>
            <span id="topbar-date">جارٍ التحميل…</span>
        </div>

        <div class="topbar-date" aria-label="المستخدم الحالي">{{ $displayName }}</div>
    </div>
</header>
