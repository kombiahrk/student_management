<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use Filament\Actions;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\PermissionResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ExportAction::make()->exports([
            //     ExcelExport::make()->askForFilename()->fromTable()
            // ]),
        ];
    }
}
