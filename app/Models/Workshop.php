<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;
    protected $fillable = [
        'mission_folder_id',
        'workshop_id',
        'workshop_date',
        'workshop_duration',
        'mission_frequency',
        'workshop_status',
        // Resources 
        'workshop_leader',
        'team_members',
        'workshop_notes',
        // data client
        'mission_client_id',
        'client_name',
        'client_website',
        'main_phone_number',
        'client_email',
        'address',
        'postcode',
        'city',
        'country',
        'total_equipment',
        'total_fire_extinguisher',
        'total_fire_hose',
        'total_others_equipment'
    ];

    public function mission()
    {
        return $this->belongsTo('App\Models\MissionFolder');
    }
    public function equipment()
    {
        return $this->belongsToMany(Equipment::class)
            ->withPivot('inspection', 'raw_recharge', 'nitrogen_recharge', 'maintenance', 'additional_maintenance', 'supply', 'standard_sign', 'numbering', 'pictogram', 'equipment_fixation', 'accessories', 'equipment_status');
    }
}
