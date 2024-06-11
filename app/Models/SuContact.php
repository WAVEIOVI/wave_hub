<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'su_contact_full_name',
        'su_contact_post',
        'su_contact_phone',
        'su_contact_email',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
