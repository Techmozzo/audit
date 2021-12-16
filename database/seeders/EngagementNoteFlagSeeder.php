<?php

namespace Database\Seeders;

use App\Models\EngagementNoteFlag;
use Illuminate\Database\Seeder;

class EngagementNoteFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flags = [
            ['name' => 'high','description' => 'Top priority'],
            ['name' => 'medium','description' => 'priority'],
            ['name' => 'low','description' => 'Not too important'],
        ];

        foreach($flags as $flag){
            EngagementNoteFlag::create($flag);
        }

    }
}
