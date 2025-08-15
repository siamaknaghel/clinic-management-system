<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('update-appointment'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(fn () => auth()->user()->can('read-appointment')),
            DeleteAction::make()->authorize(fn () => auth()->user()->can('delete-appointment')),
        ];
    }
}
