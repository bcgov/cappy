<?php

namespace App\Filament\Resources\STOB60S\Pages;

use App\Filament\Resources\STOB60S\STOB60Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSTOB60S extends ListRecords
{
    protected static string $resource = STOB60Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
