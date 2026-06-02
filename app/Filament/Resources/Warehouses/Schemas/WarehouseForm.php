<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarehouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->columns(1)
            ->components([
                Section::make('Informacion de Almacenes')
                    ->description('Ingrese la informacion del almacén')
                    ->collapsible()
                    ->icon('heroicon-o-building-office')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Almacén')
                            ->required(),
                        TextInput::make('address')
                            ->label('Dirección del Almacén')
                            ->required(),
                    ]), 
            ]);
    }
}
