<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\AdditionalMaintenance;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class AdditionalMaintenancesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = AdditionalMaintenance::class; // or "App\Models\AdditionalMaintenance"

    public function searchableBy(): array
    {
        return ['additional_maintenance_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['additional_maintenance_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
