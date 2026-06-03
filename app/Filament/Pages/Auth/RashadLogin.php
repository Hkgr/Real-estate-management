<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;

class RashadLogin extends Login
{
    public function getView(): string
    {
        return 'auth.rashad-login';
    }

    public function getLayout(): string
    {
        return 'auth.layouts.login';
    }
}
