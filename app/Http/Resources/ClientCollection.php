<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_clients' => $this->collection->count(),
            'active_clients' => $this->collection->where('client_status', 'active')->count(),
            'inactive_clients' => $this->collection->where('client_status', 'inactive')->count(),
            'pending_clients' => $this->collection->where('client_status', 'pending')->count(),
        ];
    }
}
