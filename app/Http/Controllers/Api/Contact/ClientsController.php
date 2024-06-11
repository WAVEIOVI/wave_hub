<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Client;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class ClientsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Client::class; // or "App\Models\Client"

    public function searchableBy(): array
    {
        return ['client_id', 'client_name', 'client_email'];
    }
    public function filterableBy(): array
    {
        return ['client_type', 'client_activity', 'client_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
