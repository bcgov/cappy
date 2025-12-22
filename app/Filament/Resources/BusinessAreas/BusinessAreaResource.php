<?php

namespace App\Filament\Resources\BusinessAreas;

use App\Filament\Resources\BusinessAreas\Pages\CreateBusinessArea;
use App\Filament\Resources\BusinessAreas\Pages\EditBusinessArea;
use App\Filament\Resources\BusinessAreas\Pages\ListBusinessAreas;
use App\Filament\Resources\BusinessAreas\Schemas\BusinessAreaForm;
use App\Filament\Resources\BusinessAreas\Tables\BusinessAreasTable;
use App\Models\BusinessArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BusinessAreaResource extends Resource
{
    protected static ?string $model = BusinessArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BusinessAreaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessAreasTable::configure($table);
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
            'index' => ListBusinessAreas::route('/'),
            'create' => CreateBusinessArea::route('/create'),
            'edit' => EditBusinessArea::route('/{record}/edit'),
        ];
    }
}
