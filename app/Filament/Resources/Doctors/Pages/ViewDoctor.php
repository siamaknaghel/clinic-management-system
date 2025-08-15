<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('read-doctor'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->authorize(fn () => auth()->user()->can('update-doctor')),
        ];
    }
}
