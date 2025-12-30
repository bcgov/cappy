<?php

namespace App\Filament\Resources\Applications\Resources\CVEQueries\Pages;

use App\Filament\Resources\Applications\Resources\CVEQueries\CVEQueryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCVEQuery extends EditRecord
{
    protected static string $resource = CVEQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
