<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'cl_contact_full_name',
        'cl_contact_post',
        'cl_contact_phone',
        'cl_contact_email',
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\client');
    }
}
