<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\EquipmentCategory;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class EquipmentCategoriesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = EquipmentCategory::class; // or "App\Models\EquipmentCategory"

    public function searchableBy(): array
    {
        return ['category_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['category_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
