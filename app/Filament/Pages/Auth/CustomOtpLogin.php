<?php

namespace App\Filament\Pages\Auth;

use Afsakar\FilamentOtpLogin\Filament\Pages\Login;


class CustomOtpLogin extends  Login
{
    
    
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => config('auth.providers.users.model')::STATUS_ACTIVE,
        ];
    }
    

    

}
