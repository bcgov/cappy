<?php

namespace App\Filament\Resources\SubjectMatterExperts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectMatterExpertForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('affiliable_type'),
                TextInput::make('affiliable_id')
                    ->numeric(),
            ]);
    }
}
