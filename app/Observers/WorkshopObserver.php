<?php

namespace App\Observers;

use App\Models\Workshop;
use App\Models\MissionFolder;

class WorkshopObserver
{
    /**
     * Handle the Workshop "created" event.
     */
    public function created(Workshop $workshop): void
    {
        //
    }

    /**
     * Handle the Workshop "updated" event.
     */
    public function updated(Workshop $workshop)
    {
        // Find the related MissionFolder model
        $missionFolder = MissionFolder::where('id', $workshop->mission_folder_id)->first();

        if ($missionFolder) {
            // Update the mission_status field in the MissionFolder model
            $missionFolder->mission_status = $workshop->workshop_status;
            $missionFolder->save();
        }
    }

    /**
     * Handle the Workshop "deleted" event.
     */
    public function deleted(Workshop $workshop): void
    {
        //
    }

    /**
     * Handle the Workshop "restored" event.
     */
    public function restored(Workshop $workshop): void
    {
        //
    }

    /**
     * Handle the Workshop "force deleted" event.
     */
    public function forceDeleted(Workshop $workshop): void
    {
        //
    }
}
