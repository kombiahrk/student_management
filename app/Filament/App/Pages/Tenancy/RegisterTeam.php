<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Branch';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->live(debounce: '1000')
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')->hidden(),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->users()->attach(auth()->user());

        return $team;
    }
}
