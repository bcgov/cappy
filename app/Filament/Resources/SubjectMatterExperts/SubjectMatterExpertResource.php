<?php

namespace App\Filament\Resources\SubjectMatterExperts;

use App\Filament\Resources\SubjectMatterExperts\Pages\CreateSubjectMatterExpert;
use App\Filament\Resources\SubjectMatterExperts\Pages\EditSubjectMatterExpert;
use App\Filament\Resources\SubjectMatterExperts\Pages\ListSubjectMatterExperts;
use App\Filament\Resources\SubjectMatterExperts\Schemas\SubjectMatterExpertForm;
use App\Filament\Resources\SubjectMatterExperts\Tables\SubjectMatterExpertsTable;
use App\Models\SubjectMatterExpert;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubjectMatterExpertResource extends Resource
{
    protected static ?string $model = SubjectMatterExpert::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SubjectMatterExpertForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubjectMatterExpertsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubjectMatterExperts::route('/'),
            'create' => CreateSubjectMatterExpert::route('/create'),
            'edit' => EditSubjectMatterExpert::route('/{record}/edit'),
        ];
    }
}
