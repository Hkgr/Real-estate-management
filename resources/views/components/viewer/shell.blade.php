@props([
    'active' => null,
    'activeLeaf' => null,
    'pageTitle' => 'لوحة العرض',
])

<div class="viewer-front" dir="rtl">
    <x-viewer.quick-settings />

    <div class="app-wrapper">
        <x-viewer.sidebar :active="$active" :active-leaf="$activeLeaf" />

        <div class="main-content">
            <x-viewer.topbar :page-title="$pageTitle" />

            {{ $slot }}
        </div>
    </div>
</div>
