<?php

namespace App\Filament\Resources\Applications\Resources\CVEQueries;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Filament\Resources\Applications\Resources\CVEQueries\Pages\CreateCVEQuery;
use App\Filament\Resources\Applications\Resources\CVEQueries\Pages\EditCVEQuery;
use App\Filament\Resources\Applications\Resources\CVEQueries\Schemas\CVEQueryForm;
use App\Filament\Resources\Applications\Resources\CVEQueries\Tables\CVEQueriesTable;
use App\Models\CVEQuery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CVEQueryResource extends Resource
{
    protected static ?string $model = CVEQuery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ApplicationResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CVEQueryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CVEQueriesTable::configure($table);
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
            'create' => CreateCVEQuery::route('/create'),
            'edit' => EditCVEQuery::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
