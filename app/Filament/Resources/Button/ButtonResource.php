<?php

namespace App\Filament\Resources\Button;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Classes\CustomPackage\CustomComponent\CustomIconPicker;
use App\Classes\FilamentUtility;
use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\Button\ResourcePages;
use App\Filament\Resources\DropdownList\DropdownListResource;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use Filament\Forms\Components\TextInput;

class ButtonResource extends Resource
{

    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = Button::class;

    protected static ?string $navigationIcon = 'heroicon-s-cursor-arrow-rays';

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __("BUTTONS");
    }

    public static function getModelLabel(): string
    {
        return __("BUTTONS");
    }

    public static function getPluralLabel(): ?string
    {
        return __("BUTTONS");
    }

    public static function getPluralModelLabel(): string
    {
        return __("BUTTONS");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Default Enginees");
    }





    public static function form(Form $form): Form
    {

        return $form->schema([

            TranslatableTabsNoArabic::make()
                ->columnSpan(2)
                ->localeTabSchema(fn(TranslatableTab $tab) => [

                    Grid::make(3)->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([

                                Forms\Components\TextInput::make($tab->makeName('url'))
                                    ->label(__("Url[" . $tab->getLocale() . "]"))
                                    ->maxLength(510)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                Forms\Components\TextInput::make($tab->makeName('label'))
                                    ->label(__("Label[" . $tab->getLocale() . "]"))
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                            ]),

                        Section::make()
                            ->columnSpan(1)
                            ->schema([


                                CustomIconPicker::make('icon'),

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
                                    ->options(Bms::getStatusList())
                                    ->default(Bms::STATUS_PUBLISHED)
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                \Filament\Forms\Components\Select::make('category_slug')
                                    ->label(__("Category"))
                                    ->required()
                                    ->relationship('category', 'title', fn(Builder $query) => $query->where('category', DropdownList::BUTTON_CATEGORY))
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->title}")
                                    ->native(false)
                                    ->createOptionModalHeading('Create')
                                    ->createOptionForm(fn(Form $form) => DropdownListResource::formPopup($form, DropdownList::BUTTON_CATEGORY))
                                    ->createOptionUsing(function (array $data) {

                                        $optionRecord = DropdownList::create($data);

                                        return $optionRecord->slug;

                                    })
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                Forms\Components\TextInput::make('weight_order')
                                    ->label(__("Weight Order"))
                                    ->required()
                                    ->integer()
                                    ->default(10)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                            ]),

                    ])
                ])

        ]);
    }


    public static function formPopup(Form $form, $categorySlug): Form
    {

        return $form->schema([

            TranslatableTabsNoArabic::make()
                ->columnSpan(2)
                ->localeTabSchema(fn(TranslatableTab $tab) => [

                    Grid::make(3)->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([

                                Forms\Components\TextInput::make($tab->makeName('url'))
                                    ->label(__("Url[" . $tab->getLocale() . "]"))
                                    ->required()
                                    ->maxLength(510)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                Forms\Components\TextInput::make($tab->makeName('label'))
                                    ->label(__("Label[" . $tab->getLocale() . "]"))
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                            ]),

                        Section::make()
                            ->columnSpan(1)
                            ->schema([


                                CustomIconPicker::make('icon'),

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
                                    ->options(Bms::getStatusList())
                                    ->default(Bms::STATUS_PUBLISHED)
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                TextInput::make('category_slug')
                                    ->label(__("Category"))
                                    ->readOnly()
                                    ->required()
                                    ->default($categorySlug),


                                TextInput::make('weight_order')
                                    ->label(__("Weight Order"))
                                    ->required()
                                    ->integer()
                                    ->default(10)
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



                CuratorColumn::make("image_id")
                    ->label('image'),



                Tables\Columns\TextColumn::make('url')
                    ->label(__("Url"))
                    ->searchable(
                        isIndividual: false,
                        query: function (Builder $query, string $search): Builder {
                            return $query
                                ->whereHas("translations", function ($query) use ($search) {
                                    $query->where('url', 'like', "%{$search}%")
                                        ->where("language", "en");
                                });
                        }
                    )->words('5')->html(),


                Tables\Columns\TextColumn::make('label')
                    ->label(__("Label"))
                    ->searchable(
                        isIndividual: false,
                        query: function (Builder $query, string $search): Builder {
                            return $query
                                ->whereHas("translations", function ($query) use ($search) {
                                    $query->where('label', 'like', "%{$search}%")
                                        ->where("language", "en");
                                });
                        }
                    )->words('5')->html(),



                \App\Classes\FilamentUtility::publishedAtColumn(),


                Tables\Columns\SelectColumn::make('category_slug')
                    ->label(__("Category"))
                    ->options(Button::getButtonCategoryList())
                    ->alignCenter()
                    ->selectablePlaceholder(false)
                    ->visible(static::selectColumnVisibility()),


                \App\Classes\FilamentUtility::statusColumn(static::$model),
                \App\Classes\FilamentUtility::createdAtColumn(),
                \App\Classes\FilamentUtility::updatedAtColumn(),

                \App\Classes\FilamentUtility::creatorColumn(),
                \App\Classes\FilamentUtility::updaterColumn(),



            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->whereIn("category_slug", array_keys(Button::getButtonCategoryList()->toArray()))
                    // ->withoutUnReviewed()
                    ->orderBy('weight_order', 'asc')
                    ->orderBy('published_at', 'desc');
            })
            ->striped()
            ->reorderable('weight_order')

            ->filters(

                static::renderFilterActions([
                    Tables\Filters\SelectFilter::make('category_slug')
                        ->options(Button::getButtonCategoryList()),
                ]),
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
            'index' => ResourcePages\ListItems::route('/'),
            'create' => ResourcePages\Create::route('/create'),
            'edit' => ResourcePages\Edit::route('/{record}/edit'),
        ];
    }

}
