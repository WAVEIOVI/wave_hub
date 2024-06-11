<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
    ];


    public function models()
    {
        return $this->hasMany('App\Models\EquipmentModel');
    }
}
