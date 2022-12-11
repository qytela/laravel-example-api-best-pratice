<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesAndPermissions = [
            'admin' => [
                'article' => 'c,r,u,d'
            ],
            'member' => [
                'article' => 'r'
            ],
        ];
        $permissionMap = collect([
            'c' => 'create',
            'r' => 'read',
            'u' => 'update',
            'd' => 'delete',
        ]);

        // Create Superadmin
        Role::create(['name' => 'superadmin', 'display_name' => 'Superadmin']);
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@app.com',
            'password' => 'secret'
        ])->assignRole('superadmin');

        foreach ($rolesAndPermissions as $key => $modules) {
            $role = Role::create(['name' => $key, 'display_name' => ucwords($key)]);
            $permissions = [];

            foreach ($modules as $module => $value) {
                foreach (explode(',', $value) as $p => $permission) {
                    $permissionValue = $permissionMap->get($permission);
                    $permissions[] = Permission::firstOrCreate(['name' => $permissionValue . '-' . $module, 'guard_name' => 'api'])->id;
                }
            }

            // Attachh all permissions to thhe role
            $role->permissions()->sync($permissions);

            // Create default user for each role
            User::create([
                'name' => ucwords($key),
                'username' => $key,
                'email' => $key . '@app.com',
                'password' => 'secret'
            ])->assignRole($role);
        }
    }
}
