<?php

namespace App\Filament\Resources\MessageCategory;

use App\Filament\Resources\MessageCategory\Exports\MessageCategoryExporter;
use App\Filament\Resources\MessageCategory\Imports\MessageCategoryImporter;
use App\Filament\Resources\MessageCategory\Model\MessageCategory;
use App\Filament\Resources\MessageCategory\RelationManagers\MessagesRelationManager;
use App\Filament\Resources\MessageCategory\ResourcePages\Edit;
use App\Filament\Resources\MessageCategory\ResourcePages\ListItems;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;

class MessageCategoryResource extends Resource
{
    use AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $slug = 'message-translation';

    protected static ?string $model = MessageCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';


    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __("admin.Messag Translation");
    }

    public static function getModelLabel(): string
    {
        return __("admin.Messag Category");
    }

    public static function getPluralLabel(): ?string
    {
        return __("admin.Messag Categories");
    }

    public static function getPluralModelLabel(): string
    {
        return __("admin.Messag Categories");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Setting");
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
                ->schema([

                    Grid::make(3)->schema([

                        Section::make()
                        ->columnSpan(2)
                        ->schema([

                                Forms\Components\TextInput::make('title')
                                    ->label(__("Title"))
                                    ->autofocus()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->notRegex('/<[^b][^r][^>]*>/')
                                    ->validationMessages([
                                        'not_regex' => 'HTML is invalid',
                                    ]),
                        ]),



                        Section::make()
                        ->columnSpan(1)
                        ->schema([

                            Forms\Components\Select::make('status')
                                ->label(__("Status"))
                                ->required()
                                ->options(MessageCategory::getStatusList())
                                ->default(MessageCategory::STATUS_PUBLISHED)
                                ->native(false)
                                ->selectablePlaceholder(false)
                                ->notRegex('/<[^b][^r][^>]*>/')
                                ->validationMessages([
                                    'not_regex' => 'HTML is invalid',
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
            ->label(__("title"))
            ->searchable(),


            \App\Classes\FilamentUtility::statusColumn(static::$model),
            \App\Classes\FilamentUtility::createdAtColumn(),
            \App\Classes\FilamentUtility::updatedAtColumn(),

            \App\Classes\FilamentUtility::creatorColumn(),
            \App\Classes\FilamentUtility::updaterColumn(),

        ])
        ->defaultSort('id', 'desc')
        ->striped()

        ->filters(
            static::renderFilterActions(),
        )
        ->actions(
            static::renderTableActions(),
        )
        ->headerActions(

            static::renderHeaderActions(MessageCategoryImporter::class, MessageCategoryExporter::class),

        )
        ->bulkActions(
            [
                Tables\Actions\BulkActionGroup::make(
                    static::renderBulkActions(MessageCategoryExporter::class)

                ),
            ]
        );
    }

    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            // 'create' => Pages\CreateMessageCategory::route('/create'),
            'edit' => Edit::route('/{record}/edit'),
        ];
    }
}
