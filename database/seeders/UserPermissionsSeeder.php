<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $userPermissions = [
            'user.view',
            'user.viewAny',
            'user.create',
            'user.update',
            'user.delete',
            'user.restore',
            'user.forceDelete',
        ];

        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ], [
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Give them to Super Admin
        Role::where('name', 'superadmin')->first()->givePermissionTo($userPermissions);

        // Give them to Admin
        Role::where('name', 'admin')->first()->givePermissionTo($userPermissions);
    }
}
