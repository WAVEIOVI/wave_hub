<?php

namespace Database\Seeders;

use App\Models\Supply;
use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplies = [
            ['supply_id' => 'SP001', 'name' => 'fire extinguisher pressure gauge'],
            ['supply_id' => 'SP002', 'name' => 'fire extinguisher valve assembly'],
            ['supply_id' => 'SP003', 'name' => 'fire extinguisher hose assembly'],
            ['supply_id' => 'SP004', 'name' => 'fire extinguisher discharge nozzle'],
            ['supply_id' => 'SP005', 'name' => 'fire extinguisher safety pin'],
            ['supply_id' => 'SP006', 'name' => 'fire extinguisher o ring'],
            ['supply_id' => 'SP007', 'name' => 'fire extinguisher handle and lever'],
        ];

        foreach ($supplies as $supply) {
            Supply::create($supply);
        }
    }
}
