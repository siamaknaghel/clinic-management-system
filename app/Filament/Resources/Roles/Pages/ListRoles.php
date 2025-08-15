<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(fn () => auth()->user()->can('create-role')),
        ];
    }
    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('manage-role'), 403);
    }

}
