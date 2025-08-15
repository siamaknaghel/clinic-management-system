<?php

namespace App\Filament\Resources\MedicalRecords\Tables;

use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class MedicalRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('patient.last_name')
                    ->label('Patient')
                    ->formatStateUsing(fn ($record) => "{$record->patient->first_name} {$record->patient->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(query: fn ($query, $direction) => $query
                        ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
                        ->orderBy('patients.first_name', $direction)
                        ->orderBy('patients.last_name', $direction)
                        ->select('medical_records.*')),

                TextColumn::make('doctor.last_name')
                    ->label('Doctor')
                    ->formatStateUsing(fn ($record) => "{$record->doctor->first_name} {$record->doctor->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(query: fn ($query, $direction) => $query
                        ->join('doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                        ->orderBy('doctors.first_name', $direction)
                        ->orderBy('doctors.last_name', $direction)
                        ->select('medical_records.*')),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                IconColumn::make('has_prescription')
                    ->label('Rx')
                    ->icon(fn ($record) => $record->prescription ? 'heroicon-o-document-text' : null)
                    ->color('success')
                    ->tooltip('Prescription included'),

                IconColumn::make('has_files')
                    ->label('Files')
                    ->icon('heroicon-o-paper-clip')
                    ->color('info')
                    ->boolean() // ✅ این می‌گه فقط اگر true باشه نمایش بده
                    ->tooltip('Attachments available'),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('patient_id')
                    ->relationship('patient', 'first_name')
                    ->label('Patient'),

                \Filament\Tables\Filters\SelectFilter::make('doctor_id')
                    ->relationship('doctor', 'first_name')
                    ->label('Doctor'),

                \Filament\Tables\Filters\Filter::make('has_prescription')
                    ->query(fn ($query) => $query->whereNotNull('prescription')),

                \Filament\Tables\Filters\Filter::make('has_files')
                    ->query(fn ($query) => $query->whereJsonLength('files', '>', 0)),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->visible(fn () => auth()->user()->can('read-medicalrecord')),
                \Filament\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->can('update-medicalrecord')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete-medicalrecord')),
                ]),
            ]);
    }
}
