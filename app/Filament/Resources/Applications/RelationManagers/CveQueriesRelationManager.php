<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Filament\Resources\Applications\Resources\CVEQueries\CVEQueryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class CveQueriesRelationManager extends RelationManager
{
    protected static string $relationship = 'cveQueries';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $relatedResource = CVEQueryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                TextColumn::make('cvss_threshold')
                    ->label('CVSS Threshold')
                    ->suffix('+'),

                TextColumn::make('vendor'),
                TextColumn::make('product'),

                TextColumn::make('notifications_count')
                    ->counts('notifications')
                    ->label('CVEs Notified'),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
