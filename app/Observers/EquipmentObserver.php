<?php

namespace App\Observers;

use App\Models\Equipment;

class EquipmentObserver
{
    /**
     * Handle the Equipment "created" event.
     */
    public function created(Equipment $equipment): void
    {
        //
    }

    /**
     * Handle the Equipment "updated" event.
     */
    public function updated(Equipment $equipment): void
    {
        //
    }

    /**
     * Handle the Equipment "deleted" event.
     */
    public function deleted(Equipment $equipment): void
    {
        //
    }

    /**
     * Handle the Equipment "restored" event.
     */
    public function restored(Equipment $equipment): void
    {
        //
    }

    /**
     * Handle the Equipment "force deleted" event.
     */
    public function forceDeleted(Equipment $equipment): void
    {
        //
    }
}
