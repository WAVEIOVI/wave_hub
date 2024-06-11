<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
    protected $fillable = [
        'mission_folder_id',
        'intervention_id',
        'intervention_date',
        'intervention_status',
        'intervention_duration',
        'mission_frequency',
        // Resources 
        'team_leader',
        'team_driver',
        'team_members',
        'team_total',
        'vehicle_model',
        'fuel_transportation',
        'fuel_price_100km',
        'target_in_km',
        'accommodation_night',
        'accommodation',
        'meals_cost_member_day',
        'meals_food',
        'miscellaneous_expenses',
        'intervention_finance_total',
        'intervention_notes',
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
        // data Park
        'park', // Park ID To Fetch park
        'park_id',
        'park_type',
        'park_title',
        'park_address',
        'park_postcode',
        'park_city',
        'park_country',
        'total_equipment',
        'total_fire_extinguisher',
        'total_fire_hose',
        'total_others_equipment'
    ];

    public function mission()
    {
        return $this->belongsTo('App\Models\MissionFolder');
    }

    public function checkList()
    {
        return $this->hasOne('App\Models\InCheckList');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class)
            ->using(EquipmentIntervention::class)
            ->withPivot('inspection', 'raw_recharge', 'nitrogen_recharge', 'equipment_protection', 'equipment_status');
    }
}
