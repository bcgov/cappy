<?php

namespace App\Filament\Resources\Applications\Resources\ApplicationVersions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationVersionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('release'),
                DatePicker::make('end_of_life'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('application_id')
                    ->relationship('application', 'name')
                    ->required(),
            ]);
    }
}
