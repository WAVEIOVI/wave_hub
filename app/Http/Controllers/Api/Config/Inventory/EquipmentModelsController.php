<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\EquipmentModel;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class EquipmentModelsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = EquipmentModel::class; // or "App\Models\Client"

    public function searchableBy(): array
    {
        return ['model_id', 'model_category_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['model_id', 'model_category_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
