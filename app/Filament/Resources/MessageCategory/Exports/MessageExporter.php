<?php

namespace App\Filament\Resources\MessageCategory\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\MessageCategory\Model\Message;
use Filament\Actions\Exports\ExportColumn;

class MessageExporter extends BaseExporter
{
    protected static ?string $model = Message::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('category_id'),
            ExportColumn::make('translation_value:en'),
            ExportColumn::make('translation_value:ar'),
            ExportColumn::make('message'),


        ];
    }

}
