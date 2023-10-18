<?php

namespace App\Filament\Resources\ActivitylogResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rmsramos\Activitylog\ActivitylogPlugin;
use App\Filament\Resources\ActivitylogResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Auth;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'description';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        // dd(Auth::user()->canViewActivityLogs());
        return auth()->user()->canViewActivityLogs();
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? (string) str(ActivitylogPlugin::get()->getPluralLabel())
            ->kebab()
            ->replace('-', ' ')
            ->headline();
    }

    public function form(Form $form): Form
    {
        return ActivitylogResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ActivitylogResource::table(
            $table
                ->heading(ActivitylogPlugin::get()->getPluralLabel())
                ->actions([
                    ViewAction::make(),
                ])
        );
    }
}
