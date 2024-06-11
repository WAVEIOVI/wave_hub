<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkshopCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_workshops' => $this->collection->count(),
            'total_pending_workshops' => $this->collection->where('workshop_status', 'pending')->count(),
            'total_inProgress_workshops' => $this->collection->where('workshop_status', 'in progress')->count(),
            'total_completed_workshops' => $this->collection->where('workshop_status', 'completed')->count(),
            'total_closure_workshops' => $this->collection->where('workshop_status', 'closure')->count(),
        ];
    }
}
