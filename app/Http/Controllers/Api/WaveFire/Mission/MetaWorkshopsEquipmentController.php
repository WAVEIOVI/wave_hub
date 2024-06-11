<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Workshop;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\RecapMissionCollection;


class MetaWorkshopsEquipmentController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Workshop::class; // or "App\Models\Workshop"

    protected $relation = 'equipment';
    protected $collectionResource = RecapMissionCollection::class;
    protected $pivotFillable = [
        'inspection',
        'raw_recharge',
        'nitrogen_recharge',
        'maintenance',
        'additional_maintenance',
        'supply',
        'standard_sign',
        'numbering',
        'pictogram',
        'equipment_fixation',
        'accessories',
        'equipment_status'
    ];

    public function searchableBy(): array
    {
        return [
            'qrc_id',
            'internal_id',
            'serial_number',
            'equipment_category',
            'equipment_model',
            'equipment_weight',
            'equipment_pressure',
            'mfg_date',
            'installation_date',
            'equipment_brand',
            'equipment_area'
        ];
    }
    public function filterableBy(): array
    {
        return ['equipment_category', 'equipment_model', 'equipment_status', 'pivot.equipment_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
