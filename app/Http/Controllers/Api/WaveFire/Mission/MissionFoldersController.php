<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;



class MissionFoldersController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    public function searchableBy(): array
    {
        return [
            'mission_client_id',
            'client_name',
            'mission_id',
            'mission_type',
            'mission_frequency',
            'mission_status',
        ];
    }
    public function filterableBy(): array
    {
        return ['mission_type', 'mission_status', 'client_name'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
