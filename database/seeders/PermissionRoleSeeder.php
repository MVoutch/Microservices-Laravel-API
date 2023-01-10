<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $admin = Role::whereTitle('Admin')->first();
        $editor = Role::whereTitle('Editor')->first();
        $viewer = Role::whereTitle('Viewer')->first();

        foreach ($permissions as $permission) {
            $admin->permissions()->attach($permission);

            if ($permission->name != 'edit_roles') {
                $editor->permissions()->attach($permission);
            }

            if (str_contains($permission->name, 'view')) {
                $viewer->permissions()->attach($permission);
            }
        }
    }
}
