<?php

namespace App\Filament\Resources\Product;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Classes\FilamentUtility;
use App\Filament\Resources\Product\Exports\Exporter;
use App\Filament\Resources\Product\Model\Product;
use App\Filament\Resources\Product\ResourcePages\Create;
use App\Filament\Resources\Product\ResourcePages\Edit;
use App\Filament\Resources\Product\ResourcePages\ListItems;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function getModelLabel(): string
    {
        return __('Product');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Products');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Media Center");
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
                                Forms\Components\TextInput::make($tab->makeName('title'))
                                    ->label(__('Title') . ' [' . $tab->getLocale() . ']')
                                    ->required($tab->getLocale() === 'en')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('Slug'))
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->readOnly()
                                    ->helperText(__('Generated Automatically')),
                                Textarea::make($tab->makeName('brief'))
                                    ->label(__('Brief') . ' [' . $tab->getLocale() . ']')
                                    ->rows(3),
                                    Repeater::make('specifications')
                                    ->label(__('Specifications'))
                                    ->schema([
                                        Forms\Components\TextInput::make('key')->label(__('Name'))->required(),
                                        Forms\Components\TextInput::make('value')->label(__('Value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0),
                                CustomCuratorPicker::make($tab->makeName('image_id'))
                                    ->label(__('Main Image') . ' [' . $tab->getLocale() . ']')
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->multiple(false),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('Published At'))
                                    ->default(Carbon::now())
                                    ->required(),
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
                                Forms\Components\Select::make('category_id')
                                    ->label(__('Category'))
                                    ->options(Product::getProductCategoryList())
                                    ->native(false)
                                    ->searchable(),
                                Forms\Components\Select::make('brand_id')
                                    ->label(__('Brand'))
                                    ->options(Product::getProductBrandList())
                                    ->native(false)
                                    ->searchable(),
                                // FilamentUtility::seoSection($tab, '/products/'),
                                // FilamentUtility::headerImageSection($tab, '/products/'),
                            ]),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('translations', fn ($q) => $q->where('title', 'like', "%{$search}%")->where('language', 'en'));
                    }),
                CuratorColumn::make('image_id')->label(__('Image')),
                Tables\Columns\TextColumn::make('category.title')->label(__('Category'))->sortable(),
                Tables\Columns\TextColumn::make('brand.title')->label(__('Brand'))->sortable(),
                \App\Classes\FilamentUtility::statusColumn(static::$model),
                \App\Classes\FilamentUtility::createdAtColumn(),
                \App\Classes\FilamentUtility::updatedAtColumn(),
                \App\Classes\FilamentUtility::creatorColumn(),
                \App\Classes\FilamentUtility::updaterColumn(),
            ])
            ->defaultSort('weight_order')
            ->striped()
            ->filters(static::renderFilterActions([
                Tables\Filters\SelectFilter::make('category_id')->label(__('Category'))->options(Product::getProductCategoryList()),
                Tables\Filters\SelectFilter::make('brand_id')->label(__('Brand'))->options(Product::getProductBrandList()),
            ]))
            ->actions(static::renderTableActions())
            ->bulkActions([Tables\Actions\BulkActionGroup::make(static::renderBulkActions(Exporter::class))]);
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
