<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('category')
                    ->required(),
                TextInput::make('average_daily_users')
                    ->numeric(),
                TextInput::make('annual_cost')
                    ->numeric(),
                TextInput::make('cost_function'),
                TextInput::make('cost_per_unit')
                    ->numeric(),
                Textarea::make('license_summary')
                    ->columnSpanFull(),
                TextInput::make('annual_vendor_cost')
                    ->numeric(),
                DatePicker::make('initial_deployment'),
                DatePicker::make('end_of_support'),
                DatePicker::make('end_of_life'),
                DatePicker::make('disposition_deadline'),
                TextInput::make('disposition_decision'),
            ]);
    }
}
