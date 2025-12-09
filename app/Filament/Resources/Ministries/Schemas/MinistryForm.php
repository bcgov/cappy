<?php

namespace App\Filament\Resources\Ministries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class MinistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('short_name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
