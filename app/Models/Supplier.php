<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'supplier_name',
        'supplier_website',
        'main_phone_number',
        'supplier_email',
        'address',
        'postcode',
        'city',
        'country',
        'supplier_type',
        'supplier_activity',
        'supplier_status',
        'tax_id',
        'rne_id',
        'company_form_legal',
        'company_capital',
        'created_date',
        'bank_name',
        'bank_agency',
        'bank_rib',
        'payment_terms',
        'supplier_note',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->supplier_id = 'SU24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\SuAddress');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\SuContact');
    }
}
