<?php

namespace App\Filament\Resources\MedicalRecords\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class MedicalRecordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Record Info')
                ->schema([
                    TextEntry::make('title')->label('Title'),
                    TextEntry::make('patient.last_name')
                        ->label('Patient')
                        ->formatStateUsing(fn ($record) => "{$record->patient->first_name} {$record->patient->last_name}"),
                    TextEntry::make('doctor.last_name')
                        ->label('Doctor')
                        ->formatStateUsing(fn ($record) => "{$record->doctor->first_name} {$record->doctor->last_name}"),
                    TextEntry::make('created_at')->label('Date')->date(),
                ])
                ->columns(2),

            Section::make('Clinical Details')
                ->schema([
                    TextEntry::make('description')
                        ->label('Description')
                        ->markdown()
                        ->prose(),

                    TextEntry::make('diagnosis')
                        ->label('Diagnosis')
                        ->markdown()
                        ->prose(),

                    TextEntry::make('prescription')
                        ->label('Prescription')
                        ->markdown()
                        ->prose(),
                ]),

            Section::make('Attachments')
    ->schema([
        TextEntry::make('file_list')
    ->label('Attachments')
    ->getStateUsing(fn ($record) => $record->files) // برای اولین بار درست می‌خونه
    ->formatStateUsing(function ($state) {
        // حالا $state ممکنه رشته، JSON یا آرایه باشه — ما همه حالت‌ها رو پوشش می‌دیم

        if (empty($state)) {
            return '<span class="text-gray-500">No files attached.</span>';
        }

        $files = [];

        if (is_array($state)) {
            $files = array_filter($state);
        } else {
            // اگر رشته باشه
            $decoded = json_decode($state, true);
            if (is_array($decoded)) {
                $files = array_filter($decoded);
            } else {
                $files = array_filter([$state]);
            }
        }

        if (empty($files)) {
            return '<span class="text-gray-500">No files attached.</span>';
        }

        return view('filament.components.infolists.file-list', [
            'files' => $files,
        ])->render();
    })
    ->html()
    ->visible(fn ($record) => ! empty($record->files)),
    ]),
        ]);
    }
}
