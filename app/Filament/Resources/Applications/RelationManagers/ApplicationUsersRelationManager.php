<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\ApplicationUserTypes\ApplicationUserTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ApplicationUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'applicationUsers';

    protected static ?string $relatedResource = ApplicationUserTypeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
