<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Cliente')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Razon Social')
                            ->extraInputAttributes([
                                'style' => 'text-transform: uppercase',
                            ])
                            ->required(),
                        TextInput::make('nit')
                            ->label('NIT')
                            ->unique(table: 'customers', column: 'nit')
                            ->validationMessages([
                                'unique' => 'El NIT ya está registrado.',
                            ])
                            ->required(),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->required(),
                        TextInput::make('zone')
                            ->label('Zona')
                            ->default(null),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->unique(table: 'customers', column: 'phone')
                            ->validationMessages([
                                'unique' => 'El teléfono ya está registrado.',
                            ])
                            ->default(null),
                        Select::make('level')
                            ->label('Categoria')
                            ->required()
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                            ]),
                        Toggle::make('is_active')
                            ->label('¿Está activo?')
                            ->required()
                            ->default(true),
                    ]),
            ]);
    }
}
