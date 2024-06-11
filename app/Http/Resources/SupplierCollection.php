<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_suppliers' => $this->collection->count(),
            'active_suppliers' => $this->collection->where('supplier_status', 'active')->count(),
            'inactive_suppliers' => $this->collection->where('supplier_status', 'inactive')->count(),
            'pending_suppliers' => $this->collection->where('supplier_status', 'pending')->count(),
        ];
    }
}
