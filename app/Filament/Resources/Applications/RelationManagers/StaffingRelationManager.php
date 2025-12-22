<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\STOB50S\STOB50Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class StaffingRelationManager extends RelationManager
{
    protected static string $relationship = 'staffing';

    protected static ?string $relatedResource = STOB50Resource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
