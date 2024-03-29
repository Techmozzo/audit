<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = config('system_permissions');
        foreach($permissions as $permission){
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
