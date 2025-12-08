<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Application;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('ministry')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('division')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->options(Application::getStatusOptions())
                            ->required()
                            ->default('active'),
                    ])
                    ->columns(2),

                Section::make('Business Information')
                    ->schema([
                        TextInput::make('business_owner_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('business_owner_email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Technical Information')
                    ->schema([
                        TextInput::make('technical_contact_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('technical_contact_email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Select::make('hosting_type')
                            ->options(Application::getHostingTypeOptions()),

                        Textarea::make('hosting_details')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        TextInput::make('documentation_url')
                            ->url()
                            ->maxLength(2048),

                        TextInput::make('repository_url')
                            ->url()
                            ->maxLength(2048),

                        DatePicker::make('go_live_date'),

                        DatePicker::make('end_of_life_date'),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
