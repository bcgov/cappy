<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\STOB60S\STOB60Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class VendorSupportsRelationManager extends RelationManager
{
    protected static string $relationship = 'vendorSupports';

    protected static ?string $relatedResource = STOB60Resource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
