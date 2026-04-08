<?php

namespace App\Filament\Resources\Project;

use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;
use App\Classes\FilamentUtility;
use App\Filament\Resources\Project\Exports\Exporter;
use App\Filament\Resources\Project\Model\Project;
use App\Filament\Resources\Project\ResourcePages\Create;
use App\Filament\Resources\Project\ResourcePages\Edit;
use App\Filament\Resources\Project\ResourcePages\ListItems;
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
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProjectResource extends Resource
{
    use ResourceTranslatable, AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Projects');
    }

    public static function getModelLabel(): string
    {
        return __('Project');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Projects');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Projects');
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
                                CustomCuratorPicker::make($tab->makeName('image_id'))
                                    ->label(__('Main Image') . ' [' . $tab->getLocale() . ']')
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->multiple(false),
                                TinyEditor::make($tab->makeName('content'))
                                    ->label(__('Content') . ' [' . $tab->getLocale() . ']')
                                    ->showMenuBar()
                                    ->toolbarSticky(true)
                                    ->profile('with-bootstrap'),
                                    Repeater::make('specifications')
                                    ->label(__('Specifications'))
                                    ->schema([
                                        Forms\Components\TextInput::make('key')->label(__('Name'))->required(),
                                        Forms\Components\TextInput::make('value')->label(__('Value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0),
                                Repeater::make('benefits')
                                    ->label(__('Benefits'))
                                    ->schema([
                                        Forms\Components\TextInput::make('key')->label(__('Name'))->required(),
                                        Forms\Components\TextInput::make('value')->label(__('Value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0),
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
                                CustomCuratorPicker::make('video_id')
                                    ->label(__('Video'))
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->multiple(false),
                                CustomCuratorPicker::make('gallery_image_ids')
                                    ->label(__('Photo Gallery'))
                                    ->pathGenerator(DatePathGenerator::class)
                                    ->size(40)
                                    ->multiple(true)
                                    ->orderColumn('order')
                                    ->listDisplay(true),
                                FilamentUtility::seoSection($tab, '/projects/'),
                                // FilamentUtility::headerImageSection($tab, '/projects/'),
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
                \App\Classes\FilamentUtility::statusColumn(static::$model),
                \App\Classes\FilamentUtility::createdAtColumn(),
                \App\Classes\FilamentUtility::updatedAtColumn(),
                \App\Classes\FilamentUtility::creatorColumn(),
                \App\Classes\FilamentUtility::updaterColumn(),
            ])
            ->defaultSort('weight_order')
            ->striped()
            ->filters(static::renderFilterActions([]))
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
