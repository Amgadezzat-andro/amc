<?php

namespace App\Filament\Resources\MessageCategory;

use App\Filament\Resources\MessageCategory\Model\Message;
use App\Traits\CommonActionButtons;
use App\Filament\Forms\Components\TranslatableTabsNoArabic;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MessageTranslationResource extends Resource
{
    use ResourceTranslatable, CommonActionButtons;

    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static bool $shouldRegisterNavigation = false;


    public static function getModelLabel(): string
    {
        return __("admin.Messag Translation");
    }

    public static function getPluralLabel(): ?string
    {
        return __("admin.Messag Translations");
    }

    public static function getPluralModelLabel(): string
    {
        return __("admin.Messag Translations");
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

                        Forms\Components\TextInput::make('message')
                            ->label(__("Message"))
                            ->autofocus()
                            ->required()
                            ->maxLength(500)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make($tab->makeName('translation'))
                            ->label(__("Translation[". $tab->getLocale()."]"))
                            ->autofocus()
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),

                    ]),

                    Section::make()
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


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])

            ->filters(
                static::renderFilterActions(),
            )
            ->actions([
                //Tables\Actions\EditAction::make(),
                //DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            //'index' => Pages\ListMessageTranslations::route('/{category_id}/translations'),
            //'create' => Pages\CreateMessageTranslation::route('/create'),
            //'edit' => Pages\EditMessageTranslation::route('/{record}/edit'),

        ];
    }
}
