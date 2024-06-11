<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'mission_id',
        'mission_frequency',
        'start',
        'end',
        'all_day',
        'extendedProps',
        'calendar',
        'mission_type',
        'city',
        'client',
    ];

    /**
     * Cast extended_props attribute to JSON for proper storage and retrieval.
     *
     * @var array
     */

    protected $casts = [
        'extendedProps' => 'array',
        'start' => 'datetime:Y-m-d\TH:i:s.u\Z',
        'end' => 'datetime:Y-m-d\TH:i:s.u\Z',
    ];
}
