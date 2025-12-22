<?php

namespace App\Filament\Resources\STOB60S\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class STOB60Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('rate')
                    ->numeric(),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required(),
            ]);
    }
}
