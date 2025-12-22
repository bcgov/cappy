<?php

namespace App\Filament\Resources\ApplicationUserTypes\Pages;

use App\Filament\Resources\ApplicationUserTypes\ApplicationUserTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplicationUserTypes extends ListRecords
{
    protected static string $resource = ApplicationUserTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
