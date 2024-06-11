<?php

namespace App\Listeners;

use App\Models\PaArea;
use App\Events\ParkCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ParkCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ParkCreated $event)
    {
        // Create the first area
        $area1 = new PaArea([
            'park_id' => $event->park->id,
            'area_id' => 'AR0001',
            'area_description' => 'General',
            'area_accessibility' => 'unidentified',
            'area_classification' => 'unidentified',
        ]);
        $area1->save();

        // Create the second area
        $area2 = new PaArea([
            'park_id' => $event->park->id,
            'area_id' => 'AR0002',
            'area_description' => 'unidentified',
            'area_accessibility' => 'unidentified',
            'area_classification' => 'unidentified',
        ]);
        $area2->save();
    }
}
