<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'client_name',
        'client_website',
        'main_phone_number',
        'client_email',
        'address',
        'postcode',
        'city',
        'country',
        'client_type',
        'client_activity',
        'client_status',
        'tax_id',
        'rne_id',
        'has_vat_exemption_cert',
        'vat_exemption_cert_id',
        'vat_exemption_start',
        'vat_exemption_end',
        'company_form_legal',
        'company_capital',
        'created_date',
        'bank_name',
        'bank_agency',
        'bank_rib',
        'payment_terms',
        'client_note',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->client_id = 'CL24' . sprintf('%04d', self::count() + 1);
        });
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\ClAddress');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\ClContact');
    }
    public function parks()
    {
        return $this->hasMany('App\Models\Park');
    }
    public function missions()
    {
        return $this->hasMany('App\Models\Mission');
    }
}
