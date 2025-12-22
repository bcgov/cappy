<?php

namespace App\Filament\Resources\ApplicationUserTypes\Pages;

use App\Filament\Resources\ApplicationUserTypes\ApplicationUserTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationUserType extends CreateRecord
{
    protected static string $resource = ApplicationUserTypeResource::class;
}
