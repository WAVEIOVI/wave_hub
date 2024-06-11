<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WoEquipmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_equipment' => $this->collection->count(),
                'total_fire_extinguishers' => $this->collection->where('equipment_category', 'fire extinguisher')->count(),
                'total_fire_hoses' => $this->collection->where('equipment_category', 'fire hose')->count(),
                'total_others_equipment' => $this->collection->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])->count(),
                'total_equipment_by_category' => $this->collection
                    ->groupBy('equipment_category')
                    ->map->count(),
                'total_fire_extinguishers_by_model' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->groupBy('equipment_model')
                    ->map->count(),
                'equipment_by_status' => $this->collection
                    ->groupBy(function ($item) {
                        return $item['pivot']['equipment_status'];
                    })
                    ->map->count(),
                'inspected_equipment' => $this->collection
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_fire_extinguisher' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_others_equipment' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'] . ' ' . $item['equipment_weight'];
                    })
                    ->map->count(),
                'inspected_fire_hose_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'];
                    })
                    ->map->count(),
                'inspected_others_equipment' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'];
                    })
                    ->map->count(),
                'raw_recharged_fire_extinguisher_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->count(),
                'raw_recharged_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'] . ' ' . $item['equipment_weight'];
                    })
                    ->map->count(),
                'nitrogen_recharged_fire_extinguisher_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('equipment_pressure', 'permanent pressure')
                    ->where('pivot.nitrogen_recharge', 'nitrogen charged')
                    ->count(),
                'recharged_sparklet_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('equipment_pressure', 'auxiliary pressure')
                    ->where('pivot.nitrogen_recharge', 'nitrogen charged')
                    ->count(),
                'standard_sign_equipment' => $this->collection
                    ->where('pivot.standard_sign', 'available')
                    ->count(),
                'standard_sign_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.standard_sign', 'available')
                    ->groupBy('equipment_model')
                    ->map->count(),
                'standard_sign_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.standard_sign', 'available')
                    ->count(),
                'numbered_equipment' => $this->collection
                    ->where('pivot.numbering', 'available')
                    ->count(),
                'pictogram_equipment' => $this->collection
                    ->where('pivot.pictogram', 'available')
                    ->count(),
                'pictogram_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.pictogram', 'available')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'] . ' ' . $item['equipment_weight'];
                    })
                    ->map->count(),
                'pictogram_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.pictogram', 'available')
                    ->count(),
                'fixed_equipment' => $this->collection
                    ->where('pivot.equipment_fixation', 'available')
                    ->count(),
                'fixed_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.equipment_fixation', 'available')
                    ->groupBy('equipment_model')
                    ->map->count(),
                'fixed_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.equipment_fixation', 'available')
                    ->count(),
                'box_equipment' => $this->collection
                    ->where('pivot.accessories', 'box')
                    ->count(),
                'box_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.accessories', 'box')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'] . ' ' . $item['equipment_weight'];
                    })
                    ->map->count(),
                'box_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.accessories', 'box')
                    ->groupBy('equipment_model')
                    ->map->count(),
                'cover_equipment' => $this->collection
                    ->where('pivot.accessories', 'cover')
                    ->count(),
                'cover_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.accessories', 'cover')
                    ->groupBy(function ($item) {
                        return $item['equipment_model'] . ' ' . $item['equipment_weight'];
                    })
                    ->map->count(),
                'cover_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.accessories', 'cover')
                    ->groupBy('equipment_model')
                    ->map->count(),
                'maintenance_counts' => $this->getMaintenanceCounts(),
                'maintenance_fire_extinguisher_counts' => $this->getMaintenanceFireExtinguisherCounts(),
                'maintenance_fire_hose_counts' => $this->getMaintenanceFireHoseCounts(),
                'maintenance_others_equipment_counts' => $this->getMaintenanceOthersEquipmentCounts(),

                'additional_maintenance_counts' => $this->getAdditionalMaintenanceCounts(),
                'additional_maintenance_fire_extinguisher_counts' => $this->getAdditionalMaintenanceFireExtinguisherCounts(),
                'additional_maintenance_fire_hose_counts' => $this->getAdditionalMaintenanceFireHoseCounts(),
                'additional_maintenance_others_equipment_counts' => $this->getAdditionalMaintenanceOthersEquipmentCounts(),

                'supply_counts' => $this->getSupplyCounts(),
                'supply_fire_extinguisher_counts' => $this->getSupplyFireExtinguisherCounts(),
                'supply_fire_hose_counts' => $this->getSupplyFireHoseCounts(),
                'supply_others_equipment_counts' => $this->getSupplyOthersEquipmentCounts(),

                'total_raw_material_for_fire_extinguishers' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->groupBy(function ($item) {
                        return explode(' ', $item['equipment_model'])[0]; // Group by model only
                    })
                    ->map(function ($items) {
                        return $items->sum(function ($item) {
                            return $item['equipment_weight'];
                        });
                    })
                    ->toArray(),
            ],
        ];
    }

    protected function getMaintenanceCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $maintenance = json_decode($item['pivot']['maintenance'], true);

            foreach ($maintenance as $activity) {
                if (isset($maintenanceCounts[$activity])) {
                    $maintenanceCounts[$activity]++;
                } else {
                    $maintenanceCounts[$activity] = 1;
                }
            }
        });

        return $maintenanceCounts;
    }
    protected function getMaintenanceFireExtinguisherCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            if ($item['equipment_category'] === 'fire extinguisher') {
                $maintenance = json_decode($item['pivot']['maintenance'], true);
                $model = $item['equipment_model'];
                $weight = $item['equipment_weight'];

                foreach ($maintenance as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' ' . $weight . ' kg ' . $activity;

                    if (isset($maintenanceCounts[$key])) {
                        $maintenanceCounts[$key]++;
                    } else {
                        $maintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $maintenanceCounts;
    }
    protected function getMaintenanceFireHoseCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            if ($item['equipment_category'] === 'fire hose') {
                $maintenance = json_decode($item['pivot']['maintenance'], true);
                $model = $item['equipment_model'];
                $weight = $item['equipment_weight'];

                foreach ($maintenance as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' ' . $weight . ' ' . $activity;

                    if (isset($maintenanceCounts[$key])) {
                        $maintenanceCounts[$key]++;
                    } else {
                        $maintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getMaintenanceOthersEquipmentCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $category = $item['equipment_category'];

            // Check if the category is not 'fire hose' or 'fire extinguisher'
            if ($category !== 'fire hose' && $category !== 'fire extinguisher') {
                $maintenance = json_decode($item['pivot']['maintenance'], true);
                $model = $category;

                foreach ($maintenance as $activity) {
                    // Group by equipment category and activity
                    $key = $item['location'] . ' ' . $model . ' - ' . $activity;

                    if (isset($maintenanceCounts[$key])) {
                        $maintenanceCounts[$key]++;
                    } else {
                        $maintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getAdditionalMaintenanceCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $additionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);

            foreach ($additionalMaintenance as $activity) {
                if (isset($additionalMaintenanceCounts[$activity])) {
                    $additionalMaintenanceCounts[$activity]++;
                } else {
                    $additionalMaintenanceCounts[$activity] = 1;
                }
            }
        });

        return $additionalMaintenanceCounts;
    }
    protected function getAdditionalMaintenanceFireExtinguisherCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field and count occurrences
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            if ($item['equipment_category'] === 'fire extinguisher') {
                $additionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                $model = $item['equipment_model'];

                foreach ($additionalMaintenance as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' ' . ' ' . $activity;

                    if (isset($additionalMaintenanceCounts[$key])) {
                        $additionalMaintenanceCounts[$key]++;
                    } else {
                        $additionalMaintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAdditionalMaintenanceFireHoseCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field and count occurrences
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            if ($item['equipment_category'] === 'fire hose') {
                $additionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                $model = $item['equipment_model'];

                foreach ($additionalMaintenance as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' ' . ' ' . $activity;

                    if (isset($additionalMaintenanceCounts[$key])) {
                        $additionalMaintenanceCounts[$key]++;
                    } else {
                        $additionalMaintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAdditionalMaintenanceOthersEquipmentCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $category = $item['equipment_category'];

            // Check if the category is not 'fire hose' or 'fire extinguisher'
            if ($category !== 'fire hose' && $category !== 'fire extinguisher') {
                $additionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                $model = $category;

                foreach ($additionalMaintenance as $activity) {
                    // Group by equipment category and activity
                    $key = $item['location'] . ' ' . $model . ' - ' . $activity;

                    if (isset($additionalMaintenanceCounts[$key])) {
                        $additionalMaintenanceCounts[$key]++;
                    } else {
                        $additionalMaintenanceCounts[$key] = 1;
                    }
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getSupplyCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $supply = json_decode($item['pivot']['supply'], true);

            foreach ($supply as $activity) {
                if (isset($supplyCounts[$activity])) {
                    $supplyCounts[$activity]++;
                } else {
                    $supplyCounts[$activity] = 1;
                }
            }
        });

        return $supplyCounts;
    }

    protected function getSupplyFireExtinguisherCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field and count occurrences
        $this->collection->each(function ($item) use (&$supplyCounts) {
            if ($item['equipment_category'] === 'fire extinguisher') {
                $supply = json_decode($item['pivot']['supply'], true);
                $model = $item['equipment_model'];
                $weight = $item['equipment_weight'];

                foreach ($supply as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' ' . $weight . ' kg ' . $activity;

                    if (isset($supplyCounts[$key])) {
                        $supplyCounts[$key]++;
                    } else {
                        $supplyCounts[$key] = 1;
                    }
                }
            }
        });

        return $supplyCounts;
    }
    protected function getSupplyFireHoseCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field and count occurrences
        $this->collection->each(function ($item) use (&$supplyCounts) {
            if ($item['equipment_category'] === 'fire hose') {
                $supply = json_decode($item['pivot']['supply'], true);
                $model = $item['equipment_model'];

                foreach ($supply as $activity) {
                    // Group by equipment model and weight along with activity
                    $key = $item['location'] . ' ' . $model . ' '  . ' ' . $activity;

                    if (isset($supplyCounts[$key])) {
                        $supplyCounts[$key]++;
                    } else {
                        $supplyCounts[$key] = 1;
                    }
                }
            }
        });

        return $supplyCounts;
    }
    protected function getSupplyOthersEquipmentCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $category = $item['equipment_category'];

            // Check if the category is not 'fire hose' or 'fire extinguisher'
            if ($category !== 'fire hose' && $category !== 'fire extinguisher') {
                $supply = json_decode($item['pivot']['supply'], true);
                $model = $category;

                foreach ($supply as $activity) {
                    // Group by equipment category and activity
                    $key = $item['location'] . ' ' . $model . ' - ' . $activity;

                    if (isset($supplyCounts[$key])) {
                        $supplyCounts[$key]++;
                    } else {
                        $supplyCounts[$key] = 1;
                    }
                }
            }
        });

        return $supplyCounts;
    }
}
