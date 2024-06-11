<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Park;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class PaAreasController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Park::class; // or "App\Models\Park"

    protected $relation = 'pa_areas';
}
