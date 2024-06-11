<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;
    protected $fillable = [
        'weight_id',
        'value',
        'unit',
    ];

    public function models()
    {
        return $this->belongsToMany(EquipmentModel::class, 'equipment_model_weight');
    }
}
