<?php

namespace App\Traits;

use App\Filament\Jobs\CustomImportCsv;
use App\Models\User;
use App\Traits\AllColumnActionVisibility;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

trait CommonActionButtons
{

    public static function renderFilterActions($customActions = [])
    {
        $defaultActions =
        [
            Tables\Filters\TrashedFilter::make(),

            Tables\Filters\SelectFilter::make('created_by')
            ->options(User::getAllList()),

            Tables\Filters\SelectFilter::make('updated_by')
                ->options(User::getAllList()),
        ];

        return array_merge($customActions, $defaultActions);
    }


    public static function renderTableActions($customActions = [])
    {
        $defaultActions =
        [
            Tables\Actions\EditAction::make()->iconButton(),
            Tables\Actions\DeleteAction::make()->iconButton(),
            Tables\Actions\ForceDeleteAction::make(),
            Tables\Actions\RestoreAction::make(),
        ];

        return array_merge($customActions, $defaultActions);
    }



    public static function renderHeaderActions($importer, $exporter, $customActions = [])
    {
        $defaultActions =
        [
            Tables\Actions\ImportAction::make()
                ->importer($importer)
                ->job(CustomImportCsv::class)
                ->options([
                    'updateExisting' => true,
                ])
                ->chunkSize(500)
                ->color("warning")
                ->icon("heroicon-s-document-arrow-up")
                ->iconButton()
                ->size(ActionSize::Large)
                ->visible( static::importActionVisibility() ),

            Tables\Actions\ExportAction::make()
                ->exporter($exporter)
                ->chunkSize(500)
                ->color("success")
                ->icon("heroicon-o-inbox-arrow-down")
                ->iconButton()
                ->size(ActionSize::Large)
                ->visible( static::exportActionVisibility() ),
        ];

        return array_merge($customActions, $defaultActions);
    }

    public static function renderBulkActions($exporter, $customActions = [])
    {

        $defaultActions =
        [

            Tables\Actions\BulkAction::make('publish')
                ->action(fn (Collection $records) => static::BulkActivate($records))
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation()
                ->color('success')
                ->icon('fas-toggle-on')
                ->visible( static::toggleColumnVisibility() ),

            Tables\Actions\BulkAction::make('pending')
                ->action(fn (Collection $records) => static::BulkDeactivate($records))
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation()
                ->color('warning')
                ->icon('fas-toggle-off')
                ->visible( static::toggleColumnVisibility() ),

            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\ForceDeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),

            Tables\Actions\ExportBulkAction::make()
                ->exporter($exporter)
                ->color("success")
                ->icon("heroicon-o-inbox-arrow-down")
                ->label("Export Spacific Columns")
                ->chunkSize(500)
                ->visible( static::exportActionVisibility() ),
        ];

        return array_merge($customActions, $defaultActions);

    }


    public static function BulkActivate($records)
    {
        if (count(($records)) )
        {
            $model = get_class($records[0]);
            $ids = $records->pluck('id');
            $model::whereIn("id",$ids)->update(["status"=>true]);
        }


    }

    public static function BulkDeactivate($records)
    {
        if (count(($records)) )
        {
            $model = get_class($records[0]);
            $ids = $records->pluck('id');
            $model::whereIn("id",$ids)->update(["status"=>false]);
        }
    }


}

