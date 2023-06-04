<?php

namespace Database\Seeders;

use App\Models\EngagementTeamRole;
use Illuminate\Database\Seeder;

class EngagementTeamRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Associate','description' => 'Engagement Associate', 'rank' => 10],
            ['name' => 'Senior Associate','description' => 'Engagement Senior Associate', 'rank' => 20],
            ['name' => 'Assistant Manager','description' => 'Engagement Assistant Manager', 'rank' => 30],
            ['name' => 'Manager','description' => 'Engagement Manager', 'rank' => 40],
            ['name' => 'Senior Manager','description' => 'Engagement Senior Manager', 'rank' => 50],
            ['name' => 'Director','description' => 'Engagement Director', 'rank' => 60],
            ['name' => 'Partner','description' => 'Engagement Partner', 'rank' => 70],
            ['name' => 'Quality Review Partner','description' => 'Engagement Engagement Quality Review Partner', 'rank' => 80]
        ];

        foreach($roles as $role){
            EngagementTeamRole::updateOrCreate(['name' => $role['name']], ['description' => $role['description'], 'rank' => $role['rank']]);
        }

    }
}
