<?php

namespace App\Filament\Resources\MedicalRecords\Pages;

use App\Filament\Resources\MedicalRecords\MedicalRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicalRecord extends EditRecord
{
    protected static string $resource = MedicalRecordResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('update-medicalrecord'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(fn () => auth()->user()->can('read-medicalrecord')),
            DeleteAction::make()->authorize(fn () => auth()->user()->can('delete-medicalrecord')),
        ];
    }
}
