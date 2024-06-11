<?php

namespace Database\Seeders;

use App\Models\Weight;
use Illuminate\Database\Seeder;

class WeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weights = [
            ['weight_id' => 'WK001', 'value' => 1, 'unit' => 'kg'],
            ['weight_id' => 'WK002', 'value' => 2, 'unit' => 'kg'],
            ['weight_id' => 'WK004', 'value' => 4, 'unit' => 'kg'],
            ['weight_id' => 'WK006', 'value' => 6, 'unit' => 'kg'],
            ['weight_id' => 'WK009', 'value' => 9, 'unit' => 'kg'],
            ['weight_id' => 'WK010', 'value' => 10, 'unit' => 'kg'],
            ['weight_id' => 'WK005', 'value' => 5, 'unit' => 'kg'],
            ['weight_id' => 'WL001', 'value' => 1, 'unit' => 'L'],
            ['weight_id' => 'WL002', 'value' => 2, 'unit' => 'L'],
            ['weight_id' => 'WL004', 'value' => 4, 'unit' => 'L'],
            ['weight_id' => 'WL006', 'value' => 6, 'unit' => 'L'],
            ['weight_id' => 'WL009', 'value' => 9, 'unit' => 'L'],
            ['weight_id' => 'WL010', 'value' => 10, 'unit' => 'L'],
        ];

        foreach ($weights as $weight) {
            Weight::create($weight);
        }
    }
}
