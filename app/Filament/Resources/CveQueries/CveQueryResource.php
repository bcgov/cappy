<?php

namespace App\Filament\Resources\CveQueries;

use App\Filament\Resources\CveQueries\Pages\CreateCveQuery;
use App\Filament\Resources\CveQueries\Pages\EditCveQuery;
use App\Filament\Resources\CveQueries\Pages\ListCveQueries;
use App\Filament\Resources\CveQueries\Schemas\CveQueryForm;
use App\Filament\Resources\CveQueries\Tables\CveQueriesTable;
use App\Models\CveQuery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CveQueryResource extends Resource
{
    protected static ?string $model = CveQuery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CveQueryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CveQueriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApplicationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCveQueries::route('/'),
            'create' => CreateCveQuery::route('/create'),
            'edit' => EditCveQuery::route('/{record}/edit'),
        ];
    }
}
