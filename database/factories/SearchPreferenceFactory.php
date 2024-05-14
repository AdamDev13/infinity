<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Location;
use App\Models\SearchPreference;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SearchPreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SearchPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $state = Arr::random(array_keys(Location::getStates()));
        return [
            'user_id' => User::where('type', 'vendor')->get()->random()->id,
            'category_id' => Category::all()->random()->id,
            'state' => $state,
            'county' => Arr::random(array_keys(Location::getCounties($state))),
        ];
    }
}
