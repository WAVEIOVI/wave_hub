<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Intervention;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class InCheckListsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Intervention::class; // or "App\Models\Intervention"

    protected $relation = 'checkList';
}
