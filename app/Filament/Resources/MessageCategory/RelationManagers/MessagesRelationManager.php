<?php

namespace App\Filament\Resources\MessageCategory\RelationManagers;

use App\Filament\Resources\MessageCategory\Exports\MessageExporter;
use App\Filament\Resources\MessageCategory\Imports\MessageImporter;
use App\Filament\Resources\MessageCategory\Model\Message;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use CactusGalaxy\FilamentAstrotomic\Resources\RelationManagers\Concerns\TranslatableRelationManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MessagesRelationManager extends RelationManager
{
    use TranslatableRelationManager, CommonActionButtons, AllColumnActionVisibility;

    protected static string $relationship = 'messages';

    protected static ?string $model = Message::class;

    public function form(Form $form): Form
    {
        return $form->schema([

            \App\Filament\Forms\Components\TranslatableTabsNoArabic::make()
            ->columnSpan(2)
            ->localeTabSchema(fn (\CactusGalaxy\FilamentAstrotomic\TranslatableTab $tab) => [

                \Filament\Forms\Components\Grid::make(3)->schema([
                    \Filament\Forms\Components\Section::make()
                    ->columnSpan(2)
                    ->schema([

                        Forms\Components\TextInput::make('message')
                            ->label(__("Message"))
                            ->autofocus()
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make($tab->makeName('translation_value'))
                            ->label(__("Translation Value[". $tab->getLocale()."]"))
                            ->autofocus()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),

                    ]),

                    \Filament\Forms\Components\Section::make()
                    ->columnSpan(1)
                    ->schema([

                        Forms\Components\Select::make('category_id')
                            ->label(__("Category"))
                            ->required()
                            ->relationship(name: 'category', titleAttribute: 'title')
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),

                    ])
                    ->hidden(fn (string $operation): bool => ($operation == "create") )



                ])
            ])

        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([

                Tables\Columns\TextColumn::make('message')
                ->label(__("Message"))
                ->searchable(),

                Tables\Columns\TextColumn::make('translation_value')
                ->label(__("Translation Value"))
                ->searchable(isIndividual: false,
                    query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas("translations", function($query) use($search){
                                $query->where('translation_value', 'like', "%{$search}%")
                                ->where("language","en");
                            });
                    }
                ),

                Tables\Columns\TextColumn::make('translation_value:ar')
                ->label(__("Translation Value Ar"))
                ->searchable(isIndividual: false,
                    query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas("translations", function($query) use($search){
                                $query->where('translation_value', 'like', "%{$search}%")
                                ->where("language","ar");
                            });
                    }
                ),

                Tables\Columns\SelectColumn::make('category_id')
                    ->label(__("Category"))
                    ->options(Message::getCategoryList())
                    ->alignCenter()
                    ->selectablePlaceholder(false),

            ])
            ->defaultSort("id","desc")
            ->striped()
            ->filters(
                static::renderFilterActions(),
            )
            ->headerActions(

                static::renderHeaderActions(MessageImporter::class, MessageExporter::class,
                    [
                        Tables\Actions\CreateAction::make()->createAnother(false)
                    ]
                ),
            )
            ->actions(
                static::renderTableActions(),
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(
                    static::renderBulkActions(MessageExporter::class)

                ),
            ]);
    }
}
