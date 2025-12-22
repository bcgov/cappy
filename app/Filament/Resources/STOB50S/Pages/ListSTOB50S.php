<?php

namespace App\Filament\Resources\STOB50S\Pages;

use App\Filament\Resources\STOB50S\STOB50Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSTOB50S extends ListRecords
{
    protected static string $resource = STOB50Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
