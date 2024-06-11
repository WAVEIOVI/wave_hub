<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Supply;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class SuppliesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Supply::class; // or "App\Models\Supply"

    public function searchableBy(): array
    {
        return ['supply_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['supply_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
