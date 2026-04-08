<?php

namespace App\Filament\Resources\User\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\ListBase;
use App\Filament\Resources\User\UserResource;

class ListItems extends ListBase
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return
        [
            'all' => \Filament\Resources\Components\Tab::make('All')
                ->icon('fas-globe')
                ->badge($this->getModel()::query()->count()),

            'active' => \Filament\Resources\Components\Tab::make('Active')
                ->icon('fas-toggle-on')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', $this->getModel()::STATUS_ACTIVE))
                ->badge($this->getModel()::query()->where('status', $this->getModel()::STATUS_ACTIVE)->count())
                ->badgeColor('success'),

            'inactive' => \Filament\Resources\Components\Tab::make('Inactive')
                ->icon('fas-toggle-off')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', $this->getModel()::STATUS_INACTIVE))
                ->badge($this->getModel()::query()->where('status', $this->getModel()::STATUS_INACTIVE)->count())
                ->badgeColor('warning'),

            'banned' => \Filament\Resources\Components\Tab::make('Banned')
                ->icon('fas-ban')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', $this->getModel()::STATUS_BANNED))
                ->badge($this->getModel()::query()->where('status', $this->getModel()::STATUS_BANNED)->count())
                ->badgeColor('danger'),
        ];
    }
}
