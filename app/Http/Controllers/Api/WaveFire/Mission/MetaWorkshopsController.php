<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Workshop;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\WorkshopCollection;



class MetaWorkshopsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Workshop::class; // or "App\Models\Workshop"
    protected $collectionResource = WorkshopCollection::class;
}
