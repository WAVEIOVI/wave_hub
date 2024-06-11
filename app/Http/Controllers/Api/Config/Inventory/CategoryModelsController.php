<?php


namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\EquipmentCategory;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class CategoryModelsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = EquipmentCategory::class; // or "App\Models\Client"

    protected $relation = 'models';

    public function searchableBy(): array
    {
        return ['category_id', 'name'];
    }
}
