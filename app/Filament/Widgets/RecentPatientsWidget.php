<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Patient;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;

class RecentPatientsWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Patients';
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(Patient::latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('First Name'),
                Tables\Columns\TextColumn::make('last_name')->label('Last Name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->date(),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Patient $record) => route('filament.admin.resources.patients.view', ['record' => $record])),
            ]);
    }
}
