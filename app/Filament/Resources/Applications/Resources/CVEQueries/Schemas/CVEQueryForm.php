<?php

namespace App\Filament\Resources\Applications\Resources\CVEQueries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CVEQueryForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
            ->columns(1)
            ->components([
                Section::make('Query Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('A descriptive name for this CVE query'),

                        Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Inactive queries will not be checked'),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(2)
                            ->helperText('Optional description of what this query monitors'),
                    ]),

                Section::make('OpenCVE API Parameters')
                    ->description('Configure filters for CVE search. All fields are optional.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('search')
                            ->helperText('Keyword search in CVE ID or description'),

                        TextInput::make('vendor')
                            ->helperText('Filter by vendor name (e.g., "microsoft")'),

                        TextInput::make('product')
                            ->helperText('Filter by product name (e.g., "windows")'),

                        TextInput::make('weakness')
                            ->helperText('Filter by CWE identifier (e.g., "CWE-79")'),

                        TextInput::make('tag')
                            ->columnSpanFull()
                            ->helperText('Filter by OpenCVE user tag'),
                    ]),

                Section::make('Notification Configuration')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cvss_threshold')
                            ->numeric()
                            ->required()
                            ->default(7.0)
                            ->minValue(1.0)
                            ->maxValue(10.0)
                            ->step(0.1)
                            ->helperText('Only notify for CVEs with CVSS score at or above this value'),

                        TagsInput::make('notification_emails')
                            ->required()
                            ->placeholder('Enter email addresses')
                            ->columnSpanFull()
                            ->helperText('Email addresses to notify when new CVEs are found (press Enter after each email)')
                            ->validationAttribute('notification emails')
                            ->nestedRecursiveRules([
                                'email',
                            ]),
                    ]),
            ]);
    }
}
