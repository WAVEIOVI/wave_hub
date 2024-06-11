<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'park_id',
        'area_id',
        'area_description',
        'area_accessibility',
        'area_classification',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->area_id = 'AR' . sprintf('%04d', self::count() + 1);
        });
    }

    public function Park()
    {
        return $this->belongsTo('App\Models\Park');
    }
}
