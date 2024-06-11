<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InCheckList extends Model
{
    use HasFactory;
    protected $fillable = [
        'intervention_id',
        'mission_documents',
        'team_documents',
        'ppe',
        'emergency_kit',
        'vehicle_maintenance',
        'materials_and_parts',
        'tools_and_equipment',
    ];

    public function intervention()
    {
        return $this->belongsTo('App\Models\Intervention');
    }
}
