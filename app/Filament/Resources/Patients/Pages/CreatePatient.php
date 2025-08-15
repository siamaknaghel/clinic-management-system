<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('create-patient'), 403);
    }
}
