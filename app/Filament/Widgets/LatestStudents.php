<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Student;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStudents extends BaseWidget
{

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->defaultSort('created_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('course.name')
            ]);
    }
}
