<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    DateTimePicker::make('email_verified_at')
                        ->label('Email Verified At')
                        ->nullable(),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->visible(fn (string $context) => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state))
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->minLength(8)
                        ->confirmed(),
                ])
                ->columns(2),

            Section::make('Access Control')
                ->schema([
                   Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (?array $state, Get $get, Set $set) {
                        $roleIds = $state ?? [];

                        // پرمیژن‌های وراثتی
                        $inherited = Permission::query()
                            ->whereHas('roles', fn ($q) => $q->whereIn('id', $roleIds))
                            ->pluck('id')
                            ->all();

                        $set('inherited_permissions', $inherited);

                        // حذف وراثتی‌ها از پرمیژن‌های مستقیم
                        $direct = $get('permissions') ?? [];
                        $set('permissions', array_values(array_diff($direct, $inherited)));
                    })
                    ->afterStateHydrated(function (Get $get, Set $set, $state) {
                        $roleIds = $state ?? [];
                        $inherited = Permission::query()
                            ->whereHas('roles', fn ($q) => $q->whereIn('id', $roleIds))
                            ->pluck('id')
                            ->all();

                        $set('inherited_permissions', $inherited);

                        $direct = $get('permissions') ?? [];
                        $set('permissions', array_values(array_diff($direct, $inherited)));
                    }),

                Hidden::make('inherited_permissions')->dehydrated(false),

                // Dynamic display of inherited permissions
                ViewField::make('inherited_permissions')
                ->label('Inherited Permissions')
                ->view('filament.components.inherited-permissions'),

                Select::make('permissions')
                    ->label('Extra Permissions')
                    ->relationship('permissions', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options(function (Get $get) {
                        $inherited = $get('inherited_permissions') ?? [];
                        $query = Permission::query();
                        if (!empty($inherited)) {
                            $query->whereNotIn('id', $inherited);
                        }
                        return $query->pluck('name', 'id')->toArray();
                    })
                    ->dehydrateStateUsing(fn ($state) => array_values(array_unique($state ?? [])))
                    ->columnSpanFull()
                    ->helperText('This list only stores permissions added to roles.'),
                ])
        ]);
    }
}
