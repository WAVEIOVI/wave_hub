<?php

namespace App\Http\Controllers\Api\Config\Inventory;

use App\Models\Protection;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class ProtectionsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Protection::class; // or "App\Models\Protection"

    public function searchableBy(): array
    {
        return ['protection_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['protection_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
