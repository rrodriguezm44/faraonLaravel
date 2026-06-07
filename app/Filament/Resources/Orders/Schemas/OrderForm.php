<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Inventory;
use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                Section::make('Información de la Venta')
                    ->columns(2)
                    ->schema([
                        Select::make('warehouse_id')
                            ->relationship('warehouse', 'name')
                            ->live()
                            ->default(null),
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->live()
                            ->default(null),

                        TextInput::make('notes')
                            ->columnSpan(2)
                            ->default(null),
                    ]),
                
                Section::make('Detalle de la Venta')
                    ->columns(1)
                    ->hidden(function (Get $get): bool{
                        $isVisible = (empty($get('warehouse_id')) || (empty($get('customer_id'))));
                        
                        return $isVisible;
                    })
                    ->schema([
                        Repeater::make('orderProducts')
                            ->columns(3)
                            ->live()
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->disabled(function(Get $get){

                                        $warehouseId = $get('../../warehouse_id');
                                        
                                        if(!$warehouseId) {
                                            return true;
                                        }

                                        return !Product::whereHas('inventories', function($query) use ($warehouseId) {
                                            $query->where('warehouse_id', $warehouseId);
                                        })->exists();
                                    })
                                    ->relationship('product', 'description')
                                    ->options(function(Get $get): array{
                                        
                                        $warehouseId = $get('../../warehouse_id');
                                        
                                        $product = Product::whereHas('inventories', function($query) use ($warehouseId) {
                                            $query->where('warehouse_id', $warehouseId);
                                        })->pluck('description', 'id')->toArray();
                                        
                                        return $product;
                                    }),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->required()
                                    ->numeric()
                                    ->live()
                                    ->minValue(1)
                                    ->helperText(function(Get $get){
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        $stock = Inventory::query()
                                            ->where('product_id', $productId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->value('quantity') ?? 0;

                                        return "Stock disponible: {$stock}";

                                    })
                                    ->afterStateUpdated(function(Get $get, Set $set, $state){
                                        $productId = $get('product_id');
                                        $quantity = $get('quantity');

                                        $product = Product::query()->find($productId);

                                        $subTotal = ($quantity * ($product?->priceVenta ?? 0)) ?? 0;

                                        $set('sub_total', $subTotal);
                                    })
                                    ->rule(function(Get $get){
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        $stock = Inventory::query()
                                            ->where('product_id', $productId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->value('quantity') ?? 0;

                                        return "max:{$stock}";
                                    })
                                    ->validationMessages([
                                        'max' => 'La cantidad no puede ser mayor al stock disponible.',
                                    ]),

                                TextInput::make('sub_total')
                                    ->label('Sub Total')
                                    ->numeric()
                                    ->minValue(0),
                                
                            ])
                            ->afterStateUpdated(function(Get $get, Set $set, $state){
                                $total = 0;

                                foreach ($state as $item) {
                                    $productId = $item['product_id'];
                                    $quantity = $item['quantity'] ?? 0;

                                    $product = Product::query()->find($productId);

                                    $total += (float) $quantity * (float)($product?->priceVenta ?? 0);
                                    
                                }

                                $set('total', $total);
                            })
                    ]),

                Section::make('Resumen de la Orden')
                    ->hidden(function (Get $get): bool{
                            $isVisible = (empty($get('warehouse_id')) || (empty($get('customer_id'))));
                            
                            return $isVisible;
                    })
                    ->schema([
                        TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->readOnly()
                            ->required()
                            ->minValue(0)
                            ->placeholder('Total de la Venta General'),
                    ])
            ]);
    }
}
