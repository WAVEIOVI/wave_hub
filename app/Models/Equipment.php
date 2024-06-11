<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'park_id',
        'qrc_id',
        'internal_id',
        'serial_number',
        'model_id',
        'equipment_category_id',
        'equipment_category',
        'equipment_model_id',
        'equipment_model',
        'equipment_weight_unit',
        'equipment_weight_value',
        'equipment_pressure_id',
        'equipment_pressure',
        'equipment_protection_id',
        'equipment_protection',
        'mfg_date',
        'installation_date',
        'equipment_brand',
        'made_in',
        'ce_marking',
        'pictogram',
        'standard_sign',
        'numbering',
        'accessories_availability',
        'equipment_fixation',
        'equipment_status',
        // data from park
        'park_park_id',
        'client_id',
        'client_name',
        // data from area
        'area_id',
        'equipment_area',
        'equipment_area_description',
        'equipment_area_accessibility',
        'equipment_area_classification',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function Park()
    {
        return $this->belongsTo('App\Models\Park');
    }

    public function eq_accessories()
    {
        return $this->hasMany('App\Models\EqAccessory');
    }

    public function interventions()
    {
        return $this->belongsToMany(Intervention::class)
            ->using(EquipmentIntervention::class)
            ->withPivot('inspection', 'raw_recharge', 'nitrogen_recharge', 'equipment_protection', 'equipment_status');
    }
    public function workshops()
    {
        return $this->belongsToMany(Workshop::class)
            ->withPivot('inspection', 'raw_recharge', 'nitrogen_recharge', 'maintenance', 'additional_maintenance', 'supply', 'standard_sign', 'numbering', 'pictogram', 'equipment_fixation', 'accessories', 'equipment_status');
    }
}
