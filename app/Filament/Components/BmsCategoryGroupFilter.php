<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Field;
use Illuminate\View\ComponentSlot;

class BmsCategoryGroupFilter extends Field
{
    protected string $view = 'filament.components.bms-category-group-filter';

    protected array $groups = [];

    public function groups(array $groups): static
    {
        $this->groups = $groups;
        return $this;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }
}
