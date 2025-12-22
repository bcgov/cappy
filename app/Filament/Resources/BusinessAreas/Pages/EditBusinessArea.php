<?php

namespace App\Filament\Resources\BusinessAreas\Pages;

use App\Filament\Resources\BusinessAreas\BusinessAreaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBusinessArea extends EditRecord
{
    protected static string $resource = BusinessAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
