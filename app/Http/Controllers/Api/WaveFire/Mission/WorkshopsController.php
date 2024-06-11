<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Workshop;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;



class WorkshopsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Workshop::class; // or "App\Models\Workshop"

    public function searchableBy(): array
    {
        return [
            'mission_client_id',
            'client_name',
            'workshop_id',
            'workshop_leader',
            'team_members',
            'workshop_status',
        ];
    }
    public function filterableBy(): array
    {
        return ['workshop_leader', 'workshop_status', 'client_name'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
