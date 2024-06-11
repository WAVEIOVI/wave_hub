<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Pressure;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class PressuresController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Pressure::class; // or "App\Models\Client"

    public function searchableBy(): array
    {
        return ['pressure_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['pressure_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
