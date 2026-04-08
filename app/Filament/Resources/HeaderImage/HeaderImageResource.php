<?php

namespace App\Filament\Resources\HeaderImage;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Filament\Resources\HeaderImage\Model\HeaderImage;
use App\Filament\Resources\HeaderImage\ResourcePages\Create;
use App\Filament\Resources\HeaderImage\ResourcePages\Edit;
use App\Filament\Resources\HeaderImage\ResourcePages\ListItems;
use App\Filament\Resources\HeaderImageResource\Pages;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;

use App\Traits\AllColumnActionVisibility;


use App\Traits\CommonActionButtons;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class HeaderImageResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = HeaderImage::class;

    protected static ?string $navigationIcon = 'heroicon-s-photo';

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __("HeaderImage");
    }

    public static function getModelLabel(): string
    {
        return __("HeaderImage");
    }

    public static function getPluralLabel(): ?string
    {
        return __("HeaderImage");
    }

    public static function getPluralModelLabel(): string
    {
        return __("HeaderImage");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Default Enginees");
    }





    public static function form(Form $form): Form
    {

        return $form->schema([

            TranslatableTabsNoArabic::make()
                ->columnSpanFull()
                ->localeTabSchema(fn(TranslatableTab $tab) => [

                    Grid::make(3)->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([

                                Forms\Components\TextInput::make($tab->makeName('title'))
                                    ->label(__("Title[" . $tab->getLocale() . "]"))
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                Textarea::make($tab->makeName('header_image_brief'))
                                    ->label(__("Header Image Brief[" . $tab->getLocale() . "]"))
                                    // ->maxLength(255)
                                    ->rows(3)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),




                                Forms\Components\TextInput::make('path')
                                    ->label(__("path"))
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                CustomCuratorPicker::make($tab->makeName("image_id"))
                                    ->label(__("Main Image[" . $tab->getLocale() . "]"))
                                    // ->required()
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->color('primary')
                                    ->outlined(true)
                                    ->size('md')
                                    ->constrained(false)
                                    ->orderColumn('order'),

                                // CustomCuratorPicker::make($tab->makeName("mobile_image_id"))
                                //     ->label(__("Mobile Image[" . $tab->getLocale() . "]"))
                                //     // ->required()
                                //     ->pathGenerator(DatePathGenerator::class)
                                //     ->size(40)
                                //     ->color('primary')
                                //     ->outlined(true)
                                //     ->size('md')
                                //     ->constrained(false)
                                //     ->orderColumn('order'),



                            ]),


                        Section::make()
                            ->columnSpan(1)
                            ->schema([

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->rules(['date_format:Y-m-d', 'regex:/^\d{4}-\d{2}-\d{2}$/'])
                                    ->default(Carbon::now())
                                    ->required()
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),

                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->required()
                                    ->options(HeaderImage::getStatusList())
                                    ->default(HeaderImage::STATUS_PUBLISHED)
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                            ]),

                    ])
                ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                CuratorColumn::make("image_id")->size(40)->ring(true),

                Tables\Columns\TextColumn::make('path')
                    ->label(__("path"))
                    ->searchable()
                    ->words('5')
                    ->html(),


                \App\Classes\FilamentUtility::publishedAtColumn(),

                \App\Classes\FilamentUtility::statusColumn(static::$model),
                \App\Classes\FilamentUtility::createdAtColumn(),
                \App\Classes\FilamentUtility::updatedAtColumn(),

                \App\Classes\FilamentUtility::creatorColumn(),
                \App\Classes\FilamentUtility::updaterColumn(),




            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('weight_order', 'asc')
                    ->orderBy('published_at', 'desc');
            })
            ->striped()

            ->filters(
                static::renderFilterActions(),
            )

            ->actions(
                static::renderTableActions(),
            )
            ->headerActions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->action(fn (Collection $records) => static::BulkActivate($records))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('fas-toggle-on')
                        ->visible(static::toggleColumnVisibility()),
                    Tables\Actions\BulkAction::make('pending')
                        ->action(fn (Collection $records) => static::BulkDeactivate($records))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->color('warning')
                        ->icon('fas-toggle-off')
                        ->visible(static::toggleColumnVisibility()),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
