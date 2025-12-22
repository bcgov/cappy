<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\SubjectMatterExperts\SubjectMatterExpertResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SubjectMatterExpertsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjectMatterExperts';

    protected static ?string $relatedResource = SubjectMatterExpertResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
