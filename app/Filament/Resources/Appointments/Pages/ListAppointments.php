<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('manage-appointment'), 403);
    }


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(fn () => auth()->user()->can('create-appointment')),
        ];
    }
}
