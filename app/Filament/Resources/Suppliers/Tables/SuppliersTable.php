<?php

namespace App\Filament\Resources\Suppliers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class SuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Proveedor')
                    ->searchable()
                    ->sortable()
                    ->size(TextSize::ExtraSmall),
                TextColumn::make('razons')
                    ->label('Razón Social')
                    ->searchable()
                    ->sortable()
                    ->size(TextSize::ExtraSmall),
                TextColumn::make('contact_info')
                    ->label('Persona de Contacto')
                    ->searchable()
                    ->sortable()
                    ->size(TextSize::ExtraSmall),
                TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable()
                    ->sortable()
                    ->size(TextSize::ExtraSmall),
                TextColumn::make('nit')
                    ->label('NIT')
                    ->searchable()
                    ->sortable()
                    ->size(TextSize::ExtraSmall),
                TextColumn::make('is_active')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'Activo' : 'Inactivo')
                    ->color(fn (bool $state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
