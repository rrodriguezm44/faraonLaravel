<?php

namespace App\Filament\Resources\SubCategories\Schemas;

use App\Filament\Resources\Categories\Schemas\CategoryForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información de la Subcategoría')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de la Subcategoría')
                            ->placeholder('Ej: SUBCATEGORÍA 1')
                            ->required(),
                        Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->createOptionForm(CategoryForm::create())
                            ->createOptionModalHeading('Crear Nueva Categoria'),
                    ]),
            ]);
    }
}
