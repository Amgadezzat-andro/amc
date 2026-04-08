<?php

namespace App\Filament\Resources\MessageCategory\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\MessageCategory\Model\MessageCategory;

class MessageCategoryExporter extends BaseExporter
{
    protected static ?string $model = MessageCategory::class;

}
