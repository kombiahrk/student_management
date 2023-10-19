<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_joining','>=', now()->subYear()))
                ->badge(Student::query()->where('date_of_joining','>=', now()->subYear())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_joining','>=', now()->subMonth()))
                ->badge(Student::query()->where('date_of_joining','>=', now()->subMonth())->count()),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_joining','>=', now()->subWeek()))
                ->badge(Student::query()->where('date_of_joining','>=', now()->subWeek())->count()),
        ];
    }
}
