<?php

namespace App\Filament\Resources\Applications\Resources\ApplicationVersions\Pages;

use App\Filament\Resources\Applications\Resources\ApplicationVersions\ApplicationVersionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationVersion extends CreateRecord
{
    protected static string $resource = ApplicationVersionResource::class;
}
