<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Maintenance;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class MaintenancesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Maintenance::class; // or "App\Models\Maintenance"

    public function searchableBy(): array
    {
        return ['maintenance_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['maintenance_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
