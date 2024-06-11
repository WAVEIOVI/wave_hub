<?php

namespace App\Observers;

use App\Models\EqAccessory;
use App\Models\Accessory;

class EqAccessoryObserver
{
    /**
     * Handle the EqAccessory "created" event.
     */
    public function created(EqAccessory $eqAccessory): void
    {
        $accessory = Accessory::find($eqAccessory->equipment_accessory_id);

        if ($accessory) {
            $eqAccessory->update([
                'accessory_id' => $accessory->accessory_id,
                'name' => $accessory->name,
                'description' => $accessory->description,
                'option_id' => $accessory->id,
            ]);
        }
    }

    /**
     * Handle the EqAccessory "updated" event.
     */
    public function updated(EqAccessory $eqAccessory): void
    {
        //
    }

    /**
     * Handle the EqAccessory "deleted" event.
     */
    public function deleted(EqAccessory $eqAccessory): void
    {
        //
    }

    /**
     * Handle the EqAccessory "restored" event.
     */
    public function restored(EqAccessory $eqAccessory): void
    {
        //
    }

    /**
     * Handle the EqAccessory "force deleted" event.
     */
    public function forceDeleted(EqAccessory $eqAccessory): void
    {
        //
    }
}
