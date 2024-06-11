<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionFolder extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'mission_id',
        'mission_date',
        'mission_type',
        'mission_duration',
        'mission_frequency',
        'mission_status',
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
        'mission_finance_total',
        'mission_notes',
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
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->mission_id = 'MF24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function Client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function intervention()
    {
        return $this->hasOne('App\Models\Intervention');
    }
    public function workshop()
    {
        return $this->hasOne('App\Models\Workshop');
    }
}
