<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
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
