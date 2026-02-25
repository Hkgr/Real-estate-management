<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app()->setLocale('ar');

        DatePicker::configureUsing(function (DatePicker $component): void {
            $panelId = Filament::getCurrentPanel()?->getId();
            $format = config("filament_defaults.date_display_format.$panelId")
                ?? config('filament_defaults.date_display_format.default', 'd/m/Y');

            $component->displayFormat($format);
        });

        DateTimePicker::configureUsing(function (DateTimePicker $component): void {
            $panelId = Filament::getCurrentPanel()?->getId();
            $format = config("filament_defaults.date_display_format.$panelId")
                ?? config('filament_defaults.date_display_format.default', 'd/m/Y');

            $component->displayFormat($format);
        });

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::before(function ($user, string $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole('super_admin')
                ? true
                : null;
        });

        Schema::defaultStringLength(191);
    }
}
