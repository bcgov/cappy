<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Application;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('ministry.name'),
                TextEntry::make('division')
                    ->placeholder('-'),
                TextEntry::make('business_owner_name'),
                TextEntry::make('business_owner_email'),
                TextEntry::make('technical_contact_name'),
                TextEntry::make('technical_contact_email'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('hosting_type')
                    ->placeholder('-'),
                TextEntry::make('hosting_details')
                    ->placeholder('-'),
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
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Application $record): bool => $record->trashed()),
            ]);
    }
}
