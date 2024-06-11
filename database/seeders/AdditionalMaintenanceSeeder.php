<?php

namespace Database\Seeders;

use App\Models\AdditionalMaintenance;
use Illuminate\Database\Seeder;

class AdditionalMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $additional_maintenances = [
            ['additional_maintenance_id' => 'AM001', 'name' => 'fire extinguisher sandblasting'],
            ['additional_maintenance_id' => 'AM002', 'name' => 'fire extinguisher paint'],
            ['additional_maintenance_id' => 'AM003', 'name' => 'fire extinguisher hydro test'],
        ];

        foreach ($additional_maintenances as $additional_maintenance) {
            AdditionalMaintenance::create($additional_maintenance);
        }
    }
}
