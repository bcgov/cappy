<?php

namespace App\Filament\Resources\CveQueries\Pages;

use App\Filament\Resources\CveQueries\CveQueryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCveQueries extends ListRecords
{
    protected static string $resource = CveQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
