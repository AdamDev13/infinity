<?php

namespace Database\Seeders;

use App\Nova\Admin;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Projects
        $permissions = [
            // Role = Permission name
            'superadmin',
            'admin',
            'vendor',
            'client',

            // Resources
            // Resources - Admin
            'admin.view',
            'admin.viewAny',
            'admin.create',
            'admin.update',
            'admin.delete',
            'admin.restore',
            'admin.forceDelete',
            // Resources - Clients
            'client.view',
            'client.viewAny',
            'client.create',
            'client.update',
            'client.delete',
            'client.restore',
            'client.forceDelete',
            // Resources - Vendors
            'vendor.view',
            'vendor.viewAny',
            'vendor.create',
            'vendor.update',
            'vendor.delete',
            'vendor.restore',
            'vendor.forceDelete',
            // Resources - Projects
            'project.view',
            'project.viewAny',
            'project.create',
            'project.update',
            'project.delete',
            'project.restore',
            'project.forceDelete',
            // Resources - Project Favorite
            'projectFavorite.view',
            'projectFavorite.viewAny',
            'projectFavorite.create',
            'projectFavorite.update',
            'projectFavorite.delete',
            'projectFavorite.restore',
            'projectFavorite.forceDelete',
            // Resources - Project View
            'projectView.view',
            'projectView.viewAny',
            'projectView.create',
            'projectView.update',
            'projectView.delete',
            'projectView.restore',
            'projectView.forceDelete',
            // Resources - Project Log
            'projectLog.view',
            'projectLog.viewAny',
            'projectLog.create',
            'projectLog.update',
            'projectLog.delete',
            'projectLog.restore',
            'projectLog.forceDelete',
            // Resources - Search Preferences
            'searchPreferences.view',
            'searchPreferences.viewAny',
            'searchPreferences.create',
            'searchPreferences.update',
            'searchPreferences.delete',
            'searchPreferences.restore',
            'searchPreferences.forceDelete',

            // Navigation
            // Admins
            'navigation.admins',
            'navigation.admins.add',
            'navigation.admins.all',
            // Clients
            'navigation.clients',
            'navigation.clients.add',
            'navigation.clients.all',
            // Projects
            'navigation.projects',
            'navigation.projects.all',
            'navigation.projects.add',
            'navigation.projects.viewed',
            'navigation.projects.favorited',
            'navigation.projects.searchPreferences',
            'navigation.projects.logs',
            // Vendors
            'navigation.vendors',
            'navigation.vendors.all',
            'navigation.vendors.projectViews',
            'navigation.vendors.projectFavorites',
            'navigation.vendors.searchPreferences',
        ];
        foreach($permissions as $permission) {
            Permission::create(["name" => $permission]);
        }

        // Super Admin
        Role::create(['name' => 'superadmin'])->givePermissionTo(
            Permission::all()
        );

        // Admin
        Role::create(['name' => 'admin'])->givePermissionTo([
            // Admin
            'admin',
            // Resources - Clients
            'client.view',
            'client.viewAny',
            'client.create',
            'client.update',
            'client.delete',
            'client.restore',
            'client.forceDelete',
            // Resources - Vendors
            'vendor.view',
            'vendor.viewAny',
            'vendor.create',
            'vendor.update',
            'vendor.delete',
            'vendor.restore',
            'vendor.forceDelete',
            // Resources - Project
            'project.view',
            'project.viewAny',
            'project.create',
            'project.update',
            'project.delete',
            'project.restore',
            'project.forceDelete',
            // Resources - Project Favorite
            'projectFavorite.view',
            'projectFavorite.viewAny',
            'projectFavorite.create',
            'projectFavorite.update',
            'projectFavorite.delete',
            'projectFavorite.restore',
            'projectFavorite.forceDelete',
            // Resources - Project View
            'projectView.view',
            'projectView.viewAny',
            'projectView.create',
            'projectView.update',
            'projectView.delete',
            'projectView.restore',
            'projectView.forceDelete',
            // Resources - Project Log
            'projectLog.view',
            'projectLog.viewAny',
            'projectLog.create',
            'projectLog.update',
            'projectLog.delete',
            'projectLog.restore',
            'projectLog.forceDelete',
            // Resources - Search Preferences
            'searchPreferences.view',
            'searchPreferences.viewAny',

            // Navigation
            // Clients
            'navigation.clients',
            'navigation.clients.add',
            'navigation.clients.all',
            // Porject
            'navigation.projects',
            'navigation.projects.add',
            'navigation.projects.all',
            'navigation.projects.viewed',
            'navigation.projects.favorited',
            'navigation.projects.searchPreferences',
            'navigation.projects.logs',
            // Vendors
            'navigation.vendors',
            'navigation.vendors',
            'navigation.vendors.all',
            'navigation.vendors.projectViews',
            'navigation.vendors.projectFavorites',
            'navigation.vendors.searchPreferences',
        ]);

        // Vendor
        Role::create(['name' => 'vendor'])->givePermissionTo([
            'vendor',
            'client.viewAny',

            'project.view',
            'project.viewAny',

            'searchPreferences.view',
            'searchPreferences.viewAny',
            'searchPreferences.create',
            'searchPreferences.update',
            'searchPreferences.delete',

            // Navigation
            'navigation.projects',
            'navigation.projects.all',
            'navigation.projects.viewed',
            'navigation.projects.favorited',
            'navigation.projects.searchPreferences',
        ]);

        // Client
        Role::create(['name' => 'client'])->givePermissionTo([
            'client',
        ]);
    }
}
