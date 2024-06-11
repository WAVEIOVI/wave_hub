<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maintenances = [
            ['maintenance_id' => 'BM001', 'name' => 'fire extinguisher head maintenance'],
            ['maintenance_id' => 'BM002', 'name' => 'fire extinguisher corps maintenance'],
            ['maintenance_id' => 'BM003', 'name' => 'fire extinguisher hose maintenance'],
        ];

        foreach ($maintenances as $maintenance) {
            Maintenance::create($maintenance);
        }
    }
}
