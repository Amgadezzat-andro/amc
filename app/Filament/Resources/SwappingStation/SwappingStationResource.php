<?php

namespace App\Filament\Resources\SwappingStation;

use App\Classes\FilamentUtility;
use App\Filament\Resources\SwappingStation\Model\SwappingStation;
use App\Filament\Resources\SwappingStation\ResourcePages\Create;
use App\Filament\Resources\SwappingStation\ResourcePages\Edit;
use App\Filament\Resources\SwappingStation\ResourcePages\ListItems;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SwappingStationResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = SwappingStation::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Swapping Stations');
    }

    public static function getModelLabel(): string
    {
        return __('Swapping Station');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Swapping Stations');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Media Center');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableTabsNoArabic::make()
                ->columnSpan(2)
                ->localeTabSchema(fn (TranslatableTab $tab) => [
                    Grid::make(3)->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\TextInput::make($tab->makeName('name'))
                                    ->label(__('Name') . ' [' . $tab->getLocale() . ']')
                                    ->required($tab->getLocale() === 'en')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make($tab->makeName('address'))
                                    ->label(__('Address') . ' [' . $tab->getLocale() . ']')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make($tab->makeName('hours'))
                                    ->label(__('Hours') . ' [' . $tab->getLocale() . ']')
                                    ->maxLength(255)
                                    ->placeholder('Mon-Sat: 7:00 AM - 9:00 PM'),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('lat')
                                    ->label(__('Latitude'))
                                    ->numeric()
                                    ->step(0.0000001)
                                    ->required(),
                                Forms\Components\TextInput::make('lng')
                                    ->label(__('Longitude'))
                                    ->numeric()
                                    ->step(0.0000001)
                                    ->required(),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('Published At'))
                                    ->default(Carbon::now()),
                                Forms\Components\Select::make('status')
                                    ->label(__('Status'))
                                    ->required()
                                    ->options(self::$model::getStatusList())
                                    ->default(self::$model::STATUS_PUBLISHED)
                                    ->native(false),
                                Forms\Components\TextInput::make('weight_order')
                                    ->label(__('Weight Order'))
                                    ->integer()
                                    ->default(10)
                                    ->required(),
                            ]),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('translations', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                    }),
                Tables\Columns\TextColumn::make('address')->label(__('Address'))->limit(30),
                Tables\Columns\TextColumn::make('lat')->label(__('Lat')),
                Tables\Columns\TextColumn::make('lng')->label(__('Lng')),
                FilamentUtility::statusColumn(static::$model),
                FilamentUtility::createdAtColumn(),
            ])
            ->defaultSort('weight_order')
            ->striped()
            ->filters([])
            ->actions(static::renderTableActions())
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            'create' => Create::route('/create'),
            'edit' => Edit::route('/{record}/edit'),
        ];
    }
}
