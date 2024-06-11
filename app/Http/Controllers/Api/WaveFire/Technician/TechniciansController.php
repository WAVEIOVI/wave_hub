<?php

namespace App\Http\Controllers\Api\WaveFire\Technician;

use App\Models\Technician;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;

class TechniciansController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Technician::class; // or "App\Models\Technician"
}
