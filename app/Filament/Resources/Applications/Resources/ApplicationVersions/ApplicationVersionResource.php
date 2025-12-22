<?php

namespace App\Filament\Resources\Applications\Resources\ApplicationVersions;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Filament\Resources\Applications\Resources\ApplicationVersions\Pages\CreateApplicationVersion;
use App\Filament\Resources\Applications\Resources\ApplicationVersions\Pages\EditApplicationVersion;
use App\Filament\Resources\Applications\Resources\ApplicationVersions\Schemas\ApplicationVersionForm;
use App\Filament\Resources\Applications\Resources\ApplicationVersions\Tables\ApplicationVersionsTable;
use App\Models\ApplicationVersion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationVersionResource extends Resource
{
    protected static ?string $model = ApplicationVersion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ApplicationResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ApplicationVersionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationVersionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateApplicationVersion::route('/create'),
            'edit' => EditApplicationVersion::route('/{record}/edit'),
        ];
    }
}
