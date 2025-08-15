<?php

namespace App\Filament\Resources\Permissions\Pages;

use App\Filament\Resources\Permissions\PermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->authorize(fn () => auth()->user()->can('create-permission')),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        $user = auth()->user();

        return $user?->can('manage-permissions') ?? false;
    }
}
