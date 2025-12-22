<?php

namespace App\Filament\Resources\SubjectMatterExperts\Pages;

use App\Filament\Resources\SubjectMatterExperts\SubjectMatterExpertResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubjectMatterExpert extends EditRecord
{
    protected static string $resource = SubjectMatterExpertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
