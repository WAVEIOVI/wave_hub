<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Intervention;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\InterventionCollection;



class MetaInterventionsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Intervention::class; // or "App\Models\Intervention"
    protected $collectionResource = InterventionCollection::class;
}
