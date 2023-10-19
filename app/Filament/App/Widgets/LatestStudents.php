<?php

namespace App\Filament\App\Widgets;

use Filament\Tables;
use App\Models\Student;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStudents extends BaseWidget
{

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
        ->query(Student::query()->WhereBelongsTo(Filament::getTenant()))
        ->defaultSort('created_at','desc')
        ->columns([
            Tables\Columns\TextColumn::make('first_name'),
            Tables\Columns\TextColumn::make('last_name'),
            Tables\Columns\TextColumn::make('city.name'),
            Tables\Columns\TextColumn::make('course.name')
        ]);
    }
}
