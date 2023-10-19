<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Student';

    protected static string $color = 'success';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(Student::class)
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
        return 'bar';
    }
}
