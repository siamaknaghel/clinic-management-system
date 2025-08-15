<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Appointment;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;

class UpcomingAppointmentsWidget extends TableWidget
{
    protected static ?string $heading = 'Upcoming Appointments';
    protected static ?int $sort = 3;

    // public function getColumnSpan(): int|string|array
    // {
    //     return 2;
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(Appointment::where('date', '>=', today())->orderBy('date', 'asc')->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('patient.last_name')
                    ->label('Patient')
                    ->formatStateUsing(fn ($record) => "{$record->patient->first_name} {$record->patient->last_name}"),

                Tables\Columns\TextColumn::make('doctor.last_name')
                    ->label('Doctor')
                    ->formatStateUsing(fn ($record) => "{$record->doctor->first_name} {$record->doctor->last_name}"),

                Tables\Columns\TextColumn::make('date')
                    ->date(),

                Tables\Columns\TextColumn::make('time')
                    ->label('Time')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('H:i')),


                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Appointment $record) => route('filament.admin.resources.appointments.view', ['record' => $record])),
            ]);
    }
}
