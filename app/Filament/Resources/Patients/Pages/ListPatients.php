<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(fn () => auth()->user()->can('create-patient')),
        ];
    }
    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('manage-patient'), 403);
    }
}
