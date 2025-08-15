<?php

namespace App\Filament\Resources\MedicalRecords\Schemas;

use App\Models\Doctor;
use App\Models\Patient;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class MedicalRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Patient & Doctor')
                ->schema([
                    Select::make('patient_id')
                        ->label('Patient')
                        ->relationship('patient', 'first_name')
                        ->searchable(['first_name', 'last_name', 'national_code'])
                        ->preload()
                        ->required()
                        ->live(onBlur: true),

                    Select::make('doctor_id')
                        ->label('Doctor')
                        ->relationship('doctor', 'first_name')
                        ->searchable(['first_name', 'last_name', 'specialty'])
                        ->preload()
                        ->required()
                        ->live(onBlur: true),
                ])
                ->columns(2),

            Section::make('Record Details')
                ->schema([
                    TextInput::make('title')
                        ->label('Record Title')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('e.g. Initial Consultation, Follow-up'),

                    DatePicker::make('created_at')
                        ->label('Date')
                        ->required()
                        ->maxDate(now())
                        ->default(now()),
                ])
                ->columns(2),

            Section::make('Clinical Information')
                ->schema([
                    RichEditor::make('description')
                        ->label('Description')
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('Describe symptoms, examination findings, etc.')
                        ->maxLength(65535),

                    RichEditor::make('diagnosis')
                        ->label('Diagnosis')
                        ->columnSpanFull()
                        ->placeholder('e.g. Hypertension, Dental Caries')
                        ->maxLength(65535),

                    RichEditor::make('prescription')
                        ->label('Prescription')
                        ->columnSpanFull()
                        ->placeholder('List medications, dosage, instructions')
                        ->maxLength(65535),
                ]),

            Section::make('Attachments')
                ->schema([
                    FileUpload::make('files')
                        ->label('Attach Files')
                        ->disk('public')
                        ->directory('medical-records')
                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                        ->multiple()
                        ->reorderable()
                        ->maxFiles(10)
                        ->downloadable()
                        ->openable()
                        ->columnSpanFull()
                        ->helperText('Upload PDFs, X-rays, lab results, etc.'),
                ]),

            Section::make('Appointment Link (Optional)')
                ->schema([
                    Select::make('appointment_id')
                        ->label('Linked Appointment')
                        ->options(function ($get) {
                            $patientId = $get('patient_id');
                            $doctorId = $get('doctor_id');

                            if (! $patientId || ! $doctorId) {
                                return [];
                            }

                            return \App\Models\Appointment::where('patient_id', $patientId)
                                ->where('doctor_id', $doctorId)
                                ->where('date', '<=', now())
                                ->pluck('date', 'id')
                                ->map(fn ($date, $id) => "Visit on " . \Carbon\Carbon::parse($date)->format('Y-m-d'))
                                ->toArray();
                        })
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Optional: link this record to a past appointment'),
                ]),
        ]);
    }
}
