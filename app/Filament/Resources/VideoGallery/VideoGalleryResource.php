<?php

namespace App\Filament\Resources\VideoGallery;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Filament\Resources\VideoGallery\Exports\Exporter;
use App\Filament\Resources\VideoGallery\Imports\Importer;
use App\Filament\Resources\VideoGallery\Model\VideoGallery;
use App\Filament\Resources\VideoGallery\ResourcePages\Create;
use App\Filament\Resources\VideoGallery\ResourcePages\Edit;
use App\Filament\Resources\VideoGallery\ResourcePages\ListItems;
use App\Filament\Resources\VideoGalleryResource\Pages;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use App\Traits\CommonActionButtons;

use App\Traits\AllColumnActionVisibility;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class VideoGalleryResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = VideoGallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';


    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function canAccess(): bool
    {
        return false;
    }


    protected static ?int $navigationSort = 2;


    public static function getNavigationLabel(): string
    {
        return __("VideoGallery");
    }

    public static function getModelLabel(): string
    {
        return __("VideoGallery");
    }

    public static function getPluralLabel(): ?string
    {
        return __("VideoGallery");
    }

    public static function getPluralModelLabel(): string
    {
        return __("VideoGallery");
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
                ->localeTabSchema(fn(TranslatableTab $tab) => [

                    Grid::make(3)->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([

                                Forms\Components\TextInput::make($tab->makeName('title'))
                                    ->label(__("Title[" . $tab->getLocale() . "]"))
                                    ->required()
                                    ->maxLength(255)
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),

                                Forms\Components\TextInput::make($tab->makeName('url'))
                                    ->label(__("URL[" . $tab->getLocale() . "]"))
                                    ->required()
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
                                    ->readOnly()
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),
                                TinyEditor::make($tab->makeName('description'))
                                    ->label(__("Description[" . $tab->getLocale() . "]"))
                                    ->showMenuBar()
                                    ->toolbarSticky(true)
                                    ->profile('with-bootstrap'),

                                CustomCuratorPicker::make(__("cover_image_id"))
                                    ->label(__("Cover Image"))
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->color('primary')
                                    ->outlined(true)
                                    ->size('md')
                                    ->constrained(true)
                                    ->listDisplay(false)
                                    ->orderColumn('order')
                                    ->multiple(false),



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
                                    ->options(self::$model::getStatusList())
                                    ->default(self::$model::STATUS_PUBLISHED)
                                    ->native(false)
                                    ->selectablePlaceholder(false)
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

                                \Filament\Forms\Components\Select::make('category_id')
                                    ->label(__("Category"))
                                    ->required()
                                    ->options(VideoGallery::getVideoCategoryList())
                                    ->native(false)
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
                CuratorColumn::make("cover_image_id")->label('Image'),

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
                    ),

                // Tables\Columns\TextColumn::make('title:ar')
                //     ->label(__("title Ar"))
                //     ->searchable(
                //         isIndividual: false,
                //         query: function (Builder $query, string $search): Builder {
                //             return $query
                //                 ->whereHas("translations", function ($query) use ($search) {
                //                     $query->where('title', 'like', "%{$search}%")
                //                         ->where("language", "ar");
                //                 });
                //         }
                //     ),


                Tables\Columns\SelectColumn::make('category_id')
                    ->label(__("Category"))
                    ->options(VideoGallery::getVideoCategoryList())
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
                static::renderFilterActions(),
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
