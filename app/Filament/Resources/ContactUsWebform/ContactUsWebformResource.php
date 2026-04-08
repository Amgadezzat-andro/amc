<?php

namespace App\Filament\Resources\ContactUsWebform;

use App\Filament\Resources\ContactUsWebformResource\Pages;

use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\ContactUsWebformExporter;
use App\Filament\Resources\ContactUsWebform\Exports\Exporter;
use App\Filament\Resources\ContactUsWebform\Model\ContactUsWebform;
use App\Filament\Resources\ContactUsWebform\ResourcePages\ListItems;
use Filament\Tables;
use Filament\Tables\Table;


class ContactUsWebformResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = ContactUsWebform::class;

    protected static ?string $navigationIcon = 'heroicon-s-phone';

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Contact Us Webform");
    }

    public static function getModelLabel(): string
    {
        return __("Contact Us Webform");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Contact Us Webform");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Contact Us Webform");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("WebForms");
    }





    public static function form(Form $form): Form
    {

        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([





                Tables\Columns\TextColumn::make('first_name')
                    ->label(__("First Name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__("Last Name"))
                    ->searchable(),


                Tables\Columns\TextColumn::make('email')
                    ->label(__("email"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__("phone"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('company')
                    ->label(__("Company"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('position')
                    ->label(__("Position"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label(__("Location"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('message')
                    ->label(__("message"))
                    ->searchable(),


                \App\Classes\FilamentUtility::createdAtColumn(),



            ])
            ->defaultSort('id', 'desc')
            ->striped()
            ->filters([])

            ->actions([

            ])
            ->headerActions([

                ExportAction::make()
                    ->exporter(Exporter::class)
                    ->chunkSize(500)
                    ->color("success")
                    ->icon("heroicon-o-inbox-arrow-down")
                    ->iconButton()
                    ->size(ActionSize::Large),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    ExportBulkAction::make()
                        ->exporter(Exporter::class)
                        ->color("success")
                        ->icon("heroicon-o-inbox-arrow-down")
                        ->label("Export Spacific Columns")
                        ->chunkSize(500),
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
        ];
    }
}
