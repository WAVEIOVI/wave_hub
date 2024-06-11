<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Client;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;
use App\Http\Resources\ClientCollection;

class MetaClientsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Client::class; // or "App\Models\Client"
    protected $collectionResource = ClientCollection::class;


    public function filterableBy(): array
    {
        return ['client_type', 'client_activity', 'client_status'];
    }
}
