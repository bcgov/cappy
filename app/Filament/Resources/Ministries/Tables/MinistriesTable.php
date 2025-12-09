<?php

namespace App\Filament\Resources\Ministries\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Tables\Table;

class MinistriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('short_name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn(): bool => auth()->user()->hasAnyRole(['user', 'editor', 'admin'])),
                EditAction::make()
                    ->visible(fn(): bool => auth()->user()->hasAnyRole(['editor', 'admin'])),
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                CreateAction::make()
                    ->visible(fn(): bool => auth()->user()->hasAnyRole(['editor', 'admin'])),
            ]);
    }
}
