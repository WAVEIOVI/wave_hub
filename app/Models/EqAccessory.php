<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqAccessory extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_id',
        'accessory_id',
        'equipment_accessory_id',
        'option_id',
        'name',
        'description',
    ];

    public function Equipment()
    {
        return $this->belongsTo('App\Models\Equipment');
    }
}
