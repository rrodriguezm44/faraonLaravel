<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Resources\Categories\Schemas\CategoryForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informacion del Producto')
                    ->columns(3)
                    ->schema([
                        Toggle::make('is_active')
                            ->columnSpan(3)
                            ->label('¿Está activo?')
                            ->required()
                            ->default(true),
                        TextInput::make('code')
                            ->label('Código')
                            ->placeholder('Ej: PROD-001')
                            ->required()
                            ->alphaDash(),
                        TextInput::make('description')
                            ->label('Nombre del producto')
                            ->placeholder('Ej: NOMBRE MEDICAMENTO')
                            ->required(),
                        TextInput::make('document')
                            ->label('Documento de Compra')
                            ->placeholder('Ej: FACT-001, REC-001'),
                        TextInput::make('priceCompra')
                            ->label('Precio de Compra')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Bs.')
                            ->required(),
                        TextInput::make('porcentual')
                            ->label('Porcentual de Incremento')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('priceVenta')
                            ->label('Precio de Venta')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Bs.')
                            ->required(),
                        TextInput::make('priceFeria')
                            ->label('Precio de Feria')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Bs.')
                            ->required(),
                        TextInput::make('priceOferta')
                            ->label('Precio de Oferta')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Bs.')
                            ->required(),
                        TextInput::make('descuento')
                            ->label('Descuento')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('unidad_medida')
                            ->label('Unidad de Medida')
                            ->placeholder('Ej: PQT, CAJ, GRM'),
                        Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->createOptionForm(CategoryForm::create())
                            ->createOptionModalHeading('Crear Nueva Categoria'),

                        Select::make('sub_category_id')
                            ->label('SubCategoría')
                            ->relationship('subCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('supplier_id')
                            ->label('Proveedor')
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),
            ]);
    }
}
