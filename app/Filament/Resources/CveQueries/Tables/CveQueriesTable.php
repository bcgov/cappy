<?php

namespace App\Filament\Resources\CveQueries\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;

class CveQueriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                TextColumn::make('cvss_threshold')
                    ->label('CVSS Threshold')
                    ->sortable()
                    ->suffix('+'),

                TextColumn::make('vendor')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('product')
                    ->searchable()
                    ->toggleable(),

                TagsColumn::make('notification_emails')
                    ->label('Notification Emails')
                    ->limit(2)
                    ->toggleable(),

                TextColumn::make('applications_count')
                    ->counts('applications')
                    ->label('Applications')
                    ->sortable(),

                TextColumn::make('notifications_count')
                    ->counts('notifications')
                    ->label('CVEs Notified')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }
}
