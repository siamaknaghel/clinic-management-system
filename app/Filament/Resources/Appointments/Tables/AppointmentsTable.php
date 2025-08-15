<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.last_name')
                    ->label('Patient')
                    ->formatStateUsing(fn ($record) => "{$record->patient->first_name} {$record->patient->last_name}")
                    ->searchable(['first_name', 'last_name', 'national_code'])
                    ->sortable(query: fn ($query, $direction) => $query
                        ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                        ->orderBy('patients.first_name', $direction)
                        ->orderBy('patients.last_name', $direction)
                        ->select('appointments.*')),

                TextColumn::make('doctor.last_name')
                    ->label('Doctor')
                    ->formatStateUsing(fn ($record) => "{$record->doctor->first_name} {$record->doctor->last_name}")
                    ->searchable(['first_name', 'last_name', 'specialty'])
                    ->sortable(query: fn ($query, $direction) => $query
                        ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                        ->orderBy('doctors.first_name', $direction)
                        ->orderBy('doctors.last_name', $direction)
                        ->select('appointments.*')),

                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('time')
                    ->label('Time')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('H:i'))
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->suffix(' min'),

                IconColumn::make('status')
                    ->label('Status')
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check',
                        'completed' => 'heroicon-o-document-check',
                        'canceled' => 'heroicon-o-x-mark',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                    })
                    ->sortable(),

                IconColumn::make('payment_status')
                    ->label('Payment')
                    ->icon(fn (string $state): string => match ($state) {
                        'unpaid' => 'heroicon-o-x-circle',
                        'partially_paid' => 'heroicon-o-clock',
                        'paid' => 'heroicon-o-check-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partially_paid' => 'warning',
                        'paid' => 'success',
                    })
                    ->sortable(),

                TextColumn::make('fee_charged')
                    ->label('Fee')
                    ->formatStateUsing(fn ($state) => number_format($state) . ' $')
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('doctor_id')
                    ->relationship('doctor', 'first_name')
                    ->label('Doctor'),

                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partially_paid' => 'Partially Paid',
                        'paid' => 'Paid',
                    ]),

                \Filament\Tables\Filters\Filter::make('upcoming')
                    ->query(fn ($query) => $query->where('date', '>=', now()->toDateString())),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->visible(fn () => auth()->user()->can('read-appointment')),
                \Filament\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->can('update-appointment')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete-appointment')),
                ]),
            ]);
    }
}
