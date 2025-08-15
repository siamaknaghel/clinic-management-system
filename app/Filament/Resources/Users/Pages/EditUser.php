<?php

namespace App\Filament\Resources\Users\Pages;

use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Users\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // protected function resolveRecord(string|int $key): User
    // {
    //     //dd(parent::resolveRecord($key)->load(['roles', 'permissions']));
    //     return parent::resolveRecord($key)->load(['roles', 'permissions']);
    // }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(fn () => auth()->user()->can('read-user')),
            DeleteAction::make()->authorize(fn () => auth()->user()->can('delete-user')),
        ];
    }

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless(auth()->user()->can('update-user'), 403);
    }


}
