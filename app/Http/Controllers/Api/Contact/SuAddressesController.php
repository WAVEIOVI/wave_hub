<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Supplier;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class SuAddressesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Supplier::class; // or "App\Models\Supplier"

    protected $relation = 'addresses';

    public function searchableBy(): array
    {
        return ['su_address_id', 'su_address_title', 'su_address_description', 'su_address_postcode', 'su_address_city', 'su_address_country'];
    }
}
