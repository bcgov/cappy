<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ministry.name')
                    ->label('Ministry')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'decommissioned' => 'danger',
                        'in_development' => 'info',
                        default => 'gray',
                    })
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
