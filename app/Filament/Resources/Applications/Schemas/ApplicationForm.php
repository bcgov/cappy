<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use App\Models\Enums\ApplicationCategory;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Basic Information')
                ->columns(4)
                ->description('The basic information for the application')
                ->schema([
                    TextInput::make('name')
                    ->required()
                    ->columnSpan(2),
                    TagsInput::make('tags')
                    ->required()
                    ->columnSpan(2),
                    Textarea::make('description')
                    ->rows(3)
                    ->columnSpan(2),
                    FileUpload::make('screenshots')
                    ->multiple()
                    ->image()
                    ->columnSpan(2),
                    Select::make('category')
                    ->options(ApplicationCategory::class)
                    ->required(),
                TextInput::make('average_daily_users')
                    ->numeric(),
                ]),
                Section::make('Financials & Contract')
                ->columns(4)
                ->description('The financial information for the application')
                ->schema([
                    TextInput::make('annual_cost')
                    ->numeric(), 
                    TextInput::make('cost_per_unit')
                    ->numeric(),
                    TextInput::make('annual_vendor_cost')
                    ->numeric(),
                    TextInput::make('cost_function'),
                    Textarea::make('license_summary')
                    ->columnSpanFull(),
                    
                ]),
                Section::make('Lifecycle')
                    ->columns(4)
                    ->description('The lifecycle information for the application')
                    ->schema([
                        DatePicker::make('initial_deployment'),
                        DatePicker::make('end_of_support'),
                        DatePicker::make('end_of_life'),
                        DatePicker::make('disposition_deadline'),
                        TextInput::make('disposition_decision')
                        ->columnSpanFull(),
                ])
            ]);
    }
}
