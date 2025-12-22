<?php

namespace App\Filament\Resources\ApplicationUserTypes\Pages;

use App\Filament\Resources\ApplicationUserTypes\ApplicationUserTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationUserType extends EditRecord
{
    protected static string $resource = ApplicationUserTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
