<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Inventory;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        DB::transaction(function () {
            $this->record->load('orderProducts');

            $orderProducts = $this->record->orderProducts;

            foreach ($orderProducts as $orderProduct) {
                Inventory::query()
                    ->where('warehouse_id', $this->record->warehouse_id)
                    ->where('product_id', $orderProduct->product_id)
                    ->decrement('quantity', $orderProduct->quantity);
            }
        });
    }
}
