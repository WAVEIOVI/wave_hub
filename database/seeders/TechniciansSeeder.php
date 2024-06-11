<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technician;


class TechniciansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define sample technician data
        $technicians = [
            [
                'technician_name' => 'Amin Douzi',
                'technician_status' => 'Active',
            ],
            [
                'technician_name' => 'Walid Harrabi',
                'technician_status' => 'Inactive',
            ],
            [
                'technician_name' => 'Abdelkader Triki',
                'technician_status' => 'Active',
            ],
            [
                'technician_name' => 'Jawher Triki',
                'technician_status' => 'Active',
            ],
            [
                'technician_name' => 'Nader',
                'technician_status' => 'Active',
            ],
            // Add more sample data as needed
        ];

        // Insert sample technician data into the database
        foreach ($technicians as $technician) {
            Technician::create($technician);
        }
    }
}
