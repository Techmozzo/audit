<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


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
            ['name' => 'admin', 'description' => 'Owner of firm'],
            ['name' => 'managing_partner', 'description' => 'Audit Partner'],
            ['name' => 'staff', 'description' => 'Staff member'],
        ];

        $permissions = Permission::get()->pluck('name')->toArray();
        foreach ($roles as $role) {
            $createdRole = Role::updateOrCreate(['name' => $role['name']], ['description' => $role['description']]);
            $createdRole->syncPermissions($permissions);
        }
    }
}
