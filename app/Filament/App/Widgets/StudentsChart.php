<?php

namespace App\Filament\App\Widgets;

use App\Models\Student;
use Flowframe\Trend\Trend;
use Filament\Facades\Filament;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Student';

    protected static string $color = 'success';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Trend::query(Student::query()->whereBelongsTo(Filament::getTenant()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Students',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
