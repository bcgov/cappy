<?php

namespace App\Filament\Resources\Ministries\Pages;

use App\Filament\Resources\Ministries\MinistryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMinistry extends ViewRecord
{
    protected static string $resource = MinistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
