<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('national_code'),
                TextEntry::make('phone'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('birth_date')
                    ->date(),
                TextEntry::make('gender'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
