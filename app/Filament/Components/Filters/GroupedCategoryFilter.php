<?php

namespace App\Filament\Components\Filters;

use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Concerns\HasLabel;
use Illuminate\Database\Eloquent\Builder;

class GroupedCategoryFilter extends BaseFilter
{
    use HasLabel;

    protected string $view = 'filament.components.grouped-category-filter';

    protected array $categories = [];

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function categories(array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function apply(Builder $query, $value = null): Builder
    {
        if ($value) {
            return $query->where('category', $value);
        }

        return $query;
    }

    public function getDefaultName(): string
    {
        return 'category_group_filter';
    }
}
