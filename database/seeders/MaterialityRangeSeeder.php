<?php

namespace Database\Seeders;

use App\Models\MaterialityRange;
use Illuminate\Database\Seeder;

class MaterialityRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranges = [
            ['name' => 'Expense', 'lower_limit' => 5.00, 'upper_limit' => 10.00, 'description' => 'Expense range materiality.'],
            ['name' => 'Revenue', 'lower_limit' => 0.00, 'upper_limit' => 5.00, 'description' => 'Revenue range materiality.'],
        ];

        foreach($ranges as $range){
            MaterialityRange::updateOrCreate(
                ['name' => $range['name']],
                ['lower_limit' => $range['lower_limit'], 'upper_limit' => $range['upper_limit'], 'description' => $range['description']],
            );
        }

    }
}
