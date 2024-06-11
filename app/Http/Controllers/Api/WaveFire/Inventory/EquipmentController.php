<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Equipment;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;



class EquipmentController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Equipment::class; // or "App\Models\Equipment"

    public function searchableBy(): array
    {
        return [
            'qrc_id'
        ];
    }
    public function filterableBy(): array
    {
        return ['client_name', 'client_id', 'park_park_id'];
    }
}
