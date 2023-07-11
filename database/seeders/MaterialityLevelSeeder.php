<?php

namespace Database\Seeders;

use App\Models\MaterialityLevel;
use Illuminate\Database\Seeder;

class MaterialityLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            ['name' => 'overall_materiality', 'lower_limit' => 0.00, 'upper_limit' => 100.00, 'description' => 'Overall materiality.'],
            ['name' => 'performance_materiality','lower_limit' => 25.00, 'upper_limit' => 75.00, 'description' => 'Performance materiality is 25 to 75 % of Overall materiality.'],
            ['name' => 'threshold', 'lower_limit' => 5.00, 'upper_limit' => 25.00, 'description' => 'Threshold materiality  is 5 to 25 % of Performance materiality.'],
        ];

        foreach ($levels as $level) {
            MaterialityLevel::updateOrCreate(
                ['name' => $level['name']],
                ['lower_limit' => $level['lower_limit'], 'upper_limit' => $level['upper_limit'], 'description' => $level['description']],
            );
        }
    }
}
