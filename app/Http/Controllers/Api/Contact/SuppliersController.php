<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Supplier;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class SuppliersController extends Controller
{
    use DisableAuthorization;
    /**
     * Fully-qualified model class name
     */
    protected $model = Supplier::class; // or "App\Models\Supplier"

    public function searchableBy(): array
    {
        return ['supplier_id', 'supplier_name', 'supplier_email'];
    }
    public function filterableBy(): array
    {
        return ['supplier_type', 'supplier_activity', 'supplier_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
