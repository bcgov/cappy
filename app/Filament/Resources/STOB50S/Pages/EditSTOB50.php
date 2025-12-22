<?php

namespace App\Filament\Resources\STOB50S\Pages;

use App\Filament\Resources\STOB50S\STOB50Resource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSTOB50 extends EditRecord
{
    protected static string $resource = STOB50Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
