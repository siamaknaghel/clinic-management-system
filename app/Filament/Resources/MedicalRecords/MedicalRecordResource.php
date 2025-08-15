<?php

namespace App\Filament\Resources\MedicalRecords;

use App\Filament\Resources\MedicalRecords\Pages\CreateMedicalRecord;
use App\Filament\Resources\MedicalRecords\Pages\EditMedicalRecord;
use App\Filament\Resources\MedicalRecords\Pages\ListMedicalRecords;
use App\Filament\Resources\MedicalRecords\Pages\ViewMedicalRecord;
use App\Models\MedicalRecord;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;

    protected static string | UnitEnum | null $navigationGroup = 'Clinic';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Medical Record';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Medical Records';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('manage-medicalrecord') ?? false;
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return \App\Filament\Resources\MedicalRecords\Schemas\MedicalRecordForm::configure($schema);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return \App\Filament\Resources\MedicalRecords\Schemas\MedicalRecordInfolist::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return \App\Filament\Resources\MedicalRecords\Tables\MedicalRecordsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedicalRecords::route('/'),
            'create' => CreateMedicalRecord::route('/create'),
            'view' => ViewMedicalRecord::route('/{record}'),
            'edit' => EditMedicalRecord::route('/{record}/edit'),
        ];
    }
}
