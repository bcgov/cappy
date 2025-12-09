<?php

namespace App\Filament\Resources\Ministries\RelationManagers;

use App\Filament\Resources\Applications\Tables\ApplicationsTable;
use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class ApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'applications';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return ApplicationsTable::configure($table)
            ->recordUrl(
                fn($record) =>
                ApplicationResource::getUrl('view', ['record' => $record])
            )
            ->actions([
                ViewAction::make()
                    ->url(fn($record) => ApplicationResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
