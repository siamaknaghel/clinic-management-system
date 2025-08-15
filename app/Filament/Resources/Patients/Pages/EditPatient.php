<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(fn () => auth()->user()->can('read-patient')),
            DeleteAction::make()->authorize(fn () => auth()->user()->can('delete-patient')),
        ];
    }

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('update-patient'), 403);
    }
}
