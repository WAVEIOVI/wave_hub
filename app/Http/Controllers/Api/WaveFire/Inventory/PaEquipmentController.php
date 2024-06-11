<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Park;
use App\Models\PaArea;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class PaEquipmentController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Park::class; // or "App\Models\Park"

    protected $relation = 'equipment';

    public function searchableBy(): array
    {
        return [
            'qrc_id',
            'internal_id',
            'serial_number',
            'equipment_category_id',
            'equipment_category',
            'equipment_model_id',
            'equipment_model',
            'equipment_weight_value',
            'equipment_weight_unit',
            'equipment_pressure_id',
            'equipment_pressure',
            'mfg_date',
            'installation_date',
            'equipment_brand',
            'equipment_area'
        ];
    }
    public function filterableBy(): array
    {
        return ['equipment_category', 'equipment_model', 'equipment_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
    protected function beforeSave(Request $request, $park, $equipment)
    {
        $park = Park::find($request->route('park'));
        $equipment->park_park_id = $park->park_id;
        $equipment->client_id = $park->park_client_id;
        $equipment->client_name = $park->client_name;

        $pa_area = PaArea::find($request->input('area_id'));
        $equipment->equipment_area = $pa_area->area_id;
        $equipment->equipment_area_description = $pa_area->area_description;
        $equipment->equipment_area_accessibility = $pa_area->area_accessibility;
        $equipment->equipment_area_classification = $pa_area->area_classification;
    }
}
