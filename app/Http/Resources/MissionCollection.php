<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_missions' => $this->collection->count(),
            'total_pending_missions' => $this->collection->where('mission_status', 'pending')->count(),
            'total_inProgress_missions' => $this->collection->where('mission_status', 'in progress')->count(),
            'total_completed_missions' => $this->collection->where('mission_status', 'completed')->count(),
            'total_closure_missions' => $this->collection->where('mission_status', 'closure')->count(),
        ];
    }
}
