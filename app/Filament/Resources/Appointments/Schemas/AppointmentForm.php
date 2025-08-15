<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Doctor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Patient & Doctor')
                ->schema([
                    Select::make('patient_id')
                        ->label('Patient')
                        ->relationship('patient', 'first_name', modifyQueryUsing: fn ($query) => $query->orderBy('first_name'))
                        ->searchable(['first_name', 'last_name', 'national_code'])
                        ->preload()
                        ->required()
                        ->live(onBlur: true),

                    Select::make('doctor_id')
                        ->label('Doctor')
                        ->relationship('doctor', 'first_name', modifyQueryUsing: fn ($query) => $query->orderBy('first_name'))
                        ->searchable(['first_name', 'last_name', 'specialty'])
                        ->preload()
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, $set, $get) {
                            // Load doctor's fee when doctor is selected
                            if ($state) {
                                $doctor = Doctor::find($state);
                                if ($doctor) {
                                    $set('fee_charged', $doctor->fee);
                                }
                            }
                        }),
                ])
                ->columns(2),

            Section::make('Appointment Details')
                ->schema([
                    DatePicker::make('date')
                        ->label('Date')
                        ->required()
                        ->minDate(now())
                        ->maxDate(now()->addMonths(3))
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set) => $set('time', null)), // Reset time if date changes

                    TextInput::make('time')
                    ->label('Time')
                    ->required()
                    ->helperText('Time is stored in 24-hour format (e.g. 09:30, 14:45). Your device may display it differently.')
                    ->extraInputAttributes([
                        'type' => 'time',
                        'step' => 300,
                    ])
                    ->rules([
                        'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/',
                        new \App\Rules\UniqueTimeForDoctorRule(),
                    ])
                    ->dehydrateStateUsing(function ($state) {
                        return $state ? \Carbon\Carbon::createFromFormat('H:i', $state)->format('H:i') : null;
                    })
                ])
                ->columns(2),

            Section::make('Financial Info')
                ->schema([
                     TextInput::make('fee_charged')
                    ->label('Fee Charged (USD)')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->disabled()
                    ->dehydrated(),

                    ToggleButtons::make('payment_status')
                        ->label('Payment Status')
                        ->options([
                            'unpaid' => 'Unpaid',
                            'partially_paid' => 'Partially Paid',
                            'paid' => 'Paid',
                        ])
                        ->colors([
                            'unpaid' => 'danger',
                            'partially_paid' => 'warning',
                            'paid' => 'success',
                        ])
                        ->icons([
                            'unpaid' => 'heroicon-o-x-circle',
                            'partially_paid' => 'heroicon-o-clock',
                            'paid' => 'heroicon-o-check-circle',
                        ])
                        ->grouped()
                        ->default('unpaid')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Status & Notes')
                ->schema([
                    ToggleButtons::make('status')
                        ->label('Appointment Status')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'canceled' => 'Canceled',
                        ])
                        ->colors([
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'completed' => 'success',
                            'canceled' => 'danger',
                        ])
                        ->icons([
                            'pending' => 'heroicon-o-clock',
                            'confirmed' => 'heroicon-o-check',
                            'completed' => 'heroicon-o-document-check',
                            'canceled' => 'heroicon-o-x-mark',
                        ])
                        ->grouped()
                        ->default('pending')
                        ->required(),

                    TextInput::make('duration')
                        ->label('Duration (minutes)')
                        ->numeric()
                        ->default(30)
                        ->minValue(15)
                        ->maxValue(180),

                    TextInput::make('notes')
                        ->label('Notes')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
