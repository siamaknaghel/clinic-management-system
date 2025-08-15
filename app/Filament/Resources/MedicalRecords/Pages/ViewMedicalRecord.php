<?php

namespace App\Filament\Resources\MedicalRecords\Pages;

use App\Filament\Resources\MedicalRecords\MedicalRecordResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicalRecord extends ViewRecord
{
    protected static string $resource = MedicalRecordResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('read-medicalrecord'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->authorize(fn () => auth()->user()->can('update-medicalrecord')),
        ];
    }
}
