<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'park_client_id',
        'park_id',
        'client_name',
        'park_type',
        'park_title',
        'park_address',
        'park_postcode',
        'park_city',
        'park_country',
    ];
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->park_id = 'FP24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function equipment()
    {
        return $this->hasMany('App\Models\Equipment');
    }

    public function pa_areas()
    {
        return $this->hasMany('App\Models\PaArea');
    }
}
