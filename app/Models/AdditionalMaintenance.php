<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalMaintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'additional_maintenance_id',
        'name',
        'description',
    ];

    public function models()
    {
        return $this->belongsToMany(EquipmentModel::class, 'equipment_model_additional_maintenance');
    }
}
