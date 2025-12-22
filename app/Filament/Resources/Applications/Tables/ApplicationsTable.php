<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('average_daily_users')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('annual_cost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cost_function')
                    ->searchable(),
                TextColumn::make('cost_per_unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('annual_vendor_cost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('initial_deployment')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_of_support')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_of_life')
                    ->date()
                    ->sortable(),
                TextColumn::make('disposition_deadline')
                    ->date()
                    ->sortable(),
                TextColumn::make('disposition_decision')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
