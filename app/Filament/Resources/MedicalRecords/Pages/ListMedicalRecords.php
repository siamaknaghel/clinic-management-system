<?php

namespace App\Filament\Resources\MedicalRecords\Pages;

use App\Filament\Resources\MedicalRecords\MedicalRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMedicalRecords extends ListRecords
{
    protected static string $resource = MedicalRecordResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('manage-medicalrecord'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(fn () => auth()->user()->can('create-medicalrecord')),
        ];
    }
}
