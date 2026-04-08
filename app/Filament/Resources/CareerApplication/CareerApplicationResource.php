<?php

namespace App\Filament\Resources\CareerApplication;

use App\Filament\Resources\CareerApplication\ResourcePages\ListItems;
use App\Models\CareerApplication;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CareerApplicationResource extends Resource
{
    protected static ?string $model = CareerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-s-briefcase';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Career Applications');
    }

    public static function getModelLabel(): string
    {
        return __('Career Application');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Career Applications');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Career Applications');
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
                Tables\Columns\TextColumn::make('position.title')
                    ->label(__('Position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label(__('Message'))
                    ->limit(60)
                    ->toggleable(),
                \App\Classes\FilamentUtility::createdAtColumn(),
            ])
            ->defaultSort('id', 'desc')
            ->striped()
            ->filters([
                Tables\Filters\SelectFilter::make('position_id')
                    ->relationship('position', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title),
            ])
            ->actions([
                Tables\Actions\Action::make('viewMessage')
                    ->label(__('View'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading(__('Application Details'))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('Close'))
                    ->modalContent(fn (CareerApplication $record) => view('filament.career-application.view-submission', ['record' => $record])),

                Tables\Actions\Action::make('cv')
                    ->label(__('CV'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (CareerApplication $record) => $record->cv ? asset('storage/' . $record->cv) : null, shouldOpenInNewTab: true)
                    ->visible(fn (CareerApplication $record) => !empty($record->cv)),

                Tables\Actions\Action::make('coverLetter')
                    ->label(__('Cover Letter'))
                    ->icon('heroicon-o-document-text')
                    ->url(fn (CareerApplication $record) => $record->cover_letter ? asset('storage/' . $record->cover_letter) : null, shouldOpenInNewTab: true)
                    ->visible(fn (CareerApplication $record) => !empty($record->cover_letter)),
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
