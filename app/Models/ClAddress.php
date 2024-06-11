<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'cl_address_id',
        'cl_address_title',
        'cl_address_description',
        'cl_address_postcode',
        'cl_address_city',
        'cl_address_country',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->cl_address_id = 'AD24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function client()
    {
        return $this->belongsTo('App\Models\client');
    }
}
