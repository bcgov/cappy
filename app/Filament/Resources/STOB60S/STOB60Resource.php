<?php

namespace App\Filament\Resources\STOB60S;

use App\Filament\Resources\STOB60S\Pages\CreateSTOB60;
use App\Filament\Resources\STOB60S\Pages\EditSTOB60;
use App\Filament\Resources\STOB60S\Pages\ListSTOB60S;
use App\Filament\Resources\STOB60S\Schemas\STOB60Form;
use App\Filament\Resources\STOB60S\Tables\STOB60STable;
use App\Models\STOB60;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class STOB60Resource extends Resource
{
    protected static ?string $model = STOB60::class;

    protected static ?string $modelLabel = 'STOB 60';
    protected static ?string $pluralModelLabel = 'STOB 60s';

    protected static ?string $navigationParentItem = 'Vendors';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return STOB60Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return STOB60STable::configure($table);
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
            'index' => ListSTOB60S::route('/'),
            'create' => CreateSTOB60::route('/create'),
            'edit' => EditSTOB60::route('/{record}/edit'),
        ];
    }
}
