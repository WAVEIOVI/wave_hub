<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Client;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class ClContactsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Client::class; // or "App\Models\Client"

    protected $relation = 'contacts';

    public function searchableBy(): array
    {
        return ['cl_contact_full_name', 'cl_contact_post', 'cl_contact_phone', 'cl_contact_email'];
    }
}
