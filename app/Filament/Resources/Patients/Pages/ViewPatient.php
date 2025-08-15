<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->authorize(fn () => auth()->user()->can('update-patient')),
        ];
    }

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('read-patient'), 403);
    }
}
