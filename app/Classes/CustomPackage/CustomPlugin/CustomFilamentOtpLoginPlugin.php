<?php

namespace App\Classes\CustomPackage\CustomPlugin;

use Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin;
use App\Filament\Pages\Auth\CustomOtpLogin;

class CustomFilamentOtpLoginPlugin extends FilamentOtpLoginPlugin
{
    public string $login = CustomOtpLogin::class;

}
