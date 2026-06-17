<?php

namespace App\Filament\Resources\Inventories\Schemas;

use App\Models\Inventory;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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
                        ->live()
                        ->preload()
                        ->default(null),
                    Select::make('warehouse_id')
                        ->relationship('warehouse', 'name')
                        ->label('Almacén')
                        ->placeholder('Selecciona un almacén')
                        ->searchable()
                        ->live()
                        ->preload()
                        ->default(null),
                    TextInput::make('quantity')
                        ->label('Cantidad')
                        ->required()
                        ->live()
                        ->numeric()
                        ->default(0)
                        ->helperText(function(Get $get){
                            $productId = $get('product_id');
                            $warehouseId = $get('warehouse_id');

                            $stock = Product::query()
                                ->where('id', $productId)
                                ->value('stock') ?? 0;

                            $stockDisponible = Inventory::query()
                                ->where('product_id', $productId)
                                ->where('warehouse_id', $warehouseId)
                                ->value('quantity') ?? 0;

                            return "Stock Inicial: {$stock} | Stock Disponible: {$stockDisponible}";

                        }),
                ]),
            ]);
    }
}
