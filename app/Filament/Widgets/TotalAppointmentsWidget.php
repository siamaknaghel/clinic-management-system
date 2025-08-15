<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalAppointmentsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    // public function getColumnSpan(): int|string|array
    // {
    //     return 2;
    // }

    protected function getStats(): array
    {
        $total = Appointment::count();
        $today = Appointment::where('date', today())->count();

        return [
            Stat::make('Total Appointments', $total)
                ->description('All time')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make('Today\'s Appointments', $today)
                ->description(now()->format('M d'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('success'),
        ];
    }
}
