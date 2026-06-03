<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;

class ViewerLogin extends Login
{
    public function getView(): string
    {
        return 'auth.viewer-login';
    }

    public function getLayout(): string
    {
        return 'auth.layouts.login';
    }
}
