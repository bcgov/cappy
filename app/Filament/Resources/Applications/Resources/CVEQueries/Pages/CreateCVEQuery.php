<?php

namespace App\Filament\Resources\Applications\Resources\CVEQueries\Pages;

use App\Filament\Resources\Applications\Resources\CVEQueries\CVEQueryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCVEQuery extends CreateRecord
{
    protected static string $resource = CVEQueryResource::class;
}
