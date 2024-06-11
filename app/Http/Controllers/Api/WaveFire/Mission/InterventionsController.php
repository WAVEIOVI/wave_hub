<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\Intervention;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;



class InterventionsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Intervention::class; // or "App\Models\Intervention"

    public function searchableBy(): array
    {
        return [
            'mission_client_id',
            'client_name',
            'intervention_id',
            'team_leader',
            'team_members',
            'intervention_status',
            'park_address',
        ];
    }
    public function filterableBy(): array
    {
        return ['team_leader', 'intervention_status', 'client_name'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
