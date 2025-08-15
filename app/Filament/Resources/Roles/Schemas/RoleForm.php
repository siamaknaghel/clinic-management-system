<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\CheckboxList;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Role Name')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('permissions')
                ->label('Permissions')
                ->multiple()
                ->relationship('permissions', 'name')
                ->options(Permission::pluck('name', 'id')->toArray())
                ->columns(2)
                ->columnSpanFull(),
            ]);
    }
}
