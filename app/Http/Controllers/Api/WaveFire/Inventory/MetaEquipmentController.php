<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Equipment;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\EquipmentCollection;


class MetaEquipmentController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Equipment::class; // or "App\Models\Equipment"
    protected $collectionResource = EquipmentCollection::class;

    public function filterableBy(): array
    {
        return ['equipment_category', 'equipment_model', 'equipment_status', 'client_name'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
