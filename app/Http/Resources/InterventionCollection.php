<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InterventionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_interventions' => $this->collection->count(),
            'total_pending_interventions' => $this->collection->where('intervention_status', 'pending')->count(),
            'total_inProgress_interventions' => $this->collection->where('intervention_status', 'in progress')->count(),
            'total_completed_interventions' => $this->collection->where('intervention_status', 'completed')->count(),
            'total_closure_interventions' => $this->collection->where('intervention_status', 'closure')->count(),
        ];
    }
}
