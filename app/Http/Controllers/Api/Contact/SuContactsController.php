<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Supplier;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class SuContactsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Supplier::class; // or "App\Models\Supplier"

    protected $relation = 'contacts';

    public function searchableBy(): array
    {
        return ['su_contact_full_name', 'su_contact_post', 'su_contact_phone', 'su_contact_email'];
    }
}
