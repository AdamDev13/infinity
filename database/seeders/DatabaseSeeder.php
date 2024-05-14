<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            RolesAndPermissionsSeeder::class,
            TestUserSeeder::class,
            AdminSeeder::class,
            ClientSeeder::class,
            VendorSeeder::class,
            ProjectAddendumSeeder::class,
            ProjectFavoriteSeeder::class,
            ProjectLogSeeder::class,
            ProjectRfpFileSeeder::class,
            ProjectSeeder::class,
            ProjectViewSeeder::class,
            SearchPreferenceSeeder::class,
            UserPermissionsSeeder::class
        ]);
    }
}
