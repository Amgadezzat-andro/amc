<?php

namespace App\Filament\Resources\BaseResource\Pages;

use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBase extends ListRecords
{
    use ListTranslatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return
        [
            'all' => \Filament\Resources\Components\Tab::make('All')
                ->icon('fas-globe')
                ->badge($this->getModel()::query()->count()),

            'active' => \Filament\Resources\Components\Tab::make('Published')
                ->icon('fas-toggle-on')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', $this->getModel()::STATUS_PUBLISHED))
                ->badge($this->getModel()::query()->where('status', $this->getModel()::STATUS_PUBLISHED)->count())
                ->badgeColor('success'),

            'inactive' => \Filament\Resources\Components\Tab::make('Pending')
                ->icon('fas-toggle-off')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', $this->getModel()::STATUS_PENDING))
                ->badge($this->getModel()::query()->where('status', $this->getModel()::STATUS_PENDING)->count())
                ->badgeColor('danger'),
        ];
    }

}
