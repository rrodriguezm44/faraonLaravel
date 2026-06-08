<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Usuario')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->required(),
                        
                        TextInput::make('password')
                        ->label('Contraseña')
                        ->password()
                        ->required(fn(string $context) => $context === 'create')
                        ->dehydrated(fn($state) => filled($state)),
                        Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload(),
                        Toggle::make('is_active')
                            ->label('¿Está activo?')
                            ->required()
                            ->default(true),
                    ]),
            ]);
    }
}
