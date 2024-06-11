<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protection extends Model
{
    use HasFactory;
    protected $fillable = [
        'protection_id',
        'name',
        'description',
    ];

    public function models()
    {
        return $this->belongsToMany(EquipmentModel::class, 'equipment_model_protection');
    }
}
