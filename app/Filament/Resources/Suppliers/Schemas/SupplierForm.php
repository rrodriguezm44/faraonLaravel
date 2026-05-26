<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Proveedor')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Proveedor')
                            ->placeholder('Ej: NOMBRE PROVEEDOR')
                            ->required(),
                        TextInput::make('contact_info')
                            ->label('Persona de Contacto')
                            ->placeholder('Ej: NOMBRE CONTACTO'),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->placeholder('Ej: DIRECCIÓN PROVEEDOR'),
                        TextInput::make('nit')
                            ->label('NIT')
                            ->numeric()
                             ->minValue(0)
                             ->placeholder('Ej: 123456789'),
                        Toggle::make('is_active')
                            ->label('¿Está activo?')
                            ->required()
                            ->default(true),
                    ]),
            ]);
    }
}
