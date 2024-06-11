<?php

namespace App\Observers;

use App\Models\MissionEvent;
use Carbon\Carbon;

class MissionEventObserver
{
    /**
     * Handle the MissionEvent "created" event.
     */
    public function created(MissionEvent $missionEvent): void
    {
        //
    }

    /**
     * Handle the MissionEvent "updated" event.
     *
     * @param  \App\Models\MissionEvent  $missionEvent
     * @return void
     */
    public function updated(MissionEvent $missionEvent)
    {
        // Check if the event is being updated from pending to completed
        if ($missionEvent->wasChanged('calendar') && $missionEvent->calendar === 'completed') {
            // Check if mission_frequency is not "none"
            if ($missionEvent->mission_frequency !== 'none') {
                // Check if the event has not been cloned before
                if (!$missionEvent->cloned) {
                    $clonedMissionEvent = $missionEvent->replicate();

                    // Calculate the new start and end dates based on mission frequency
                    $start = Carbon::parse($missionEvent->start);
                    $end = Carbon::parse($missionEvent->end);
                    if ($missionEvent->mission_frequency === 'half-yearly') {
                        $clonedMissionEvent->start = $start->addMonths(6);
                        $clonedMissionEvent->end = $end->addMonths(6);
                    } elseif ($missionEvent->mission_frequency === 'yearly') {
                        $clonedMissionEvent->start = $start->addMonths(12);
                        $clonedMissionEvent->end = $end->addMonths(12);
                    }

                    // Update calendar to "prevision" for the cloned event
                    $clonedMissionEvent->calendar = 'prevision';

                    // Update title of the cloned event
                    $clonedMissionEvent->title = 'Next Mission of ' . $missionEvent->title;

                    // Set the flag to indicate that the event has been cloned
                    $missionEvent->cloned = true;

                    // Save the cloned mission event
                    $clonedMissionEvent->save();
                }
            }
            $missionEvent->save();
        }
    }

    /**
     * Handle the MissionEvent "deleted" event.
     */
    public function deleted(MissionEvent $missionEvent): void
    {
        //
    }

    /**
     * Handle the MissionEvent "restored" event.
     */
    public function restored(MissionEvent $missionEvent): void
    {
        //
    }

    /**
     * Handle the MissionEvent "force deleted" event.
     */
    public function forceDeleted(MissionEvent $missionEvent): void
    {
        //
    }
}
