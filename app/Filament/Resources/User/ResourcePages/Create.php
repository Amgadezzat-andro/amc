<?php

namespace App\Filament\Resources\User\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\CreateBase;
use App\Filament\Resources\User\UserResource;

class Create extends CreateBase
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $this->record->update(['superadmin' => 1]);
    }
}
