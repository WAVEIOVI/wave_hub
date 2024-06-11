<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Equipment;


class EquipmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => [
                'total_equipment' => Equipment::count(),
                'total_fire_extinguisher' => Equipment::where('equipment_category', 'fire extinguisher')->count(),
                'total_active_extinguisher' => Equipment::where('equipment_status', 'in service')->count(),
                'total_limited_use_extinguisher' => Equipment::where('equipment_status', 'limited use')->count(),
                'total_out_of_order_extinguisher' => Equipment::where('equipment_status', 'out of order')->count(),
                'total_workshop_extinguisher' => Equipment::where('equipment_status', 'workshop')->count(),
                'total_fire_hose' => Equipment::where('equipment_category', 'fire hose')->count(),
                'total_others_equipment' => Equipment::whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])->count(),
            ],
            'count' => [
                'equipment_per_park' => $this->collection->groupBy('park_id')
                    ->mapWithKeys(function ($group, $parkId) {
                        return [$parkId => $group->count()];
                    }),
                'fire_extinguisher_per_park' => $this->collection->where('equipment_category', 'fire extinguisher')->groupBy('park_id')
                    ->mapWithKeys(function ($group, $parkId) {
                        return [$parkId => $group->count()];
                    }),
                'fire_hose_per_park' => $this->collection->where('equipment_category', 'fire hose')->groupBy('park_id')
                    ->mapWithKeys(function ($group, $parkId) {
                        return [$parkId => $group->count()];
                    }),
                'others_equipment_per_park' => $this->collection->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])->groupBy('park_id')
                    ->mapWithKeys(function ($group, $parkId) {
                        return [$parkId => $group->count()];
                    }),
                'equipment_status_count' => $this->collection->groupBy('equipment_status')
                    ->map(function ($status) {
                        return $status->count();
                    }),
                'equipment_category_count' => $this->collection->groupBy('equipment_category')
                    ->map(function ($category) {
                        return $category->count();
                    }),
                'fire_extinguisher_model_count' => $this->collection->where('equipment_category', 'fire extinguisher')->groupBy('equipment_model')
                    ->map(function ($model) {
                        return $model->count();
                    }),
            ],
        ];
    }
}
