<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\EquipmentIntervention;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;

class EquipmentInterventionSuppliesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = EquipmentIntervention::class;

    /**
     * Relation name on the model
     */
    protected $relation = 'in_supplies';
}
