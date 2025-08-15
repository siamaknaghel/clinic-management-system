<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('update-doctor'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(fn () => auth()->user()->can('read-doctor')),
            DeleteAction::make()->authorize(fn () => auth()->user()->can('delete-doctor')),
        ];
    }
}
