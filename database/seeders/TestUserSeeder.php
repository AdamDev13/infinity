<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SuperAdmin
        $User = User::factory()->state(['email' => 'superadmin@ugduck.com', 'type' => 'superadmin'])->create();
        $User->assignRole('superadmin');

        // Admin
        $User = User::factory()->state(['email' => 'admin@ugduck.com', 'type' => 'admin'])->create();
        $User->assignRole('admin');
        
        // Vendor
        $User = User::factory()->state(['email' => 'vendor@ugduck.com', 'type' => 'vendor'])->create();
        $User->assignRole('vendor');
        for ($i=0; $i < 5; $i++) { 
            $User = User::factory()->state(['email' => 'vendor' . $i . '@ugduck.com', 'type' => 'vendor'])->create();
            $User->assignRole('vendor');
        }
    }
}
