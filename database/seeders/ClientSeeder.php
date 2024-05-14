<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 50; $i++) { 
            $User = User::factory()->state(['type' => 'client'])->create();
            $User->assignRole('client');
            // Create a Project per User
            $Project = Project::factory()->withUserId($User->id)->create();
        }
    }
}
