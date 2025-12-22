<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DependenciesRelationManager extends RelationManager
{
    protected static string $relationship = 'dependencies';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])->inverseRelationship('dependency_of');
    }
}
