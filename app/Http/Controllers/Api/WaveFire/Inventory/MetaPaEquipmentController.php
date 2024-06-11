<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Park;
use Orion\Http\Controllers\RelationController;
use App\Http\Resources\EquipmentCollection;
use Orion\Concerns\DisableAuthorization;


class MetaPaEquipmentController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Park::class; // or "App\Models\Park"
    protected $collectionResource = EquipmentCollection::class;

    protected $relation = 'equipment';
}
