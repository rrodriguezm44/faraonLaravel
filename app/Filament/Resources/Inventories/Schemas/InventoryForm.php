<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Inventario')
                ->columns(2)
                ->schema([
                    Select::make('product_id')
                        ->relationship('product', 'description')
                        ->label('Producto')
                        ->placeholder('Selecciona un producto')
                        ->searchable()
                        ->preload()
                        ->default(null),
                    Select::make('warehouse_id')
                        ->relationship('warehouse', 'name')
                        ->label('Almacén')
                        ->placeholder('Selecciona un almacén')
                        ->searchable()
                        ->preload()
                        ->default(null),
                    TextInput::make('quantity')
                        ->label('Cantidad')
                        ->required()
                        ->numeric()
                        ->default(0),
                ]),
            ]);
    }
}
