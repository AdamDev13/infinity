<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Models\ProjectView;
use App\Models\User;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) {
            $User = User::factory()->state(['type' => 'vendor'])->create();
            $User->assignRole('vendor');
            // add views
            for ($vi=0; $vi < 10; $vi++) {
                $Project_id = Project::get()->random()->id;
                ProjectView::factory()->withIds($User->id, $Project_id)->create();
                if(mt_rand(0,99) > 80) {
                    ProjectFavorite::factory()->withIds($User->id, $Project_id)->create();
                }
            }
        }
    }
}
