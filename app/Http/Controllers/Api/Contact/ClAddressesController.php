<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Client;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class ClAddressesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Client::class; // or "App\Models\Client"

    protected $relation = 'addresses';

    public function searchableBy(): array
    {
        return ['cl_address_id', 'cl_address_title', 'cl_address_description', 'cl_address_postcode', 'cl_address_city', 'cl_address_country'];
    }
}
