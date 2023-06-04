<?php

namespace Database\Seeders;

use App\Models\EngagementStage;
use Illuminate\Database\Seeder;

class EngagementStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = [
            ['name' => 'planning','description' => 'Planning stage'],
            ['name' => 'execution','description' => 'Execution'],
            ['name' => 'conclusion','description' => 'Conclusion'],
        ];

        foreach($stages as $stage){
            EngagementStage::updateOrCreate(['name' => $stage['name']], ['description' => $stage['description']]);
        }

    }
}
