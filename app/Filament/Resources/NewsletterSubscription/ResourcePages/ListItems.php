<?php

namespace App\Filament\Resources\NewsletterSubscription\ResourcePages;

use App\Filament\Resources\NewsletterSubscription\NewsletterSubscriptionResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = NewsletterSubscriptionResource::class;
}
