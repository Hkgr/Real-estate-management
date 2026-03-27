<x-filament-panels::page>
    <div class="page active" id="page-dashboard">
        <div style="max-width: 1400px; margin: 0 auto;">

            @include('filament.dashboard.partials.header')

            @include('filament.dashboard.partials.stats-grid')

            @include('filament.dashboard.partials.charts-row')

            @include('filament.dashboard.partials.recent-updates')

        </div>
    </div>
</x-filament-panels::page>