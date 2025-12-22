<?php

namespace App\Filament\Resources\SubjectMatterExperts\Pages;

use App\Filament\Resources\SubjectMatterExperts\SubjectMatterExpertResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubjectMatterExperts extends ListRecords
{
    protected static string $resource = SubjectMatterExpertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
