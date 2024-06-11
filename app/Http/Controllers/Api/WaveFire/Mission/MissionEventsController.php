<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionEvent;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\MissionEventResource;


class MissionEventsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionEvent::class; // or "App\Models\MissionEvent"

    public function filterableBy(): array
    {
        return ['calendar'];
    }
    protected $resource = MissionEventResource::class;

    public function beforeSave(Request $request, $MissionEvent)
    {
        if (isset($request->extendedProps['calendar'])) {
            $MissionEvent->calendar = $request->extendedProps['calendar'];
        }
        if (isset($request->extendedProps['city'])) {
            $MissionEvent->city = $request->extendedProps['city'];
        }
        if (isset($request->extendedProps['mission_type'])) {
            $MissionEvent->mission_type = $request->extendedProps['mission_type'];
        }
        if (isset($request->extendedProps['client'])) {
            $MissionEvent->client = $request->extendedProps['client'];
        }
    }
}
