<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::truncate();
        \App\Models\Category::factory()->state(['name' => 'E-Rate Category 1'])->create();
        \App\Models\Category::factory()->state(['name' => 'E-Rate Category 2'])->create();
        \App\Models\Category::factory()->state(['name' => 'Non-E-Rate'])->create();
    }
}
