<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('ministry')
                    ->searchable(),
                TextColumn::make('division')
                    ->searchable(),
                TextColumn::make('business_owner_name')
                    ->searchable(),
                TextColumn::make('business_owner_email')
                    ->searchable(),
                TextColumn::make('technical_contact_name')
                    ->searchable(),
                TextColumn::make('technical_contact_email')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('hosting_type')
                    ->searchable(),
                TextColumn::make('hosting_details')
                    ->searchable(),
                TextColumn::make('documentation_url')
                    ->searchable(),
                TextColumn::make('repository_url')
                    ->searchable(),
                TextColumn::make('go_live_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_of_life_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
