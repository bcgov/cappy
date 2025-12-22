<?php

namespace App\Filament\Resources\Applications\Resources\ApplicationVersions\Pages;

use App\Filament\Resources\Applications\Resources\ApplicationVersions\ApplicationVersionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationVersion extends EditRecord
{
    protected static string $resource = ApplicationVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
