<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_category_id',
        'model_id',
        'model_category_id',
        'category_name',
        'name',
        'description',
        'inspection',
        'raw_recharge',
        'nitrogen_recharge',
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'equipment_model_accessory');
    }

    public function pressures()
    {
        return $this->belongsToMany(Pressure::class, 'equipment_model_pressure');
    }

    public function protections()
    {
        return $this->belongsToMany(Protection::class, 'equipment_model_protection');
    }

    public function weights()
    {
        return $this->belongsToMany(Weight::class, 'equipment_model_weight');
    }

    public function maintenances()
    {
        return $this->belongsToMany(Maintenance::class, 'equipment_model_maintenance');
    }

    public function additional_maintenances()
    {
        return $this->belongsToMany(AdditionalMaintenance::class, 'equipment_model_additional_maintenance');
    }

    public function supplies()
    {
        return $this->belongsToMany(Supply::class, 'equipment_model_supply');
    }
}
