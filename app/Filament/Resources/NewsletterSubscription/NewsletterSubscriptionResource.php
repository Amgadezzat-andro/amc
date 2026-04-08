<?php

namespace App\Filament\Resources\NewsletterSubscription;

use App\Models\NewsletterSubscription;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterSubscriptionResource extends Resource
{
    protected static ?string $model = NewsletterSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'WebForms';

    protected static ?string $navigationLabel = 'Newsletter Subscriptions';

    protected static ?string $modelLabel = 'Newsletter Subscription';

    protected static ?string $pluralModelLabel = 'Newsletter Subscriptions';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('locale')
                //     ->label(__('Locale'))
                //     ->searchable(),
                Tables\Columns\TextColumn::make('subscribed_at')
                    ->label(__('Subscribed At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('subscribed_at', 'desc')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => ResourcePages\ListItems::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
