<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDoctors extends ListRecords
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(fn () => auth()->user()->can('create-doctor')),
        ];
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('manage-doctor'), 403);
    }
}
