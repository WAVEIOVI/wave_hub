<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Supplier;
use Orion\Http\Controllers\Controller;
use App\Http\Resources\SupplierCollection;
use Orion\Concerns\DisableAuthorization;


class MetaSuppliersController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Supplier::class; // or "App\Models\Supplier"
    protected $collectionResource = SupplierCollection::class;


    public function filterableBy(): array
    {
        return ['supplier_type', 'supplier_activity', 'supplier_status'];
    }
}
