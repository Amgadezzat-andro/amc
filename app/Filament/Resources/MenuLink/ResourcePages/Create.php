<?php

namespace App\Filament\Resources\MenuLink\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\CreateBase;
use App\Filament\Resources\MenuLink\MenuLinkResource;
use App\Traits\HasParentResource;


class Create extends CreateBase
{
    use HasParentResource;

    protected static string $resource = MenuLinkResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('menu-link.index', [
            'parent' => $this->parent,
        ]);
    }

    // This can be moved to Trait, but we are keeping it here
    //   to avoid confusion in case you mutate the data yourself
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the parent relationship key to the parent resource's ID.
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }

}
