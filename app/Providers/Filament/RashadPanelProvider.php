<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

class RashadPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
return $panel
    ->id('rashad')
    ->path('rashad')

    ->middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    AuthenticateSession::class, // <-- Illuminate one
    ShareErrorsFromSession::class,
    VerifyCsrfToken::class,
    SubstituteBindings::class,
    DisableBladeIconComponents::class,
    DispatchServingFilamentEvent::class,

    \App\Http\Middleware\ProbeCookie::class,
    ])
    ->authMiddleware([
        Authenticate::class,
    ])

    ->login()

    ->font('Cairo')
    ->maxContentWidth('full')
    ->viteTheme('resources/css/filament/rashad/theme.css')
    ->colors([
        'primary' => Color::Amber,
    ])
    ->pages([
        \App\Filament\Pages\PropertyCardPage::class,
        \App\Filament\Pages\OwnerCardPage::class,
        \App\Filament\Pages\SignalCardPage::class,
    ])
    ->widgets([
        \App\Filament\Widgets\AppStatsOverview::class,
    ])
    ->renderHook('panels::topbar.end', fn (): View => view('filament.components.realtime-notifications'));

    }
}
