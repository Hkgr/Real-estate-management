<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;

class RashadPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('rashad')
            ->path('rashad')
            ->login()
            ->font('Cairo')
            ->maxContentWidth('full')
            ->viteTheme('resources/css/filament/rashad/theme.css')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([])
            ->pages([
                \App\Filament\Pages\PropertyCardPage::class,
                \App\Filament\Pages\OwnerCardPage::class,
                \App\Filament\Pages\SignalCardPage::class,
            ])
            ->widgets([
                \App\Filament\Widgets\AppStatsOverview::class,
            ])
            ->renderHook('panels::topbar.end', fn (): View => view('filament.components.realtime-notifications'))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
