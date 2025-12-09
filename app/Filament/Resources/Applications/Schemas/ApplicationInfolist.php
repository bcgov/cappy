<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Application;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->columns(1)
            ->components([
                Section::make('Basic Information')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('ministry.name'),
                        TextEntry::make('division')->placeholder('-'),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('status')
                            ->formatStateUsing(fn($state) => Application::getStatusOptions()[$state] ?? $state),
                    ]),
                Section::make('Business Information')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('business_owner_name'),
                        TextEntry::make('business_owner_email'),
                    ]),
                Section::make('Technical Information')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('technical_contact_name'),
                        TextEntry::make('technical_contact_email'),
                        TextEntry::make('hosting_type')
                            ->placeholder('-')
                            ->formatStateUsing(fn($state) => Application::getHostingTypeOptions()[$state] ?? $state),
                        TextEntry::make('hosting_details')
                            ->placeholder('-'),
                    ]),
                Section::make('Additional Information')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('documentation_url')
                            ->placeholder('-'),
                        TextEntry::make('repository_url')
                            ->placeholder('-'),
                        TextEntry::make('go_live_date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('end_of_life_date')
                            ->date()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
