<?php

namespace App\Filament\Resources\Ministries\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class MinistryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->columns(1)
            ->components([
                Section::make('Basic Information')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('short_name'),
                ])
            ]);
    }
}
