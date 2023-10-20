<?php

namespace App\Filament\App\Resources\MachineResource\Pages;

use App\Filament\App\Resources\MachineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachine extends EditRecord
{
    protected static string $resource = MachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
