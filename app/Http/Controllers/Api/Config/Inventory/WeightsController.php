<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Weight;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class WeightsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Weight::class; // or "App\Models\weight"

    public function searchableBy(): array
    {
        return ['weight_id', 'value', 'unit'];
    }
    public function filterableBy(): array
    {
        return ['weight_id', 'unit'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
