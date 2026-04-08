<?php

namespace App\Filament\Resources\ConsultationWebform;

use App\Filament\Resources\ConsultationWebform\Model\ConsultationWebform;
use App\Filament\Resources\ConsultationWebform\ResourcePages\ListItems;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultationWebformResource extends Resource
{
    protected static ?string $model = ConsultationWebform::class;

    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-left-right';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Consultation Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Consultation Request');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Consultation Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Consultation Requests');
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
                Tables\Columns\TextColumn::make('first_name')->label(__('First Name'))->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label(__('Last Name'))->searchable(),
                Tables\Columns\TextColumn::make('company')->label(__('Company'))->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('position')->label(__('Position'))->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__('Email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('Phone'))->searchable(),
                Tables\Columns\TextColumn::make('location')->label(__('Location'))->searchable(),
                Tables\Columns\TextColumn::make('message')->label(__('Message'))->limit(60)->toggleable(),
                \App\Classes\FilamentUtility::createdAtColumn(),
            ])
            ->defaultSort('id', 'desc')
            ->striped()
            ->actions([
                Tables\Actions\Action::make('viewMessage')
                    ->label(__('View'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading(__('Consultation Details'))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('Close'))
                    ->modalContent(fn (ConsultationWebform $record) => view('filament.consultation-webform.view-submission', ['record' => $record])),
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
