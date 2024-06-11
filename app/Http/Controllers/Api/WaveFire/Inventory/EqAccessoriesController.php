<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Equipment;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class EqAccessoriesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Equipment::class;
    protected $relation = 'eq_accessories';
}
