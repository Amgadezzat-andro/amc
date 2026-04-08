<?php

namespace App\Filament\Resources\QuoteWebform;

use App\Filament\Resources\QuoteWebform\Exports\Exporter;
use App\Filament\Resources\QuoteWebform\Model\QuoteWebform;
use App\Filament\Resources\QuoteWebform\ResourcePages\ListItems;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class QuoteWebformResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = QuoteWebform::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Quote Webform');
    }

    public static function getModelLabel(): string
    {
        return __('Quote Webform');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Quote Webform');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Quote Webform');
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
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('Full Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('site_location')
                    ->label(__('Site Location'))
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('power_source')
                    ->label(__('Power Source'))
                    ->badge(),
                Tables\Columns\TextColumn::make('project_type')
                    ->label(__('Project Type'))
                    ->badge(),
                \App\Classes\FilamentUtility::createdAtColumn(),
            ])
            ->defaultSort('id', 'desc')
            ->striped()
            ->filters([
                Tables\Filters\SelectFilter::make('project_type')
                    ->options([
                        'residential' => __('Residential'),
                        'commercial' => __('Commercial'),
                        'agricultural' => __('Agricultural'),
                        'utility' => __('Utility'),
                    ]),
                Tables\Filters\SelectFilter::make('power_source')
                    ->options([
                        'grid' => __('Grid'),
                        'generator' => __('Generator'),
                        'solar' => __('Solar'),
                        'hybrid' => __('Hybrid'),
                        'other' => __('Other'),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('viewSubmission')
                    ->label(__('View'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalWidth('7xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('Close'))
                    ->modalContent(fn ($record) => view('filament.quote-webform.view-submission', ['record' => $record])),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(Exporter::class)
                    ->chunkSize(500)
                    ->color('success')
                    ->icon('heroicon-o-inbox-arrow-down')
                    ->iconButton()
                    ->size(ActionSize::Large),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(Exporter::class)
                        ->color('success')
                        ->icon('heroicon-o-inbox-arrow-down')
                        ->label('Export Spacific Columns')
                        ->chunkSize(500),
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
