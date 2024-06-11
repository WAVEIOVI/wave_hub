<?php

namespace App\Observers;

use App\Models\Intervention;
use App\Models\InCheckList;
use App\Models\MissionFolder;

class InterventionObserver
{
    /**
     * Handle the Intervention "created" event.
     */
    public function created(Intervention $intervention): void
    {
        $InCheckList = new InCheckList([
            'intervention_id' => $intervention->id,
        ]);
        $intervention->checkList()->save($InCheckList);
    }

    /**
     * Handle the Intervention "updated" event.
     */
    public function updated(Intervention $intervention)
    {
        // Find the related MissionFolder model
        $missionFolder = MissionFolder::where('id', $intervention->mission_folder_id)->first();

        if ($missionFolder) {
            // Update the mission_status field in the MissionFolder model
            $missionFolder->mission_status = $intervention->intervention_status;
            $missionFolder->save();
        }
    }

    /**
     * Handle the Intervention "deleted" event.
     */
    public function deleted(Intervention $intervention): void
    {
        //
    }

    /**
     * Handle the Intervention "restored" event.
     */
    public function restored(Intervention $intervention): void
    {
        //
    }

    /**
     * Handle the Intervention "force deleted" event.
     */
    public function forceDeleted(Intervention $intervention): void
    {
        //
    }
}
