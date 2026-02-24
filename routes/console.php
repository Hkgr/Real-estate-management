<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users:create-viewer {name} {email} {password}', function (string $name, string $email, string $password) {
    $user = \App\Models\User::query()->updateOrCreate(
        ['email' => $email],
        ['name' => $name, 'password' => $password],
    );

    if (! \Spatie\Permission\Models\Role::query()->where('name', 'viewer')->where('guard_name', 'web')->exists()) {
        \Spatie\Permission\Models\Role::query()->create(['name' => 'viewer', 'guard_name' => 'web']);
    }

    $user->syncRoles(['viewer']);

    $this->info("Viewer user ready: {$user->email}");
})->purpose('Create or update a read-only viewer user for /viewer panel.');
