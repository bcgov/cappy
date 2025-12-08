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
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('ministry')
                    ->required(),
                TextInput::make('division'),
                TextInput::make('business_owner_name')
                    ->required(),
                TextInput::make('business_owner_email')
                    ->email()
                    ->required(),
                TextInput::make('technical_contact_name')
                    ->required(),
                TextInput::make('technical_contact_email')
                    ->email()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                TextInput::make('hosting_type'),
                TextInput::make('hosting_details'),
                TextInput::make('documentation_url')
                    ->url(),
                TextInput::make('repository_url')
                    ->url(),
                DatePicker::make('go_live_date'),
                DatePicker::make('end_of_life_date'),
            ]);
    }
}
