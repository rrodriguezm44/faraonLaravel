<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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
                        // Select::make('user_id')
                        //     ->relationship('user', 'name')
                        //     ->default(null),
                        // TextInput::make('total')
                        //     ->required()
                        //     ->numeric()
                        //     ->default(0.0),
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
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->searchable()
                                    ->preload()
                                    ->relationship('product', 'description'),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1),
                                TextInput::make('sub_total')
                                    ->label('Sub Total')
                                    ->numeric()
                                    ->default(0.0),
                                
                            ])
                    ]),
            ]);
    }
}
