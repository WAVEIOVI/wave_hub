<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\MissionCollection;



class MetaMissionFoldersController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"
    protected $collectionResource = MissionCollection::class;
}
