<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Accessory;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class AccessoriesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Accessory::class; // or "App\Models\Client"

    public function searchableBy(): array
    {
        return ['accessory_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['accessory_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
