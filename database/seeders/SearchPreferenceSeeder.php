<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SearchPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SearchPreference::factory(200)->create();
}
}
