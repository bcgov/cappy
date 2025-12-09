<?php

namespace App\Filament\Resources\Ministries\Pages;

use App\Filament\Resources\Ministries\MinistryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMinistry extends EditRecord
{
    protected static string $resource = MinistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->visible(fn(): bool => auth()->user()->hasAnyRole(['admin'])),
        ];
    }
}
