<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Client;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;



class ClParksController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Client::class; // or "App\Models\Client"

    protected $relation = 'parks';
}
