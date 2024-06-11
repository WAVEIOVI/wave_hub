<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;
    protected $fillable = [
        'technician_id',
        'technician_name',
        'technician_status',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->technician_id = 'TECH' . sprintf('%02d', self::count() + 1);
        });
    }
}
