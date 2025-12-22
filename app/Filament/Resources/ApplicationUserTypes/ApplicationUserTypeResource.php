<?php

namespace App\Filament\Resources\ApplicationUserTypes;

use App\Filament\Resources\ApplicationUserTypes\Pages\CreateApplicationUserType;
use App\Filament\Resources\ApplicationUserTypes\Pages\EditApplicationUserType;
use App\Filament\Resources\ApplicationUserTypes\Pages\ListApplicationUserTypes;
use App\Filament\Resources\ApplicationUserTypes\Schemas\ApplicationUserTypeForm;
use App\Filament\Resources\ApplicationUserTypes\Tables\ApplicationUserTypesTable;
use App\Models\ApplicationUserType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationUserTypeResource extends Resource
{
    protected static ?string $model = ApplicationUserType::class;

    protected static ?string $navigationLabel = 'User Types';

    protected static ?string $navigationParentItem = 'Business Areas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ApplicationUserTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationUserTypesTable::configure($table);
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
            'index' => ListApplicationUserTypes::route('/'),
            'create' => CreateApplicationUserType::route('/create'),
            'edit' => EditApplicationUserType::route('/{record}/edit'),
        ];
    }
}
