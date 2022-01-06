<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin','description' => 'Owner of firm'],
            ['name' => 'managing_partner','description' => 'Audit Partner'],
            ['name' => 'staff','description' => 'Staff member'],
        ];

        foreach($roles as $role){
            Role::create($role);
        }
    }
}
