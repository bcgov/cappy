<?php

namespace App\Filament\Resources\BusinessAreas\Pages;

use App\Filament\Resources\BusinessAreas\BusinessAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBusinessAreas extends ListRecords
{
    protected static string $resource = BusinessAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
