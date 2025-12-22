<?php

namespace App\Filament\Resources\STOB60S\Pages;

use App\Filament\Resources\STOB60S\STOB60Resource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSTOB60 extends EditRecord
{
    protected static string $resource = STOB60Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
