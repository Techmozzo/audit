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
            ['name' => 'overall_materiality', 'type' => 'expense', 'lower_limit' => 0.00, 'upper_limit' => 100.00, 'description' => 'Overall expense materiality.'],
            ['name' => 'performance_materiality', 'type' => 'expense', 'lower_limit' => 25.00, 'upper_limit' => 75.00, 'description' => 'Performance expense materiality.'],
            ['name' => 'threshold', 'type' => 'expense', 'lower_limit' => 5.00, 'upper_limit' => 25.00, 'description' => 'Threshold expense materiality.'],
        ];

        foreach ($levels as $level) {
            MaterialityLevel::updateOrCreate(
                ['name' => $level['name']],
                ['type' => $level['type'], 'lower_limit' => $level['lower_limit'], 'upper_limit' => $level['upper_limit'], 'description' => $level['description']],
            );
        }
    }
}
