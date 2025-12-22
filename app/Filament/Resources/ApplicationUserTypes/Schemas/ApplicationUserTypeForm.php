<?php

namespace App\Filament\Resources\ApplicationUserTypes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApplicationUserTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                Select::make('business_area_id')
                    ->relationship('businessArea', 'name')
                    ->required(),
            ]);
    }
}
