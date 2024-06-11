<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'su_address_id',
        'su_address_title',
        'su_address_description',
        'su_address_postcode',
        'su_address_city',
        'su_address_country',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->su_address_id = 'AD24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
