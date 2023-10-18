<?php

namespace App\Filament\Resources\ActivitylogResource\Pages;

use App\Filament\Resources\ActivitylogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewActivitylogs extends ViewRecord
{
    public static function getResource(): string
    {
        return ActivitylogResource::class;
    }
}

