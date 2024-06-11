<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\EquipmentModel;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class ModelsAccessoriesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = EquipmentModel::class; // or "App\Models\EquipmentModel"

    protected $relation = 'accessories';

    public function searchableBy(): array
    {
        return [
            'category_id',
            'model_category_id',
            'name',
            'description',
        ];
    }
    public function filterableBy(): array
    {
        return [
            'category_id',
            'model_category_id',
            'name',
            'description',
        ];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
