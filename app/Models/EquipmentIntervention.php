<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class EquipmentIntervention extends Pivot
{
    protected $table = 'equipment_intervention';

    public function in_maintenances()
    {
        return $this->hasMany(InMaintenance::class, 'equipment_intervention_id');
    }

    public function in_add_maintenances()
    {
        return $this->hasMany(InAddMaintenance::class, 'equipment_intervention_id');
    }

    public function in_supplies()
    {
        return $this->hasMany(InSupply::class, 'equipment_intervention_id');
    }

    public function in_accessories()
    {
        return $this->hasMany(InAccessory::class, 'equipment_intervention_id');
    }
}
