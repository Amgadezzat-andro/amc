<?php

namespace App\Filament\Resources\InternshipApplication;

use App\Filament\Resources\InternshipApplication\ResourcePages\ListItems;
use App\Models\InternshipApplication;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternshipApplicationResource extends Resource
{
    protected static ?string $model = InternshipApplication::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Internship Applications');
    }

    public static function getModelLabel(): string
    {
        return __('Internship Application');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Internship Applications');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Internship Applications');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('WebForms');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('surname')
                    ->label(__('Surname'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('level_of_studies')
                    ->label(__('Level of Studies'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('university')
                    ->label(__('University'))
                    ->limit(40)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('message')
                    ->label(__('Message'))
                    ->limit(60)
                    ->toggleable(),
                \App\Classes\FilamentUtility::createdAtColumn(),
            ])
            ->defaultSort('id', 'desc')
            ->striped()
            ->actions([
                Tables\Actions\Action::make('viewMessage')
                    ->label(__('View'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading(__('Application Details'))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('Close'))
                    ->modalContent(fn (InternshipApplication $record) => view('filament.internship-application.view-submission', ['record' => $record])),

                Tables\Actions\Action::make('cv')
                    ->label(__('CV'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (InternshipApplication $record) => $record->cv ? asset('storage/' . $record->cv) : null, shouldOpenInNewTab: true)
                    ->visible(fn (InternshipApplication $record) => !empty($record->cv)),

                Tables\Actions\Action::make('coverLetter')
                    ->label(__('Cover Letter'))
                    ->icon('heroicon-o-document-text')
                    ->url(fn (InternshipApplication $record) => $record->cover_letter ? asset('storage/' . $record->cover_letter) : null, shouldOpenInNewTab: true)
                    ->visible(fn (InternshipApplication $record) => !empty($record->cover_letter)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
        ];
    }
}
