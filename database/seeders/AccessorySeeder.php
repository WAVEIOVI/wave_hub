<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessories = [
            ['accessory_id' => 'AC001', 'name' => 'standard sign'],
            ['accessory_id' => 'AC002', 'name' => 'numbering'],
            ['accessory_id' => 'AC003', 'name' => 'fixation'],
            ['accessory_id' => 'AC004', 'name' => 'pictogram'],
        ];

        foreach ($accessories as $accessory) {
            Accessory::create($accessory);
        }
    }
}
