<?php

namespace App\Filament\Resources\MenuLink\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\EditBase;
use App\Filament\Resources\MenuLink\MenuLinkResource;
use App\Traits\HasParentResource;
use Filament\Actions;

class Edit extends EditBase
{
    use HasParentResource;

    protected static string $resource = MenuLinkResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('menu-link.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('menu-link.index', [
                'parent' => $this->parent,
            ]));
    }


}
