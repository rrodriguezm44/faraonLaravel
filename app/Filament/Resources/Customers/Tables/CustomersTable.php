<?php

namespace App\Filament\Resources\Customers\Tables;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Razon Social')
                    ->searchable(),
                TextColumn::make('nit')
                    ->label('NIT')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable(),
                TextColumn::make('zone')
                    ->label('Zona')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('level')
                    ->label('Categoría')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->alignCenter()
                    ->label('Estado'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->iconButton(),
                DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('¿Estas Seguro de Eliminar al Cliente?')
                ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('exportar_excel')
                    ->label('Exportar Excel')
                    ->fileName('clientes')
                    ->timeFormat('d-m-Y_H-i')
                    ->defaultFormat('xlsx')
                    ->icon('heroicon-o-table-cells')
                    ->color('success'),
                FilamentExportHeaderAction::make('exportar_pdf')
                    ->label('Exportar PDF')
                    ->fileName('clientes')
                    ->timeFormat('d-m-Y_H-i')
                    ->defaultFormat('pdf')
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->extraViewData([
                        'companyName' => 'Faraon SRL',
                        'reportTitle' => 'Reporte de Clientes',
                        'exporData' => now()->format('d/m/Y H:i'),
                    ]),
                
            ]);
    }
}
