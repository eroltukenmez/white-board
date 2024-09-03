<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'admin','title' => 'Administrator']);

        Permission::create(['name'=>'profile.delete','title' => 'Delete Profile','guard_name' => 'web']);
        Permission::create(['name'=>'profile.role.update','title' => 'Profile Role Update','guard_name' => 'web']);
        Permission::create(['name'=>'profile.department.update','title' => 'Profile Department Update','guard_name' => 'web']);

        $role->givePermissionTo(['profile.delete','profile.role.update','profile.department.update']);
    }
}
