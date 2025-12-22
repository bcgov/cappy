<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\Documentations\DocumentationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DocumentationRelationManager extends RelationManager
{
    protected static string $relationship = 'documentation';

    protected static ?string $relatedResource = DocumentationResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
