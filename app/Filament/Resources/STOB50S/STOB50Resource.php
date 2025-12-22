<?php

namespace App\Filament\Resources\STOB50S;

use App\Filament\Resources\STOB50S\Pages\CreateSTOB50;
use App\Filament\Resources\STOB50S\Pages\EditSTOB50;
use App\Filament\Resources\STOB50S\Pages\ListSTOB50S;
use App\Filament\Resources\STOB50S\Schemas\STOB50Form;
use App\Filament\Resources\STOB50S\Tables\STOB50STable;
use App\Models\STOB50;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class STOB50Resource extends Resource
{
    protected static ?string $model = STOB50::class;

    protected static ?string $modelLabel = 'STOB 50';
    protected static ?string $pluralModelLabel = 'STOB 50s';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return STOB50Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return STOB50STable::configure($table);
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
            'index' => ListSTOB50S::route('/'),
            'create' => CreateSTOB50::route('/create'),
            'edit' => EditSTOB50::route('/{record}/edit'),
        ];
    }
}
