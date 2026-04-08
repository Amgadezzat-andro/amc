<?php

namespace App\Filament\Resources\Page;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Classes\FilamentUtility;
use App\Filament\Resources\Bms\BmsResource;
use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Button\ButtonResource;
use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\Page\Exports\Exporter;
use App\Filament\Resources\Page\Imports\Importer;
use App\Filament\Resources\Page\Model\Page;
use App\Filament\Resources\Page\ResourcePages\Create;
use App\Filament\Resources\Page\ResourcePages\Edit;
use App\Filament\Resources\Page\ResourcePages\ListItems;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use App\Traits\CommonActionButtons;
use App\Traits\AllColumnActionVisibility;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Eloquent\Model;

class PageResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __("Page");
    }

    public static function getModelLabel(): string
    {
        return __("Page");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Page");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Page");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Default Enginees");
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
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

                                Forms\Components\TextInput::make($tab->makeName('title'))
                                    ->label(__("Title[" . $tab->getLocale() . "]"))
                                    ->required($tab->getLocale() === 'en')
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Generated Automatically')
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                // Forms\Components\TextInput::make($tab->makeName('second_title'))
                                //     ->label(__("Second Title [" . $tab->getLocale() . "]"))
                                //     ->maxLength(255)
                                //     ->notRegex('/<[^b][^r][^>]*>/')
                                //     ->validationMessages([
                                //         'not_regex' => 'HTML is invalid',
                                //     ]),

                                Forms\Components\Textarea::make($tab->makeName('brief'))
                                    ->label(__("Brief[" . $tab->getLocale() . "]"))
                                    ->maxLength(1000)
                                    ->rows(6)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),


                                TinyEditor::make($tab->makeName('content'))
                                    ->label(__("Content[" . $tab->getLocale() . "]"))
                                    ->showMenuBar()
                                    ->toolbarSticky(true)
                                    ->profile('with-bootstrap'),


                                // Fieldset::make(__("Bmses"))
                                //     ->schema([

                                //         FilamentUtility::genericRepeater(
                                //             "Bmses",
                                //             "bmses",
                                //             [],
                                //             "weight_order",
                                //             BmsResource::class,
                                //             "formPopup",
                                //             [
                                //                 "module_id" => fn($get) => $get("id"),
                                //                 "module_class" => Page::class,
                                //                 'category' => 'PageBms'
                                //             ],
                                //         ),


                                //         FilamentUtility::genericAddButtonRepeater(
                                //             "addBms",
                                //             "Add Bms Item",
                                //             BmsResource::class,
                                //             "formPopup",
                                //             [
                                //                 "module_id" => fn($get) => $get("id"),
                                //                 "module_class" => Page::class,
                                //                 'category' => 'PageBms'
                                //             ],
                                //             Bms::class,
                                //             "bmses"
                                //         ),
                                //     ])
                                //     ->visible(fn(string $operation, $get): bool => $operation != 'create' && $get("id")),


                                Fieldset::make("Buttons")
                                    ->schema([

                                        Repeater::make("Buttons")
                                            ->relationship('buttons')
                                            ->collapsed()
                                            ->addable(false)
                                            ->schema([])
                                            ->orderColumn('weight_order')
                                            ->itemLabel(fn(array $state): ?string => $state['url'] ?? null)
                                            ->visible(fn(string $operation, $record): bool => $operation != 'create' && count($record->buttons))
                                            ->columnSpanFull()
                                            ->deleteAction(
                                                fn(Action $action) => $action->requiresConfirmation()
                                                    ->action(function (array $arguments, Repeater $component, \Livewire\Component $livewire): void {
                                                        $records = $component->getCachedExistingRecords();
                                                        $record = $records[$arguments['item']] ?? null;
                                                        if ($record) {
                                                            $record->delete();
                                                        }
                                                        $livewire->dispatch('refresh');

                                                    }),
                                            )
                                            ->extraItemActions([

                                                Action::make('edit')
                                                    ->label(__('Edit'))
                                                    ->icon('heroicon-m-pencil-square')
                                                    ->modalHeading(__('Edit Container'))
                                                    ->modalWidth('5xl')
                                                    ->form(fn(Form $form, $get) => ButtonResource::formPopup($form, $get("slug")))
                                                    ->fillForm(function (array $arguments, Repeater $component) {

                                                        $records = $component->getCachedExistingRecords();
                                                        $record = $records[$arguments['item']] ?? null;

                                                        $data = $record->toArray();

                                                        foreach ($record->getTranslationsArray() as $locale => $attributes) {
                                                            $data[$locale] = $attributes;
                                                        }

                                                        return $data;
                                                    })
                                                    ->action(function ($data, $record, array $arguments, Repeater $component, \Livewire\Component $livewire): void {
                                                        $records = $component->getCachedExistingRecords();
                                                        $record = $records[$arguments['item']] ?? null;
                                                        $record->update($data);
                                                        $livewire->refreshFormData(["Buttons"]);
                                                    }),

                                            ]),


                                        Actions::make([
                                            Action::make('addButton')
                                                ->label(__('Add Button'))
                                                ->modalHeading(__('Add Button'))
                                                ->modalWidth('5xl')
                                                ->form(fn(Form $form, $get) => ButtonResource::formPopup($form, $get('slug')))
                                                ->action(function ($data, \Livewire\Component $livewire, $record): void {
                                                    Button::create($data);
                                                    $livewire->dispatch('refresh');
                                                })
                                                ->visible(fn(array $state): bool => !empty($state["slug"])),

                                        ])
                                            ->columnSpanFull()
                                            ->alignCenter(),



                                    ])
                                    ->visible(fn(array $state): bool => !empty($state["slug"])),








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
                                    ->options(Page::getStatusList())
                                    ->default(Page::STATUS_PUBLISHED)
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),



                                Forms\Components\Select::make('view')
                                    ->label(__("Page View"))
                                    ->required()
                                    ->options(Page::getViewList())
                                    ->native(false)
                                    ->searchable()
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),

                                Forms\Components\Textarea::make($tab->makeName("video_link"))
                                    ->label(__("Video Link[" . $tab->getLocale() . "]"))
                                    ->maxLength(255)
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

                                CustomCuratorPicker::make($tab->makeName("image"))
                                    ->label(__("Main Image[" . $tab->getLocale() . "]"))
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->color('primary')
                                    ->outlined(true)
                                    ->size('md')
                                    ->constrained(true)
                                    ->listDisplay(false)
                                    ->orderColumn('order')
                                    ->multiple(false),

                                CustomCuratorPicker::make("image_header_id")
                                    ->label(__("Image Header"))
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->color('primary')
                                    ->outlined(true)
                                    ->size('md')
                                    ->constrained(true)
                                    ->listDisplay(false)
                                    ->orderColumn('order')
                                    ->multiple(false),

                                FilamentUtility::seoSection($tab, "/"),
                                // FilamentUtility::headerImageSection($tab, '/')





                            ]),

                    ])
                ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\TextColumn::make('title')
                    ->label(__("title"))
                    ->searchable(
                        isIndividual: false,
                        query: function (Builder $query, string $search): Builder {
                            return $query
                                ->whereHas("translations", function ($query) use ($search) {
                                    $query->where('title', 'like', "%{$search}%")
                                        ->where("language", "en");
                                });
                        }
                    )->words('5')->html(),


                Tables\Columns\SelectColumn::make('view')
                    ->label(__("View Page"))
                    ->options(Page::getViewList())
                    ->alignCenter()
                    ->selectablePlaceholder(false),




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
                static::renderFilterActions([
                    Tables\Filters\SelectFilter::make('view')
                        ->options(Page::getViewList()),
                ]),
            )

            ->actions(
                static::renderTableActions(),
            )
            ->headerActions(

                static::renderHeaderActions(Importer::class, Exporter::class),

            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(
                    static::renderBulkActions(Exporter::class)

                ),
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
