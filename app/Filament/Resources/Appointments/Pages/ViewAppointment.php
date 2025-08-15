<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('read-appointment'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->authorize(fn () => auth()->user()->can('update-appointment')),
        ];
    }
}
