<?php

namespace App\Filament\Resources\Ministries;

use App\Filament\Resources\Ministries\Pages\CreateMinistry;
use App\Filament\Resources\Ministries\Pages\EditMinistry;
use App\Filament\Resources\Ministries\Pages\ListMinistries;
use App\Filament\Resources\Ministries\Pages\ViewMinistry;
use App\Filament\Resources\Ministries\Schemas\MinistryForm;
use App\Filament\Resources\Ministries\Schemas\MinistryInfolist;
use App\Filament\Resources\Ministries\Tables\MinistriesTable;
use App\Models\Ministry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MinistryResource extends Resource
{
    protected static ?string $model = Ministry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return MinistryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MinistryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistriesTable::configure($table);
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
            'index' => ListMinistries::route('/'),
            'create' => CreateMinistry::route('/create'),
            'view' => ViewMinistry::route('/{record}'),
            'edit' => EditMinistry::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchColumns(): array
    {
        return [
            'name',
            'short_name'
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['user', 'editor', 'admin']);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyRole(['editor', 'admin']);
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasAnyRole(['editor', 'admin']);
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
