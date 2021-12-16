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
            ['name' => 'manager','description' => 'Engagement Manager'],
            ['name' => 'managing_partner','description' => 'Engagement Managing Partner'],
            ['name' => 'staff','description' => 'Engagement Staff'],
        ];

        foreach($roles as $role){
            EngagementTeamRole::create($role);
        }

    }
}
