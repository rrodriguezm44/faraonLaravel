<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\User;
use Filament\Notifications\Notification;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
       $superAdmins = User::role('super_admin')->get();

       Notification::make()
       ->title('Categoria creada con Exito')
       ->body("La categoria {$category->name} ha sido creada con exito.")
       ->success()
       ->icon('heroicon-o-check')
       ->sendToDatabase($superAdmins);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
