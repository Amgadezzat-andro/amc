<?php

namespace App\Filament\Resources\Job;

use App\Filament\Resources\Job\ResourcePages\Create;
use App\Filament\Resources\Job\ResourcePages\Edit;
use App\Filament\Resources\Job\ResourcePages\ListItems;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-s-briefcase';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Jobs');
    }

    public static function getModelLabel(): string
    {
        return __('Job');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Jobs');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Jobs');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Careers');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label(__('Title'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('location')
                ->label(__('Location'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('department')
                ->label(__('Department'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('experience_level')
                ->label(__('Experience Level'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('employment_type')
                ->label(__('Employment Type'))
                ->required()
                ->maxLength(255),

            Forms\Components\DatePicker::make('posted_at')
                ->label(__('Posted Date'))
                ->required()
                ->default(now()),

            Forms\Components\Select::make('status')
                ->label(__('Status'))
                ->required()
                ->options(Job::getStatusList())
                ->default(Job::STATUS_PUBLISHED)
                ->native(false),

            Forms\Components\TextInput::make('sort_order')
                ->label(__('Sort Order'))
                ->numeric()
                ->required()
                ->default(0)
                ->minValue(0),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->defaultSort('posted_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label(__('Location'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('department')
                    ->label(__('Department'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('experience_level')
                    ->label(__('Experience Level'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('employment_type')
                    ->label(__('Employment Type'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('posted_at')
                    ->label(__('Posted Date'))
                    ->date('d-M-Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Sort Order'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->formatStateUsing(fn ($state) => Job::getStatusList()[$state] ?? '-')
                    ->badge()
                    ->color(fn ($state) => ((int) $state === Job::STATUS_PUBLISHED) ? 'success' : 'danger'),

                \App\Classes\FilamentUtility::createdAtColumn(),
            ])
            ->striped()
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(Job::getStatusList()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'create' => Create::route('/create'),
            'edit' => Edit::route('/{record}/edit'),
        ];
    }
}
